<?php


namespace TQ\Tools;

use Matrix\Exception;
use \PhpOffice\PhpSpreadsheet\IOFactory,
    Bitrix\Main\Loader;

Loader::includeModule('iblock');
@set_time_limit(60000);
@ini_set('memory_limit', '2048M');
class Import extends Singleton
{
    protected function __construct()
    {
    }

    public function startImport($path)
    {
        require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';
        Logger::log('Import started!');
        $this->startLocationsImport(sprintf('%scities.xlsx', $path));
        $this->startSqlImport();
        Logger::log('Import ended');
    }

    public function startLocationsImport($path)
    {
        if (file_exists($path)) {
            $inputFileType = IOFactory::identify($path);
            $reader = IOFactory::createReader($inputFileType);
            $reader->setReadDataOnly(true);
            try {
                $spreadsheet = $reader->load($path);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $arData = array_slice($sheetData, 2);
                $arHlFields = [
                    'A' => 'UF_XML_ID',
                    'B' => 'UF_DISTRICT',
                    'C' => 'UF_REGION',
                    'D' => 'UF_SUB_DOMAIN',
                    'E' => 'UF_NAME',
                ];
                $arItems = $this->getSavedElements(HL_LOCATION_ID);
                $arCount = [
                    'UPDATED' => 0,
                    'CREATED' => 0,
                ];

                foreach ($arData as $location) {
                    $arFields = [];
                    foreach ($arHlFields as $key => $field) {
                        $arFields[$arHlFields[$key]] = $location[$key];
                    }
                    $arFields['UF_HASH'] = md5(serialize($arFields));
                    if ($arSavedItem = $arItems[$arFields['UF_XML_ID']]) {
                        if ($arFields['UF_HASH'] != $arSavedItem['UF_HASH']) {
                            HL::updateElement(HL_LOCATION_ID, intval($arSavedItem['ID']), $arFields);
                            $arCount['UPDATED']++;
                        }
                    } else {
                        HL::addElement(HL_LOCATION_ID, $arFields);
                        $arCount['CREATED']++;
                    }
                }
                Logger::log(sprintf('Updated: %1$s%2$sCreated: %3$s', $arCount['UPDATED'], PHP_EOL,
                    $arCount['CREATED']));
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                Logger::log(sprintf('Error loading file: "%s"', $e->getMessage()));
            }
        } else {
            Logger::log(sprintf('File "%s" does not exist!', $path));
        }
    }

    public function startSqlImport()
    {
        $res = \CIBlock::GetList([], ['TYPE' => 'auto']);
        while ($arIBlock = $res->Fetch()) {
            $arIBlocks[$arIBlock['ID']] = $arIBlock['CODE'];
            $this->saveFromTable($arIBlock['CODE'], $arIBlock['ID']);
        }
        if (isset($arIBlocks) && $arIBlocks) {
            $this->updateLinkProps($arIBlocks);
        }
    }

    private function saveFromTable($table, $iBlockId)
    {
        $arItems = $this->getSqlTable($table);
        if ($arItems) {
            $el = new \CIBlockElement;
            $arCount = [
                'UPDATED' => 0,
                'CREATED' => 0,
            ];
            $arSavedItems = $this->getSavedIBlockElements($iBlockId);
            foreach ($arItems as $arItem) {
                $xmlId = reset($arItem);

                $arParams = array("replace_space"=>"-","replace_other"=>"-");
                $trans = \Cutil::translit($arItem['name'] ?: "Элемент","ru",$arParams);
                $arFields = array(
                    "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                    "IBLOCK_ID" => $iBlockId,
                    "NAME" => $arItem['name'] ?: "Элемент",
                    "CODE"=>$trans,
                    "ACTIVE" => "Y",            // активен
                );
                foreach ($arItem as $key => $value) {
                    $arFields['PROPERTY_VALUES'][ToUpper($key)] = $value;
                }
                $arFields['XML_ID'] = $xmlId;
                $arFields['PROPERTY_VALUES']['HASH'] = md5(serialize($arFields));
                try {
                    if ($arSavedItem = $arSavedItems[$xmlId]) {
                        if ($arFields['PROPERTY_VALUES']['HASH'] != $arSavedItem['PROPERTY_HASH_VALUE']) {
                            $el->Update($arSavedItem['ID'], $arFields);
                            $arCount['UPDATED']++;
                        }
                    } else {
                        if ($el->Add($arFields)) {
                            $arCount['CREATED']++;
                        } else {
                            Logger::log($el->LAST_ERROR);
                        }
                    }
                } catch (Exception $e){
                    Logger::log($e->getMessage());
                }

            }
            Logger::log(sprintf('Table: "%4$s"%2$s Updated: %1$s%2$sCreated: %3$s', $arCount['UPDATED'], PHP_EOL,
                $arCount['CREATED'], $table));
        }
    }

