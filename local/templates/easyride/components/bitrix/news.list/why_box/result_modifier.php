<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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
if ($arResult['ITEMS']) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        if ($arItem['DISPLAY_PROPERTIES']['ICON']['VALUE']) {
            $arItem['ICON'] = CFile::ResizeImageGet($arItem['DISPLAY_PROPERTIES']['ICON']['VALUE'],
                array("width" => 24, "height" => 24), BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
        }
        if($arItem['PREVIEW_PICTURE']){
            $arItem['PICTURE'] = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'],array("width" => 147, "height" => 165),BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
        }else{
            $arItem['PICTURE'] = '';
        }
    }
    unset($arItem);
}