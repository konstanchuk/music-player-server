<?php

namespace modules\music\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\imagine\Image;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\helpers\Inflector;
use yii\helpers\Html;
use yii\helpers\Url;


class Genres extends \yii\db\ActiveRecord
{
    private $_fileName;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'music_genres';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'position', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['name',], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 80],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent genre',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Genre Image',
            'position' => 'Position',
            'is_active' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getParentGenre()
    {
        return $this->hasOne(static::className(), ['id' => 'parent_id']);
    }

    public static function getHierarchy()
    {
        $options = [];
        $parents = self::find()->where('parent_id=0 or parent_id is NULL')->all();
        foreach($parents as $id => $item) {
            $children = self::find()->where('parent_id=:parent_id', [':parent_id'=>$item->id])->all();
            $childOptions = [];
            foreach($children as $child) {
                $childOptions[$child->id] = $child->name;
            }
            $options[$item->name] = $childOptions;
        }
        return $options;
    }

    public function upload()
    {
        if ($this->validate()) {

            //Skip on empty
            if ($this->image == null) {
                return true;
            }

            $uploadDir = Yii::$app->getModule('music')->uploadDir;
            $uploadThumbs = Yii::$app->getModule('music')->uploadThumbs;

            //Create Dir if not exist
            $originalPath = Yii::getAlias($uploadDir) . DIRECTORY_SEPARATOR . 'original';
            if (!file_exists($originalPath)) {
                if (!FileHelper::createDirectory($originalPath, 0775, $recursive = true)) {
                    throw new InvalidConfigException('genre image upload directory does not exist and default path creation failed');
                }
            }

            //Save original file
            $this->image->saveAs($originalPath . DIRECTORY_SEPARATOR . $this->getFileName());

            //Save thumbs
            foreach ($uploadThumbs as $thumbDirName => $size) {
                $thumbPath = Yii::getAlias($uploadDir) . DIRECTORY_SEPARATOR . $thumbDirName;
                if (!file_exists($thumbPath)) {
                    if (!FileHelper::createDirectory($thumbPath, 0775, $recursive = true)) {
                        throw new InvalidConfigException($thumbPath . 'genre thumb path creation failed');
                    }
                }
                Image::thumbnail(Yii::getAlias($originalPath . DIRECTORY_SEPARATOR . $this->getFileName()), $size[0], $size[1])
                    ->save(Yii::getAlias($thumbPath . DIRECTORY_SEPARATOR . $this->getFileName()), ['quality' => 90]);
            }
            $this->image = $this->getFileName();
            $this->save(false);
            return true;
        } else {
            return false;
        }
    }

    public function getFileName()
    {
        if (!$this->_fileName) {
            $fileName = substr(uniqid(md5(rand()), true), 0, 10);
            $fileName .= '-' . Inflector::slug($this->image->baseName);
            $fileName .= '.' . $this->image->extension;
            $this->_fileName = $fileName;
        }
        return $this->_fileName;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->image = UploadedFile::getInstance($this, 'image');
            return true;
        }
        return false;
    }

    public function afterDelete()
    {
        parent::afterDelete();

        // delete images in future
    }

    public static function createTreeList($parentId, $currentGenre)
    {
        $genres = static::find()->where(['parent_id' => $parentId])->all();
        $parentId = Yii::$app->request->getQueryParam('parent_id');
        $html = '';
        $html .= '<ul>';
        foreach ($genres as $genre) {
            $html .= "<li>";
            $class = (($genre->id == $parentId) || ($genre->id == $currentGenre)) ? 'jstree-clicked' : '';
            $url = Yii::$app->urlManager->createUrl(['/music/genre', 'id' => $genre->id]);
            $html .= '<a class="' . $class . '" href="' . $url . '">';
            $html .= Html::getAttributeValue($genre, 'name');
            $html .= "</a>";
            $childCount = static::find()->where(['parent_id' => $genre->id])->count();
            if ($childCount > 0) {
                $html .= static::createTreeList($genre->id, $currentGenre);
            }
            $html .= "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    public static function printEditPath($genreId, $html = "")
    {
        $genre = static::find()->where(['id' => $genreId])->one();
        if ($genre->parent_id != null) {
            $html .= static::printEditPath($genre->parent_id, $html);
        }
        $html .= "<a href=\"" . Yii::$app->urlManager->createUrl(['/music/genre', 'id' => $genre->id]) . "\">" . $genre->name . "</a> &nbsp;/ ";
        return $html;
    }

    public static function getImage($genreId, $type, $htmlOptions = [])
    {
        $uploadThumbs = Yii::$app->getModule('music')->uploadThumbs;
        $uploadUrl = Yii::$app->getModule('music')->uploadUrl;
        $model = static::find()->where(['id' => $genreId])->one();
        $htmlOptionsDefault = ['alt' => $model->name, 'title' => $model->name];

        if (isset($uploadThumbs[$type][0])) {
            $htmlOptionsDefault['width'] = $uploadThumbs[$type][0] . 'px';
        }
        if (isset($uploadThumbs[$type][1])) {
            $htmlOptionsDefault['height'] = $uploadThumbs[$type][1] . 'px';
        }
        $htmlOptions = array_merge($htmlOptionsDefault, $htmlOptions);
        if (empty($model->image)) {
            $image = null;
            $image = Html::img(Yii::$app->getModule('music')->assets->baseUrl . '/no-image-found.jpg', $htmlOptions);
        } else {
            $image = Html::img($uploadUrl . '/' . $type . '/' . $model->image, $htmlOptions);
        }
        return $image;
    }

    public static function deleteImages($genreId)
    {
        $uploadDir = Yii::$app->getModule('music')->uploadDir;
        $uploadThumbs = Yii::$app->getModule('music')->uploadThumbs;
        $model = static::find()->where(['id' => $genreId])->one();

        foreach ($uploadThumbs as $thumbDirName => $size) {
            $thumbPath = Yii::getAlias($uploadDir) . DIRECTORY_SEPARATOR . $thumbDirName;
            $deletePath = Yii::getAlias($thumbPath . DIRECTORY_SEPARATOR . $model->image);
            @unlink($deletePath);
        }
        $deletePath = Yii::getAlias($uploadDir . DIRECTORY_SEPARATOR . 'original' . DIRECTORY_SEPARATOR . $model->image);
        @unlink($deletePath);
    }

    public static function getAll($parentId = null, $attributes = null)
    {
        $data = static::find()->where(['parent_id' => $parentId])->all();
        $result = [];
        $uploadDir = Yii::$app->getModule('music')->uploadDir;
        $uploadThumbs = Yii::$app->getModule('music')->uploadThumbs;
        foreach ($data as $item) {
            $genreData = $item->getAttributes($attributes);
            foreach ($uploadThumbs as $thumbType => $sizes) {
                if (empty($genreData['image'])) {
                    $genreData['image_' . $thumbType] = false;
                } else {
                    $genreData['image_' . $thumbType] = Url::to($uploadDir . '/' . $thumbType . '/' . $genreData['image']);
                }
            }
            $countChilds = Genres::find()->where(['parent_id' => $item->id])->count();
            if ($countChilds > 0) {
                $genreData['sub_genres'] = static::getAll($parentId = $item->id, $attributes);
            }
            $result[] = $genreData;
        }
        return $result;
    }

    public function getOne($genreId = null, $attributes = null, $includeSubGenres = false)
    {
        $data = static::find()->where(['id' => $genreId])->one();
        if ($data === null) {
            return false;
        }
        $genreData = $data->getAttributes($attributes);
        $uploadDir = Yii::$app->getModule('music')->uploadDir;
        $uploadThumbs = Yii::$app->getModule('music')->uploadThumbs;
        foreach ($uploadThumbs as $thumbType => $sizes) {
            if (empty($genreData['image'])) {
                $genreData['image_' . $thumbType] = false;
            } else {
                $genreData['image_' . $thumbType] = Url::to($uploadDir . '/' . $thumbType . '/' . $genreData['image']);
            }
        }
        if ($includeSubGenres) {
            $countChilds = static::find()->where(['parent_id' => $data->id])->count();
            if ($countChilds > 0) {
                $genreData['sub_genres'] = $this->getAll($parentId = $data->id, $attributes);
            }
        }
        return $genreData;
    }
}