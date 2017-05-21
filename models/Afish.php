<?php

namespace app\models;

use Yii;


class Afish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'afish';
    }


    public function rules()
    {
        return [
            /*
            [['description', 'content'], 'string'],
            [['viewed', 'catalog_id'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
*/
            [['name'], 'required'],
            [['name','description','content'],'string'],
            [['date'], 'date', 'format'=>'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['name','phone'],'string','max'=> 255],

            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'description' => 'Краткое описание',
            'phone' => 'Номер телефона',
            'content' => 'Контент',
            'image' => 'Изображение',
            'viewed' => 'Просмотры',
            'catalog_id' => 'Каталог',
        ];
    }

    public function saveArticle()
    {
        $this->user_id = Yii::$app->user->id;
        return $this->save(false);
    }

    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(),['id'=>'catalog_id']);
    }

    public function saveCatalog($catalog_id)
    {
        $catalog = Catalog::findOne($catalog_id);
        if($catalog != null)
        {
            $this->link('catalog',$catalog);
            return true;
        }

    }

    public function viewedCounter()
    {
        $this->viewed += 1;
        return $this->save(false);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(),['afish_id'=>'id']);
    }

    public function getAfishComments()
    {
        return $this->getComments()->where(['status'=>1])->all();
    }

    public function getCountComments()
    {
        return $this->getComments()->where(['status'=>1])->count();
    }

    public function getPopular()
    {
        return Afish::find()->orderBy('viewed desc')->limit(3)->all();
    }
    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
    }

    public function getRecent()
    {
        return Afish::find()->orderBy('date asc')->limit(3)->all();
    }









}