<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "conta".
 *
 * @property int $id
 * @property int|null $tipoconta_id
 * @property float|null $saldo
 *
 * @property Tipoconta $tipoconta
 */
class Conta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipoconta_id'], 'default', 'value' => null],
            [['tipoconta_id'], 'integer'],
            [['saldo'], 'number'],
            [['tipoconta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoconta::class, 'targetAttribute' => ['tipoconta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipoconta_id' => 'Tipoconta ID',
            'saldo' => 'Saldo',
        ];
    }

    /**
     * Gets query for [[Tipoconta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoconta()
    {
        return $this->hasOne(Tipoconta::class, ['id' => 'tipoconta_id']);
    }

    public function getTipoContaString()
    {
        return Tipoconta::findOne($this->tipoconta_id)->nome;
    }
}
