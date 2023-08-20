<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $nome
 * @property string $username
 * @property string $endereco
 * @property string $nascimento
 * @property string $telefone
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property int|null $conta_id
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public $tipo_conta;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'username', 'endereco', 'nascimento', 'telefone', 'password', 'auth_key', 'access_token'], 'required'],
            [['nascimento'], 'safe'],
            [['nome', 'endereco', 'password', 'auth_key', 'access_token'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 20],
            [['telefone'], 'string', 'max' => 15],
            [['username'], 'unique'],
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
            'username' => 'CPF',
            'endereco' => 'Endereco',
            'nascimento' => 'Nascimento',
            'telefone' => 'Telefone',
            'password' => 'Senha',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->where(['access_token' => $token])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function salvarTipoConta()
    {
        $conta = Conta::findOne($this->conta_id);
        $conta->tipoconta_id = $this->tipo_conta;
        $conta->save();
    }
}
