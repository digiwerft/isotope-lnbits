<?php

namespace Contao;

/**
 * Class SecupayPaymentModel
 *
 * @package Contao
 */
class LNbitsModel extends Model
{

    protected static $strTable = 'tl_lnbits';

    public static function findByOrderId($orderId)
    {
        $t = static::$strTable;
        $arrColumns = ["$t.orderId=?"];
        $arrValues = [$orderId];
        return static::findOneBy($arrColumns, $arrValues);
    }

    public static function findByPaymentHash($paymentHash)
    {
        $t = static::$strTable;
        $arrColumns = ["$t.paymentHash=?"];
        $arrValues = [$paymentHash];
        return static::findOneBy($arrColumns, $arrValues);
    }
}