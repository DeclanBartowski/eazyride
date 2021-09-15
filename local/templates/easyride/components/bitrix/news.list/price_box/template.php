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
if(!$arResult['ITEMS'])return false;
?>

<div class="price-box" id="prices">
    <div class="container">
        <?if($arParams['TITLE']){?>
        <div class="title-bx"><?=$arParams['TITLE']?></div>
        <?}?>
        <div class="row row-price">
<?foreach($arResult["ITEMS"] as $arItem){?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	?>
    <div class="col-sm-4 col-xs-12" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="price-frame">
            <div class="t1"><?=$arItem['NAME']?></div>
            <div class="t2"><?=$arItem['PREVIEW_TEXT']?></div>
            <a href="#calculate_form" class="btn">Рассчитать</a>
        </div>
    </div>
<?}?>
        </div>
    </div>
</div>


