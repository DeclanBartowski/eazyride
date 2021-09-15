<?php


namespace TQ\Tools\Handlers\Request\Wrapper;


use TQ\Tools\Handlers\Request\EntityWrapper,
    Bitrix\Main\Loader,
    TQ\Tools\Sef;

class AutoEW extends EntityWrapper
{
    private $datas;
    private $def_params = [
        'id',
    ];

    public function __construct($datas)
    {
        $this->datas = $datas;

        parent::__construct($this->datas);
        parent::checkRequestMethod('post');
        parent::checkDataParams($this->def_params, $this->datas);
    }

    public function get()
    {
        $arItems = [];
        if($this->datas['id']){
            $sef = Sef::getInstance();
            $arAuto = $sef->getCurrentAuto();
            $arItems[] = '<option value="">Выбрать</option>';
            Loader::includeModule('iblock');
            $arSelect = array("ID", "IBLOCK_ID", "NAME", "XML_ID");
            $arFilter = ['IBLOCK_ID' => MODELS_IBLOCK_ID,'ACTIVE'=>'Y','PROPERTY_ID_CAR_MARK'=>$this->datas['id']];
            $res = \CIBlockElement::GetList(['NAME'=>'asc'], $arFilter, false, false, $arSelect);
            while ($ob = $res->Fetch()) {
                $arItems[] = sprintf('<option value="%s"%s>%s</option>',$ob['ID'],$ob['ID'] == $arAuto['MODEL']['ID']?' selected':'',$ob['NAME']);
            }
        }else{
            $arItems[] = '<option value="">Выберите марку</option>';
        }

        return implode('',$arItems);
    }
}