<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \yii\helpers\VarDumper;

/**
 * ClienteLogin is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class ClienteCadastro extends Model
{
    public $id;
    public $nome;
    public $username;
    public $endereco;
    public $nascimento;
    public $telefone;
    public $password;
    public $repetir_senha;
    public $tipo_conta;
    public $admin;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['nome'], 'string', 'min' => 4, 'max' => 100],
            [['endereco', 'username', 'nascimento', 'telefone', 'nome'], 'required'],
            [['endereco', 'username', 'nascimento', 'telefone'], 'string'],
            [['tipo_conta'], 'required'],
            [['admin'], 'boolean'],
            [['password', 'repetir_senha'], 'string', 'min' => 4, 'max' => 30],
            [['repetir_senha'], 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function signup()
    {
        $transaction = Yii::$app->db->beginTransaction();

        $cliente = new User();
        $cliente->nome = $this->nome;
        $cliente->username = $this->username;
        $cliente->endereco = $this->endereco;
        $cliente->nascimento = $this->nascimento;
        $cliente->telefone = $this->telefone;

        $cliente->password = \Yii::$app->security->generatePasswordHash($this->password);
        $cliente->auth_key = \Yii::$app->security->generateRandomString();
        $cliente->access_token = \Yii::$app->security->generateRandomString();

        $conta = new Conta();
        $conta->tipoconta_id = $this->tipo_conta;
        $conta->saldo = 0.0;

        if ($conta->save()) {
            $cliente->conta_id = $conta->id;

            if ($cliente->save()) {
                $this->id = $cliente->id;

                $assignment = new AuthAssignment();
                if ($this->admin) {
                    $assignment->item_name = 'admin';
                } else {
                    $assignment->item_name = 'cliente';
                }
                $assignment->user_id = $cliente->id;
                $assignment->save();
                $transaction->commit();
                return true;
            }
            \Yii::error("Cliente não foi salvo" . VarDumper::dumpAsString($cliente->getErrors()));
        }
        \Yii::error("Conta não foi salva" . VarDumper::dumpAsString($conta->getErrors()));
        return false;
    }

    public function update($model)
    {
        $conta = Conta::findOne($model->conta_id);
        $conta->tipoconta_id = $this->tipo_conta;
        \Yii::error("Teste" . VarDumper::dumpAsString($this->tipo_conta));
        if ($conta->save()) {
            if ($model->save()) {
                return true;
            }
        }
        \Yii::error("Conta não foi salva" . VarDumper::dumpAsString($conta->getErrors()));
        return false;
    }
}
