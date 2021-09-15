<?php
use \Bitrix\Iblock\ElementTable;
use \Bitrix\Iblock\ElementPropertyTable;
use \Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Application;
use TQ\Tools\Seo;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
@set_time_limit(60000);
@ini_set('memory_limit', '5096М');
$APPLICATION->RestartBuffer();
header('Content-type: application/xml');
$seo = new Seo();
echo $seo->showSiteMap();
die();



