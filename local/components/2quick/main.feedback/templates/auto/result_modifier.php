<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
use TQ\Tools\Sef;
$sef = Sef::getInstance();
$arAuto = $sef->getCurrentAuto();

$arSelect = array("ID", "IBLOCK_ID", "NAME", "XML_ID");
$arFilter = ['IBLOCK_ID' => MARKS_IBLOCK_ID,'ACTIVE'=>'Y'];
$res = CIBlockElement::GetList(['NAME'=>'asc'], $arFilter, false, false, $arSelect);
while ($ob = $res->Fetch()) {
    if($ob['ID'] == $arAuto['MARK']['ID'])
        $ob['CURRENT'] = 'Y';
    $arResult['MARKS'][] = $ob;
}
if($arParams['SERVICE_ID']){
    $arService = CIBlockElement::GetByID($arParams['SERVICE_ID'])->Fetch();
    if($arService){

        $arResult['SERVICE_URL'] = $sef->getServiceUrl($arService['CODE'],true);
    }

}
