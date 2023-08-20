<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoconta".
 *
 * @property int $id
 * @property string $nome
 *
 * @property Conta[] $contas
 */
class Tipoconta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoconta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Contas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContas()
    {
        return $this->hasMany(Conta::class, ['tipoconta_id' => 'id']);
    }
}
