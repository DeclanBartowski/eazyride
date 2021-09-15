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
        "SEF_MODE" => Array(
            "service" => array(
                "NAME" => Loc::getMessage('SERVICE_PAGE'),
                "DEFAULT" => "#SERVICE_PATH#/",
                "VARIABLES" => array('#SERVICE_PATH#'),
            ),
        ),
    ]
];
CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);