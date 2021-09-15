<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
use TQ\Tools\Sef;

if($arResult['ITEMS']){
    $sef = Sef::getInstance();
    $arSefElements = $sef->getSef();
foreach ($arResult['ITEMS'] as &$arItem){
    if($arItem['ID'] == $arSefElements['SERVICE']['ID']){
        $arItem['CURRENT'] = 'Y';
    }
    $arItem['DETAIL_PAGE_URL'] = $sef->getServiceUrl($arItem['CODE']);

}
unset($arItem);
}

