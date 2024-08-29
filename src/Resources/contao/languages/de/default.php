<?php


$arrPayment = [
    '_paypal' => 'PayPal',
    '_invoice' => 'Kauf auf Rechnung',
    '_creditcard' => 'Kreditkarte',
    '_debit' => 'Lastschrift',
    '_sofort' => 'Sofortüberweisung',
    '_giropay' => 'Giropay',
    '_prepay' => 'Vorkasse',
    '_easycredit' => 'Ratenkauf',
    '_ppexpress' => 'PayPal Express',
];

foreach ($arrPayment as $k => $v) {
    $GLOBALS['TL_LANG']['MODEL']['tl_iso_payment']["secupay$k"][0] = "Secupay $v";
}