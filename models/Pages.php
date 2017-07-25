<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $alias
 * @property string $route
 * @property integer $parent_id
 * @property string $sort
 * @property string $creation_time
 * @property string $update_time
 *
 * @property PagesInfo[] $pagesInfos
 */
class Pages extends \yii\db\ActiveRecord
{
    
    public function rewriteOg()
    {
        $this->rewriteOgTitle();
        $this->rewriteOgType();
        $this->rewriteOgUrl();
        $this->rewriteOgDescription();
        $this->rewriteOgImage();
        return $this;
    }
        public function rewriteOgUrl(){
        if (!empty(Yii::$app->request->getAbsoluteUrl())) {
            Yii::$app->view->registerMetaTag([
                'property' => 'og:url',
                'content' => Yii::$app->request->getAbsoluteUrl()
            ], 'og_url');
            return true;    
        } else {
            return false;
        } 
    }
    
    public function rewriteOgType()
    {
            Yii::$app->view->registerMetaTag([
                'property' => 'og:type',
                'content' => "website"
            ], 'og_type');
            return true;
    }
            
    public function rewriteOgImage()
    {
        
        if (!empty($this->ogImgPath)) {
            $img = $this->ogImgPath;
        } else if (!empty(Yii::$app->page->pageThumb)) {
            $img = Yii::$app->page->pageThumb;
        } else {
            $img = "/images/shedule/b-1.jpg";
        }

        Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'content' => trim(\yii\helpers\Url::to(['/'],true),'/').$img
        ], 'og_image');
        
        return true;
    }
    
    public function rewriteOgTitle()
    {
        if (!empty($this->info->og_title)) {
            Yii::$app->view->registerMetaTag([
                'property' => 'og:title',
                'content' => $this->info->og_title
            ], 'og_title');
            return true;    
        } else {
            return false;
        } 
    }
    public function rewriteOgDescription()
    {
        if (!empty($this->info->og_dscr)) {
            Yii::$app->view->registerMetaTag([
                'property' => 'og:description',
                'content' => str_replace("&nbsp;", " ", strip_tags($this->info->og_dscr))
            ], 'og_description');
            return true;    
        } else {
            return false;
        } 
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'url', 'parent_id', 'sort', 'creation_time', 'update_time'], 'required'],
            [['parent_id', 'sort'], 'integer'],
            [['alias', 'url', 'creation_time', 'update_time'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias (заповнювати не обов`язково)'),
            'url' => Yii::t('app', 'url'),
            'parent_id' => Yii::t('app', 'Належить до розділу'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
        ];
    }
    
    public function behaviors()
    {
        return [
            'Thumb' => \app\behaviors\ThumbBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\Queries\Pages the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\Pages(get_called_class());
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfo()
    {
        return $this->hasOne(PagesInfo::className(), ['record_id' => 'id'])->where([PagesInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }
	
    /**
     * 
     * @return type
     */
    public function getSubBlocks()
    {
        return $this->hasMany(SubBlocks::className(), ['parent_id' => 'id'])
                ->joinWith('info')
                ->where([SubBlocks::tableName().'.hide' => 0]);
    }
    
    
    public function rewriteMeta()
    {
        $this->rewriteMetaTitle();
        $this->rewriteMetaDescription();
        return $this;
    }
    
    public function rewriteMetaTitle()
    {
        if (!empty($this->info->seo_title)) {
            Yii::$app->view->title = $this->info->seo_title;
            return true;
        } else {
            return false;
        }
    }
    
    public function rewriteMetaDescription()
    {
        if (!empty($this->info->seo_description)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $this->info->seo_description
            ]);
            return true;    
        } else {
            return false;
        } 
    }
    
    public function getOgImgPath()
    {
        if (!empty($this->og_image)) {
            $type = end(explode('.',$this->og_image));
        }
        $path="userfiles/$type/{$this->og_image}";
        if(file_exists($path)) {
            return "/$path";
        } else {
            return false;
        }
    }
}
