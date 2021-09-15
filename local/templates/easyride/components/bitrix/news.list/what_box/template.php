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
if(!$arResult["ITEMS"])return false;
?>

<div class="what-box" id="akpp">
    <div class="container">
        <div class="wr">
            <?if($arParams['TITLE']){?>
                <div class="title-bx"><?=$arParams['TITLE']?></div>
            <?}?>
            <ul class="brand-list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

    <li  id="<?=$this->GetEditAreaId($arItem['ID']);?>"><?=$arItem['NAME']?></li>
<?endforeach;?>
                <?if($arResult['EMPTY_BLOCK_COUNT']){
                    for ($i = 0;$i<$arResult['EMPTY_BLOCK_COUNT'];$i++){?>
                <li></li>
                <?}
                    }?>
            </ul>
        </div>
    </div>
</div>

