<?php

/**
 * This is the model class for table "tiendas".
 *
 * The followings are the available columns in table 'tiendas':
 * @property integer $ID
 * @property string $nombre
 * @property string $descripcion
 * @property string $direccion
 * @property integer $ciudad
 * @property integer $tipodelivery
 * @property integer $valordelivery
 * @property string $apertura
 * @property string $cierre
 * @property integer $estado
 * @property integer $codintegracion
 * @property string $endpoint
 * @property string $horario
 * @property string $foto
 * @property integer $tiempoentrega
 * @property double $longitud
 * @property double $latitud
 *
 * The followings are the available model relations:
 * @property Menucategoria[] $menucategorias
 * @property Producto[] $productos
 * @property Ciudad $ciudad0
 * @property Tramo[] $tramos
 * @property Xmls[] $xmls
 */
class Tiendas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tiendas';
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
			array('ciudad, tipodelivery, valordelivery, estado, codintegracion, tiempoentrega', 'numerical', 'integerOnly'=>true),
			array('longitud, latitud', 'numerical'),
			array('nombre, direccion, apertura, cierre, endpoint, horario, color', 'length', 'max'=>50),
			array('foto', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, nombre, descripcion, direccion, ciudad, tipodelivery, valordelivery, apertura, cierre, estado, codintegracion, endpoint, horario, foto, tiempoentrega, longitud, latitud, color', 'safe', 'on'=>'search'),
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
			'menucategorias' => array(self::HAS_MANY, 'Menucategoria', 'tienda'),
			'productos' => array(self::HAS_MANY, 'Producto', 'restaurante'),
			'ciudad0' => array(self::BELONGS_TO, 'Ciudad', 'ciudad'),
			'tramos' => array(self::HAS_MANY, 'Tramo', 'idPntoVnta'),
			'xmls' => array(self::HAS_MANY, 'Xmls', 'punto'),
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
			'direccion' => 'Direccion',
			'ciudad' => 'Ciudad',
			'tipodelivery' => 'Tipodelivery',
			'valordelivery' => 'Valordelivery',
			'apertura' => 'Apertura',
			'cierre' => 'Cierre',
			'estado' => 'Estado',
			'codintegracion' => 'Codintegracion',
			'endpoint' => 'Endpoint',
			'horario' => 'Horario',
			'foto' => 'Foto',
			'tiempoentrega' => 'Tiempoentrega',
			'longitud' => 'Longitud',
			'latitud' => 'Latitud',
			'color' => 'Color',
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
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('ciudad',$this->ciudad);
		$criteria->compare('tipodelivery',$this->tipodelivery);
		$criteria->compare('valordelivery',$this->valordelivery);
		$criteria->compare('apertura',$this->apertura,true);
		$criteria->compare('cierre',$this->cierre,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('codintegracion',$this->codintegracion);
		$criteria->compare('endpoint',$this->endpoint,true);
		$criteria->compare('horario',$this->horario,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('tiempoentrega',$this->tiempoentrega);
		$criteria->compare('longitud',$this->longitud);
		$criteria->compare('latitud',$this->latitud);
		$criteria->compare('color',$this->color,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tiendas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
