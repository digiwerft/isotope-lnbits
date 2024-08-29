<?php

$GLOBALS['TL_DCA']['tl_iso_payment']['palettes']["lnbits"] = '
{type_legend},name,label,type;
{note_legend:hide},note;
{config_legend},new_order_status,quantity_mode,minimum_quantity,maximum_quantity,minimum_total,maximum_total,countries,shipping_modules,product_types,product_types_condition,config_ids;
{gateway_legend},lnbits_api_url,lnbits_api_key,lnbits_checkout_headline,lnbits_checkout_message;
{price_legend:hide},price,tax_class;
{expert_legend:hide},guests,protected;
{enabled_legend},enabled,debug,logging';

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['lnbits_api_key'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_iso_payment']['lnbits_api_key'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('mandatory' => false, 'maxlength' => 128, 'tl_class' => 'w50', 'hideInput' => true),
    'sql' => "varchar(128) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['lnbits_api_url'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_iso_payment']['lnbits_api_url'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'),
    'sql' => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['lnbits_checkout_headline'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_iso_payment']['lnbits_checkout_headline'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'),
    'sql' => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['lnbits_checkout_message'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_iso_payment']['lnbits_checkout_message'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => array('mandatory' => false, 'tl_class' => 'clr'),
    'sql' => "text NULL",
);