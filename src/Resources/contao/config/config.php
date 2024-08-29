<?php

use Digiwerft\IsotopeLNbits\Model\Payment\LNbits;
use Isotope\Model\Payment;


/**
 * Register the models
 */
Payment::registerModelType('lnbits', LNbits::class);