<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \yii\helpers\VarDumper;

/**
 * TransacaoCadastro is the model behind the login form.
 *
 *
 */
class TransacaoCadastro extends Model
{
    public $id;
    public $label = 'transacao';
    public $valor;
    public $remetente_id;
    public $destinatario_id;
    public $tipo_transacao;

    public $encontrouR = false;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['valor'], 'required'],
            [['remetente_id', 'destinatario_id'], 'required'],
            [['remetente_id'], 'encontrarRemetente', 'skipOnError' => false],
            [['destinatario_id'], 'encontrarDestinatario', 'skipOnError' => false],
            [['remetente_id'], 'checarSaldo']
        ];
    }

    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();

        $transacao = new Transacao();
        $transacao->datahora = date('Y-m-d h:i:s');
        $transacao->tipotransacao_id = 3; // transferencia

        if (Yii::$app->user->can('cliente')) {
            $this->remetente_id = Yii::$app->user->identity->username;
        }

        if (Yii::$app->user->can('admin')) {
            $transacao->tipotransacao_id = $this->tipo_transacao;
        }

        $remetente = User::findOne(['username' => $this->remetente_id]);
        $destinatario = User::findOne(['username' => $this->destinatario_id]);

        $transacao->remetente_id = $remetente->username;
        $transacao->destinatario_id = $destinatario->username;

        $transacao->valor = $this->valor;

        $conta = Conta::findOne($remetente->conta_id);
        $conta->saldo -= $this->valor;

        $contaD = Conta::findOne($destinatario->conta_id);
        $contaD->saldo += $this->valor;

        if ($conta->save()) {
            if ($contaD->save()) {
                if ($transacao->save()) {
                    $this->id = $transacao->id;
                    $transaction->commit();
                    return true;
                }
                \Yii::error("Transação não foi salva" . VarDumper::dumpAsString($transacao->getErrors()));
                return false;
            }
        }
        \Yii::error("Conta não foi salva" . VarDumper::dumpAsString($conta->getErrors()));
        \Yii::error("Conta não foi salva" . VarDumper::dumpAsString($contaD->getErrors()));
        return false;
    }

    public function encontrarRemetente($attribute, $params)
    {
        $remetente_cpf = $this->remetente_id;
        if (User::findOne(['username' => $remetente_cpf]) == null) {
            $encontrouR = false;
            $this->addError($attribute, 'CPF não encontrado');
        }
        $encontrouR = true;
    }


    public function encontrarDestinatario($attribute, $params)
    {
        $destinatario_cpf = $this->destinatario_id;
        if (User::findOne(['username' => $destinatario_cpf]) == null) {
            $encontrouR = false;
            $this->addError($attribute, 'CPF não encontrado');
        }
        $encontrouR = true;
    }

    public function checarSaldo($attribute, $params)
    {
        $valor = $this->valor;
        if ($valor != null) {
            $remetente_cpf = $this->remetente_id;
            $remetente = User::findOne(['username' => $remetente_cpf]);
            $conta = Conta::findOne($remetente->conta_id);
            \Yii::error("teste" . VarDumper::dumpAsString($remetente));
            if ($conta->saldo < $valor) {
                $this->addError($attribute, 'Saldo insuficiente');
            }
        }
    }
}
