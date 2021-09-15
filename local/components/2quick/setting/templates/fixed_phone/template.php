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
<div class="fixed-btn-bx">
    <a href="#calculate_form" class="btn">Рассчитать стоимость</a>
    <?if($arResult['VALUE']){?>
        <a href="tel:<?=normalizePhone($arResult['VALUE'])?>" class="call"></a>
    <?}?>
</div>


