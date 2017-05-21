<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Afish */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="afish-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::dropDownList('catalog',$selectedCatalog, $cataloges,['class'=>'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' =>'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
