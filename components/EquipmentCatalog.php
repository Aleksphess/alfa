<?php
namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use app\models\Brands;
use app\models\Category;
use app\models\Products;
use app\models\Tags;
use app\helpers\TreeHelper;

class EquipmentCatalog extends Component
{
    public $perPage = 10;
    public $pagiPages;
    
    private $brand;
    private $brands;
    private $category;
    private $products;
    private $product;
    private $tag;
    private $catalogTags;
    private $categoryTags = [];
    private $topCategoryFolders = ['equipment'];
    private $catalogCategoriesIds = [];
    private $catalogCategoriesTree;
    private $categoryIds = [];
    private $kits;
    private $kit;
    private $tagsProducts = [];
    
    public function initComponent(array $params)
    {
        if (isset($params['brandAlias']) && isset($params['bId'])) {
            $brandId = substr($params['bId'], 1);
            $this->brand = Brands::find()->where(['id'=>$brandId])
                ->andWhere(['alias' => addslashes($params['brandAlias'])])
                ->joinWith('info')
                ->one();
        }
        if (isset($params['pId']) && isset($params['alias'])) {
            $productId = substr($params['pId'], 1);
            $this->product = Products::find()->where(['products.id'=>$productId])
                ->andWhere(['products.alias' => addslashes($params['alias'])])    
                ->joinWith(['info','brand','category'])
                ->one();
            $this->brand = $this->product->brand;
        }
        if (isset($params['categoryAlias'])) {
            $this->category = Category::find()->where(['alias' => addslashes($params['categoryAlias'])])
                    ->joinWith('info')
                    ->one();
        }
        if (isset($params['tagAlias']) && isset($params['tId'])) {
            $tagId = (int)substr($params['tId'], 1);
            $this->tag = Tags::find()->where(['id' => $tagId])
                    ->andWhere(['alias' => addslashes($params['tagAlias'])])
                    ->joinWith('info')
                    ->one();
        }
        if (isset($params['kId']) && isset($params['kitAlias'])) {
            $kitId = (int)substr($params['kId'], 1);
            $this->kit = Category::find()->where(['category.id'=>$kitId])
                ->andWhere(['category.alias' => addslashes($params['kitAlias'])])    
                ->joinWith('info')
                ->joinWith(['products' => function(\yii\db\ActiveQuery $q){
                    $q->joinWith('info');
                }])
                ->one();
        }
        if (isset($params['perPage'])) {
            $this->perPage = $params['perPage'];
        }
    }
        
    private function getIssetCatalogBrands()
    {
        $query = Brands::find()
                ->joinWith('info')
                ->joinWith('products.categoriesAssoc')
                ->orderBy(Brands::tableName().'.sort ASC');
        
        if ($this->category) {
            $query->where(['category_products_assoc.category_id' => $this->getCategoryIds()]);
        } else {
            $categoriesIds = $this->getCatalogCategoriesIds();
            $query->where(['products.parent_id' => $categoriesIds]);
        }
                
        return $query->all();
    }

    public function getBrands()
    {
        if (empty($this->brands)) {
             $this->brands = $this->getIssetCatalogBrands();
        }
        return $this->brands;
    }
    
    public function getBrand() 
    {
        if (!empty($this->brand)) {
            return $this->brand;
        }
        return false;
    }
    
    public function getTag() 
    {
        if (!empty($this->tag)) {
            return $this->tag;
        }
        return false;
    }
    
    public function getKit() 
    {
        if (!empty($this->kit)) {
            return $this->kit;
        }
        return false;
    }
    
    public function getCategory() 
    {
        if (!empty($this->category)) {
            return $this->category;
        }
        return false;
    }
    
    public function getProduct() 
    {
        if (!empty($this->product)) {
            return $this->product;
        }
        return false;
    }
    
