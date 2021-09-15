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
if(!$arResult['DISTRICTS'])return false;
?>
<div class="address-search-box">
    <div class="container">
        <div class="h4"><?=Loc::getMessage('ADDRESSES_TITLE')?></div>
        <p><?=Loc::getMessage('ADDRESSES_DESCRIPTION')?></p>
        <form action="" class="default-form address-search-form">
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <div class="lbl"><?=Loc::getMessage('ADDRESSES_DISTRICTS')?></div>
                    <select class="tq_location_select" name="district">
                        <option value="">Выбрать</option>
                        <?foreach ($arResult['DISTRICTS'] as $key=> $arItem){?>
                        <option value="<?=$arItem['UF_DISTRICT']?>"<?=$arResult['CURRENT']['UF_DISTRICT'] == $arItem['UF_DISTRICT']?' selected':''?>><?=$arItem['UF_DISTRICT']?></option>
                        <?}?>
                    </select>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="lbl lbl-disabled"><?=Loc::getMessage('ADDRESSES_REGIONS')?></div>
                    <select class="tq_location_select" name="region" disabled>
                        <option value="">Выбрать</option>
                    </select>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="lbl lbl-disabled"><?=Loc::getMessage('ADDRESSES_CITIES')?></div>
                    <select class="tq_location_select" name="city" disabled>
                        <option value="">Выбрать</option>
                    </select>
                </div>
            </div>
        </form>
        <ul class="address-search-list">
        </ul>
    </div>
</div>

