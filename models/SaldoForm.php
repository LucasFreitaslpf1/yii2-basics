<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \yii\helpers\VarDumper;

class SaldoForm extends Model
{
    public $saldo;
    public $conta;

    public function rules()
    {
        return [
            [['saldo'], 'required'],
            [['saldo'], 'number']
        ];
    }

    public function addSaldo()
    {
        $this->conta->saldo += $this->saldo;

        if ($this->conta->save()) {
            return true;
        }

        \Yii::error("Saldo não salvo" . VarDumper::dumpAsString($this->conta->getErrors()));
        return false;
    }
}
