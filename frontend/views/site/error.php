<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>

<!-- page content -->
<div class="col-md-12">
    <div class="col-middle">
        <div class="text-center text-center">
            <h1 class="error-number"><?= $exception->statusCode ?></h1>
            <h2><?php echo Html::encode($this->title) ?></h2>
            <p>
                <?php echo nl2br(Html::encode($message)) ?>
            </p>
            <div class="mid_center hide">
                <h3>Search</h3>
                <form>
                    <div class="col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Go!</button>
                          </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>