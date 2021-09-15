<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Page\Asset;
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

?>
<?if($arResult){?>
    <div class="seo-text-box">
        <div class="container">
            <div class="wr">
                <?if($arResult['PROPERTY_TITLE_VALUE']){?>
                <div class="title-bx"><?=$arResult['PROPERTY_TITLE_VALUE']?></div>
                <?}?>
                <?if($arResult['PREVIEW_TEXT']){?>
                <div class="text">
                    <?=$arResult['PREVIEW_TEXT']?>
                </div>
                <?}?>
            </div>
        </div>
    </div>
<?}?>

