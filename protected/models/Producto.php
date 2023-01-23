<?php

/**
 * This is the model class for table "producto".
 *
 * The followings are the available columns in table 'producto':
 * @property integer $ID
 * @property string $nombre
 * @property string $descripcion
 * @property integer $precio
 * @property integer $restaurante
 * @property integer $menucategoria
 * @property integer $posicion
 * @property integer $estado
 * @property string $apertura
 * @property string $cierre
 * @property string $codintegracion
 * @property string $foto
 * @property integer $valordescuento
 * @property integer $descuento
 *
 * The followings are the available model relations:
 * @property Categoriaadicionales[] $categoriaadicionales
 * @property Menucategoria $menucategoria0
 * @property Tiendas $restaurante0
 * @property Relproductocatadicionales[] $relproductocatadicionales
 */
class Producto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion', 'required'),
			array('precio, restaurante, menucategoria, posicion, estado, valordescuento, descuento', 'numerical', 'integerOnly'=>true),
			array('nombre, apertura, cierre, codintegracion', 'length', 'max'=>50),
			array('foto', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, nombre, descripcion, precio, restaurante, menucategoria, posicion, estado, apertura, cierre, codintegracion, foto, valordescuento, descuento', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'categoriaadicionales' => array(self::HAS_MANY, 'Categoriaadicionales', 'producto'),
			'menucategoria0' => array(self::BELONGS_TO, 'Menucategoria', 'menucategoria'),
			'restaurante0' => array(self::BELONGS_TO, 'Tiendas', 'restaurante'),
			'relproductocatadicionales' => array(self::HAS_MANY, 'Relproductocatadicionales', 'producto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
			'precio' => 'Precio',
			'restaurante' => 'Restaurante',
			'menucategoria' => 'Menucategoria',
			'posicion' => 'Posicion',
			'estado' => 'Estado',
			'apertura' => 'Apertura',
			'cierre' => 'Cierre',
			'codintegracion' => 'Codintegracion',
			'foto' => 'Foto',
			'valordescuento' => 'Valordescuento',
			'descuento' => 'Descuento',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('precio',$this->precio);
		$criteria->compare('restaurante',$this->restaurante);
		$criteria->compare('menucategoria',$this->menucategoria);
		$criteria->compare('posicion',$this->posicion);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('apertura',$this->apertura,true);
		$criteria->compare('cierre',$this->cierre,true);
		$criteria->compare('codintegracion',$this->codintegracion,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('valordescuento',$this->valordescuento);
		$criteria->compare('descuento',$this->descuento);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Producto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
