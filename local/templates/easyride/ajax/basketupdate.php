<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Sale;
?>
<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "basket", Array(
    "ACTION_VARIABLE" => "basketAction",	// Название переменной действия
    "AUTO_CALCULATION" => "Y",	// Автопересчет корзины
    "COLUMNS_LIST" => array(	// Выводимые колонки
        0 => "NAME",
        1 => "DISCOUNT",
        2 => "WEIGHT",
        3 => "DELETE",
        4 => "DELAY",
        5 => "TYPE",
        6 => "PRICE",
        7 => "QUANTITY",
    ),
    "CORRECT_RATIO" => "N",	// Автоматически рассчитывать количество товара кратное коэффициенту
    "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",	// Текст заголовка "Подарки"
    "GIFTS_CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
    "GIFTS_HIDE_BLOCK_TITLE" => "N",	// Скрыть заголовок "Подарки"
    "GIFTS_HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
    "GIFTS_MESS_BTN_BUY" => "Выбрать",	// Текст кнопки "Выбрать"
    "GIFTS_MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
    "GIFTS_PAGE_ELEMENT_COUNT" => "4",	// Количество элементов в строке
    "GIFTS_PLACE" => "BOTTOM",	// Вывод блока "Подарки"
    "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
    "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
    "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",	// Показывать процент скидки
    "GIFTS_SHOW_IMAGE" => "Y",	// Показывать изображение
    "GIFTS_SHOW_NAME" => "Y",	// Показывать название
    "GIFTS_SHOW_OLD_PRICE" => "N",	// Показывать старую цену
    "GIFTS_TEXT_LABEL_GIFT" => "Подарок",	// Текст метки "Подарка"
    "HIDE_COUPON" => "N",	// Спрятать поле ввода купона
    "PATH_TO_ORDER" => "/personal/order.php",	// Страница оформления заказа
    "PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
    "QUANTITY_FLOAT" => "N",	// Использовать дробное значение количества
    "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
    "TEMPLATE_THEME" => "blue",	// Цветовая тема
    "USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
    "USE_GIFTS" => "Y",	// Показывать блок "Подарки"
    "USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
),
    false
);?>