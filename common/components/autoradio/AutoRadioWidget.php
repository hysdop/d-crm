<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 16.05.17
 * Time: 17:54
 */

namespace common\components\autoradio;

use yii\bootstrap\Widget;
use yii\widgets\ActiveForm;

class AutoRadioWidget extends Widget
{
    /** @var  ActiveForm */
    public $form;

    public $items;

    public $selectAfter = 3;

    public $model;

    public $attribute;

    public $options = [];

    public $label = false;

    public $nullOption = false;

    public $isRadio;

    public function run()
    {
        $this->isRadio = ($this->selectAfter > count($this->items));

        if (!$this->isRadio) {
            if ($this->nullOption) {
                $oName = ($this->nullOption === true ? '---' : $this->nullOption);
                $this->items = [null => $oName] + $this->items;
            }
        }

        return $this->render('index', [
            'widget' => $this
        ]);
    }
}