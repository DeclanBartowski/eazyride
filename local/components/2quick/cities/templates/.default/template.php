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
?>
<div class="town-search-bx">
    <div class="title-bx">Ваш город</div>
    <form action="" class="town-search-form" id="city_search_form">
        <input type="text" name="query" placeholder="Найти город">
    </form>
    <?include ('search_block.php')?>

</div>
<?if($arResult['DISTRICTS']){?>
<div class="town-search-list-bx">
    <div class="bx">
        <div class="h3">Округ</div>
        <ul class="list" id="city_district_list">
            <?foreach ($arResult['DISTRICTS'] as $arItem){?>
            <li><a href="javascript:void(0)" data-city-object="district" data-id="<?=$arItem['UF_DISTRICT']?>"><?=$arItem['UF_DISTRICT']?></a></li>
            <?}?>
        </ul>
    </div>
    <div class="bx">
        <div class="h3">Регион</div>
        <ul class="list" id="city_region_list">
        </ul>
    </div>
    <div class="bx">
        <div class="h3">Город</div>
        <ul class="list" id="city_list_block">

        </ul>
    </div>
</div>
<?}?>


