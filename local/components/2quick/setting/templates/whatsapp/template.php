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
    <div class="whats-bx">
        <div class="ph"><img src="<?=SITE_TEMPLATE_PATH?>/img/telep.png" alt=""></div>
        <div class="tt">
            <div class="ico"><img src="<?=SITE_TEMPLATE_PATH?>/img/whatsapp.png" alt=""></div>
            <div class="t">Проконсультироваться с инженером <br>по ремонту  по Whatsapp</div>
        </div>
        <a href=" https://wa.me/<?=normalizePhone($arResult['VALUE'])?>" target="_blank" class="bt"><img src="<?=SITE_TEMPLATE_PATH?>/img/ava.png" alt=""><span>Начать переписку</span></a>
    </div>

<?}?>

