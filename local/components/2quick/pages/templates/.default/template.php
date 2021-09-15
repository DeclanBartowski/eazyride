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

<div class="about-info-box">
    <div class="container">
        <div class="title-bx"><?=$arResult['TITLE']?></div>
        <?if($arResult['ITEM']['PREVIEW_TEXT']){?>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="t">
                <?=$arResult['ITEM']['PREVIEW_TEXT']?>
                </div>
            </div>
        </div>
        <?}?>
    </div>
    <?if($arResult['ITEM']['PREVIEW_PICTURE']['SRC']){?>
    <div class="image"><img src="<?=$arResult['ITEM']['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arResult['ITEM']['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arResult['ITEM']['NAME']?>"></div>
    <?}?>
    <div class="container">
        <?=$arResult['ITEM']['DETAIL_TEXT']?>
        <?if($arResult['ITEM']['PROPERTY_SHOW_CONTACTS_VALUE'] == 'Y'){?>
        <div class="sep"></div>
        <div class="contacts-bx">
            <div class="h4"><?=Loc::getMessage('CONTACTS_TITLE')?></div>
            <ul class="cc-list">
                <?if($arResult['CONTACTS']['PHONE']){?>
                <li>
                    <div class="ico"><img src="<?=SITE_TEMPLATE_PATH?>/img/cc1.svg" alt=""></div>
                    <div class="tel"><a href="tel:<?=$arResult['CONTACTS']['PHONE']['NORMALIZED_VALUE']?>"><?=$arResult['CONTACTS']['PHONE']['VALUE']?></a></div>
                </li>
                <?}?>
                <?if($arResult['CONTACTS']['EMAIL']){?>
                <li>
                    <div class="ico"><img src="<?=SITE_TEMPLATE_PATH?>/img/cc2.svg" alt=""></div>
                    <div class="tt">E-mail: <a href="mailto:<?=$arResult['CONTACTS']['EMAIL']?>"><?=$arResult['CONTACTS']['EMAIL']?></a></div>
                </li>
                <?}?>
                <?if($arResult['CONTACTS']['CENTER']){?>
                <li>
                    <div class="ico"><img src="<?=SITE_TEMPLATE_PATH?>/img/cc3.svg" alt=""></div>
                    <div class="tt">Центральный техцентр: <span><?=$arResult['CONTACTS']['CENTER']?></span></div>
                </li>
                <?}?>
            </ul>
        </div>
        <?}?>
    </div>
</div>


