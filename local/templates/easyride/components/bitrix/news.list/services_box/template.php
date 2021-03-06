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
<div class="service-box">
    <div class="container">
        <?if($arParams['TITLE']){?>
            <div class="title-bx"><?=$arParams['TITLE']?></div>
        <?}?>
        <div class="wr">
            <div class="aside">
                <ul class="tabset">
                    <?foreach($arResult["ITEMS"] as $key=> $arItem){?>
                        <?
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                        ?>
                        <li id="<?=$this->GetEditAreaId($arItem['ID'])?>"><a href="#tab<?=$key?>"<?=$key == 0?' class="active"':''?> ><?=$arItem['NAME']?></a></li>
                    <?}?>
                </ul>
            </div>
            <div class="tab-list">
                <?foreach($arResult["ITEMS"] as $key=> $arItem){?>
                    <div class="tab" id="tab<?=$key?>">
                        <div class="service-item serv1-bg" <?if($arItem['PREVIEW_PICTURE']){?>style="background: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>) 50% / cover no-repeat;" <?}?>>
                            <div class="frame">
                                <?=$arItem['PREVIEW_TEXT']?>
                            </div>
                        </div>
                    </div>
                <?}?>


            </div>
        </div>
    </div>
</div>
<script>
    jQuery('ul.tabset').contentTabs({
        activeClass:'active',      // ???????????????? ?????????? ?????? ??????-????????????
        addToParent:false,         // ?????????????????? ???????????????? ?????????? ???? ???? ????????????, ?? ???? ???? ????????????????
        autoHeight:false,          // ?????????????? ?????????????????? ???????????? ?????? ?????????? ?????????? (?????????????? ???????????????????????????????? ???????????????? ??????????)
        autoRotate:false,          // ??????/???????? ??????????????????????
        switchTime:3000,           // ?????????????? ?????????????????????? (3??????)
        animSpeed:400,             // ???????????????? ????????????????
        effect: 'none',            // ???????????? ???????????????????????? ?????????? "none", "fade" ?????? "slide"
        tabLinks:'a',              // ???????????????? ??????-???????????? ???????????? ??????????????
        event:'click'              // ?????????????? ??????-???????????? "click", "mouseover" ?? ??.??.
    });
</script>



