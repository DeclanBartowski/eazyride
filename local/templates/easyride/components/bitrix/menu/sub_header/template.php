<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <div class="mnu-box">
        <div class="container">
            <div class="mnu-wrap">
                <ul class="mnu">
                    <?foreach($arResult as $arItem):
                        if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                            continue;?>
                            <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                    <?endforeach?>

                </ul>
            </div>
        </div>
    </div>
<?endif?>