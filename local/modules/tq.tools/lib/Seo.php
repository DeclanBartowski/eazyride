<?php


namespace TQ\Tools;

use Bitrix\Iblock\ElementTable,
    Bitrix\Main\Loader,
    Bitrix\Seo\RobotsFile,
    Bitrix\Main\Application,
    \Bitrix\Main\Entity\ReferenceField,
    \Bitrix\Iblock\ElementPropertyTable;

@set_time_limit(60000);
@ini_set('memory_limit', '5096М');
Loader::includeModule('iblock');

class Seo
{

    private $prefix,
        $arDisallow,
        $date,
        $documentRoot;

    public function __construct()
    {
        /*if ($_SERVER['HTTP_HOST']) {
            $this->prefix = sprintf('%s://%s', $_SERVER['HTTPS']?'https':'http', $_SERVER['HTTP_HOST']);
        } else {
            $this->prefix = 'http://eazyride.ru/';
        }*/
        $this->prefix = 'http://eazyride.ru';

        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $this->arDisallow = $this->getRobotsRulesList();
        $this->date = date('Y-m-d', strtotime("last day of -1 month"));
    }

    private function getXml($code, $priority)
    {
        $url = sprintf('%s/%s/', $this->prefix, $code);

        if ($this->skipUrl($url)) {
            $result = '';
        } else {
            $result = sprintf('<url>
      <loc>%s</loc>
      <lastmod>%s</lastmod>
      <changefreq>weekly</changefreq>
      <priority>%s</priority>
   </url>', $url, $this->date, $priority);
        }
        return $result;
    }

    /**
     * Получаем список url из robots.txt по типу
     * @param string $type = Disallow / Allow
     *
     * @return array
     */

    private function getRobotsRulesList($type = 'Disallow')
    {
        $robotsFile = new RobotsFile(SITE_ID);
        $allRulesArr = $robotsFile->getRules($type);
        $arRulesUrls = array();
        if (count($allRulesArr) > 0) {
            foreach ($allRulesArr as $k => $al) {
                $arRulesUrls[] = $al[1];
            }
        }
        return $arRulesUrls;
    }

    private function getDirectories($scanPath, &$arDirectories)
    {
        if ($arFiles = scandir($scanPath)) {
            $arFiles = array_diff($arFiles, ['.', '..']);
            if (file_exists(sprintf('%s/index.php', $scanPath)) && file_exists(sprintf('%s/.section.php', $scanPath))) {
                $arDirectories[] = str_replace($this->documentRoot, $this->prefix, $scanPath);
                foreach ($arFiles as $path) {
                    if (!is_file(sprintf('%s/%s', $this->documentRoot, $path))) {
                        $this->getDirectories(sprintf('%s/%s', $scanPath, $path), $arDirectories);
                    }
                }
            }
        }
    }

    private function skipUrl($url)
    {
        $isNeedSkip = false;
        $url = str_replace($this->prefix, '', $url);
        if ($this->arDisallow) {
            if (in_array($url, $this->arDisallow)) {
                $isNeedSkip = true;
            } else {
                foreach ($this->arDisallow as $rule) {
                    if (strpos($url, $rule) !== false) {
                        $isNeedSkip = true;
                        break;
                    }
                }
            }
        }
        return $isNeedSkip;
    }

    public function createSiteMap()
    {
        $arDirectories = [];
        $this->getDirectories($this->documentRoot, $arDirectories);
        file_put_contents(sprintf('%s/sitemap.xml', $_SERVER['DOCUMENT_ROOT']),
            '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

        if ($arDirectories) {
            file_put_contents(sprintf('%s/sitemap_pages.xml', $_SERVER['DOCUMENT_ROOT']),
                '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
            foreach ($arDirectories as $url) {
                if ($this->skipUrl(sprintf('%s/', $url))) {
                    continue;
                }
                $priority = 1 - substr_count($url, '/', strlen($this->prefix)) * 0.1;
                $url = $priority == 1 ? $url : sprintf('%s/', $url);
                file_put_contents(sprintf('%s/sitemap_pages.xml', $_SERVER['DOCUMENT_ROOT']), sprintf('<url>
      <loc>%s</loc>
      <lastmod>%s</lastmod>
      <changefreq>weekly</changefreq>
      <priority>%s</priority>
   </url>', $url, $this->date, $priority), FILE_APPEND);
            }
            file_put_contents(sprintf('%s/sitemap_pages.xml', $_SERVER['DOCUMENT_ROOT']), '</urlset>', FILE_APPEND);
            file_put_contents(sprintf('%s/sitemap.xml', $_SERVER['DOCUMENT_ROOT']),
                sprintf('<sitemap><loc>%s/sitemap_pages.xml</loc></sitemap>', $this->prefix), FILE_APPEND);
        }
        $arCities = HL::getList(HL_LOCATION_ID, ['UF_SUB_DOMAIN', 'ID'], ['!UF_SUB_DOMAIN' => false]);
        $select = ['CODE', 'IBLOCK_ID', 'ID'];
        $filter = ['=IBLOCK_ID' => [SERVICES_IBLOCK_ID, MARKS_IBLOCK_ID, MODELS_IBLOCK_ID], 'ACTIVE' => 'Y',];
        $res = ElementTable::getList([
            'select' => $select,
            'filter' => $filter
        ]);
        while ($ob = $res->fetch()) {
            $arItems[$ob['IBLOCK_ID']][] = $ob;
        }


        if (isset($arItems) && $arItems[SERVICES_IBLOCK_ID]) {
            if ($arCities) {
                file_put_contents(sprintf('%s/sitemap_cities.xml', $_SERVER['DOCUMENT_ROOT']),
                    '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
                foreach ($arCities as $arCity) {
                    if ($link = $this->getXml($arCity['UF_SUB_DOMAIN'], 0.9)) {
                        file_put_contents(sprintf('%s/sitemap_cities.xml', $_SERVER['DOCUMENT_ROOT']), $link,
                            FILE_APPEND);
                    }
                    foreach ($arItems[SERVICES_IBLOCK_ID] as $arItem) {
                        $mapName = sprintf('sitemap_service_%s_%s.xml', $arCity['ID'], $arItem['ID']);
                        file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName),
                            '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
                        file_put_contents(sprintf('%s/sitemap.xml', $_SERVER['DOCUMENT_ROOT']),
                            sprintf('<sitemap><loc>%s/%s</loc></sitemap>', $this->prefix, $mapName),
                            FILE_APPEND);
                        if ($link = $this->getXml(sprintf('%s/%s', $arCity['UF_SUB_DOMAIN'], $arItem['CODE']),
                            0.8)) {
                            file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName), $link,
                                FILE_APPEND);
                        }
                        foreach ($arItems[MARKS_IBLOCK_ID] as $arMark) {
                            if ($link = $this->getXml(sprintf('%s/%s/%s', $arCity['UF_SUB_DOMAIN'], $arItem['CODE'],
                                $arMark['CODE']), 0.7)) {
                                file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName), $link,
                                    FILE_APPEND);
                            }
                            foreach ($arItems[MODELS_IBLOCK_ID] as $arModel) {
                                if ($link = $this->getXml(sprintf('%s/%s/%s/%s', $arCity['UF_SUB_DOMAIN'],
                                    $arItem['CODE'], $arMark['CODE'], $arModel['CODE']), 0.6)) {
                                    file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName), $link,
                                        FILE_APPEND);
                                }
                            }
                        }
                        file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName), '</urlset>',
                            FILE_APPEND);
                    }
                }
                file_put_contents(sprintf('%s/sitemap_cities.xml', $_SERVER['DOCUMENT_ROOT']), '</urlset>',
                    FILE_APPEND);
                file_put_contents(sprintf('%s/sitemap.xml', $_SERVER['DOCUMENT_ROOT']),
                    sprintf('<sitemap><loc>%s/sitemap_cities.xml</loc></sitemap>', $this->prefix), FILE_APPEND);
            }
            foreach ($arItems[SERVICES_IBLOCK_ID] as $arItem) {
                $mapName = sprintf('sitemap_service_%s.xml', $arItem['ID']);
                file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName),
                    '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
                file_put_contents(sprintf('%s/sitemap.xml', $_SERVER['DOCUMENT_ROOT']),
                    sprintf('<sitemap><loc>%s/%s</loc></sitemap>', $this->prefix, $mapName), FILE_APPEND);
                if ($link = $this->getXml($arItem['CODE'], 0.9)) {
                    file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName), $link, FILE_APPEND);
                }
                foreach ($arItems[MARKS_IBLOCK_ID] as $arMark) {
                    if ($link = $this->getXml(sprintf('%s/%s', $arItem['CODE'], $arMark['CODE']), 0.8)) {
                        file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName), $link, FILE_APPEND);
                    }
                    foreach ($arItems[MODELS_IBLOCK_ID] as $arModel) {
                        if ($link = $this->getXml(sprintf('%s/%s/%s', $arItem['CODE'], $arMark['CODE'],
                            $arModel['CODE']), 0.7)) {
                            file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName), $link,
                                FILE_APPEND);
                        }
                    }
                }
                file_put_contents(sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $mapName), '</urlset>', FILE_APPEND);
            }
        }
        file_put_contents(sprintf('%s/sitemap.xml', $_SERVER['DOCUMENT_ROOT']), '</sitemapindex>', FILE_APPEND);
    }

    public function showSiteMap()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $arRequest = $request->getQueryList()->toArray();
        $sef = $this->checkSef($arRequest);
        $xml = '';


        switch ($sef) {
            case 'general':
                $xml = $this->getGeneralSiteMap();
                break;
            case 'pages':
                $xml = $this->getPagesSiteMap();
                break;
            case 'cities':
                $xml = $this->getCitiesSiteMap();
                break;
            case 'services':
                $xml = $this->getServicesSiteMap();
                break;
            case 'services_links':
                $xml = $this->getServicesLinksSiteMap();
                break;
            case 'service':
                $xml = $this->getServiceSiteMap($arRequest['service']);
                break;
            case 'service_model':
                $xml = $this->getModelSiteMap($arRequest['service'], $arRequest['mark']);
                break;
            case 'city':
                $xml = $this->getCitySiteMap($arRequest['city']);
                break;
            case 'city_services_links':
                $xml = $this->getCityServicesLinksSiteMap($arRequest['service_city']);
                break;
            case 'city_service':
                $xml = $this->getCityServiceSiteMap($arRequest['city'],$arRequest['service']);
                break;
            case 'city_service_model':
                $xml = $this->getCityModelSiteMap($arRequest['city'],$arRequest['service'], $arRequest['mark']);
                break;
        }

        return $xml;
    }

    private function checkSef($arRequest)
    {
        global $APPLICATION;
        $result = 'general';
        $page = basename($APPLICATION->GetCurPage());
        list('city' => $city, 'service' => $service, 'mark' => $mark,'service_city'=>$serviceCity) = $arRequest;
        if ($city && $service && $mark) {
            $result = 'city_service_model';
        } elseif ($city && $service) {
            $result = 'city_service';
        } elseif ($service && $mark) {
            $result = 'service_model';
        } elseif ($city) {
            $result = 'city';
        } elseif ($service) {
            $result = 'service';
        }elseif ($serviceCity) {
            $result = 'city_services_links';
        } elseif ($page == 'sitemap_pages.xml') {
            $result = 'pages';
        } elseif ($page == 'sitemap_cities.xml') {
            $result = 'cities';
        } elseif ($page == 'sitemap_services.xml') {
            $result = 'services';
        } elseif ($page == 'sitemap_services_links.xml') {
            $result = 'services_links';
        }
        return $result;
    }

