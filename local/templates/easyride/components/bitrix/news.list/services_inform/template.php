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
        <ul class="step-list">

            <?foreach ($arResult['ITEMS'] as $arItem){
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                ?>
                <li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="ico"><img src="<?=$arItem['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC']?>" alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']?:$arItem['NAME']?>"></div>
                    <?if($arItem['PREVIEW_TEXT']){?>
                        <div class="t1"><?=$arItem['PREVIEW_TEXT']?></div>
                    <?}?>
                    <?if($arItem['DETAIL_TEXT']){?>
                        <div class="t2"><?=$arItem['DETAIL_TEXT']?></div>
                    <?}?>
                </li>

            <?}?>

        </ul>
    </div>
</div>


