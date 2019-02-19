<?php
/** @var $widget AutoRadioWidget */

use  \common\components\autoradio\AutoRadioWidget;

?>

<?php if ($widget->isRadio): ?>
    <?php echo $widget->form->field($widget->model, $widget->attribute)
        ->radioList($widget->items, $widget->options)
        ->label($widget->label) ?>
<?php else: ?>
    <?php echo $widget->form->field($widget->model, $widget->attribute)
        ->dropDownList($widget->items, $widget->options)
        ->label($widget->label) ?>
<?php endif; ?>
