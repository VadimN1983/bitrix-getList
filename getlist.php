<?
define('NEED_AUTH', false);
define('NO_KEEP_STATISTIC', true);
define("NO_AGENT_CHECK", true);
define('NOT_CHECK_PERMISSIONS',true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php" );
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"] = "N";
$APPLICATION->ShowIncludeStat = false;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Query\Join;

\Bitrix\Main\Loader::includeModule('iblock');

class ElementPropertyTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_iblock_element_property';
    }

    public static function getMap()
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary(true)
                ->configureAutocomplete(true),
            new IntegerField('IBLOCK_PROPERTY_ID'),
            new IntegerField('IBLOCK_ELEMENT_ID'),
            new Reference(
                'ELEMENT', ElementTable::class,
                Join::on('this.IBLOCK_ELEMENT_ID', 'ref.ID')
            ),
            new TextField('VALUE')
        ];
    }
}


$arResult = \Bitrix\Iblock\ElementTable::getList([
    'order'  => [
        'ID' => 'ASC'
    ],
    'filter' => [
        'IBLOCK_ID' => 35,
        'ACTIVE'    => 'Y',
        'LAT.IBLOCK_PROPERTY_ID'     => 134,
        'LNG.IBLOCK_PROPERTY_ID'     => 133,
        'ADDRESS.IBLOCK_PROPERTY_ID' => 132,
    ],
    'select' => [
        'ID',
        'IBLOCK_ID',
        'NAME',
        'PROPERTY_LAT_VALUE'     => 'LAT.VALUE',
        'PROPERTY_LNG_VALUE'     => 'LNG.VALUE',
        'PROPERTY_ADDRESS_VALUE' => 'ADDRESS.VALUE',
    ],
    'cache' => [
        'ttl' => 3600,
        'cache_joins' => true
    ],
    'runtime' => [
        'LAT' => new \Bitrix\Main\ORM\Fields\Relations\Reference(
            'LAT',
            ElementPropertyTable::class,
            Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID'),
            ['join_type' => 'LEFT']
        ),
        'LNG' => new \Bitrix\Main\ORM\Fields\Relations\Reference(
            'LNG',
            ElementPropertyTable::class,
            Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID'),
            ['join_type' => 'LEFT']
        ),
        'ADDRESS' => new \Bitrix\Main\ORM\Fields\Relations\Reference(
            'ADDRESS',
            ElementPropertyTable::class,
            Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID'),
            ['join_type' => 'LEFT']
        ),
    ]
])->fetchAll();

echo '<pre>';
print_r(arResult);
echo '</pre>';
