<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Tipoconta;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var app\models\Cliente $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cliente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->widget(
        MaskedInput::class,
        ['mask' => '999.999.999-99']
    ) ?>

    <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nascimento')->widget(DatePicker::class, [
        'language' => 'pt-BR', // Defina o idioma desejado
        'dateFormat' => 'dd-MM-yyyy',
        'options' => ['class' => 'form-control'],
    ]); ?>

    <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?php
    $tipoContas = Tipoconta::find()->all();
    $tipoContaList = ArrayHelper::map($tipoContas, 'id', 'nome');
    ?>

    <?= $form->field($model, 'tipo_conta')
        ->dropDownList($tipoContaList, ['prompt' => 'Selecione um tipo de conta']); ?>

    <?= $form->field($model, 'admin')->checkbox([
        'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
