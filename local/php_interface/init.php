<?
$arLibs = [
    $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/defines.php',
];

foreach($arLibs as $lib){
    if(file_exists($lib)){
        require_once($lib);
    }
}
\Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    'DDS\\Tools' => '/local/php_interface/include/DDSShopAPI/classes/tools.php',
    'DDS\\Basketclass' => '/local/php_interface/include/DDSShopAPI/classes/basket.php',
    'DDS\\Bonus' => '/local/php_interface/include/DDSShopAPI/classes/bonus.php',
    'DDS\\Date' => '/local/php_interface/include/DDSShopAPI/classes/date.php',
    'DDS\\HL' => '/local/php_interface/include/DDSShopAPI/classes/hL.php',
]);

AddEventHandler("sale", "OnOrderSave", array("OrderHandler", "orderAdd"));
AddEventHandler("sale", "OnSaleStatusOrder", array("OrderHandler", "orderStatusUpdate"));
use Bitrix\Sale,
    Bitrix\Sale\PaySystem,
    Bitrix\Sale\Delivery;
class OrderHandler
{
    function orderStatusUpdate($ID, $arFields)
    {
        //Изменения статуса
        if ($arFields == "F") {
            $add = (new DDS\Tools\Bonus())->addBonus(array("UF_ID" => $ID));
        }

    }

}

