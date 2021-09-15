<?php

define('NO_KEEP_STATISTIC', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);
define('NO_AGENT_STATISTIC', true);
define('PERFMON_STOP', true);
define("DisableEventsCheck", true);
if(!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(dirname(dirname(__FILE__)));
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use TQ\Tools\Seo;


    $seo = new Seo();
    $seo->createSiteMap();

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");