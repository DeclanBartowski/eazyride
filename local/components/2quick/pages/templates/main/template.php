<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
/** @var array $arParams */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var array $arResult */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
if(!$arResult['ITEM'])return false;
?>
<div class="text">
    <?if($arResult['ITEM']['PREVIEW_TEXT'] && $arResult['ITEM']['DETAIL_TEXT']){?>
    <div class="hidden-text">
        <p><?=$arResult['ITEM']['PREVIEW_TEXT']?></p>
        <p><?=$arResult['ITEM']['DETAIL_TEXT']?></p>
    </div>
    <a href="" class="open-text">Расскрыть</a>
    <?}elseif($arResult['ITEM']['PREVIEW_TEXT'] || $arResult['ITEM']['DETAIL_TEXT']){?>
        <p><?=$arResult['ITEM']['PREVIEW_TEXT']?:$arResult['ITEM']['DETAIL_TEXT']?></p>
    <?}?>
</div>



