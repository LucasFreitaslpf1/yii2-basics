<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \yii\helpers\VarDumper;

class SaldoForm extends Model
{
    public $saldo;
    public $saque;
    public $conta;
    public $pagamento;
    public $boletonum;

    public function attributeLabels()
    {
        return [
            'boletonum' => 'Número do boleto',
            'pagamento' => 'Valor a pagar',
            'saldo' => 'Valor a ser depositado',
            'saque' => 'Valor a ser sacado'
        ];
    }

    public function rules()
    {
        return [
            [['saldo'], 'required'],
            [['saldo'], 'number'],
            [['saque'], 'required'],
            [['saque'], 'number'],
            [['boletonum', 'pagamento'], 'required'],
            [['pagamento'], 'number'],
        ];
    }

    public function addSaldo()
    {
        $conta = Yii::$app->user->identity;
        $this->conta->saldo += $this->saldo;

        $transacao = new Transacao();
        $transacao->datahora = date('Y-m-d h:i:s');
        $transacao->tipotransacao_id = 1; // depósito
        $transacao->remetente_id = $conta->username;
        $transacao->destinatario_id = $conta->username;
        $transacao->valor = $this->saldo;

        if ($transacao->save()) {
            if ($this->conta->save()) {
                return true;
            }
        }

        \Yii::error("Saldo não salvo" . VarDumper::dumpAsString($this->conta->getErrors()));
        return false;
    }

    public function saque()
    {
        $conta = Yii::$app->user->identity;
        $this->conta->saldo -= $this->saque;

        $transacao = new Transacao();
        $transacao->datahora = date('Y-m-d h:i:s');
        $transacao->tipotransacao_id = 2; // saque
        $transacao->remetente_id = $conta->username;
        $transacao->destinatario_id = $conta->username;
        $transacao->valor = $this->saque;

        if ($transacao->save()) {
            if ($this->conta->save()) {
                return true;
            }
            \Yii::error("Transcação não salvo" . VarDumper::dumpAsString($transacao->getErrors()));
        }

        \Yii::error("Saldo não salvo" . VarDumper::dumpAsString($this->conta->getErrors()));
        return false;
    }

    public function boleto()
    {
        $conta = Yii::$app->user->identity;
        $this->conta->saldo -= $this->pagamento;

        $transacao = new Transacao();
        $transacao->datahora = date('Y-m-d h:i:s');
        $transacao->tipotransacao_id = 4; // saque
        $transacao->remetente_id = $conta->username;
        $transacao->destinatario_id = $conta->username;
        $transacao->valor = $this->pagamento;

        if ($transacao->save()) {
            if ($this->conta->save()) {
                return true;
            }
            \Yii::error("Transcação não salvo" . VarDumper::dumpAsString($transacao->getErrors()));
        }

        \Yii::error("Saldo não salvo" . VarDumper::dumpAsString($this->conta->getErrors()));
        return false;
    }
}
