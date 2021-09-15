<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader,
    TQ\Tools\HL,
    Bitrix\Main\Engine\ActionFilter\Authentication,
    Bitrix\Main\Engine\ActionFilter,
    Bitrix\Main\Engine\Contract\Controllerable;

CJSCore::Init(array("fx", "ajax"));

Loader::includeModule('iblock');
Loader::includeModule('tq.tools');

class Cities extends \CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [
            'search' => [ // Ajax-метод
                'prefilters' => [],
            ],
            'getCities' => [ // Ajax-метод
                'prefilters' => [],
            ],
            'getContacts' => [ // Ajax-метод
                'prefilters' => [],
            ],
        ];
    }

    public function searchAction($query)
    {

        if ($query) {
            $this->arResult['FAVORITES'] = HL::getList(HL_LOCATION_ID, ['*'], ['UF_NAME' => sprintf('%%%s%%',$query)], []);
        } else {
            $this->arResult['FAVORITES'] = $this->getFavorites();
        }
        ob_start();
        $this->includeComponentTemplate('search_block');
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function getCitiesAction()
    {
        $arResult = [];

        $arCities = HL::getList(HL_LOCATION_ID, ['UF_DISTRICT', 'UF_REGION', 'UF_NAME', 'UF_XML_ID','UF_SUB_DOMAIN']);
        foreach ($arCities as $arCity) {
            $arResult[$arCity['UF_DISTRICT']][$arCity['UF_REGION']][] = $arCity;
        }

        return $arResult;
    }


    private function getPage()
    {
        $this->arResult['DISTRICTS'] = HL::getList(HL_LOCATION_ID, ['*'], [], [], ['UF_DISTRICT']);
        $this->arResult['FAVORITES'] = $this->getFavorites();
    }

    private function getFavorites()
    {
        return HL::getList(HL_LOCATION_ID, ['*'], ['UF_FAVORITE' => 1], []);
    }


    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate();
    }

}
