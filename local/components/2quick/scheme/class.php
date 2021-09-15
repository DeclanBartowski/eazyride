<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Config\Option;

class Scheme extends \CBitrixComponent
{
    private function getPage()
    {
            $this->arResult['RATING'] = Option::get("tq.tools", 'tq_module_param_scheme_rating_value');
            $this->arResult['REVIEW'] = Option::get("tq.tools", 'tq_module_param_scheme_review_count');
            $this->arResult['PHONE'] = Option::get("tq.tools", 'tq_module_param_obshchie_nastroyki_phone');
            $this->arResult['EMAIL'] = Option::get("tq.tools", 'tq_module_param_obshchie_nastroyki_email');
            $this->arResult['ADDRESS'] = Option::get("tq.tools", 'tq_module_param_obshchie_nastroyki_center');
            $this->arResult['SLOGAN'] = Option::get("tq.tools", 'tq_module_param_scheme_slogan');

    }

    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate();
    }

}