    public function getProductsByCategoryTag()
    {
        if (empty($this->products) && !empty($this->tag) && !empty($this->category)) {
            $tag = $this->tag;
            $categoriesIds = $this->getCategoryIds();
            $this->products = Products::find()
                    ->joinWith(['info','category cat','categoriesAssoc'])
                    ->joinWith(['taggedProducts' => function(\yii\db\ActiveQuery $q) use ($tag){
                        $q->onCondition(['tag_id' => $tag->id]);
                    }])
                    ->where(['category_products_assoc.category_id' => $categoriesIds])
                    ->orderBy('products.sort ASC')
                    ->all();
            
            return $this->products;
        }
        return $this->products;
    }
    
    public function getProductsByTag()
    {
        if (empty($this->products) && !empty($this->tag)) {
            $tag = $this->tag;
            $this->products = Products::find()
                    ->joinWith(['taggedProducts' => function(\yii\db\ActiveQuery $q) use ($tag){
                        $q->onCondition(['tags_assoc.tag_id' => $tag->id]);
                    }],true,"INNER JOIN")
                    ->joinWith(['info','category'])
                    ->orderBy('products.sort ASC')
                    ->all();
            
            return $this->products;
        }
        return $this->products;
    }
    
    public function getProductsByCategoryBrand()
    {
        if (empty($this->products) && !empty($this->brand) && !empty($this->category)) {
            $categoriesIds = $this->getCategoryIds();
            $this->products = Products::find()
                    ->joinWith('info','categoriesAssoc')
                    ->where(['category_products_assoc.category_id' => $categoriesIds])
                    ->andWhere(['brand_id' => $this->brand->id])
                    ->orderBy('products.sort ASC')
                    ->all();
            
            return $this->products;
        }
        return $this->products;
    }
    
    public function getProductsByBrand()
    {
        if (empty($this->products) && !empty($this->brand)) {
            $categoriesIds = $this->getCatalogCategoriesIds();
            $this->products = Products::find()->where(['parent_id' => $categoriesIds])
                    ->andWhere(['brand_id' => $this->brand->id])
                    ->joinWith('info')
                    ->orderBy('products.sort ASC')
                    ->all();
            
            return $this->products;
        }
        return $this->products;
    }
    
    public function getKitsByCategoryTag()
    {
        if (empty($this->kits) && !empty($this->tag) && !empty($this->category)) {
            $subCategoriesIds = array_keys(ArrayHelper::index($this->category->children,'id'));
            $tag = $this->tag;
            $this->kits = Category::find()->where(['category.id' => $subCategoriesIds])
                    ->joinWith('info')
                    ->joinWith(['products' => function(\yii\db\ActiveQuery $q){
                        $q->joinWith('info');
                    }])
                    ->joinWith(['taggedCategories' => function(\yii\db\ActiveQuery $q) use ($tag){
                        $q->onCondition(['tag_id' => $tag->id]);
                    }])
                    ->all();
            
            return $this->kits;
        }
        return $this->kits;
    }
    
    
    public function getCatalogTags() 
    {
        if (empty($this->catalogTags)) {
            $tags = Tags::find()->where([
                        'tags.alias' => ['tech']
                    ])
                    ->joinWith(['children chld' => function(\yii\db\ActiveQuery $q) {
                        $q->orderBy('chld.sort DESC')->joinWith(['info','parentTag parent','products']);
                    }])
                    ->joinWith(['infoData inf' => function(\yii\db\ActiveQuery $q) {
                        $q->where(['inf.lang' => \app\models\Lang::getCurrentId()]);
                    }])
                    ->orderBy(Tags::tableName().'.sort ASC')
                    ->all();
                    
            $this->catalogTags = $tags;
        }
        
        return $this->catalogTags; 
    }
    
    public function getCategoryTags() 
    {
        if (empty($this->categoryTags) && !empty($this->category)) {
            $categoriesIds = $this->getCategoryIds();
            $tags = Tags::find()->joinWith(['products.categoriesAssoc','info'])
                    ->where(['category_products_assoc.category_id' => $categoriesIds])
                    ->orderBy(Tags::tableName().'.sort DESC')
                    ->all();
            $this->categoryTags = $tags;
        }
        
        return $this->categoryTags; 
    }
    
