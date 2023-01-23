<?php

/**
 * This is the model class for table "tramo".
 *
 * The followings are the available columns in table 'tramo':
 * @property integer $idtramo
 * @property integer $punto1Kra
 * @property integer $punto2Kra
 * @property integer $punto1Cll
 * @property integer $punto2Cll
 * @property integer $idPntoVnta
 * @property string $cntrolSgnoKra
 * @property string $cntrolSgnoCll
 * @property integer $punto1Av
 * @property integer $punto2AV
 *
 * The followings are the available model relations:
 * @property Tiendas $idPntoVnta0
 */
class Tramo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tramo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('punto1Kra, punto2Kra, punto1Cll, punto2Cll, idPntoVnta, cntrolSgnoKra, cntrolSgnoCll, punto1Av, punto2AV', 'required'),
			array('punto1Kra, punto2Kra, punto1Cll, punto2Cll, idPntoVnta, punto1Av, punto2AV', 'numerical', 'integerOnly'=>true),
			array('cntrolSgnoKra, cntrolSgnoCll', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idtramo, punto1Kra, punto2Kra, punto1Cll, punto2Cll, idPntoVnta, cntrolSgnoKra, cntrolSgnoCll, punto1Av, punto2AV', 'safe', 'on'=>'search'),
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
			'idPntoVnta0' => array(self::BELONGS_TO, 'Tiendas', 'idPntoVnta'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idtramo' => 'Idtramo',
			'punto1Kra' => 'Punto1 Kra',
			'punto2Kra' => 'Punto2 Kra',
			'punto1Cll' => 'Punto1 Cll',
			'punto2Cll' => 'Punto2 Cll',
			'idPntoVnta' => 'Id Pnto Vnta',
			'cntrolSgnoKra' => 'Cntrol Sgno Kra',
			'cntrolSgnoCll' => 'Cntrol Sgno Cll',
			'punto1Av' => 'Punto1 Av',
			'punto2AV' => 'Punto2 Av',
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

		$criteria->compare('idtramo',$this->idtramo);
		$criteria->compare('punto1Kra',$this->punto1Kra);
		$criteria->compare('punto2Kra',$this->punto2Kra);
		$criteria->compare('punto1Cll',$this->punto1Cll);
		$criteria->compare('punto2Cll',$this->punto2Cll);
		$criteria->compare('idPntoVnta',$this->idPntoVnta);
		$criteria->compare('cntrolSgnoKra',$this->cntrolSgnoKra,true);
		$criteria->compare('cntrolSgnoCll',$this->cntrolSgnoCll,true);
		$criteria->compare('punto1Av',$this->punto1Av);
		$criteria->compare('punto2AV',$this->punto2AV);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tramo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
