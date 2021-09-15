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
<?if($arParams['TITLE']){?>
    <div class="title-bx"><?=$arParams['TITLE']?></div>
<?}?>
<ul class="ico-list" id="sheme">
    <?foreach($arResult["ITEMS"] as $arItem){?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        ?>
        <li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?if($arItem['ICON']){?>
            <div class="ico"><img src="<?=$arItem['ICON']?>" alt="<?=$arItem['NAME']?>"></div>
            <?}?>
            <div class="tt">
                <div class="h4"><?=$arItem['NAME']?></div>
                <?if($arItem['PREVIEW_TEXT']){?>
                <p><?=$arItem['PREVIEW_TEXT']?></p>
                <?}?>
            </div>
        </li>
    <?}?>
</ul>



