<?php


namespace TQ\Tools;

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

\CModule::IncludeModule('highloadblock');

class HL
{
    /**
     * @param int $HlBlockId
     * @return mixed
     * @throws
     */
    public static function GetEntityDataClass(int $HlBlockId)
    {
        if (empty($HlBlockId) || $HlBlockId < 1) {
            return false;
        }
        $hlBlock = HLBT::getById($HlBlockId)->fetch();
        $entity = HLBT::compileEntity($hlBlock);
        return $entity->getDataClass();
    }

    /**
     * @param int $HlBlockId
     * @param array $arSelect
     * @param array $arFilter
     * @param array $arOrder
     * @param array|boolean $arPageSize
     * @param array|boolean $arGroup
     * @return array
     * @throws
     */
    static public function getList(
        int $HlBlockId,
        $arSelect = ['*'],
        $arFilter = [],
        $arOrder = [],
        $arGroup = false,
        $arPageSize = false
    ) {
        $entity_data_class = HL::GetEntityDataClass($HlBlockId);
        $arGetList = ['select' => $arSelect, 'filter' => $arFilter, 'order' => $arOrder,];
        if ($arGroup != false) {
            $arGetList['group'] = $arGroup;
            $arGetList['select'] = $arGroup;
        }
        if ($arPageSize != false) {
            $arGetList['offset'] = $arPageSize['iNumPage'];
            $arGetList['limit'] = $arPageSize['nPageSize'];
            $arGetList['count_total'] = true;
        }
        $rsData = $entity_data_class::getList($arGetList);
        return $rsData->fetchAll();
    }

    /**
     * @param int $HlBlockId
     * @param array $arFields
     * @return array
     */
    public static function addElement(int $HlBlockId, $arFields = [])
    {
        if ($HlBlockId && $arFields) {
            $entity_data_class = HL::GetEntityDataClass($HlBlockId);
            $result = $entity_data_class::add($arFields);
        }
        return $result->getId();
    }

    /**
     * @param int $HlBlockId
     * @param int $id
     * @return array
     */
    public static function deleteElement(int $HlBlockId, int $id)
    {
        if ($HlBlockId) {
            $entity_data_class = HL::GetEntityDataClass($HlBlockId);
            $result = $entity_data_class::delete($id);
        }
        return $result;
    }

    /**
     * @param int $HlBlockId
     * @param int $id
     * @param array $arFields
     * @return array
     */
    public static function updateElement(int $HlBlockId, int $id, $arFields = [])
    {
        $entity_data_class = HL::GetEntityDataClass($HlBlockId);
        $result = $entity_data_class::update($id, $arFields);
        if ($result->isSuccess()) {
            return ['TYPE' => 'SUCCESS'];
        } else {
            return ['TYPE' => 'ERROR', 'MESSAGE' => $result->getErrorMessages()];
        }
    }


}