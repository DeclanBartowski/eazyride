<?  require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;
global $USER;
Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");
CModule::IncludeModule('subscribe');
$request = Context::getCurrent()->getRequest();
$siteId = Context::getCurrent()->getSite();
$currencyCode = CurrencyManager::getBaseCurrency();

$deliveryID = Delivery\Services\EmptyDeliveryService::getEmptyDeliveryServiceId();
$paymentID = 2;
$name = $request['name'];
$phone = $request['phone'];
$email = $request['email'];
$productId = $request["ELEMENT_ID"];

$arResult['ERROR']="";
if(empty($name)) $arResult['ERROR'].= "Введите Имя <br>";
if(empty($phone)) $arResult['ERROR'].= "Введите телефон <br>";
if(empty($email)) $arResult['ERROR'].= "Введите E-Mail <br>";

if(!empty($arResult['ERROR'])){
    echo json_encode(array("STATUS"=>"ERROR","HTML"=>$arResult['ERROR']));
    die();
}

// Создаёт новый заказ
$order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : 1);
$order->setPersonTypeId(1);
//$order->setField('CURRENCY', $currencyCode);
// Создаём корзину с одним товаром
$basket = Basket::create($siteId);
$item = $basket->createItem('catalog', $productId);
$resq = $item->setFields(array(
    'QUANTITY' => 1,
    'CURRENCY' => 'RUB',
    'LID' => 's1',
    'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
));
$order->setBasket($basket);


// Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)
$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem();
$service = Delivery\Services\Manager::getById($deliveryID);
$shipment->setFields(array(
    'DELIVERY_ID' => $service['ID'],
    'DELIVERY_NAME' => $service['NAME'],
));
$shipmentItemCollection = $shipment->getShipmentItemCollection();
// Создаём оплату со способом #1
$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem();
$paySystemService = PaySystem\Manager::getObjectById($paymentID);
$payment->setFields(array(
    'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
    'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
));
//$shipment->setField("BASE_PRICE_DELIVERY", 1000);
//$shipment->setField("CUSTOM_PRICE_DELIVERY", "Y")

$propertyCollection = $order->getPropertyCollection();
$propertyCollection->getPhone()->setValue($phone);
$propertyCollection->getPayerName()->setValue($name);
$propertyCollection->getUserEmail()->setValue($email);
$propertyCollection->getItemByOrderPropertyId(1)->setValue($name);
$propertyCollection->getItemByOrderPropertyId(3)->setValue($email);
$propertyCollection->getItemByOrderPropertyId(5)->setValue($phone);


$order->doFinalAction(true);
$result = $order->save();
$orderId = $order->getId();

if($result>0){
    $_SESSION['SALE_ORDER_ID'][] = $orderId;
    echo json_encode($orderId);
}