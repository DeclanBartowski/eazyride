<?php

define('NO_KEEP_STATISTIC', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);
define('NO_AGENT_STATISTIC', true);
define('PERFMON_STOP', true);
define("DisableEventsCheck", true);
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use TQ\Tools\Import;

global $USER;
if ($USER->IsAdmin()) {
    Loader::includeModule('tq.tools');

$import = Import::getInstance();
$import->startImport(sprintf('%s/files/', __DIR__));
} else {
    ShowError('Раздел только для администраторов');
}
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
