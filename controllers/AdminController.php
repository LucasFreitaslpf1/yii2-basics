<?php

namespace app\controllers;

use app\models\PainelCliente;
use app\models\Transacao;
use yii\web\Controller;
use Yii;
use yii\helpers\VarDumper;
use app\models\Conta;

class AdminController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')) {
            return $this->render('index');
        } else {
            $this->redirect(Yii::$app->homeUrl);
        }
    }
}
