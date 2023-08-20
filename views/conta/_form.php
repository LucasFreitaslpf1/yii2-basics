<?php

use app\models\Tipoconta;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Conta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="conta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $tipoContas = Tipoconta::find()->all();
    $tipoContaList = ArrayHelper::map($tipoContas, 'id', 'nome');
    ?>

    <?= $form->field($model, 'tipoconta_id')
        ->dropDownList($tipoContaList, ['prompt' => 'Selecione um tipo de conta']); ?>

    <?= $form->field($model, 'saldo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
