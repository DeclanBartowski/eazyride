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

?>
<div class="info-block">
    <div class="container">
        <?if($arResult['PICTURE']){?>
        <div class="ico"><img src="<?=CFile::GetPath($arResult['PICTURE'])?>" alt="<?=$arResult['NAME']?>"></div>
        <?}?>
        <?if($arResult['DESCRIPTION']){?>
        <div class="title-bx"><?=$arResult['DESCRIPTION']?></div>
        <?}?>
        <div class="row">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <div class="col-sm-4 col-xs-12"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="ib-item">
            <div class="t1">
                <img src="<?=$arItem['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC']?>" alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arItem['NAME']?>">
                <?=$arItem['PREVIEW_TEXT']?>
            </div>
            <div class="t2"><?=$arItem['DETAIL_TEXT']?></div>
        </div>
    </div>

<?endforeach;?>
        </div>
    </div>
</div>


