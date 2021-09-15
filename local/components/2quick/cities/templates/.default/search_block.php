<?/**
 *@var $arResult
 */?>
<ul class="town-list" id="city_list">
<?if($arResult['FAVORITES']){
    foreach ($arResult['FAVORITES'] as $arCity){?>
        <li><a href="/<?=$arCity['UF_SUB_DOMAIN']?>/"><?=$arCity['UF_NAME']?></a></li>
    <?}?>
<?}?>
</ul>
