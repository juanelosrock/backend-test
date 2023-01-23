<?php

/**
 * This is the model class for table "pedidos".
 *
 * The followings are the available columns in table 'pedidos':
 * @property integer $ID
 * @property string $telefono
 * @property integer $ciudad
 * @property integer $punto
 * @property string $direccion
 * @property integer $agente
 * @property string $datos
 * @property string $fecha
 * @property string $pedidoplataforma
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Usuarios $agente0
 * @property Xmls[] $xmls
 */
class Pedidos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pedidos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('datos', 'required'),
			array('ciudad, punto, agente, estado', 'numerical', 'integerOnly'=>true),
			array('telefono, pedidoplataforma', 'length', 'max'=>20),
			array('direccion', 'length', 'max'=>50),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, telefono, ciudad, punto, direccion, agente, datos, fecha, pedidoplataforma, estado', 'safe', 'on'=>'search'),
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
			'agente0' => array(self::BELONGS_TO, 'Usuarios', 'agente'),
			'xmls' => array(self::HAS_MANY, 'Xmls', 'pedido'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'telefono' => 'Telefono',
			'ciudad' => 'Ciudad',
			'punto' => 'Punto',
			'direccion' => 'Direccion',
			'agente' => 'Agente',
			'datos' => 'Datos',
			'fecha' => 'Fecha',
			'pedidoplataforma' => 'Pedidoplataforma',
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
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('ciudad',$this->ciudad);
		$criteria->compare('punto',$this->punto);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('agente',$this->agente);
		$criteria->compare('datos',$this->datos,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('pedidoplataforma',$this->pedidoplataforma,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function generarpedido($logjson, $telefono, $ciudad, $punto, $direccion){
		$pedido = new Pedidos;
		$pedido->telefono = $telefono;
		$pedido->ciudad = $ciudad;
		$pedido->punto = $punto;
		$pedido->direccion = $direccion;
		$pedido->agente = 1;
		$pedido->datos = $logjson;
		$pedido->fecha = date('Y-m-d H:i:s');
		$pedido->pedidoplataforma = 1;
		$pedido->estado = 3;
		$pedido->save();
		return $pedido->ID;
		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pedidos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
