<?php

namespace app\models;


use Yii;

/**
 * This is the model class for table "catalog_sections".
 *
 * @property integer $ID
 * @property string $NAME
 * @property string $IMAGE
 *
 * @property CATALOGPRODUCTS[] $cATALOGPRODUCTSs
 */
class CatalogSections extends Prototype
{
    public $UPLOAD;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_sections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['NAME'], 'string', 'max' => 50],
            [['SORT'], 'integer'],
            [['UPLOAD'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Название',
            'IMAGE' => 'Изображение',
            'UPLOAD' => 'Изображение',
            'SORT' => 'Сортировка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasMany(CatalogProducts::className(), ['CATALOG_SECTION_ID' => 'ID'])->inverseOf('catalogSection');
    }


    /**
     * @param bool $insert
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        try{
            # saving image
            $this->saveImage();    
        }
        catch( \Exception $e ){
            Yii::trace($e->getMessage(), 'flower');
        }
    }
}