    private function getCatalogCategoriesIds()
    {
        if (empty($this->catalogCategoriesIds)) {
            $nestingItems = $this->getCatalogCategoriesTree();
            $this->catalogCategoriesIds = TreeHelper::searchTreeIdsByTopItems($nestingItems, $this->topCategoryFolders);
            return $this->catalogCategoriesIds;
        }
        return $this->catalogCategoriesIds;
    }
    
    
    private function getCatalogCategoriesTree()
    {
        if (empty($this->catalogCategoriesTree)) {
            $allCategories = Category::find()->all();
            $relation_items = TreeHelper::buildRelationItems($allCategories);
            $this->catalogCategoriesTree = TreeHelper::buildTree($relation_items, -1);
            return $this->catalogCategoriesTree;
        }
        return $this->catalogCategoriesTree;
    }

    private function getCategoryIds()
    {
        if (empty($this->categoryIds) && !empty($this->category)) {
            $nestingItems = $this->getCatalogCategoriesTree();
            $this->categoryIds = TreeHelper::searchTreeIdsByNestedAlias($nestingItems, [
                'alias' => 'equipment',
                'item' => [
                    'alias' => $this->category->alias
                ]
            ]);
            return $this->categoryIds;
        }
        return $this->categoryIds;
        
    }
    
    public function getTagsProductsByCategoryBrand()
    {
        if (empty($this->tagsProducts) && !empty($this->brand) && !empty($this->category)) {
            $categoriesIds = $this->getCategoryIds();
            $tagsProducts = Tags::find()->joinWith('info')
                    ->joinWith(['products' => function(\yii\db\ActiveQuery $q){
                        $q->onCondition(['products.brand_id' => $this->brand->id])
                        ->joinWith(['info','categoriesAssoc'])
                        ->orderBy('products.sort ASC');
                    }])
                    ->joinWith(['tagsAssocs ta' => function(\yii\db\ActiveQuery $q){
                        $q->onCondition(['ta.table_name' => 'brands','ta.record_id' => $this->brand->id]);
                    }])
                    ->where(['category_products_assoc.category_id' => $categoriesIds])
                    ->orderBy('ta.sort ASC')
                    ->all();
            
//            $this->tagsProducts = $this->groupByTags($tagsProducts);
            $this->tagsProducts = $tagsProducts;
            return $this->tagsProducts;
        }
        return $this->tagsProducts;
    }
    
    public function getTagsProductsByBrand()
    {
        if (empty($this->tagsProducts) && !empty($this->brand)) {
            $categoriesIds = $this->getCatalogCategoriesIds();
            $tagsProducts = Tags::find()->joinWith('info')
                    ->joinWith(['products' => function(\yii\db\ActiveQuery $q){
                        $q->onCondition(['products.brand_id' => $this->brand->id])
                        ->joinWith(['info','categoriesAssoc'])
                        ->orderBy('products.sort ASC');
                    }])
                    ->joinWith(['tagsAssocs ta' => function(\yii\db\ActiveQuery $q){
                        $q->onCondition(['ta.table_name' => 'brands','ta.record_id' => $this->brand->id]);
                    }])
                    ->where(['category_products_assoc.category_id' => $categoriesIds])
                    ->orderBy('ta.sort ASC')   
                    ->all();
            
//            $this->tagsProducts = $this->groupByTags($tagsProducts);
            $this->tagsProducts = $tagsProducts;
            return $this->tagsProducts;
        }
        return $this->tagsProducts;
    }
    
    private function groupByTags($array)
    {
        $result = [];
        $issetProducts = [];
        foreach ($array as $index => $tag) {
            foreach ($tag->products as $key => $product) {
                if (!in_array($product->id, $issetProducts)) {
                    $issetProducts[] = $product->id;
                    $result[$tag->id]['name'] = $tag->info->name;
                    $result[$tag->id]['products'][] = $product;
                }
            }
        }
        return $result;
    }
}