<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tipotransacao $model */

$this->title = 'Depósito';

?>
<div class="tipotransacao-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Digite o valor a ser depositado:</p>
    <?php
    $form = ActiveForm::begin();
    ?>

    <?= $form->field($model, 'saldo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
