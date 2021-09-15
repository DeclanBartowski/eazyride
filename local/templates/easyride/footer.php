<?

/**
 * @var $arCity
 * @global  $APPLICATION
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<?if($APPLICATION->GetProperty('text_page') == 'Y'){?>
    </div>
<?}?>
</main>
<footer class="footer">
    <div class="foot-top hidden-xs">
        <div class="container">
            <div class="row">
                <?
                $GLOBALS['arServiceMenuFilter'] = ['PROPERTY_SHOW_ON_MENU_VALUE'=>'Y'];
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "service_menu_footer",
                    Array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "arServiceMenuFilter",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "30",
                        "IBLOCK_TYPE" => "content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("ICON", "ICON", ""),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "SORT",
                        "SORT_BY2" => "ID",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N"
                    )
                );?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "footer",
                    Array(
                        "TITLE"=>"О нас",
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(0=>"",),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "bottom",
                        "USE_EXT" => "N"
                    )
                );?>


            </div>
        </div>
    </div>
    <div class="foot-mid">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <div class="flogo"><img src="<?=SITE_TEMPLATE_PATH?>/img/flogo.svg" alt=""></div>
                    <?$APPLICATION->IncludeComponent(
                        "2quick:setting",
                        "copy",
                        Array(
                            "SETTING" => "tq_module_param_obshchie_nastroyki_copy"
                        )
                    );?>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom_footer",
                        Array(

                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(0=>"",),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "footer",
                            "USE_EXT" => "N"
                        )
                    );?>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="cont-bx">
                        <div class="town-wr">
                            <div class="town-opener">
                                <img src="<?=SITE_TEMPLATE_PATH?>/img/town2.svg" alt="">
                                <span><?=$arCity['UF_NAME']?:'Москва'?></span>
                            </div>
                            <div class="phone-bx">
                                <?$APPLICATION->IncludeComponent(
                                    "2quick:setting",
                                    "footer",
                                    Array(
                                        "SETTING" => "tq_module_param_obshchie_nastroyki_phone"
                                    )
                                );?>
                            </div>
                        </div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:news.list",
                            "soc",
                            Array(
                                "CLASS"=>"soc-list",
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "AJAX_MODE" => "N",
                                "AJAX_OPTION_ADDITIONAL" => "",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "CACHE_FILTER" => "N",
                                "CACHE_GROUPS" => "Y",
                                "CACHE_TIME" => "36000000",
                                "CACHE_TYPE" => "A",
                                "CHECK_DATES" => "Y",
                                "DETAIL_URL" => "",
                                "DISPLAY_BOTTOM_PAGER" => "Y",
                                "DISPLAY_DATE" => "Y",
                                "DISPLAY_NAME" => "Y",
                                "DISPLAY_PICTURE" => "Y",
                                "DISPLAY_PREVIEW_TEXT" => "Y",
                                "DISPLAY_TOP_PAGER" => "N",
                                "FIELD_CODE" => array("", ""),
                                "FILTER_NAME" => "",
                                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                "IBLOCK_ID" => "17",
                                "IBLOCK_TYPE" => "content",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "MESSAGE_404" => "",
                                "NEWS_COUNT" => "20",
                                "PAGER_BASE_LINK_ENABLE" => "N",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "N",
                                "PAGER_SHOW_ALWAYS" => "N",
                                "PAGER_TEMPLATE" => ".default",
                                "PAGER_TITLE" => "Новости",
                                "PARENT_SECTION" => "",
                                "PARENT_SECTION_CODE" => "",
                                "PREVIEW_TRUNCATE_LEN" => "",
                                "PROPERTY_CODE" => array("ICON",'URL'),
                                "SET_BROWSER_TITLE" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_STATUS_404" => "N",
                                "SET_TITLE" => "N",
                                "SHOW_404" => "N",
                                "SORT_BY1" => "SORT",
                                "SORT_BY2" => "ID",
                                "SORT_ORDER1" => "ASC",
                                "SORT_ORDER2" => "ASC",
                                "STRICT_SECTION_CHECK" => "N"
                            )
                        );?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="foot-bot">
        <div class="container">
            <div class="t">Ответим на ваши вопросы:</div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "soc",
                Array(
                    "CLASS"=>"mes-list",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => array("", ""),
                    "FILTER_NAME" => "",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => "18",
                    "IBLOCK_TYPE" => "content",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "20",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Новости",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "PROPERTY_CODE" => array("ICON",'URL'),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "SORT",
                    "SORT_BY2" => "ID",
                    "SORT_ORDER1" => "ASC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N"
                )
            );?>
        </div>
    </div>
</footer>
</div>
<div class="overlay"></div>
<div class="popup-town-wrap">
    <div class="popup popup-town">
        <div class="close"><img src="<?=SITE_TEMPLATE_PATH?>/img/close.svg" alt=""></div>
        <?$APPLICATION->IncludeComponent(
            "2quick:cities",
            "",
            Array(),
            false
        );?>
    </div>
</div>
<?$APPLICATION->IncludeComponent(
    "2quick:setting",
    "fixed_phone",
    Array(
        "SETTING" => "tq_module_param_obshchie_nastroyki_phone"
    )
);?>


<div class="popup popup-comert popup-comert-form">
    <div class="close"><img src="<?=SITE_TEMPLATE_PATH?>/img/close2.svg" alt=""></div>
    <div class="vh">
        <div class="container">
            <?$APPLICATION->IncludeComponent(
                "2quick:main.feedback",
                "kp",
                Array(
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "EMAIL_TO" => "",
                    "EVENT_MESSAGE_ID" => array('12'),
                    "INFOBLOCKADD" => "Y",
                    "INFOBLOCKID" => "15",
                    "LINK" => "",
                    "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                    "REQUIRED_FIELDS" => array(0=>"NONE",),
                    "TITLE" => "",
                    "USE_CAPTCHA" => "N"
                )
            );?>

        </div>
    </div>
</div>

<div class="popup popup-comert popup-comert-load">
    <div class="close"><img src="<?=SITE_TEMPLATE_PATH?>/img/close2.svg" alt=""></div>
    <div class="vh">
        <div class="container">
            <div class="load-comert-bx">
                <div class="ico"><img src="<?=SITE_TEMPLATE_PATH?>/img/tnx.svg" alt=""></div>
                <div class="h3">Спасибо! <br>за проявленный интерес.</div>
                <p>Теперь вы можете скачать коммерческое <br> предложение по ссылке ниже</p>
                <?$APPLICATION->IncludeComponent(
                    "2quick:file.link",
                    "",
                    Array(
                        "CODE" => "kp"
                    )
                );?>
            </div>
        </div>
    </div>
</div>

<div class="popup popup-comert popup-comert-tnx">
    <div class="close" id="#close_reload"><img src="<?=SITE_TEMPLATE_PATH?>/img/close2.svg" alt=""></div>
    <div class="vh">
        <div class="container">
            <div class="load-comert-bx">
                <div class="ico"><img src="<?=SITE_TEMPLATE_PATH?>/img/tnx2.svg" alt=""></div>
                <div class="h3">Спасибо!</div>
                <p>Наш менеджер скоро с вами свяжется</p>
            </div>
        </div>
    </div>
</div>
<!--[if lt IE 9]>
<script data-skip-moving src="/local/templates/easyride/libs/html5shiv/es5-shim.min.js"></script>
<script data-skip-moving src="/local/templates/easyride/libs/html5shiv/html5shiv.min.js"></script>
<script data-skip-moving src="/local/templates/easyride/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script data-skip-moving src="/local/templates/easyride/libs/respond/respond.min.js"></script>
<![endif]-->
<?$APPLICATION->IncludeComponent(
    "2quick:scheme",
    "",
    Array(),
    false
);?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(85030096, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/85030096" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>