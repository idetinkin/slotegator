<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "prize".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type_id
 * @property int $status_id
 * @property int|null $value
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PrizeStatus $status
 * @property PrizeType $type
 * @property User $user
 */
class Prize extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prize';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type_id', 'status_id'], 'required'],
            [['user_id', 'type_id', 'status_id', 'value'], 'default', 'value' => null],
            [['user_id', 'type_id', 'status_id', 'value'], 'integer'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => PrizeStatus::class, 'targetAttribute' => ['status_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PrizeType::class, 'targetAttribute' => ['type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type_id' => 'Type ID',
            'status_id' => 'Status ID',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(PrizeStatus::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PrizeType::class, ['id' => 'type_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


}
