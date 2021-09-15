<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
Loader::includeModule('iblock');

class SeoText extends \CBitrixComponent
{
    private function getPage()
    {
        global $APPLICATION;
        $page = $this->arParams['PAGE']?:$APPLICATION->GetCurPage();
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_TITLE", "PREVIEW_TEXT",'PROPERTY_PAGES');
        $arFilter = ['IBLOCK_ID' => SEO_IBLOCK_ID, 'PROPERTY_PAGES' => $page, 'ACTIVE' => 'Y'];
        $res = CIBlockElement::GetList(['ID'=>'asc'], $arFilter, false, ['nPageSize'=>1], $arSelect);
        if ($ob = $res->Fetch()) {
            $this->arResult = $ob;
        }
    }

    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate();
    }

}
