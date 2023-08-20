<?php

use yii\helpers\Html;
use app\models\Tipoconta;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Cliente $model */

$this->title = 'Update Cliente: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cliente-update">

    <h1><?= Html::encode($this->title) ?></h1>

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


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
