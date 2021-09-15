<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
$APPLICATION->SetPageProperty('show_submenu','Y');
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Главная");
?><?$APPLICATION->IncludeComponent(
	"2quick:sef.auto",
	"",
	Array(
		"FILE_404" => "",
		"MESSAGE_404" => "",
		"SEF_FOLDER" => "",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("service"=>"#SERVICE_PATH#/"),
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y"
	),
false,
Array(
	'HIDE_ICONS' => 'Y'
)
);?><?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>