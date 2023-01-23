<?php

/**
 * This is the model class for table "menucategoria".
 *
 * The followings are the available columns in table 'menucategoria':
 * @property integer $ID
 * @property string $nombre
 * @property integer $tienda
 * @property integer $estado
 * @property integer $posicion
 * @property string $apertura
 * @property string $cierre
 *
 * The followings are the available model relations:
 * @property Tiendas $tienda0
 * @property Producto[] $productos
 */
class Menucategoria extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menucategoria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tienda, estado, posicion', 'numerical', 'integerOnly'=>true),
			array('nombre, apertura, cierre', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, nombre, tienda, estado, posicion, apertura, cierre', 'safe', 'on'=>'search'),
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
			'tienda0' => array(self::BELONGS_TO, 'Tiendas', 'tienda'),
			'productos' => array(self::HAS_MANY, 'Producto', 'menucategoria'),
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
			'tienda' => 'Tienda',
			'estado' => 'Estado',
			'posicion' => 'Posicion',
			'apertura' => 'Apertura',
			'cierre' => 'Cierre',
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
		$criteria->compare('tienda',$this->tienda);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('posicion',$this->posicion);
		$criteria->compare('apertura',$this->apertura,true);
		$criteria->compare('cierre',$this->cierre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menucategoria the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
