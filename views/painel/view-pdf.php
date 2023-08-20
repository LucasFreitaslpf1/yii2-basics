<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */

\yii\web\YiiAsset::register($this);
?>
<div class="transacao-view">

    <h1><?= Html::encode("Comprovante de Transferência") ?></h1>

    <label><b>De: </b><?= $remetente->nome ?></label><br />
    <label><b>Para: </b><?= $destinatario->nome ?></label><br />
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
