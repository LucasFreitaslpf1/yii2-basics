<?php

use app\models\Tipotransacao;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
use app\models\User;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transacao-form form">

    <?php $form = ActiveForm::begin(
        [
            'enableAjaxValidation' => true,
        ]
    ); ?>

    <?php
    $tipoTransacao = Tipotransacao::find()->all();
    $tipoTransacaoList = ArrayHelper::map($tipoTransacao, 'id', 'nome');
    ?>

    <?= $form->field($model, 'tipo_transacao')
        ->dropDownList($tipoTransacaoList, ['prompt' => 'Selecione um tipo de transação']); ?>

    <?php
    $clientes = User::find()->select(['id', 'cpf']);
    $clienteList = ArrayHelper::map($clientes, 'id', 'cpf');
    ?>

    <?php
    if (Yii::$app->user->can('admin')) :
    ?>
        <?= $form->field($model, 'remetente_id')->widget(
            MaskedInput::class,
            ['mask' => '999.999.999-99']
        ) ?>

    <?php endif; ?>



    <?= $form->field($model, 'destinatario_id')->widget(
        MaskedInput::class,
        ['mask' => '999.999.999-99']
    ) ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
