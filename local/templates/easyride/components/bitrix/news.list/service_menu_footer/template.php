<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if($arResult['ITEMS']){
?>

    <div class="col-sm-8 col-md-6 col-xs-12">
        <div class="h3">Услуги</div>
        <ul class="list list-double">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <li  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <a<?=$arItem['CURRENT'] == 'Y'?' class="act"':''?> href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
    </li>
<?endforeach;?>
        </ul>
    </div>
<?}?>

