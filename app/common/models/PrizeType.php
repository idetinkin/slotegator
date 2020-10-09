<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prize_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Prize[] $prizes
 */
class PrizeType extends \yii\db\ActiveRecord
{
    const TYPE_MONEY = 1;
    const TYPE_POINTS = 2;
    const TYPE_THINGS = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prize_type';
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
        return $this->hasMany(Prize::class, ['type_id' => 'id']);
    }
}