function getDeliveryPriceForBusket( $siteId, $userId, $personTypeId, $deliveryId, $paySystemId, $userCityId,$paymentID)
{
    $result = null;
    \Bitrix\Main\Loader::includeModule('catalog');
    \Bitrix\Main\Loader::includeModule('sale');
    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    /** @var \Bitrix\Sale\Order $order */
    $order = \Bitrix\Sale\Order::create($siteId, $userId);
    $order->setPersonTypeId($personTypeId);
    $order->setBasket($basket);
   /* if($paymentID){
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem();
        $paySystemService = PaySystem\Manager::getObjectById($paymentID);
        $payment->setFields(array(
            'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
            'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
        ));
    }*/

    /** @var \Bitrix\Sale\PropertyValueCollection $orderProperties */
    $orderProperties = $order->getPropertyCollection();
    /** @var \Bitrix\Sale\PropertyValue $orderDeliveryLocation */
    $orderDeliveryLocation = $orderProperties->getDeliveryLocation();
    $orderDeliveryLocation->setValue(CSaleLocation::getLocationCODEbyID($userCityId)); // В какой город "доставляем" (куда доставлять).

    /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
    $shipmentCollection = $order->getShipmentCollection();

    $delivery = \Bitrix\Sale\Delivery\Services\Manager::getObjectById($deliveryId);
    /** @var \Bitrix\Sale\Shipment $shipment */
    $shipment = $shipmentCollection->createItem($delivery);

    /** @var \Bitrix\Sale\ShipmentItemCollection $shipmentItemCollection */
    $shipmentItemCollection = $shipment->getShipmentItemCollection();
    /** @var \Bitrix\Sale\BasketItem $basketItem */
    foreach ($basket as $basketItem) {
        $item = $shipmentItemCollection->createItem($basketItem);
        $item->setQuantity($basketItem->getQuantity());
    }

    /** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
    $paymentCollection = $order->getPaymentCollection();
    /** @var \Bitrix\Sale\Payment $payment */
    $payment = $paymentCollection->createItem(
        \Bitrix\Sale\PaySystem\Manager::getObjectById($paySystemId)
    );
    $payment->setField("SUM", $order->getPrice());
    $payment->setField("CURRENCY", $order->getCurrency());

    $deliveryPrice = $order->getDeliveryPrice();
    if ($deliveryPrice === '') {
        $deliveryPrice = null;
    }
    $result = $deliveryPrice;
    return $result;
}
function getDeliveryPrices( $siteId, $userId, $personTypeId, $deliveryArray, $userCityId,$paymentID)
{

    $result = null;
    \Bitrix\Main\Loader::includeModule('catalog');
    \Bitrix\Main\Loader::includeModule('sale');
    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    $order = \Bitrix\Sale\Order::create($siteId, $userId);
    $order->setPersonTypeId($personTypeId);
    $order->setBasket($basket);
    if($paymentID){
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem();
        $paySystemService = PaySystem\Manager::getObjectById($paymentID);
        $payment->setFields(array(
            'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
            'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
        ));
    }
    $orderProperties = $order->getPropertyCollection();
    $orderDeliveryLocation = $orderProperties->getDeliveryLocation();
    $orderDeliveryLocation->setValue(CSaleLocation::getLocationCODEbyID($userCityId));


    foreach ($deliveryArray as $key=> $itemShipment)
    {
        /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
        $shipmentCollection = $order->getShipmentCollection();
        $shipmentCollection->clearCollection();

        $delivery = \Bitrix\Sale\Delivery\Services\Manager::getObjectById($itemShipment['ID']);
        /** @var \Bitrix\Sale\Shipment $shipment */
        $shipment = $shipmentCollection->createItem($delivery);

        /** @var \Bitrix\Sale\ShipmentItemCollection $shipmentItemCollection */
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        /** @var \Bitrix\Sale\BasketItem $basketItem */
        foreach ($basket as $basketItem) {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }
        $calculationResult = $order->getShipmentCollection()->calculateDelivery();
        if ($calculationResult->isSuccess())
        {
            $item = $calculationResult->getData();
            if(!empty($item["CALCULATED_DELIVERIES"]))
            {
                $current = $item["CALCULATED_DELIVERIES"][0];
                $period =  $current->getPeriodDescription();
            }
            $deliveryPrice = $order->getDeliveryPrice();
        }else{
            $deliveryPrice = '';
        }
        if ($deliveryPrice === '') {
            $deliveryPrice = null;
        }
        $result[$itemShipment['ID']] = $deliveryPrice;

    }

    return $result;
}
function getDeliveriesByLocation($siteId, $userId, $personTypeId, $paySystemId, $userCityId)
{

    $result = null;
    \Bitrix\Main\Loader::includeModule('catalog');
    \Bitrix\Main\Loader::includeModule('sale');
    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    $order = \Bitrix\Sale\Order::create($siteId, $userId);
    $order->setPersonTypeId($personTypeId);
    $order->setBasket($basket);

    $orderProperties = $order->getPropertyCollection();
    $orderDeliveryLocation = $orderProperties->getDeliveryLocation();
    $orderDeliveryLocation->setValue(CSaleLocation::getLocationCODEbyID($userCityId));

    if ($paySystemId) {
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem();
        $paySystemService = PaySystem\Manager::getObjectById($paySystemId);
        $payment->setFields(array(
            'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
            'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
        ));
    }
    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();
    $shipmentItemCollection = $shipment->getShipmentItemCollection();
    $shipment->setField('CURRENCY', $order->getCurrency());
    foreach ($order->getBasket() as $item)
    {
        $shipmentItem = $shipmentItemCollection->createItem($item);
        $shipmentItem->setQuantity($item->getQuantity());
    }
    $arDelivery = Delivery\Services\Manager::getRestrictedObjectsList($shipment);

    foreach ($arDelivery as $key => $itemShipment) {
        /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
        $shipmentCollection = $order->getShipmentCollection();
        $shipmentCollection->clearCollection();
        /** @var \Bitrix\Sale\Shipment $shipment */
        $shipment = $shipmentCollection->createItem($itemShipment);

        /** @var \Bitrix\Sale\ShipmentItemCollection $shipmentItemCollection */
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        /** @var \Bitrix\Sale\BasketItem $basketItem */
        foreach ($basket as $basketItem) {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }


        $calculationResult = $order->getShipmentCollection()->calculateDelivery();
        if ($calculationResult->isSuccess()) {
            $item = $calculationResult->getData();
            if (!empty($item["CALCULATED_DELIVERIES"])) {
                $current = $item["CALCULATED_DELIVERIES"][0];
                $period = $current->getPeriodDescription();
            }
            $deliveryPrice = $order->getDeliveryPrice();
        } else {
            $deliveryPrice = '';
        }
        if ($deliveryPrice === '') {
            $deliveryPrice = null;
        }
        $result[$key] = ['PRICE' => $deliveryPrice, 'PERIOD' => $period];

    }

    return $result;
}