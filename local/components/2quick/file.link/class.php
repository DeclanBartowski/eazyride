<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
Loader::includeModule('iblock');

class FileLink extends \CBitrixComponent
{
    private function getPage()
    {
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_FILE");
        $arFilter = ['IBLOCK_ID' => FILES_IBLOCK_ID, 'CODE' => $this->arParams['CODE'], 'ACTIVE' => 'Y','!PROPERTY_FILE'=>false];
        $res = CIBlockElement::GetList(['ID'=>'asc'], $arFilter, false, ['nPageSize'=>1], $arSelect);
        if ($ob = $res->Fetch()) {
            $ob['FILE'] = CFile::GetFileArray($ob['PROPERTY_FILE_VALUE']);
            $ob['FILE_SIZE'] = CFile::FormatSize( $ob['FILE']['FILE_SIZE'],0);
            $this->arResult = $ob;
        }
    }

    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate();
    }

}
