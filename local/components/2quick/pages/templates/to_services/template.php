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

<div class="comert-box">
    <div class="container">
        <div class="text">
            <div class="img"><img src="<?=SITE_TEMPLATE_PATH?>/img/picc.png" alt="<?=$arResult['ITEM']['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arResult['ITEM']['NAME']?>"></div>
            <div class="wr">
                <?if($arResult['ITEM']['DETAIL_TEXT']){?>
                    <?=$arResult['ITEM']['DETAIL_TEXT']?>
                <?}?>
                <?if($arResult['ITEM']['PREVIEW_TEXT']){?>
                    <div class="gift-bx">
                        <img src="<?=SITE_TEMPLATE_PATH?>/img/gift.svg" alt="<?=$arResult['ITEM']['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arResult['ITEM']['NAME']?>">
                        <span><?=$arResult['ITEM']['PREVIEW_TEXT']?></span>
                    </div>
                <?}?>
                <a href="javascript:void(0)" class="btn btn-comert">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/load.svg" alt="<?=$arResult['ITEM']['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arResult['ITEM']['NAME']?>">
                    <span>Скачать коммерческое предложение</span>
                </a>
            </div>
        </div>
    </div>
</div>


