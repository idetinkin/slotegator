<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prize_status".
 *
 * @property int $id
 * @property string $name
 *
 * @property Prize[] $prizes
 */
class PrizeStatus extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_DELIVERED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prize_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Prizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrizes()
    {
        return $this->hasMany(Prize::class, ['status_id' => 'id']);
    }
}
