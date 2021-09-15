<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader,
    TQ\Tools\HL,
    TQ\Tools\Sef,
    Bitrix\Main\Engine\ActionFilter\Authentication,
    Bitrix\Main\Engine\ActionFilter,
    Bitrix\Main\Engine\Contract\Controllerable;

CJSCore::Init(array("fx", "ajax"));

Loader::includeModule('iblock');
Loader::includeModule('tq.tools');

class Addresses extends \CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [
            'getCities' => [ // Ajax-метод
                'prefilters' => [],
            ],
            'getContacts' => [ // Ajax-метод
                'prefilters' => [],
            ],
        ];
    }

    public function getCitiesAction()
    {
        $arResult = [];
        if ($arCitiesXmlIds = $this->getContactsCitiesGroup()) {
            $arCities = HL::getList(HL_LOCATION_ID, ['UF_DISTRICT','UF_REGION','UF_NAME','UF_XML_ID'], ['UF_XML_ID' => $arCitiesXmlIds], []);
            foreach ($arCities as $arCity){
                $arResult[$arCity['UF_DISTRICT']][$arCity['UF_REGION']][] = $arCity;
            }
        }
        $sef = Sef::getInstance();
        $arCity = $sef->getCurrentCity();
        return ['result'=>$arResult,'current'=>$arCity];
    }

    public function getContactsAction($city)
    {
        $arItems = [];
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "XML_ID");
        $arFilter = ['IBLOCK_ID' => CONTACTS_IBLOCK_ID,'PROPERTY_CITY'=>$city];
        $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
        while ($ob = $res->Fetch()) {
            $arItems[] = sprintf('<li>%s</li>',$ob['NAME']);
        }
        return implode('',$arItems);
    }

    private function getPage()
    {
        if ($arCitiesXmlIds = $this->getContactsCitiesGroup()) {
            $this->arResult['DISTRICTS'] = HL::getList(HL_LOCATION_ID, ['*'], ['UF_XML_ID' => $arCitiesXmlIds], [],
                ['UF_DISTRICT']);
        }
        $sef = Sef::getInstance();
        $this->arResult['CURRENT'] = $sef->getCurrentCity();
    }

    private function getContactsCitiesGroup()
    {
        $arItems = [];
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "XML_ID");
        $arFilter = ['IBLOCK_ID' => CONTACTS_IBLOCK_ID];
        $res = CIBlockElement::GetList([], $arFilter, ['PROPERTY_CITY'], false, $arSelect);
        while ($ob = $res->Fetch()) {
            $arItems[] = $ob;
        }

        return array_column($arItems, 'PROPERTY_CITY_VALUE');
    }

    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate();
    }

}
