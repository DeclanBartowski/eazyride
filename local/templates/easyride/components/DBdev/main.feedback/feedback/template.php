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
	?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>


<form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="form" enctype="multipart/form-data">
    <?=bitrix_sessid_post()?>
    <div class="row">
        <div class="col-lg-6">
            <input type="text"  name="NAME" placeholder="Ваше имя" class="vf-all" required="required">
            <input type="text"  name="PHONE" placeholder="Номер телефона" class="vf-all" required="required">
            <input type="text"  name="EMAIL" placeholder="E-mail" class="vf-all" required="required">
        </div>
        <div class="col-lg-6">
            <textarea name="MESSAGE" class="vf-all" id="" placeholder="Сообщение"></textarea>
        </div>

        <div class="col-lg-12">
            <div class="left">
                <div class="file_upload">
                    <button type="button"><i class="demo-icon icon-clip"></i> Прикрепить файл</button>
                    <div></div>
                    <input type="file" name="file">
                </div>
                <div class="check">
                    <input type="checkbox" required  class="checkbox" id="checkbox2" />
                    <label for="checkbox2">Я принимаю условия пользовательского соглашения</label>
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
            <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
            <input type="hidden" name="submit" value="Y">
            <button class="btn btn-feed vf-submit" type="submit">Отправить</button>
        </div>
    </div>
</form>