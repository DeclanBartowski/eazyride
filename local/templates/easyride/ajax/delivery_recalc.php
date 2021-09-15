<?
define('NO_KEEP_STATISTIC', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);
define('NO_AGENT_STATISTIC', true);
define('PERFMON_STOP', true);
define("DisableEventsCheck", true);
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Application,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\Delivery\Services,
    Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\PaySystem;
global $USER;
Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

$request = Application::getInstance()->getContext()->getRequest();
$siteId = Context::getCurrent()->getSite();

$arResult = array();

switch ($_REQUEST['action']){
    case 'list':
        $order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : 1);
        $order->setPersonTypeId(!empty($personType)?$personType:1);
        $basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
        $order->setBasket($basket);
        $price = $basket->getPrice();

        $location = $request->getPost('location');
        $currency = 'RUB';
        $arDeliveris = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();
        foreach ($arDeliveris as &$arItem){
            if($arItem['PARENT_ID']>0 && !$arItem['LOGOTIP']){
                $arItem['LOGOTIP'] = $arDeliveris[$arItem['PARENT_ID']]['LOGOTIP'];
                $arItem['PERIOD_FROM'] = $arDeliveris[$arItem['PARENT_ID']]['CONFIG']['MAIN']['PERIOD']['FROM'];
                $arItem['PERIOD_TO'] = $arDeliveris[$arItem['PARENT_ID']]['CONFIG']['MAIN']['PERIOD']['TO'];
            }elseif($arItem['CONFIG']['MAIN']['PERIOD']){
                $arItem['PERIOD_FROM'] = $arItem['CONFIG']['MAIN']['PERIOD']['FROM'];
                $arItem['PERIOD_TO'] = $arItem['CONFIG']['MAIN']['PERIOD']['TO'];
            }


        }


        foreach ($arDeliveris as &$arItem){
            if($arItem['ID']==1){
                unset($arDeliveris[$arItem['ID']]);
                continue;
            }
            if($arItem['PARENT_ID']>0 && $arDeliveris[$arItem['PARENT_ID']])unset($arDeliveris[$arItem['PARENT_ID']]);
        }

        $siteId = Context::getCurrent()->getSite();
        $arPrices = getDeliveryPrices($siteId,$USER->IsAuthorized()?$USER->GetId():1,1,$arDeliveris,$location);

        $html = '';
        $cnt = 0;
        foreach ($arDeliveris as $key => $arDelivery){
            $cnt++;
            if($arPrices[$arDelivery['ID']] != 'Уточнит менеджер'){
                $strDeliveryPrice = CurrencyFormat($arPrices[$arDelivery['ID']],$currency);
                $total = CurrencyFormat($arPrices[$arDelivery['ID']]+$price,$currency);
            }
            else{
                $strDeliveryPrice = $arPrices[$arDelivery['ID']];
                $total = CurrencyFormat($price,$currency);
            }
            if($arPrices[$arDelivery['ID']] == 'Уточнит менеджер'){
                $deliveryPrice = $arPrices[$arDelivery['ID']];
            }
            else{
                $deliveryPrice = CurrencyFormat($arPrices[$arDelivery['ID']], $currency);
            }

            if($cnt == 1){
                $arFirstDeliveryPrice = [
                    'DELIVERY' => $strDeliveryPrice,
                    'TOTAL' => $total
                ];
                $checked = 'checked';
            }
            else{
                $checked = '';
            }

            if (!empty($arDelivery['LOGOTIP'])) {
                $arFileTmp = CFile::ResizeImageGet(
                    $arDelivery['LOGOTIP'],
                    array("width" => 60, "height" => 24),
                    BX_RESIZE_IMAGE_PROPORTIONAL);
                $img = '<img src="'. $arFileTmp['src'] .'" alt="'. $arDelivery['NAME'] .'" class="delivery-variables__img">';
            }
            else{
                $img = '';
            }


            $html .= '<label class="delivery-variables__item">
								<input type="radio"
                                       '.$checked.'
									   data-delivery="'. $deliveryPrice .'"
									   data-price="'. $total .'"
									   name="delivery" value="'. $arDelivery['ID'] .'"
									   class="delivery-variables__input">
								<span class="delivery-variables__content">
                          <span class="delivery-variables__information">
                            <span class="delivery-variables__block-marker">
                              <span class="variable__marker"></span>
                            </span>
                            <span class="delivery-variables__block-img">
	                           '.$img.'
                            </span>
                            <span class="delivery-variables__name">
                              '. $arDelivery['NAME'] .'
                            </span>
                            <span class="delivery-variables__line"></span>
                          </span>
                          <span class="delivery-variables__sub-information">
                            <div class="delivery-variables__days">'.$arDelivery['TIME'].'</div>
                            <div class="delivery-variables__sum">
                              '. $deliveryPrice .'
                            </div>
                          </span>
                        </span>
							</label>';
        }

        echo json_encode(['PRICES' => $arFirstDeliveryPrice,'HTML' => $html]);
        break;
    case 'all':
        $arDeliveris = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();

        foreach ($arDeliveris as &$arItem){
            if($arItem['PARENT_ID']>0 && !$arItem['LOGOTIP']){
                $arItem['LOGOTIP'] = $arDeliveris[$arItem['PARENT_ID']]['LOGOTIP'];
                $arItem['PERIOD_FROM'] = $arDeliveris[$arItem['PARENT_ID']]['CONFIG']['MAIN']['PERIOD']['FROM'];
                $arItem['PERIOD_TO'] = $arDeliveris[$arItem['PARENT_ID']]['CONFIG']['MAIN']['PERIOD']['TO'];
            }elseif($arItem['CONFIG']['MAIN']['PERIOD']){
                $arItem['PERIOD_FROM'] = $arItem['CONFIG']['MAIN']['PERIOD']['FROM'];
                $arItem['PERIOD_TO'] = $arItem['CONFIG']['MAIN']['PERIOD']['TO'];
            }


        }
        foreach ($arDeliveris as &$arItem){
            if($arItem['PARENT_ID']>0 && $arDeliveris[$arItem['PARENT_ID']])unset($arDeliveris[$arItem['PARENT_ID']]);
        }
        foreach ($arDeliveris as &$arItem){
            $arDelivery_prices[$arItem['ID']]['PRICE']=getDeliveryPriceForBusket(SITE_ID,$USER->GetId()?:1,
                1,
                $arItem['ID'],
                $_REQUEST['payment']?:1,
                $_REQUEST['CITY']
            );
            $arDelivery_prices[$arItem['ID']]['FORMAT'] =CurrencyFormat($arDelivery_prices[$arItem['ID']]['PRICE'],'RUB');
        }

        $order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : 1);
        $order->setPersonTypeId(!empty($personType)?$personType:1);
        $basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
        $order->setBasket($basket);
        $price = $basket->getPrice();
        echo json_encode(['PRICES'=>$arDelivery_prices,'TOTAL'=>CurrencyFormat($arDelivery_prices[$_REQUEST['delivery']]['PRICE']+$price,'RUB')]);
        break;
    default:
        $arDel=getDeliveryPriceForBusket(SITE_ID,$USER->GetId()?:1,
            1,
            $_REQUEST['delivery'],
            $_REQUEST['payment']?:1,
            $_REQUEST['CITY']
        );
        $order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : 1);
        $order->setPersonTypeId(!empty($personType)?$personType:1);
//$order->setField('CURRENCY', $currencyCode);
// Создаём корзину с одним товаром
        $basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
        $order->setBasket($basket);
// Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)
        $price = $basket->getPrice();
        echo json_encode(CurrencyFormat($arDel+$price,'RUB'));
        break;
}



require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");