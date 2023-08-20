<?php

/** @var yii\web\View $this */

use Symfony\Component\VarDumper\VarDumper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

$this->title = 'Painel do Administrador';
?>

<style>
    .container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .box {
        background-color: #f2f2f2;
        padding: 20px;
        border: 1px solid #ccc;
        flex: 3;
        width: 900px;
    }

    ul {
        list-style-type: none;
    }

    .lista {
        padding: 1px;
        margin: 5px;
        border-bottom: 1px solid;
    }
</style>
<div class="site-index">
    <?php $form = ActiveForm::begin(); ?>

    <h1>Painel do Administrador</h1>
    <div class="container">
        <div class="box" style="padding-top: 10px; border-radius: 1px;">
            <h2>Criar/Editar</h2>
            <?= Html::a(
                'Clientes',
                ["cliente/index"],
                ['class' => 'btn btn-primary']
            ); ?><br /><br />
            <?= Html::a(
                'Transações',
                ["transacao/index"],
                ['class' => 'btn btn-primary']
            ); ?><br /><br />
            <?= Html::a(
                'Conta',
                ["conta/index"],
                ['class' => 'btn btn-primary']
            ); ?><br /><br />
            <?= Html::a(
                'Tipo de Transação',
                ["transacao/novotipo"],
                ['class' => 'btn btn-primary']
            ); ?><br /><br />
            <?= Html::a(
                'Tipo de Conta',
                ["conta/novotipo"],
                ['class' => 'btn btn-primary']
            ); ?><br />
        </div>
        <br />
    </div>

    <?php ActiveForm::end(); ?>
</div>
