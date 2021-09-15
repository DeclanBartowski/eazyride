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

<div class="faq-box" id="faq" itemscope itemtype="https://schema.org/FAQPage">
    <div class="container">
        <?if($arParams['TITLE']){?>
        <div class="title-bx"><?=$arParams['TITLE']?></div>
        <?}?>
        <div class="row row-price">
<?foreach($arResult["ITEMS"] as $key=> $arItem){?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	?>
    <div class="faq-item<?=$key == 0?' opened':''?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <div class="hh" itemprop="name"><?=$arItem['PREVIEW_TEXT']?></div>
        <div class="tt" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
            <meta itemprop="text" content="<?=$arItem['DETAIL_TEXT']?>">
            <?=$arItem['DETAIL_TEXT']?>
        </div>
    </div>
<?}?>
        </div>
    </div>
</div>


