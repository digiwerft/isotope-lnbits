<?php

namespace Digiwerft\IsotopeLNbits\Controller;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Input;
use Digiwerft\IsotopeLNbits\Model\Payment\LNbits;
use Isotope\Model\Payment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lnbits-check-payment', LNbitsCheckPayment::class, defaults: ['_scope' => 'frontend', '_token_check' => false])]
class LNbitsCheckPayment extends AbstractController
{
    private $framework;
    private $requestStack;
    private $request;

    public function __construct(ContaoFramework $framework, RequestStack $requestStack)
    {
        $this->framework = $framework;
        $this->requestStack = $requestStack;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function __invoke()
    {
        $this->framework->initialize();
        $paymentId = Input::get('id');
        $paymentHash = Input::get('hash');
        $objPaymentModel = Payment::findByPk($paymentId);
        if ($objPaymentModel instanceof LNbits) {
            $api = new LNbitsApi($objPaymentModel->lnbits_api_url, $objPaymentModel->lnbits_api_key);
            $payment = $api->checkPayment($paymentHash);
        }
        return new Response(\json_encode(['paid' => $payment['paid']]), 200);
    }
}