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
    <div class="partner-form-box">
        <div class="container">
            <div class="h3">Хотите зарабатывать <br> больше?</div>
            <div class="t">и стать нашим партнером</div>
            <form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="default-form calc-form partner-form">
                <?=bitrix_sessid_post()?>
                <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
                <div class="wr">
                    <div class="bx">
                        <div class="lbl">Введите Ваше имя</div>
                        <input type="text" placeholder="имя" name="NAME">
                    </div>
                    <div class="bx">
                        <div class="lbl">Введите Ваш телефон</div>
                        <input type="text" placeholder="+7 (___) ___-__-__" name="PHONE" class="phone-mask" required>
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
                    <input type="submit" name="submit" class="btn" value="Отправить заявку">
                </div>
                <div class="polit">Нажимая «Отправить заявку», я даю согласие на обработку персональных данных</div>
            </form>
        </div>
    </div>

