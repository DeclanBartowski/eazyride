<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

?>

<h1 class="h1-title"><?=$arParams['~TITLE']?></h1>
<div class="t1"><?=$arParams['~DESCRIPTION']?></div>
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
    foreach($arResult["ERROR_MESSAGE"] as $v)
        ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{

    ?>
    <script>
        $('.overlay, .popup-comert-tnx').fadeIn();
        $(".phone-mask").mask("+7 (999) 999-99-99");
        $('.overlay, .close').data('reload','Y');
        <?if(isset($arResult['SERVICE_URL']) && $arResult['SERVICE_URL']){?>
        $('.overlay, .close').data('reload_href','<?=$arResult['SERVICE_URL']?>');
        <?}?>
        changeMark();
    </script>
    <?
}
?>
<form  action="<?=POST_FORM_ACTION_URI?>" method="post" class="default-form calc-form" id="calculate_form">
    <?=bitrix_sessid_post()?>
    <?if($arParams['SERVICE_ID']){?>
    <input type="hidden" name="SERVICE_ID" value="<?=$arParams['SERVICE_ID']?>">
    <?}?>
    <div class="wr">
        <div class="bx">
            <div class="lbl">Выберите марку</div>
            <select name="MARK" class="tq_auto_select">
                <option value="">Выбрать</option>
                <?foreach ($arResult['MARKS'] as $arMark){?>
                <option value="<?=$arMark['ID']?>"<?=$arMark['CURRENT'] == 'Y'?' selected':''?>><?=$arMark['NAME']?></option>
                <?}?>
            </select>
        </div>
        <div class="bx">
            <div class="lbl">Выберите Модель</div>
            <select name="MODEL" class="tq_auto_select rev-select-box">
                <option value="">Выберите марку</option>
            </select>
        </div>
        <div class="bx">
            <div class="lbl">Выберите год выпуска</div>
            <select name="YEAR" class="rev-select-box">
                <option value="">Выбрать</option>
                <?for($i = 1995;$i<=date('Y');$i++){?>
                    <option value="<?=$i?>"><?=$i?></option>
                <?}?>

            </select>
        </div>
        <div class="bx">
            <div class="lbl">Ваш телефон</div>
            <input type="text" name="PHONE" placeholder="+7 (___) ___-__-__" class="phone-mask" required>
        </div>
        <div class="bx">
            <?if($arParams["USE_CAPTCHA"] == "Y"):?>
                <div class="mf-captcha">
                    <div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
                    <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
                    <div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
                    <input type="text" name="captcha_word" size="30" maxlength="50" value="">
                </div>
            <?endif;?>
            <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
            <input type="submit" name="submit" class="btn" value="Рассчитать стоимость">
        </div>
    </div>
    <div class="polit">Нажимая «Рассчитать стоимость», я даю согласие на обработку персональных данных</div>
</form>


