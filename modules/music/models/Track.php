<?php

namespace modules\music\models;


class Track extends \yii\db\ActiveRecord
{
    public $trackFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'music_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge([
            [['genre_id','title'], 'required'],
            [['genre_id'], 'integer'],
            [['title', 'file'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['trackFile'], 'file'],
        ], parent::rules());
    }

    public function getGenre()
    {
        return $this->genre_id ? Genres::findOne($this->genre_id) : null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'genre_id' => 'Genre',
            'title' => 'Title',
            'file' => 'Track File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

}