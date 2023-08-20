<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */

$this->title = 'Transação';
\yii\web\YiiAsset::register($this);
?>
<div class="transacao-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if (Yii::$app->user->can('admin')) :
    ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(
                'Gerar Comprovante',
                ['painel/gen-pdf', 'id' => $model->id],
                ['class' => 'btn btn-success']
            ); ?>
        </p>
    <?php
    endif;
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'datahora',
            'tipotransacao_id',
            'remetente_id',
            'destinatario_id',
            'valor',
        ],
    ]) ?>
</div>
