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

<?if(!empty($arResult["ERROR_MESSAGE"]))
{
    foreach($arResult["ERROR_MESSAGE"] as $v)
        ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
    ?>
    <script>
        $('.overlay, .popup-comert-load').fadeIn();
        $(".phone-mask").mask("+7 (999) 999-99-99");
    </script>
    <?
}
?>
<form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="comert-form default-form">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
    <div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/img/pdf.svg" alt=""><span>Коммерческое предложение </span></div>
    <div class="t">Заполните все поля и получите коммерческое предложение на почту</div>
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <div class="lbl">Ваше имя *</div>
            <input type="text" name="NAME" required>
        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="lbl">Телефон *</div>
            <input type="text" name="PHONE" required class="phone-mask">
        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="lbl">E-mail *</div>
            <input type="text" name="EMAIL" required>
        </div>
    </div>
    <?if($arParams["USE_CAPTCHA"] == "Y"):?>
        <div class="mf-captcha">
            <div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
            <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
            <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
            <div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
            <input type="text" name="captcha_word" size="30" maxlength="50" value="">
        </div>
    <?endif;?>
    <input type="submit" class="btn" name="submit" value="Получить коммерческое предложение">

</form>


