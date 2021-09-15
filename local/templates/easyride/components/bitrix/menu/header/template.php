<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <div class="links-bx">
        <ul class="links">
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
        <?if($arItem["LINK"]){?>
		<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
        <?}else{?>
        <li><?=$arItem["TEXT"]?></li>
        <?}?>

	
<?endforeach?>

        </ul>
    </div>
<?endif?>