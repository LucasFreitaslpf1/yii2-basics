<?php

namespace app\controllers;

use app\models\Transacao;
use yii\web\Controller;
use Yii;
use app\models\Conta;
use app\models\User;
use app\models\SaldoForm;


class PainelController extends Controller
{
    public function actionIndex()
    {
        $cliente = Yii::$app->user->identity;
        $conta = Conta::findOne($cliente->conta_id);
        $transacoes = Transacao::find()
            ->where(['remetente_id' => $cliente->username])
            ->orWhere(['destinatario_id' => $cliente->username])
            ->orderBy(['datahora' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'cliente' => $cliente,
            'transacoes' => $transacoes,
            'conta' => $conta,
        ]);
    }

    public function actionGenPdf($id)
    {
        $model = Transacao::findOne($id);
        $remetente = User::findOne(['username' => $model->remetente_id]);
        $destinatario = User::findOne(['username' => $model->destinatario_id]);
        $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
        $pdf_content = $this->renderPartial('view-pdf', [
            'model' => $model,
            'remetente' => $remetente,
            'destinatario' => $destinatario
        ]);

        $mpdf->WriteHTML($pdf_content);
        $mpdf->Output();
        exit;
    }


    public function actionAdicionarSaldo()
    {
        $model = new SaldoForm();
        $user = Yii::$app->user->identity;
        $conta = Conta::findOne($user->conta_id);
        $model->conta = $conta;



        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->addSaldo()) {
                return $this->redirect('index');
            }
        }

        return $this->render('adicionar-saldo', [
            'conta' => $conta,
            'model' => $model
        ]);
    }

    public function actionSaque()
    {
        $model = new SaldoForm();
        $user = Yii::$app->user->identity;
        $conta = Conta::findOne($user->conta_id);
        $model->conta = $conta;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->saque()) {
                return $this->redirect('index');
            }
        }

        return $this->render('saque', [
            'conta' => $conta,
            'model' => $model
        ]);
    }

    public function actionBoleto()
    {
        $model = new SaldoForm();
        $user = Yii::$app->user->identity;
        $conta = Conta::findOne($user->conta_id);
        $model->conta = $conta;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->boleto()) {
                return $this->redirect('index');
            }
        }

        return $this->render('boleto', [
            'conta' => $conta,
            'model' => $model
        ]);
    }
}
