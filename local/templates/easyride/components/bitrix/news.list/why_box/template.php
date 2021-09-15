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

<div class="why-box" id="why">
    <div class="container">
        <?if($arParams['TITLE']){?>
        <div class="title-bx"><?=$arParams['TITLE']?></div>
        <?}?>
        <div class="wr">
<?foreach($arResult["ITEMS"] as $arItem){?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	?>
    <div class="text-frame <?=$arItem['PROPERTIES']['STYLE']['VALUE_XML_ID']?>"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?if($arItem['PICTURE']){?>
        <div class="ava"><img src="<?=$arItem['PICTURE']?>" alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arItem['NAME']?>"></div>
        <?}?>
        <div class="frame">
            <div class="h3"><?=$arItem['NAME']?> <?if($arItem['ICON']){?><img src="<?=$arItem['ICON']?>" alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arItem['NAME']?>"><?}?></div>
            <?if($arItem['DISPLAY_PROPERTIES']['LIST']['~VALUE']){?>
            <ul class="list">
                <?foreach ($arItem['DISPLAY_PROPERTIES']['LIST']['~VALUE'] as $value){?>
                <li><?=$value?></li>
                <?}?>
            </ul>
            <?}?>
        </div>
    </div>
<?}?>
        </div>
    </div>
</div>


