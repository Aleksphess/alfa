<?php

namespace app\controllers;

use Yii;
use app\models\Products;
use app\models\Tags;
use yii\data\Pagination;

class SearchController extends \app\extentions\BaseController
{
    public function actionIndex()
    {
        $s = Yii::$app->request->get('s',false);
        if (!empty($s)) {
            // Products
            $query = Products::find()
                        ->joinWith('info')
                        ->joinWith('brand.info')
                        ->where(["like", "products_info.name",  addslashes($s)])
                        ->andWhere(['not',['brand_id' => null]])
                        ->orWhere(["like", "brands_info.name",  addslashes($s)])
                        ->limit(20);
            
            // Pagination
            $countQuery = clone $query;
            $totalCount = $countQuery->count('products.id');
            unset($countQuery);
            $pages = new Pagination(['totalCount' => $totalCount]);
            $pages->setPageSize(20);
            $query->offset($pages->offset)->limit($pages->limit);
            $products = $query->all();
            
            // Technologies
            $parentTag = Tags::find()->where(['tags.alias' => ['tech']])->one();
            if ($parentTag) {
                $query = Tags::find()->joinWith('info')
                        ->where(['parent_id' => $parentTag->id])
                        ->andWhere(["like", "name",  addslashes($s)])
                        ->orderBy(Tags::tableName().'.sort ASC');

                // Pagination
                $countQuery = clone $query;
                $totalCount = $countQuery->count('tags.id');
                unset($countQuery);
                $pagesTech = new Pagination(['totalCount' => $totalCount]);
                $pagesTech->setPageSize(20);
                $query->offset($pagesTech->offset)->limit($pagesTech->limit);
                $technologies = $query->all();
            } else {
                $technologies = [];
            }
        } else {
            $products = [];
            $pages = new Pagination(['totalCount' => 0]);
            $technologies = [];
            $pagesTech = new Pagination(['totalCount' => 0]);
        }
        return $this->render('index',[
            'products' => $products,
            'pages' => $pages,    
            'technologies' => $technologies,
            'pagesTech' => $pagesTech    
        ]);
    }

}
