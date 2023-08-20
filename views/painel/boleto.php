<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tipotransacao $model */

$this->title = 'Pagar boleto';

?>
<div class="tipotransacao-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Digite o numero e o valor do boleto</p>

    <?php
    $form = ActiveForm::begin();
    ?>

    <?= $form->field($model, 'boletonum')->textInput() ?>
    <?= $form->field($model, 'pagamento')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
