<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prize_thing".
 *
 * @property int $id
 * @property string $name
 * @property int|null $qty
 */
class PrizeThing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prize_thing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['qty'], 'default', 'value' => null],
            [['qty'], 'integer'],
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
            'qty' => 'Qty',
        ];
    }
}
