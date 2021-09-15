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

    array_walk($arResult['ITEMS'], function (&$arItem) {
        if ($arItem['PROPERTIES']['ICON']['VALUE']) {
            $arItem['ICON'] = CFile::GetPath($arItem['PROPERTIES']['ICON']['VALUE']);
        } else {
            $arItem['ICON'] = '';
        }
    });

}

