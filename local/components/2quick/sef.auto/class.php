<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader,
    TQ\Tools\Sef,
    TQ\Tools\HL;

Loader::includeModule('tq.tools');
Loader::includeModule('iblock');

class SefAuto extends \CBitrixComponent
{
    private $componentPage = '';


    private function getPage()
    {
        global $APPLICATION;
        if ($this->arParams["SEF_MODE"] == "Y") {
            $sef = Sef::getInstance();
            $arSefElements = $sef->getSef();

            if ($arSefElements['SERVICE']) {
                $this->componentPage = 'service';
            } elseif ($arSefElements['CITY'] || $arSefElements['INDEX'] == 'Y') {
                $this->componentPage = 'index';
            }
            if ($arSefElements['404'] == 'Y' || !$this->componentPage) {
                $folder404 = str_replace("\\", "/", $this->arParams["SEF_FOLDER"]);
                if ($folder404 != "/") {
                    $folder404 = "/" . trim($folder404, "/ \t\n\r\0\x0B") . "/";
                }
                if (substr($folder404, -1) == "/") {
                    $folder404 .= "index.php";
                }

                if ($folder404 != $APPLICATION->GetCurPage(true)) {
                    \Bitrix\Iblock\Component\Tools::process404(
                        ""
                        , ($this->arParams["SET_STATUS_404"] === "Y")
                        , ($this->arParams["SET_STATUS_404"] === "Y")
                        , ($this->arParams["SHOW_404"] === "Y")
                        , $this->arParams["FILE_404"]
                    );
                }
            }else{
                $this->arResult = $arSefElements;
            }
        }
    }


    public function executeComponent()
    {
        $this->getPage();
        $this->includeComponentTemplate($this->componentPage);
    }

}
