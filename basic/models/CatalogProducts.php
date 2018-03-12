<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CATALOG_PRODUCTS".
 *
 * @property integer $ID
 * @property string $NAME
 * @property string $CODE
 * @property integer $CATALOG_SECTION_ID
 * @property string $IMAGE
 * @property double $BASE_PRICE
 * @property double $RETAIL_PRICE
 * @property integer $EXPIRATION_TIME
 * @property integer $MIN_COUNT
 * @property integer $AMOUNT
 *
 * @property CatalogSections $cATALOGSECTION
 */
class CatalogProducts extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CATALOG_PRODUCTS';
    }

    public $UPLOAD;
    public $IN_STOCK;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'CATALOG_SECTION_ID', 'BASE_PRICE', 'RETAIL_PRICE'], 'required'],
            [['CATALOG_SECTION_ID', 'EXPIRATION_TIME', 'MIN_COUNT', 'AMOUNT'], 'integer'],
            [['BASE_PRICE', 'RETAIL_PRICE'], 'number'],
            [['NAME', 'CODE'], 'string', 'max' => 70],
            [['UPLOAD'], 'file'],
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
            'CODE' => 'Артикул',
            'CATALOG_SECTION_ID' => 'Тип товара',
            'UPLOAD' => 'Изображение',
            'IMAGE' => 'Изображение',
            'BASE_PRICE' => 'Закупочная цена',
            'RETAIL_PRICE' => 'Розничная цена',
            'EXPIRATION_TIME' => 'Срок годности, дней',
            'MIN_COUNT' => 'Минимальный остаток',
            'AMOUNT' => 'Количество',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogSection()
    {
        return $this->hasOne(CatalogSections::className(), ['ID' => 'CATALOG_SECTION_ID'])->inverseOf('good');
    }


    /**
     * @return $this
     */
    public function getGoodsSupplies()
    {
        return $this->hasMany(GoodsSupplies::className(), ['GOOD_ID' => 'ID'])->inverseOf('good');
    }


    /**
     * @return $this
     */
    public function getOrdersGoods()
    {
        return $this->hasMany(OrdersGoods::className(), ['GOOD_ID' => 'ID'])->inverseOf('good');
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
