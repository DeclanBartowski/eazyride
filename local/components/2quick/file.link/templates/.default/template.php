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
<?if($arResult['FILE']['SRC']){?>
    <a href="<?=$arResult['FILE']['SRC']?>" download="" class="btn">
        <img src="<?=SITE_TEMPLATE_PATH?>/img/load.svg" alt="load">
        <span>Скачать коммерческое предложение   <?=$arResult['FILE_SIZE']?></span>
    </a>
<?}?>

