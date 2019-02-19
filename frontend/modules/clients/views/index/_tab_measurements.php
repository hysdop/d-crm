<?php

/** @var $measurements array */

$measurementLabels = (new \common\repositories\MeasurementsRepository())->attributeLabels();

$i = count($measurements);
?>

<?php foreach ($measurements as $item): ?>
    <?php //if($i !== 0) echo 'Замер #' . $item['id']; ?>
    <?php echo $this->render('_tab_measurement_item', [
        'item' => $item,
        'isFiz' => $isFiz,
        'labels' => $measurementLabels
    ]); ?>
<?php endforeach; ?>
