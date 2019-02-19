<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 06.05.17
 * Time: 11:44
 */

namespace common\components\fias;

use common\repositories\AddressRepository;
use yii\base\Model;
use yii\bootstrap\Widget;
use yii\helpers\BaseHtml;
use yii\helpers\Json;
use yii\validators\RequiredValidator;
use yii\widgets\ActiveForm;

class FiasWidget extends Widget
{
    /** @var  Model модель */
    public $model;

    /** @var  string название атрибута */
    public $attribute;

    /** @var AddressRepository */
    public $addressModel;

    public $fields = [];

    /** @var array Html настройки инпута */
    public $options = [
        'class' => 'form-control',
        'label' => null
    ];

    /** @var array Параметры плагина dadata */
    public $suggestionsParams = [
        'type' => 'ADDRESS',
        'count' => 5,
    ];

    /** @var ActiveForm */
    public $form;
    public $optionsField = [];
    private $_availableAtrrs = [
        'postal_code', 'country', 'region_fias_id', 'region_kladr_id', 'region_with_type', 'region_type',
        'region_type_full', 'region', 'area_fias_id', 'area_kladr_id', 'area_with_type', 'area_type', 'area_type_full',
        'area', 'city_fias_id', 'city_kladr_id', 'city_with_type', 'city_type', 'city_type_full', 'city', 'city_area',
        'city_district_fias_id', 'city_district_kladr_id', 'city_district_with_type', 'city_district_type',
        'city_district_type_full', 'city_district', 'settlement_fias_id', 'settlement_kladr_id', 'settlement_with_type',
        'settlement_type', 'settlement_type_full', 'settlement', 'street_fias_id', 'street_kladr_id', 'street_with_type',
        'street_type', 'street_type_full', 'street', 'house_fias_id', 'house_kladr_id', 'house_type', 'house_type_full',
        'house', 'block_type', 'block_type_full', 'block', 'flat_type', 'flat_type_full', 'flat', 'flat_area', 'square_meter_price',
        'flat_price', 'postal_box', 'fias_id', 'fias_level', 'kladr_id', 'capital_marker', 'okato', 'oktmo',
        'tax_office', 'tax_office_legal', 'timezone', 'geo_lat', 'geo_lon', 'beltway_hit', 'beltway_distance', 'qc_geo',
        'qc_complete', 'qc_house', 'unparsed_parts', 'qc'
    ];

    private $_id;

    public function init()
    {
        $this->_id = 'w' . uniqid();
        parent::init();
    }

    public function run()
    {
        $buf = [];
        foreach ($this->fields as $key => $name) {
            /*
            if (!in_array($name, $this->_availableAtrrs)) {
              throw new \HttpRuntimeException("Поле '" . htmlspecialchars($name) . "' нет в списке доступных.");
            }
            */

            if (is_int($key)) {
                $buf[$name] = $name;
            } else {
                $buf[$key] = $name;
            }
        }
        $this->fields = $buf;

        if (!array_key_exists('id', $this->options)) {
            $this->options['id'] = BaseHtml::getInputId($this->model, $this->attribute);
        }

        if (!array_key_exists('token', $this->suggestionsParams)) {
            $this->suggestionsParams['token'] = \Yii::$app->params['dadataToken'];
        }

        $setData = [];
        foreach ($this->fields as $k => $val) {
            $setData[$k] = $this->addressModel->$val;
        }
        $setData = Json::encode([
            'data' => $setData,
            'unrestricted_value' => $this->addressModel->full
        ]);

        return $this->render('widget', [
            'widget' => $this,
            'divId' => $this->_id,
            'setData' => $setData,
        ]);
    }

    private function isAttributeRequired($attribute)
    {
        foreach ($this->model->getActiveValidators($attribute) as $validator) {
            if ($validator instanceof RequiredValidator && $validator->when === null) {
                return true;
            }
        }
        return false;
    }
}
