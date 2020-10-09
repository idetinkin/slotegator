<?php

namespace common\models;

use frontend\components\prize\PrizeGenerator;
use frontend\components\prize\prizeHelpers\AbstractPrizeHelper;
use frontend\components\prize\prizeHelpers\MoneyPrizeHelper;
use frontend\components\prize\prizeHelpers\PointsPrizeHelper;
use frontend\components\prize\prizeHelpers\ThingsPrizeHelper;
use Yii;
use yii\base\InvalidArgumentException;
use yii\behaviors\TimestampBehavior;
use yii\db\Exception;

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
 * @property AbstractPrizeHelper $prizeHelper
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

    public static function createNewPrize()
    {
        $prizeGenerator = new PrizeGenerator();
        $prize = $prizeGenerator->generatePrize(Yii::$app->user->identity);

        if (!$prize->save()) {
            throw new Exception('Cannot save the prize', $prize->errors);
        }

        return $prize;
    }

    public function getPrizeHelper()
    {
        switch ($this->type_id) {
            case PrizeType::TYPE_MONEY: return new MoneyPrizeHelper(['prize' => $this]);
            case PrizeType::TYPE_POINTS: return new PointsPrizeHelper(['prize' => $this]);
            case PrizeType::TYPE_THINGS: return new ThingsPrizeHelper(['prize' => $this]);
            default: throw new InvalidArgumentException("The prize type {$this->type_id} has not been configured yet");
        }
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->prizeHelper->reservePrize();
        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        $this->prizeHelper->freePrize();

        return parent::beforeDelete();
    }


}
