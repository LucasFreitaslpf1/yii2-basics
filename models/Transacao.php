<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transacao".
 *
 * @property int $id
 * @property string|null $datahora
 * @property int|null $tipotransacao_id
 * @property float|null $valor
 * @property string|null $remetente_id
 * @property string|null $destinatario_id
 *
 * @property User $destinatario
 * @property User $remetente
 * @property Tipotransacao $tipotransacao
 */
class Transacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datahora'], 'safe'],
            [['tipotransacao_id'], 'default', 'value' => null],
            [['tipotransacao_id'], 'integer'],
            [['valor'], 'number'],
            [['remetente_id', 'destinatario_id'], 'string', 'max' => 20],
            [['tipotransacao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipotransacao::class, 'targetAttribute' => ['tipotransacao_id' => 'id']],
            [['remetente_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['remetente_id' => 'username']],
            [['destinatario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['destinatario_id' => 'username']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datahora' => 'Dia e hora',
            'tipotransacao_id' => 'Tipo de Transação',
            'valor' => 'Valor',
            'remetente_id' => 'CPF do Remetente',
            'destinatario_id' => 'CPF do Destinatario',
        ];
    }

    /**
     * Gets query for [[Destinatario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinatario()
    {
        return $this->hasOne(User::class, ['username' => 'destinatario_id']);
    }

    /**
     * Gets query for [[Remetente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRemetente()
    {
        return $this->hasOne(User::class, ['username' => 'remetente_id']);
    }

    /**
     * Gets query for [[Tipotransacao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipotransacao()
    {
        return $this->hasOne(Tipotransacao::class, ['id' => 'tipotransacao_id']);
    }
}
