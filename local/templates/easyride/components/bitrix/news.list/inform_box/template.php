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
<div class="inform-box">
    <div class="container">
        <?if($arParams['TITLE']){?>
        <div class="title-bx"><?=$arParams['TITLE']?></div>
        <?}?>
        <?if($arParams['DESCRIPTION']){?>
        <div class="under-text"><?=$arParams['DESCRIPTION']?></div>
        <?}?>
        <?foreach ($arResult['GROUPS'] as $arGroup){?>
            <div class="pic-bx">
                <?foreach ($arGroup as $arItem){
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                    ?>
                <div class="pic-item"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <?if($arItem['PICTURE']){?>
                    <div class="img"><img src="<?=$arItem['PICTURE']?>" alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arItem['NAME']?>"></div>
                    <?}?>
                    <div class="h3"><?=$arItem['NAME']?></div>
                    <p><?=$arItem['PREVIEW_TEXT']?></p>
                </div>
                <?}?>
            </div>
        <?}?>
        <?if($arResult['BANNERS']){?>
                <?foreach ($arResult['BANNERS'] as $arItem){
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
                    <div class="garant-bx" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="img" id="warranty">
                            <?if($arItem['PREVIEW_PICTURE']['SRC']){?>
                            <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arItem['NAME']?>" class="hidden-xs">
                            <?}
                            if($arItem['DETAIL_PICTURE']['SRC']){?>
                            <img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']?:$arItem['NAME']?>" class="hidden-lg hidden-md hidden-sm">
                            <?}?>
                        </div>
                        <?=$arItem['PREVIEW_TEXT']?>
                    </div>
                <?}?>
        <?}?>
</div>
</div>

