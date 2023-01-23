<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $ID
 * @property string $correo
 * @property string $nit
 * @property string $usuario
 * @property string $clave
 * @property string $nombre
 */
class Usuarios extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('correo, nit, usuario, clave, nombre', 'required'),
			array('correo, usuario, clave, nombre', 'length', 'max'=>50),
			array('nit', 'length', 'max'=>20),
			array('correo, usuario', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, correo, nit, usuario, clave, nombre', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'correo' => 'Correo',
			'nit' => 'Nit',
			'usuario' => 'Usuario',
			'clave' => 'Clave',
			'nombre' => 'Nombre',
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
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('nit',$this->nit,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password)===$this->clave;
	}
	
	public function hashPassword($password)
	{
	 return md5($password);
	}
}
