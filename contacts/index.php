<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
<?$APPLICATION->IncludeComponent(
    "2quick:pages",
    "",
    Array(),
    false
);?>
<?$APPLICATION->IncludeComponent(
    "2quick:addresses",
    "",
    Array(),
    false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>