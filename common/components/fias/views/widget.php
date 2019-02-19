<?php

/** @var $widget \common\components\fias\FiasWidget */

use \yii\helpers\BaseHtml;
use \yii\helpers\Json;

$this->registerJs("
    function fillInputs(data) {
        $.each(data.data, function(index, value) {
            $('#$divId [data-name=' + index + ']').val(value);
        });
        $('#$divId [data-name=unrestricted_value]').val(data.unrestricted_value);
        $('#$divId [data-name=value]').val(data.value);
    }
    
    var params = $.extend({}, " . Json::encode($widget->suggestionsParams) . ", {
        onSelect: function(suggestion) {
            fillInputs(suggestion)
        }
    });
    $('#" . $widget->options['id'] . "').suggestions(params);
    
    var buf = $setData;
    fillInputs(buf);
");

?>

<div id="<?= $divId ?>">
    <?php echo $widget->form->field($widget->model, $widget->attribute, $widget->optionsField)->textInput($widget->options)->label($widget->options['label']) ?>

    <?php foreach ($widget->fields as $key => $name): ?>
        <input type="hidden" data-name="<?= $key ?>" name="<?= BaseHtml::getInputName($widget->addressModel, $name) ?>">
    <?php endforeach; ?>
</div>