    private function updateLinkProps($arIBlocks)
    {
        foreach ($arIBlocks as $id => $code) {
            $arPropsIBlocks[$id] = sprintf('id_%s', $code);
        }
        if (isset($arPropsIBlocks) && $arPropsIBlocks) {
            $arIBlockItems = [];
            $arSelect = array("ID", "IBLOCK_ID", "NAME", "XML_ID");
            $arFilter = ['IBLOCK_ID' => array_keys($arIBlocks)];
            $res = \CIBlockElement::GetList(['LEFT_MARGIN' => 'asc'], $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                $arFields['PROPERTIES'] = $ob->GetProperties();
                $arItems[] = $arFields;
                $arIBlockItems[$arPropsIBlocks[$arFields['IBLOCK_ID']]][$arFields['XML_ID']] = $arFields;
            }
            if (isset($arItems) && $arItems) {
                $count = 0;
                foreach ($arItems as $arItem) {
                    $isNeedUpdate = false;
                    $arProps = [];
                    foreach ($arItem['PROPERTIES'] as $code => $arProperty) {
                        $lowerCode = ToLower($code);
                        if ($lowerCode == 'id_parent' && $arIBlockItems[$arPropsIBlocks[$arItem['IBLOCK_ID']]][$arProperty['VALUE']]['ID'] != $arProperty['VALUE']) {
                            $isNeedUpdate = true;
                            $arProps[$code] = $arIBlockItems[$arPropsIBlocks[$arItem['IBLOCK_ID']]][$arProperty['VALUE']]['ID'] ?: $arProperty['VALUE'];
                        } elseif ($arIBlockItems[$lowerCode] && $arIBlockItems[$lowerCode][$arProperty['VALUE']]['ID'] != $arProperty['VALUE']) {
                            $isNeedUpdate = true;
                            $arProps[$code] = $arIBlockItems[$lowerCode][$arProperty['VALUE']]['ID'] ?: $arProperty['VALUE'];
                        }
                    }
                    if ($isNeedUpdate) {
                        \CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, $arProps);
                        $count++;
                    }
                }
                Logger::log(sprintf('Updated links: %s', $count));
            }
        }
    }

    private function getSqlTable($table)
    {
        $arItems = [];
        $connection = \Bitrix\Main\Application::getConnection('auto');
        $sqlHelper = $connection->getSqlHelper();
        $sql = sprintf('SELECT * FROM %s', $table);

        $recordset = $connection->query($sql);
        while ($record = $recordset->fetch()) {
            $arItems[] = $record;
        }
        return $arItems;
    }


    private function getSavedElements($hlId)
    {
        $arItems = HL::getList($hlId, ['UF_XML_ID', 'UF_HASH', 'ID']);
        if ($arItems) {
            $arItems = array_combine(array_column($arItems, 'UF_XML_ID'), $arItems);
        }
        return $arItems;
    }

    private function getSavedIBlockElements($IBlockId)
    {
        $arItems = [];
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "XML_ID", "PROPERTY_HASH");
        $arFilter = ['IBLOCK_ID' => $IBlockId];
        $res = \CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
        while ($ob = $res->Fetch()) {
            $arItems[$ob['XML_ID']] = $ob;
        }

        return $arItems;
    }

}