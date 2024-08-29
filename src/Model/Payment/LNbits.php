<?php

namespace Digiwerft\IsotopeLNbits\Model\Payment;

use chillerlan\QRCode\QRCode;
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\LNbitsModel;
use Contao\Module;
use Contao\PageModel;
use Contao\SecupayPaymentModel;
use Contao\StringUtil;
use Contao\System;
use Digiwerft\IsotopeLNbits\Controller\LNbitsApi;
use Haste\Http\Response\RedirectResponse;
use Haste\Util\Url;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopePurchasableCollection;
use Isotope\Isotope;
use Isotope\Model\Payment;
use Isotope\Model\TaxRate;
use Isotope\Module\Checkout;
use Psr\Log\LogLevel;

class LNbits extends Payment
{

    public function checkoutForm(IsotopeProductCollection $objOrder, Module $objModule)
    {
        $GLOBALS['TL_JAVASCRIPT']['iso_lnbits'] = 'bundles/isotopelnbits/iso_payment_lnbits.js';
        $GLOBALS['TL_CSS']['iso_lnbits'] = 'bundles/isotopelnbits/iso_payment_lnbits.css';
        $successUrl = Checkout::generateUrlForStep(Checkout::STEP_COMPLETE, $objOrder);
        $api = new LNbitsApi($this->lnbits_api_url, $this->lnbits_api_key);
        $invoice = $api->createInvoice($objOrder->getTotal(), "Order: " . $objOrder->getUniqueId(), $objOrder->getCurrency());
        if (!$invoice) {
            Checkout::redirectToStep(Checkout::STEP_FAILED);
        }
        $lnbitsPayment = new LNbitsModel();
        $lnbitsPayment->paymentHash = $invoice['payment_hash'];
        $lnbitsPayment->orderId = $objOrder->getUniqueId();
        $lnbitsPayment->save();
        $template = new FrontendTemplate('iso_payment_lnbits');
        $template->headline = $this->headline ?? "Lightning Invoice";
        $template->message = \str_replace('##orderId##', $objOrder->getUniqueId(), $this->message);
        $template->qr = (new QRCode)->render($invoice['payment_request']);
        $template->orderId = $objOrder->getUniqueId();
        $template->successUrl = $successUrl;
        $template->paymentHash = $invoice['payment_hash'];
        $template->paymentId = $this->id;

        return $template->parse();
    }
    public function processPayment(IsotopeProductCollection $objOrder, Module $objModule)
    {
        if (!$objOrder instanceof IsotopePurchasableCollection) {
            $level = LogLevel::ERROR;
            $logger = System::getContainer()->get('monolog.logger.contao');
            $logger->log($level, __METHOD__, ['Product collection ID "' . $objOrder->getId() . '" is not purchasable']);
            Checkout::redirectToStep(Checkout::STEP_FAILED);
        }

        $api = new LNbitsApi($this->lnbits_api_url, $this->lnbits_api_key);
        $lnbits = LNbitsModel::findByOrderId($objOrder->getUniqueId());
        $payment = $api->checkPayment($lnbits->paymentHash);
        if (!$payment || $payment['paid'] == false) {
            Checkout::redirectToStep(Checkout::STEP_FAILED);
        } else {
            $objOrder->checkout();
            $objOrder->setDatePaid(time());
            $objOrder->updateOrderStatus($this->new_order_status);

            $objPage = PageModel::findByPk($objModule->orderCompleteJumpTo);
            $url = Environment::get('base') . $objPage->getFrontendUrl();
            $url = Url::addQueryString('uid=' . $objOrder->getUniqueId(), $url);

            $response = new RedirectResponse($url);
            return $response->send();
            exit;
        }
    }
}