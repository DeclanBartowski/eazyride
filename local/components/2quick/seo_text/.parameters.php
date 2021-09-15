<?php
if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
/**
* @var array $arCurrentValues
 **/
use Bitrix\Main\Localization\Loc;
if(!CModule::IncludeModule("iblock"))
    return;
Loc::loadMessages(__FILE__);

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "PAGE" => Array(
            "NAME" => 'Url страницы',
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "PARENT" => "BASE",
        ),
    ]
];
CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);