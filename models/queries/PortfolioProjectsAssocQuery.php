<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\PortfolioProjectsAssoc]].
 *
 * @see \app\models\PortfolioProjectsAssoc
 */
class PortfolioProjectsAssocQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\PortfolioProjectsAssoc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\PortfolioProjectsAssoc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
