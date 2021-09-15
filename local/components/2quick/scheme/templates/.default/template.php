<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Page\Asset;
/** @var array $arParams */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var array $arResult */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

?>
<?if($arResult['RATING'] && $arResult['REVIEW']){?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "<?=CSite::GetByID(SITE_ID)->Fetch()['SITE_NAME']?>",
            "telephone":"<?=$arResult['PHONE']?>",
            "email":"<?=$arResult['EMAIL']?>",
            "address":"<?=$arResult['ADDRESS']?>",
            "slogan":"<?=$arResult['SLOGAN']?>",
            "url":"//<?=$_SERVER['HTTP_HOST']?>",
            "logo":"//<?=$_SERVER['HTTP_HOST']?><?= SITE_TEMPLATE_PATH ?>/img/logo.svg",
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "<?=$arResult['RATING']?>",
                "reviewCount": "<?=$arResult['REVIEW']?>"
            }
        }
    </script>

<?}?>

