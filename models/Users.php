<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $login
 * @property string $passwd
 * @property string $firstname
 * @property string $lastname
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $user = false;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'passwd'], 'required'],
            [['login', 'passwd', 'firstname', 'lastname'], 'string', 'max' => 255],
            ['passwd','validatePassword'],
        ];
    }
    
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(!$this->getUser())
            {
                $this->addError($attribute, 'Неверный пароль ');
            } 
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'passwd' => 'Пароль',
            'firstname' => 'Фамилия',
            'lastname' => 'Имя',
        ];
    }
    
    
    public function login()
        {
            if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
            }
        }
        
    public function getUser()
     {
       if ($this->user === false) {
        $this->user = Users::findOne(['login'=>$this->login]);
        
        if($this->user->passwd)
        {
            if (Yii::$app->getSecurity()->validatePassword($this->passwd, $this->user->passwd)) {
                    return true;
                } else {
                   return false;
                }
        }
    }
            
      return $this->user;
    }
    
    public function Logout()
    {
        Yii::$app->user->logout();
    }
    
    public function getLibrary()
    {
        return $this->hasOne(Library::className(), ['id_owner'=>'id']);
    }
    
        public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
      
    }
    
    public function getAuthKey()
    {
       
    }

    public function validateAuthKey($authKey)
    {
      
    }
}
