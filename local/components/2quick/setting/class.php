<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Config\Option;

class Setting extends \CBitrixComponent
{
    private function getPage()
    {
        if ($this->arParams['SETTING']) {
            $this->arResult['VALUE'] = Option::get("tq.tools", $this->arParams['SETTING']);
        }
    }

    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate();
    }

}
