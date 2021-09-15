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
<?if($arResult['VALUE']){?>
    <a href="tel:<?=normalizePhone($arResult['VALUE'])?>">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/phone2.svg" alt="">
        <span><?=$arResult['VALUE']?></span>
    </a>
<?}?>

