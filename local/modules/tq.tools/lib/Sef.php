<?php


namespace TQ\Tools;

use Bitrix\Main\Loader,
    Bitrix\Iblock\ElementTable;

Loader::includeModule('iblock');

class Sef extends Singleton
{
    private $arSefItems,
        $arCurrentCity,
        $arCurrentAuto,
        $arSefParams = [
        ['IBLOCK_ID' => MARKS_IBLOCK_ID, 'NAME' => 'MARK'],
        ['IBLOCK_ID' => MODELS_IBLOCK_ID, 'NAME' => 'MODEL']
        //'YEAR'
    ],
        $arComputedProps = ['TITLE','DESCRIPTION','H1','ORDER_TITLE','PRICE_TITLE','SEO_TEXT_TITLE','SEO_TEXT','WHAT_TITLE'];

    protected function __construct()
    {
    }

    private function getService($code)
    {
        $arItem = [];
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "XML_ID", 'PREVIEW_TEXT', 'DETAIL_TEXT');
        $arFilter = ['IBLOCK_ID' => SERVICES_IBLOCK_ID, 'CODE' => $code];
        $res = \CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arFields['PROPERTIES'] = $ob->GetProperties();
            $arItem = $arFields;
        }

        return $arItem;
    }

    public function getSef()
    {
        global $APPLICATION;
        $arUrl = array_values(array_diff(explode('/', $APPLICATION->GetCurPage()), ['']));
        if ($arUrl && !$this->arSefItems) {
            $firstCode = array_shift($arUrl);
            $arCity = HL::getList(HL_LOCATION_ID, ['*'], ['UF_SUB_DOMAIN' => $firstCode], []);
            if ($arCity) {
                $this->arSefItems['CITY'] = reset($arCity);
            } else {
                $arService = $this->getService($firstCode);
                if ($arService) {
                    $this->arSefItems['SERVICE'] = $arService;
                }
            }
            if (count($arUrl) > 0) {
                if (!$this->arSefItems['SERVICE']) {
                    $firstCode = array_shift($arUrl);
                    $arService = $this->getService($firstCode);
                    if ($arService) {
                        $this->arSefItems['SERVICE'] = $arService;
                        if ($arUrl) {
                            $arUrl = array_values($arUrl);

                            foreach ($arUrl as $key => $value) {
                                if (!$this->arSefParams[$key]) {
                                    $this->arSefItems['404'] = 'Y';
                                    break;
                                }
                                if (is_array($this->arSefParams[$key])) {
                                    $arFilter = [
                                        '=IBLOCK_ID' => $this->arSefParams[$key]['IBLOCK_ID'],
                                        'ACTIVE' => 'Y',
                                        'CODE' => $value
                                    ];
                                    $arSelect = array("ID", "IBLOCK_ID", "NAME", "XML_ID", "CODE",'PROPERTY_NAME_RUS');
                                    $res = \CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
                                    if ($ob = $res->Fetch()) {
                                        $this->arSefItems[$this->arSefParams[$key]['NAME']] = $ob;
                                    } else {
                                        $this->arSefItems['404'] = 'Y';
                                        break;
                                    }
                                } else {
                                    $intVal = intval($value);
                                    if ($intVal && $intVal > 1995 && $intVal < date('Y')) {
                                        $this->arSefItems['YEAR'] = intval($value);
                                    } else {
                                        $this->arSefItems['404'] = 'Y';
                                        break;
                                    }
                                }
                            }
                        }
                    } else {
                        $this->arSefItems['404'] = 'Y';
                    }
                }
            }
        } elseif (!$this->arSefItems) {
            $this->arSefItems['INDEX'] = 'Y';
        }

        if ($this->arSefItems['SERVICE']) {
            $this->arSefItems['SERVICE']['COMPUTED'] = $this->computeTemplates($this->arSefItems);
        }
        return $this->arSefItems;
    }


    public function getServiceUrl($code, $ignoreSef = false)
    {
        $arUrl = [];
        $city = $this->getCurrentCity();
        $auto = $this->getCurrentAuto($ignoreSef);
        if ($city) {
            $arUrl[] = $city['UF_SUB_DOMAIN'];
        }
        $arUrl[] = $code;
        if ($auto) {
            foreach ($auto as $arItem) {
                $arUrl[] = $arItem['CODE'];
            }
        }

        return sprintf('/%s/', implode('/', $arUrl));
    }

    public function getCurrentCity()
    {
        if (!$this->arCurrentCity) {
            $arSefElements = $this->getSef();
            $currentCity = $_SESSION['CURRENT_CITY'];
            if ($arSefElements['CITY']) {
                $this->arCurrentCity = $arSefElements['CITY'];
                if ($currentCity != $arSefElements['CITY']['ID']) {
                    $_SESSION['CURRENT_CITY'] = $arSefElements['CITY']['ID'];
                   // setcookie('CURRENT_CITY', $arSefElements['CITY']['ID'], ['path' => '/']);
                }
            } elseif ($currentCity) {
                $arCity = HL::getList(HL_LOCATION_ID, ['*'], ['ID' => $currentCity], []);
                $this->arCurrentCity = reset($arCity);
            }
        }
        return $this->arCurrentCity;
    }

    public function getCurrentAuto($ignoreSef = false)
    {
        if (!$this->arCurrentAuto || $ignoreSef) {
            $arSefElements = [];
            if (!$ignoreSef) {
                $arSefElements = $this->getSef();
            }

            foreach ($this->arSefParams as $arParam) {
                $cookieName = sprintf('CURRENT_%s', $arParam['NAME']);
                $current = $_SESSION[$cookieName];
                if ($arSefElements[$arParam['NAME']]) {
                    $this->arCurrentAuto[$arParam['NAME']] = $arSefElements[$arParam['NAME']];
                    if (!$current) {
                        $_SESSION[$cookieName] = $arSefElements[$arParam['NAME']]['ID'];
                        //setcookie($cookieName, $arSefElements[$arParam['NAME']]['ID'], ['path' => '/']);
                    }
                } elseif ($current) {
                    $arFilter = [
                        '=IBLOCK_ID' => $arParam['IBLOCK_ID'],
                        'ACTIVE' => 'Y',
                        'ID' => $current
                    ];
                    $arSelect = array("ID", "IBLOCK_ID", "NAME", "CODE");
                    $res = \CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
                    if ($ob = $res->Fetch()) {
                        $this->arCurrentAuto[$arParam['NAME']] = $ob;
                    }
                }
            }
        }

        return $this->arCurrentAuto;
    }

    /**
     * @param $arItems
     * @return array
     * !SERVICE! - Название услуги
     * !AUTO! - Название авто (Марка+модель)
     * !AUTO_RU! - Название авто на русском (Марка+модель)
     * !AUTO_FULL! - Полное название авто (Марка+модель)
     * !CITY! - Город
     **/
    private function computeTemplates($arItems)
    {
        $arComputed = [];
        $auto = '';
        $autoRu = '';
        $autoFull = '';
        $service = $this->my_mb_lcfirst($arItems['SERVICE']['NAME']);
        if($arItems['MARK'])
        $arAutoNames[] = $arItems['MARK']['NAME'];
        if($arItems['MODEL'])
        $arAutoNames[] = $arItems['MODEL']['NAME'];
        if(isset($arAutoNames) && $arAutoNames){
            $auto = implode(' ',$arAutoNames);
        }
        if($arItems['MODEL']['PROPERTY_NAME_RUS_VALUE']){
            if($arItems['MARK'])
                $arRuNames[] = $arItems['MARK']['NAME'];
            $arRuNames[] = $arItems['MODEL']['PROPERTY_NAME_RUS_VALUE'];
            if($arRuNames)
            $autoRu = implode(' ',$arRuNames);
        }
        if($auto && $autoRu){
            $autoFull = sprintf('%s (%s)',$auto,$autoRu);
        }


        $city = $arItems['CITY']?sprintf('в городе %s',$arItems['CITY']['UF_NAME']):'';
        foreach ($arItems['SERVICE']['PROPERTIES'] as $arProperty){
            if(in_array($arProperty['CODE'],$this->arComputedProps)){
                $value = $arProperty['VALUE']['TEXT']?:$arProperty['DEFAULT_VALUE']['TEXT'];
                if($value){
                    $arComputed[$arProperty['CODE']] = $this->my_mb_ucfirst(htmlspecialchars_decode(str_replace(['!SERVICE!','!AUTO!','!AUTO_RU!','!AUTO_FULL!','!CITY!'],[$service,$auto,$autoRu,$autoFull,$city],$value)));
                }
            }
        }
        return $arComputed;
    }
    private function my_mb_ucfirst($str) {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }
    private function my_mb_lcfirst($str) {
        $fc = mb_strtolower(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }
}