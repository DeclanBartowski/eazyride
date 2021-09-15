<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use \Bitrix\Main\Config\Option;
Loader::includeModule('iblock');

class Pages extends \CBitrixComponent
{
    private function getPage()
    {
        global $APPLICATION;
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_SHOW_CONTACTS", "PREVIEW_TEXT",'DETAIL_TEXT','PREVIEW_PICTURE');
        $arFilter = ['IBLOCK_ID' => PAGES_IBLOCK_ID, 'PROPERTY_PAGE' => $APPLICATION->GetCurPage(), 'ACTIVE' => 'Y'];
        $res = CIBlockElement::GetList(['ID'=>'asc'], $arFilter, false, ['nPageSize'=>1], $arSelect);
        if ($ob = $res->Fetch()) {
            $this->arResult['TITLE'] = $APPLICATION->GetTitle('h1');
            $iPropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($ob["IBLOCK_ID"], $ob["ID"]);
            $ob['IPROPERTY_VALUES'] = $iPropValues->getValues();
            if($ob['PREVIEW_PICTURE']){
                $ob['PREVIEW_PICTURE'] = CFile::GetFileArray($ob['PREVIEW_PICTURE']);
            }
            $this->arResult['ITEM'] = $ob;
           if($ob['PROPERTY_SHOW_CONTACTS_VALUE'] == 'Y'){
               $this->arResult['CONTACTS']['PHONE']['VALUE'] = Option::get("tq.tools", 'tq_module_param_obshchie_nastroyki_phone');
               if($this->arResult['CONTACTS']['PHONE']['VALUE']){
                   $this->arResult['CONTACTS']['PHONE']['NORMALIZED_VALUE'] = normalizePhone($this->arResult['CONTACTS']['PHONE']['VALUE']);
               }
               $this->arResult['CONTACTS']['EMAIL'] = Option::get("tq.tools", 'tq_module_param_obshchie_nastroyki_email');
               $this->arResult['CONTACTS']['CENTER'] = Option::get("tq.tools", 'tq_module_param_obshchie_nastroyki_center');
            }
        }
    }

    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate();
    }

}
