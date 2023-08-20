<?php

/** @var yii\web\View $this */

use Symfony\Component\VarDumper\VarDumper;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

$this->title = 'Painel do Cliente';
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

    <h1>Painel do Cliente</h1>
    <div class="container">
        <div class="box" style="padding-top: 10px; border-radius: 1px;">
            <label><b>Numero da Conta:</b> <?= $cliente->conta_id ?></label><br />
            <label><b>Nome:</b> <?= $cliente->nome ?></label><br />
            <label><b>Cpf:</b> <?= $cliente->username ?></label><br />
            <label><b>Endereço:</b> <?= $cliente->endereco ?></label><br />
            <label><b>Data de Nascimento:</b> <?= $cliente->nascimento ?></label><br />
            <label><b>Telefone:</b> <?= $cliente->telefone ?></label><br />
            <label><b>Tipo de Conta:</b> <?= $conta->getTipoContaString() ?></label><br />
            <label><b>Saldo:</b> <?= $conta->saldo ?></label><br /><br />
            <?= Html::a(
                'Fazer Depósito',
                ["adicionar-saldo"],
                ['class' => 'btn btn-success']
            ); ?>
            <?= Html::a(
                'Fazer Saque',
                ["saque"],
                ['class' => 'btn btn-warning']
            ); ?>
            <?= Html::a(
                'Pagar boleto',
                ["boleto"],
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
        <br />
        <div class="box">
            <h2>Transações:</h2>
            <?= Html::a(
                'Nova transferência',
                ["transacao/create"],
                ['class' => 'btn btn-warning']
            ); ?>
            <ul>
                <?php
                foreach ($transacoes as $transacao) :
                ?>
                <li class="lista">
                    <?= Html::encode("Dia: {$transacao->datahora}"); ?><br />
                    <?= Html::encode("De: {$transacao->remetente_id}") ?><br />
                    <?= Html::encode("Para: {$transacao->destinatario_id}"); ?><br />
                    <?= Html::encode("Valor: {$transacao->valor}"); ?><br />
                    <?= Html::a(
                            'Ver',
                            ["transacao/view?id=" . $transacao->id],
                            ['class' => 'btn btn-primary']
                        ); ?>
                    <?= Html::a(
                            'Gerar Comprovante',
                            ['gen-pdf', 'id' => $transacao->id],
                            ['class' => 'btn btn-success']
                        ); ?>

                </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
