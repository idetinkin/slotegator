<?php

namespace common\models;

use Yii;
use yii\db\Exception as DbException;

/**
 * This is the model class for table "key_value_storage".
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 */
class KeyValueStorage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key_value_storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    /**
     * @param string $key
     * @return string|null
     */
    public static function getValue($key)
    {
        return static::find()
            ->select('value')
            ->where([
                'key' => $key,
            ])
            ->scalar();
    }

    /**
     * @param string $key
     * @param string $value
     * @throws DbException
     */
    public static function setValue($key, $value)
    {
        $keyValueRecord = static::find()
            ->where([
                'key' => $key
            ])
            ->one();

        if (empty($keyValueRecord)) {
            $keyValueRecord = new KeyValueStorage();
            $keyValueRecord->key = $key;
        }

        $keyValueRecord->value = $value;

        if (!$keyValueRecord->save()) {
            throw new DbException('Cannot save to the key/value storage', $keyValueRecord->errors);
        }
    }
}
