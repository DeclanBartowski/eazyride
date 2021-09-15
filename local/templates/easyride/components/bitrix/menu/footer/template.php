<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <div class="col-sm-4 col-md-6 col-lg-5 col-lg-offset-1 col-xs-12">
        <div class="h3"><?=$arParams['TITLE']?></div>
        <ul class="list">
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
		<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
<?endforeach?>

        </ul>
    </div>
<?endif?>