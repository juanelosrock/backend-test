<?php

/**
 * This is the model class for table "clientes".
 *
 * The followings are the available columns in table 'clientes':
 * @property integer $ID
 * @property string $nombre
 * @property string $apellido
 * @property string $telefono
 * @property string $celular
 * @property string $documento
 * @property string $email
 * @property string $fcm
 * @property integer $ciudad
 * @property integer $tienda
 * @property string $direccion
 * @property string $complemento_direccion
 * @property string $barrio
 * @property string $foto
 * @property string $fecha_creacion
 *
 * The followings are the available model relations:
 * @property Ciudad $ciudad0
 * @property Tiendas $tienda0
 */
class Clientes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ciudad, tienda', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido', 'length', 'max'=>50),
			array('telefono, celular, documento', 'length', 'max'=>20),
			array('direccion, barrio', 'length', 'max'=>100),
			array('email, fcm, complemento_direccion, foto, fecha_creacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, nombre, apellido, telefono, celular, documento, email, fcm, ciudad, tienda, direccion, complemento_direccion, barrio, foto, fecha_creacion', 'safe', 'on'=>'search'),
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
			'ciudad0' => array(self::BELONGS_TO, 'Ciudad', 'ciudad'),
			'tienda0' => array(self::BELONGS_TO, 'Tiendas', 'tienda'),
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
			'apellido' => 'Apellido',
			'telefono' => 'Telefono',
			'celular' => 'Celular',
			'documento' => 'Documento',
			'email' => 'Email',
			'fcm' => 'Fcm',
			'ciudad' => 'Ciudad',
			'tienda' => 'Tienda',
			'direccion' => 'Direccion',
			'complemento_direccion' => 'Complemento Direccion',
			'barrio' => 'Barrio',
			'foto' => 'Foto',
			'fecha_creacion' => 'Fecha Creacion',
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
		$criteria->compare('apellido',$this->apellido,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('fcm',$this->fcm,true);
		$criteria->compare('ciudad',$this->ciudad);
		$criteria->compare('tienda',$this->tienda);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('complemento_direccion',$this->complemento_direccion,true);
		$criteria->compare('barrio',$this->barrio,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function cobertura($ciudadval, $nomenclaturaval, $cllval, $craval, $ctrlcllval, $ctrlcraval, $tienda){
		$ciudad = $ciudadval;
        $nomenclatura = $nomenclaturaval;
                
                                
        $cll = $cllval;
		$cra = $craval;
                                                        
		$ctrlcll = $ctrlcllval;
		$ctrlcra = $ctrlcraval;
		$avenida = 0;
		$puntoseleccionado = -1;
		
		$cll1 = $cllval;
		$cra1 = $craval;
		$ctrlcll1 = $ctrlcllval;
		$ctrlcra1 = $ctrlcraval;
                
                $letras = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                $cll = str_replace($letras, "", $cll);
                $cra = str_replace($letras, "", $cra);
                $cll1 = str_replace($letras, "", $cll1);
                $cra1 = str_replace($letras, "", $cra1);
                
                $cllv = str_replace($letras, "", $cll);
                $crav = str_replace($letras, "", $cra);
                $cll1v = str_replace($letras, "", $cll1);
                $cra1v = str_replace($letras, "", $cra1);                			
				
                $puntos_venta = Tiendas::model()->findAll('ID = '.$tienda);	
               
		
		
		$datos_ciudad = Ciudad::model()->findByPk($ciudad);	
                
                $cll = $cllv;
                $cra = $crav;
                $cll1 = $cll1v;
                $cra1 = $cra1v;
                
		switch ($nomenclatura) 
		{
			case "KRA":
				$avenida = 0;
				$cll = $cra1;
				$cra = $cll1;
				$ctrlcll = $ctrlcra;
				$ctrlcra = $ctrlcll;                                
				   break;
			case "CLL":
				$avenida = 0;
				break;
			case "TRAN":
				$avenida = 0;
				if($datos_ciudad->transversal == 1)
				{
					$cll = $cra1;
					$cra = $cll1;
					$ctrlcll = $ctrlcra;
					$ctrlcra = $ctrlcll;
				}
				break;
			case "AV":
				$avenida = 1;
				$cll = $cra1;
				$cra = $cll1;
				$ctrlcll = $ctrlcra;
				$ctrlcra = $ctrlcll;
				break;
			case "DIA":
				$avenida = 0;
				if($datos_ciudad->diagonal == 1)
				{
					$cll = $cra1;
					$cra = $cll1;
					$ctrlcll = $ctrlcra;
					$ctrlcra = $ctrlcll;
				}
				break;										  
		}
		
		if($nomenclatura == "AV")
		{
			$avenida = 1;
		}
				
		foreach($puntos_venta as $punto)
		{	
			$tramos = Tramo::model()->findAll('idPntoVnta = '.$punto->ID);
			
			foreach($tramos as $tramo)
			{
                                $cll = $cllv;
                                $cra = $crav;
                                $cll1 = $cll1v;
                                $cra1 = $cra1v;
                                
                                switch ($nomenclatura) 
                                {
                                        case "KRA":
                                                $avenida = 0;
                                                $cll = $cra1;
                                                $cra = $cll1;
                                                $ctrlcll = $ctrlcra;
                                                $ctrlcra = $ctrlcll;                                
                                                   break;
                                        case "CLL":
                                                $avenida = 0;
                                                break;
                                        case "TRAN":
                                                $avenida = 0;
                                                if($datos_ciudad->transversal == 1)
                                                {
                                                        $cll = $cra1;
                                                        $cra = $cll1;
                                                        $ctrlcll = $ctrlcra;
                                                        $ctrlcra = $ctrlcll;
                                                }
                                                break;
                                        case "AV":
                                                $avenida = 1;
                                                $cll = $cra1;
                                                $cra = $cll1;
                                                $ctrlcll = $ctrlcra;
                                                $ctrlcra = $ctrlcll;
                                                break;
                                        case "DIA":
                                                $avenida = 0;
                                                if($datos_ciudad->diagonal == 1)
                                                {
                                                        $cll = $cra1;
                                                        $cra = $cll1;
                                                        $ctrlcll = $ctrlcra;
                                                        $ctrlcra = $ctrlcll;
                                                }
                                                break;										  
                                }
                                
				if($avenida == 0)
				{
					if($ciudad == 1)
					{
						if($ctrlcll == $tramo->cntrolSgnoKra)
						{
							$cra = $cra * -1;
						}
						if($ctrlcra == $tramo->cntrolSgnoCll)
						{
							$cll = $cll * -1;
                                                        
						}
					}			
					else
					{
						if($ctrlcra == $tramo->cntrolSgnoKra or $ctrlcll == $tramo->cntrolSgnoKra)
						{
							$cra = $cra * -1;
						}
						if($ctrlcll == $tramo->cntrolSgnoCll or $ctrlcra == $tramo->cntrolSgnoCll)
						{
							$cll = $cll * -1;                                                       
						}
					}
                                       
					if($cra >= $tramo->punto1Kra && $cra <= $tramo->punto2Kra)
					{
						if($cll >= $tramo->punto1Cll && $cll <= $tramo->punto2Cll)
						{
							$puntoseleccionado = $tramo->idPntoVnta;
						}
					}
					
				}
				else
				{
					if($ciudad == 1)
					{
						if($ctrlcll == $tramo->cntrolSgnoKra)
						{
							$cra = $cra * 1;
                                                        
						}
						if($ctrlcra == $tramo->cntrolSgnoCll)
						{
							$cll = $cll * -1;
                                                        
						}
					}			
					else
					{
						if($ctrlcra == $tramo->cntrolSgnoKra or $ctrlcll == $tramo->cntrolSgnoKra)
						{
							$cra = $cra * -1;
                                                        
						}
						if($ctrlcll == $tramo->cntrolSgnoCll or $ctrlcra == $tramo->cntrolSgnoCll)
						{
							$cll = $cll * -1;                                                        
						}
					}					
					if($cra >= $tramo->punto1Av && $cra <= $tramo->punto2AV)
					{
						if($cll >= $tramo->punto1Cll && $cll <= $tramo->punto2Cll)
						{                                                        
							$puntoseleccionado = $tramo->idPntoVnta;							
						}
					}
					
				}
                            
			}
		}     
      
      	if($puntoseleccionado == -1)
        {
          	$sindireccion = new DireccionNoCobertura;
           	//$sindireccion->direccion = $nomenclatura." ".$cll." ".$ctrlcll." ".$cra." ".$ctrlcra;
            $sindireccion->direccion = $nomenclatura." ".$cll." ".$ctrlcll." ".$cra." ".$ctrlcra;
          	$sindireccion->ciudad = $ciudad;
          	$sindireccion->fecha = date("Y-m-d h:i:s");
          	$sindireccion->save();
        }
		echo $puntoseleccionado;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
