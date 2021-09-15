<?

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;
use TQ\Tools\Sef;

global $APPLICATION;
$page = $APPLICATION->GetCurPage();
$sef = Sef::getInstance();
$arCity = $sef->getCurrentCity();
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="ru"> <!--<![endif]-->
<head>

    <?
    $APPLICATION->ShowHead(); ?>
    <title><?
        $APPLICATION->ShowTitle(); ?></title>

    <?
    Asset::getInstance()->addString('<meta charset="utf-8">');
    Asset::getInstance()->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge">');
    Asset::getInstance()->addString('<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/owl.carousel.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/owl.theme.default.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/bootstrap-grid.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/fonts/fonts.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/main.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/media.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/costume.css");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery-1.11.2.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/owl.carousel.js");
    //Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jcf.js");
    //Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jcf.select.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/custom-selectbox.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.maskedinput.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/common.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.tabs.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/costume.js");
    ?>

</head>
<body>

<?
$APPLICATION->ShowPanel(); 

?>
<div id="wrapper">
    <header class="header">
        <div class="head-top">
            <div class="container">
                <div class="toggle_mnu">
					<span class="sandwich">
					<span class="sw-topper"></span>
					<span class="sw-bottom"></span>
					<span class="sw-footer"></span>
					</span>
                </div>

                <div class="wrap">

                    <div class="logo">
                        <a href="<?=$arCity['UF_SUB_DOMAIN']?sprintf('/%s/',$arCity['UF_SUB_DOMAIN']):'/'?>">
                            <img class="hidden-xs hidden-sm" src="<?= SITE_TEMPLATE_PATH ?>/img/logo.svg" alt="">
                            <img class="hidden-lg hidden-md " src="<?= SITE_TEMPLATE_PATH ?>/img/logo-mob.svg" alt="">
                        </a>
                    </div>
                    <div class="town-wr">
                        <div class="town-modal">
                            <div class="town-name"><span><?=$arCity['UF_NAME']?:'Москва'?></span></div>
                            <div class="t">это ваш регион?</div>
                            <div class="btns">
                                <a href="" class="btn btn-yes">Да</a>
                                <a href="" class="btn btn-no">Нет</a>
                            </div>
                        </div>
                        <div class="town-opener">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.2798 0.347857L8.26952 14.3435L6.3087 7.92823L1.94553e-05 5.64775L14.2798 0.347857Z"
                                      fill="#141414"/>
                            </svg>
                            <span><?=$arCity['UF_NAME']?:'Москва'?></span>
                        </div>
                        <div class="phone-bx">
                            <?
                            $APPLICATION->IncludeComponent(
                                "2quick:setting",
                                "",
                                array(
                                    "SETTING" => "tq_module_param_obshchie_nastroyki_phone"
                                )
                            ); ?>
                        </div>
                    </div>
                </div>

                <div class="nav-bx">
                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "header",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(0 => "",),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "N"
                        )
                    ); ?>
                    <?
                    $GLOBALS['arServiceMenuFilter'] = ['PROPERTY_SHOW_ON_MENU_VALUE'=>'Y'];
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "service_menu",
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
                </div>
            </div>
        </div>
        <?
        if ($APPLICATION->GetProperty('show_submenu') == 'Y') { ?>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "sub_header",
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(0 => "",),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "sub_header",
                    "USE_EXT" => "N"
                )
            ); ?>

        <?
        } ?>
    </header>
    <main class="main">
        <?if($APPLICATION->GetProperty('text_page') == 'Y'){?>
        <div class="container">
        <?}?>
