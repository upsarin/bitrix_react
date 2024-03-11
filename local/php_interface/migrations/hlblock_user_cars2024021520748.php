<?php

namespace Sprint\Migration;


class hlblock_user_cars20240215120748 extends Version
{
    protected $description = "";

    protected $moduleVersion = "4.6.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
    $hlblockId = $helper->Hlblock()->saveHlblock(array (
  'NAME' => 'UserCars',
  'TABLE_NAME' => 'user_cars',
  'LANG' =>
  array (
    'ru' =>
    array (
      'NAME' => 'Машины пользователей',
    ),
    'en' =>
    array (
      'NAME' => 'Cars',
    ),
  ),
));
        $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_CAR_USER_ID',
  'USER_TYPE_ID' => 'integer',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'Y',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' =>
  array (
    'SIZE' => 20,
    'MIN_VALUE' => 0,
    'MAX_VALUE' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' =>
  array (
    'en' => 'User ID',
    'ru' => 'ИД Пользователя',
  ),
  'LIST_COLUMN_LABEL' =>
  array (
    'en' => 'User ID',
    'ru' => 'ИД Пользователя',
  ),
  'LIST_FILTER_LABEL' =>
  array (
    'en' => 'User ID',
    'ru' => 'ИД Пользователя',
  ),
  'ERROR_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_CAR_BRAND',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'Y',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' =>
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => '',
  ),
  'EDIT_FORM_LABEL' =>
  array (
    'en' => 'Brand',
    'ru' => 'Марка',
  ),
  'LIST_COLUMN_LABEL' =>
  array (
    'en' => 'Brand',
    'ru' => 'Марка',
  ),
  'LIST_FILTER_LABEL' =>
  array (
    'en' => 'Brand',
    'ru' => 'Марка',
  ),
  'ERROR_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_CAR_MODEL',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' =>
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => '',
  ),
  'EDIT_FORM_LABEL' =>
  array (
    'en' => 'Model',
    'ru' => 'Модель',
  ),
  'LIST_COLUMN_LABEL' =>
  array (
    'en' => 'Model',
    'ru' => 'Модель',
  ),
  'LIST_FILTER_LABEL' =>
  array (
    'en' => 'Model',
    'ru' => 'Модель',
  ),
  'ERROR_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_CAR_YEAR',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' =>
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => '',
  ),
  'EDIT_FORM_LABEL' =>
  array (
    'en' => 'Year',
    'ru' => 'Год выпуска',
  ),
  'LIST_COLUMN_LABEL' =>
  array (
    'en' => 'Year',
    'ru' => 'Год выпуска',
  ),
  'LIST_FILTER_LABEL' =>
  array (
    'en' => 'Year',
    'ru' => 'Год выпуска',
  ),
  'ERROR_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_CAR_EQUIPMENT',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' =>
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => '',
  ),
  'EDIT_FORM_LABEL' =>
  array (
    'en' => 'Equipment',
    'ru' => 'Комплектация',
  ),
  'LIST_COLUMN_LABEL' =>
  array (
    'en' => 'Equipment',
    'ru' => 'Комплектация',
  ),
  'LIST_FILTER_LABEL' =>
  array (
    'en' => 'Equipment',
    'ru' => 'Комплектация',
  ),
  'ERROR_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_CAR_EQUIPMENT_NAME',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' =>
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => '',
  ),
  'EDIT_FORM_LABEL' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'LIST_COLUMN_LABEL' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'LIST_FILTER_LABEL' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'ERROR_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' =>
  array (
    'en' => '',
    'ru' => '',
  ),
));
        }

    public function down()
    {
        //your code ...
    }
}
