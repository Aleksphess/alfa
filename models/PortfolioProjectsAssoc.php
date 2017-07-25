<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "portfolio_projects_assoc".
 *
 * @property integer $portfolio_id
 * @property integer $project_id
 *
 * @property Projects $project
 * @property Portfolio $portfolio
 */
class PortfolioProjectsAssoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portfolio_projects_assoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['portfolio_id', 'project_id'], 'required'],
            [['portfolio_id', 'project_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['portfolio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portfolio::className(), 'targetAttribute' => ['portfolio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'portfolio_id' => 'Portfolio ID',
            'project_id' => 'Project ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\PortfolioProjectsAssocQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\PortfolioProjectsAssocQuery(get_called_class());
    }
}