private function getServicesLinksSiteMap(){

    $xml = '';
    $select = ['ID', 'ACTIVE','CODE'];
    $filter = ['=IBLOCK_ID' => SERVICES_IBLOCK_ID, 'ACTIVE' => 'Y'];
    $res = ElementTable::getList([
        'select' => $select,
        'filter' => $filter,
    ]);
    while ($ob = $res->fetch()) {
        $xml .= $this->getXml($ob['CODE'], '0.9');
    }

    return $this->getUrlSetXml($xml);

}
private function getCityServicesLinksSiteMap($cityId){

    $xml = '';
    $arCities = HL::getList(HL_LOCATION_ID, ['UF_SUB_DOMAIN', 'ID'], ['!UF_SUB_DOMAIN' => false, 'ID' => $cityId]);
    if ($arCities) {
        $city = reset($arCities);
        $select = ['ID', 'ACTIVE', 'CODE'];
        $filter = ['=IBLOCK_ID' => SERVICES_IBLOCK_ID, 'ACTIVE' => 'Y'];
        $res = ElementTable::getList([
            'select' => $select,
            'filter' => $filter,
        ]);
        while ($ob = $res->fetch()) {
            $xml .= $this->getXml(sprintf('%s/%s',$city['UF_SUB_DOMAIN'],$ob['CODE']), '0.8');
        }
    }

    return $this->getUrlSetXml($xml);

}
    private function getGeneralSiteMap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_pages.xml</loc></sitemap>', $this->prefix);
        $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_cities.xml</loc></sitemap>', $this->prefix);
        $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_services.xml</loc></sitemap>', $this->prefix);
        $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_services_links.xml</loc></sitemap>', $this->prefix);
        //$xml .= $this->getServices();
        $xml .= $this->getCities();
        //$xml .= $this->getCityServices();

        $xml .= '</sitemapindex>';
        return $xml;
    }

    private function getCitySiteMap($cityId)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $arCities = HL::getList(HL_LOCATION_ID, ['UF_SUB_DOMAIN', 'ID'], ['!UF_SUB_DOMAIN' => false, 'ID' => $cityId]);
        if ($arCities) {
            $city = reset($arCities);
            $select = ['ID', 'ACTIVE', 'CODE'];
            $filter = ['=IBLOCK_ID' => SERVICES_IBLOCK_ID, 'ACTIVE' => 'Y'];
            $res = ElementTable::getList([
                'select' => $select,
                'filter' => $filter,
            ]);
            while ($ob = $res->fetch()) {
                $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_city_service_%s_%s.xml</loc></sitemap>', $this->prefix,$city['ID'],$ob['ID']);
            }
            $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_services_links_city_%s.xml</loc></sitemap>', $this->prefix,$city['ID']);
        }

        $xml .= '</sitemapindex>';
        return $xml;
    }

    private function getPagesSiteMap()
    {
        $arDirectories = [];

        $this->getDirectories($this->documentRoot, $arDirectories);

        $xml = '';
        if ($arDirectories) {
            foreach ($arDirectories as $url) {
                if ($this->skipUrl(sprintf('%s/', $url))) {
                    continue;
                }
                $priority = 1 - substr_count($url, '/', strlen($this->prefix)) * 0.1;
                $url = $priority == 1 ? $url : sprintf('%s/', $url);
                $xml .= sprintf('<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>weekly</changefreq><priority>%s</priority></url>',
                    $url, $this->date, $priority);
            }
        }

        return $this->getUrlSetXml($xml);
    }

    private function getCitiesSiteMap()
    {
        $xml = '';
        $arCities = HL::getList(HL_LOCATION_ID, ['UF_SUB_DOMAIN', 'ID'], ['!UF_SUB_DOMAIN' => false]);
        foreach ($arCities as $arCity) {
            $xml .= $this->getXml($arCity['UF_SUB_DOMAIN'], '0.9');
        }

        return $this->getUrlSetXml($xml);
    }

    private function getServicesSiteMap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml .= $this->getServices();
        $xml .= '</sitemapindex>';
        return $xml;
    }

    private function getServiceSiteMap($serviceId)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $select = ['ID', 'ACTIVE',];
        $filter = ['=IBLOCK_ID' => MARKS_IBLOCK_ID, 'ACTIVE' => 'Y'];
        $res = ElementTable::getList([
            'select' => $select,
            'filter' => $filter,
        ]);
        while ($ob = $res->fetch()) {
            $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_service_%s_%s.xml</loc></sitemap>', $this->prefix,
                $serviceId, $ob['ID']);
        }

        $xml .= '</sitemapindex>';
        return $xml;
    }
    private function getModelSiteMap($serviceId, $markId)
    {
        $xml = '';
        $service = \CIBlockElement::GetByID($serviceId)->Fetch();
        $mark = \CIBlockElement::GetByID($markId)->Fetch();
        //$xml .= $this->getXml(sprintf('%s', $service['CODE']), '0.9');
        $xml .= $this->getXml(sprintf('%s/%s',$service['CODE'], $mark['CODE']), '0.8');
        $res = ElementTable::getList([
            'filter' => [
                'prop.IBLOCK_PROPERTY_ID' => 42,
                'prop.VALUE' => $markId,
                'IBLOCK_ID' => MODELS_IBLOCK_ID,
                'ACTIVE' => 'Y'
            ],
            'runtime' => [
                new ReferenceField('prop', ElementPropertyTable::getEntity(),
                    [
                        '=this.ID' => 'ref.IBLOCK_ELEMENT_ID'
                    ],
                    [
                        'join_type' => 'INNER'
                    ]),
                new ReferenceField('element', ElementTable::getEntity(),
                    [
                        '=this.prop.VALUE' => 'ref.ID'
                    ],
                    [
                        'join_type' => 'INNER'
                    ]),
            ],
            'select' => ['prop.VALUE', 'ID', 'CODE', 'element.CODE', 'element.ID']
        ]);

        while ($ob = $res->fetch()) {

            $xml .= $this->getXml(sprintf('%s/%s/%s', $service['CODE'], $mark['CODE'], $ob['CODE']), '0.7');
        }


        return $this->getUrlSetXml($xml);
    }
    private function getCityModelSiteMap($cityId,$serviceId, $markId)
    {

        $xml = '';
        $arCities = HL::getList(HL_LOCATION_ID, ['UF_SUB_DOMAIN', 'ID'], ['!UF_SUB_DOMAIN' => false, 'ID' => $cityId]);
        if ($arCities) {
            $city = reset($arCities);
            Loader::includeModule('iblock');
            $service = \CIBlockElement::GetByID($serviceId)->Fetch();
            $mark = \CIBlockElement::GetByID($markId)->Fetch();
            //$xml .= $this->getXml(sprintf('%s/%s',$city['UF_SUB_DOMAIN'], $service['CODE']), '0.8');
            $xml .= $this->getXml(sprintf('%s/%s/%s',$city['UF_SUB_DOMAIN'], $service['CODE'], $mark['CODE']), '0.7');
            $res = ElementTable::getList([
                'filter' => [
                    'prop.IBLOCK_PROPERTY_ID' => 42,
                    'prop.VALUE' => $markId,
                    'IBLOCK_ID' => MODELS_IBLOCK_ID,
                    'ACTIVE' => 'Y'
                ],
                'runtime' => [
                    new ReferenceField('prop', ElementPropertyTable::getEntity(),
                        [
                            '=this.ID' => 'ref.IBLOCK_ELEMENT_ID'
                        ],
                        [
                            'join_type' => 'INNER'
                        ]),
                    new ReferenceField('element', ElementTable::getEntity(),
                        [
                            '=this.prop.VALUE' => 'ref.ID'
                        ],
                        [
                            'join_type' => 'INNER'
                        ]),
                ],
                'select' => ['prop.VALUE', 'ID', 'CODE', 'element.CODE', 'element.ID']
            ]);
            while ($ob = $res->fetch()) {
                $xml .= $this->getXml(sprintf('%s/%s/%s/%s',$city['UF_SUB_DOMAIN'], $service['CODE'], $mark['CODE'], $ob['CODE']), '0.6');
            }
        }


        return $this->getUrlSetXml($xml);
    }
    private function getCityServiceSiteMap($cityId,$serviceId)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $select = ['ID', 'ACTIVE',];
        $filter = ['=IBLOCK_ID' => MARKS_IBLOCK_ID, 'ACTIVE' => 'Y'];
        $res = ElementTable::getList([
            'select' => $select,
            'filter' => $filter,
        ]);
        while ($ob = $res->fetch()) {
            $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_city_service_%s_%s_%s.xml</loc></sitemap>', $this->prefix,
                $cityId,$serviceId, $ob['ID']);
        }

        $xml .= '</sitemapindex>';
        return $xml;
    }

    private function getCities()
    {
        $xml = '';
        $arCities = HL::getList(HL_LOCATION_ID, ['UF_SUB_DOMAIN', 'ID'], ['!UF_SUB_DOMAIN' => false]);
        foreach ($arCities as $arCity) {
            $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_city_%s.xml</loc></sitemap>', $this->prefix,
                $arCity['ID']);
        }
        return $xml;
    }

    private function getUrlSetXml($urlSet)
    {
        return sprintf('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">%s</urlset>',$urlSet);
    }

    private function getServices()
    {
        $xml = '';
        $select = ['ID', 'ACTIVE',];
        $filter = ['=IBLOCK_ID' => SERVICES_IBLOCK_ID, 'ACTIVE' => 'Y'];
        $res = ElementTable::getList([
            'select' => $select,
            'filter' => $filter,
        ]);
        while ($ob = $res->fetch()) {
            $xml .= sprintf('<sitemap><loc>%s/sitemap/sitemap_service_%s.xml</loc></sitemap>', $this->prefix,
                $ob['ID']);
        }
        return $xml;
    }

}