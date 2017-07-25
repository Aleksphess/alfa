<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use app\models\Tags;
use app\models\TagsAssoc;
use app\models\Blog;

class EventsComponent extends Component
{
    public $perPage = 9;
    public $pagiPages;
    
    private $events;
    private $event;
    private $eventId;
    private $eventsByLimit;
    private $sortBy = 'pub_date';
    private $order = 'DESC';
    
    public function initComponent(array $params)
    {
        if (isset($params['perPage'])) {
            $this->perPage = $params['perPage'];
        }
        if (isset($params['pId']) && isset($params['alias'])) {
            $this->eventId = substr($params['pId'], 1);
            $this->event = Blog::find()->where(['id'=>$this->eventId])
                ->andWhere(['alias' => addslashes($params['alias'])])
                ->active()
                ->joinWith('info')
                ->joinWith(['tags' => function(\yii\db\ActiveQuery $q){
                    $q->where(['tags.id' => 197]);
                }])
                ->one();
        }
    }
    
    public function getEvents() 
    {
        if (empty($this->events)) {
            $query = Blog::find()
                    ->active()
                    ->orderBy("{$this->sortBy} $this->order");
            
            // If search param present
            $search = Yii::$app->request->get('s',false);
            if ($search) {
                $query->joinWith(['info' => function (\yii\db\ActiveQuery $q) use ($search){
                    $q->where(['like','title',$search]);
                }]);
            } 
            else {
                $query->joinWith('info');
//                        ->andWhere(['>=','pub_date',date('Y-m-d')]);
            }
            
            $query->joinWith(['tags' => function(\yii\db\ActiveQuery $q){
                $q->where(['tags.id' => 197]);
            }]);
            
            // Pagination
            $countQuery = clone $query;
            $totalCount = $countQuery->count('blog.id');
            unset($countQuery);
            $this->pagiPages = new Pagination(['totalCount' => $totalCount]);
            $this->pagiPages->setPageSize($this->perPage);
            $query->offset($this->pagiPages->offset)->limit($this->pagiPages->limit);
            
            // db execute
            $this->events = $query->all();
            
            return $this->events;
        }
        return $this->events;
    }
    
    public function getEventsByLimit($limit, $sortBy = null, $order = null) 
    {
        if (empty($this->eventsByLimit)) {
            $this->sortBy = (($sortBy === null) ? $this->sortBy : $sortBy);
            $this->order = (($order === null) ? $this->order : $order);
        
            $this->eventsByLimit = Blog::find()
                    ->active()
                    ->andWhere(['not',['id' => $this->event->id]])
                    ->andWhere(['>=','pub_date',date('Y-m-d')])
                    ->joinWith('info')
                    ->joinWith(['tags' => function(\yii\db\ActiveQuery $q){
                        $q->where(['tags.id' => 197]);
                    }])
                    ->limit($limit)
                    ->orderBy("{$this->sortBy} $this->order")
                    ->all();
            
            return $this->eventsByLimit;
        }
        return $this->eventsByLimit;
    }
    
    public function getEvent() 
    {
        if (!empty($this->event)) {
            return $this->event;
        }
        return false;
    }
}