<?php

namespace app\models;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "library".
 *
 * @property integer $id
 * @property integer $id_owner
 * @property integer $id_user
 * @property string $title
 * @property string $description
 * * @property string $img
 * @property integer $year
 */
class Library extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'library';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'year'], 'required'],
            [['id_owner', 'id_user', 'year'], 'integer'],
            [['img'],'file','skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['description','img'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('/web/images/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_owner' => 'Владелец',
            'id_user' => 'Кто взял',
            'title' => 'Наиманование',
            'description' => 'Описание',
            'year' => 'Год',
            'img'=>'Изображение'
        ];
    }
    
    public function getOwner()
    {
        return $this->hasOne(Users::className(), ['id'=>'id_owner']);
    }
    
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id'=>'id_user']);
    }
}
