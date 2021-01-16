# bitrix-getList
D7 Getlist vs CIblockElement::GetList

**Всевеликий getlist**

Принцип простой. Есть таблица с записями пользовательских свойств b_iblock_element_property, но нет map-инга для него. Видимо битрикс исключил его
из-за предполагающихся переработок ядра. Нам ничего не мешает описать свой маппинг таблицы и использовать это в getlist.

Все поля описывать нет необходимости, только те, которые вам нужны. Подходит для вытягивания строковых и числовых свойств. Для списочных свойств не забываем про  PropertyEnumerationTable.

Для примера:

```php
  'filter' => [
    'IBLOCK_ID' => 35,
    'ACTIVE'    => 'Y',
    'LAT.IBLOCK_PROPERTY_ID'     => 134,
    'LNG.IBLOCK_PROPERTY_ID'     => 133,
    'ADDRESS.IBLOCK_PROPERTY_ID' => 132,
  ],
```

Для свойств 'LAT.IBLOCK_PROPERTY_ID' => 134: 134 - это ID свойства
