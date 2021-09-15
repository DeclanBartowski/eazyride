<?php

$arUrlRewrite = array(
    0 =>
        array(
            'CONDITION' => '#^/rest/#',
            'RULE' => '',
            'ID' => null,
            'PATH' => '/bitrix/services/rest/index.php',
            'SORT' => 100,
        ),
    1 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap.xml#',
            "RULE" => "",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    2 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_pages.xml#',
            "RULE" => "",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    3 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_cities.xml#',
            "RULE" => "",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    4 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_services.xml#',
            "RULE" => "",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    5 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_services_links.xml#',
            "RULE" => "",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    6 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_services_links_city_([0-9]+).xml#',
            "RULE" => "service_city=$1",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    7 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_city_([0-9]+).xml#',
            "RULE" => "city=$1",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    8 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_service_([0-9]+).xml#',
            "RULE" => "service=$1",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    9 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_service_([0-9]+)_([0-9]+).xml#',
            "RULE" => "service=$1&mark=$2",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    10 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_city_service_([0-9]+)_([0-9]+).xml#',
            "RULE" => "city=$1&service=$2",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    11 =>
        array(
            'CONDITION' => '#^/sitemap/sitemap_city_service_([0-9]+)_([0-9]+)_([0-9]+).xml#',
            "RULE" => "city=$1&service=$2&mark=$3",
            'ID' => '',
            'PATH' => '/sitemap/generate.php',
            'SORT' => 100,
        ),
    12 =>
        array(
            'CONDITION' => '#^#',
            'RULE' => '',
            'ID' => '2quick:sef.auto',
            'PATH' => '/index.php',
            'SORT' => 100,
        ),
);
