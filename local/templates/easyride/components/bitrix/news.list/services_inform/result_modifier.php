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
    $arResult['BANNERS'] = array_filter($arResult['ITEMS'], function ($arItem) {
        return $arItem['PROPERTIES']['BANNER']['VALUE'] == 'Y';
    });
    $arItems = array_filter($arResult['ITEMS'], function ($arItem) {
        return $arItem['PROPERTIES']['BANNER']['VALUE'] != 'Y';
    });
    array_walk($arItems, function (&$arItem) {
        if ($arItem['PREVIEW_PICTURE']) {
            $arItem['PICTURE'] = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'],
                array("width" => 500, "height" => 150), BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
        } else {
            $arItem['PICTURE'] = '';
        }
    });
    unset($arItem);
    $arResult['GROUPS'] = array_chunk($arItems, 2);
}

