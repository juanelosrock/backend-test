<?php

/**
 * This is the model class for table "adicionales".
 *
 * The followings are the available columns in table 'adicionales':
 * @property integer $ID
 * @property string $nombre
 * @property integer $precio
 * @property integer $categoriaadicional
 * @property string $codintegracion
 * @property integer $posicion
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Categoriaadicionales $categoriaadicional0
 */
class Adicionales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'adicionales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('precio, categoriaadicional, posicion, estado', 'numerical', 'integerOnly'=>true),
			array('nombre, codintegracion', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, nombre, precio, categoriaadicional, codintegracion, posicion, estado', 'safe', 'on'=>'search'),
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
			'categoriaadicional0' => array(self::BELONGS_TO, 'Categoriaadicionales', 'categoriaadicional'),
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
			'precio' => 'Precio',
			'categoriaadicional' => 'Categoriaadicional',
			'codintegracion' => 'Codintegracion',
			'posicion' => 'Posicion',
			'estado' => 'Estado',
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
		$criteria->compare('precio',$this->precio);
		$criteria->compare('categoriaadicional',$this->categoriaadicional);
		$criteria->compare('codintegracion',$this->codintegracion,true);
		$criteria->compare('posicion',$this->posicion);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Adicionales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
