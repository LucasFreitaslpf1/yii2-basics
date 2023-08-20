<?php

/** @var yii\web\View $this */

$this->title = 'Banco de Minas Gerais';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Banco do Norte de Minas Gerais</h1>
        <?php if (!Yii::$app->user->can('cliente')) : ?>
            <p class="lead">Clique em login para entrar</p>
        <?php else : ?>
            <p>Clique em minha conta para continuar</p>
        <?php endif; ?>
    </div>

</div>
