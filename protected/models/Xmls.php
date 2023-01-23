<?php

/**
 * This is the model class for table "xmls".
 *
 * The followings are the available columns in table 'xmls':
 * @property integer $ID
 * @property integer $punto
 * @property integer $pedido
 * @property string $xml
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Pedidos $pedido0
 * @property Tiendas $punto0
 */
class Xmls extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xmls';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('xml', 'required'),
			array('punto, pedido, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, punto, pedido, xml, estado', 'safe', 'on'=>'search'),
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
			'pedido0' => array(self::BELONGS_TO, 'Pedidos', 'pedido'),
			'punto0' => array(self::BELONGS_TO, 'Tiendas', 'punto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'punto' => 'Punto',
			'pedido' => 'Pedido',
			'xml' => 'Xml',
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
		$criteria->compare('punto',$this->punto);
		$criteria->compare('pedido',$this->pedido);
		$criteria->compare('xml',$this->xml,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function generarxml($xml){
		$xml_objeto = simplexml_load_string($xml);
		$horaxml = date('H');
		$minutosxml = date('i');
		$cont_numlineas = 0;
		
		
		/* GENERANDO EL XML */

		$minutaxml = new DomDocument('1.0', 'UTF-8'); 
		$minutaxml->xmlStandalone = true;
						
		$minuta = $minutaxml->createElement('minuta'); 
		$minuta = $minutaxml->appendChild($minuta);		

		$cont_numlineas = count($xml_objeto->ITEM);		
						
		/* Cabecera */
						
		$cabecera=$minutaxml->createElement('cabecera'); 
		$cabecera=$minuta->appendChild($cabecera); 
						
		$aliascliente=$minutaxml->createElement('aliascliente',CHtml::decode($xml_objeto->CLIENTE->NOMBRE)); 
		$aliascliente=$cabecera->appendChild($aliascliente); 

		$nombrecliente=$minutaxml->createElement('nombrecliente',CHtml::decode($xml_objeto->CLIENTE->NOMBRE)); 
		$nombrecliente=$cabecera->appendChild($nombrecliente); 
						
		$codpostalcliente=$minutaxml->createElement('codpostalcliente',CHtml::decode($xml_objeto->CLIENTE->CIUDAD)); 
		$codpostalcliente=$cabecera->appendChild($codpostalcliente);

		$direccioncliente=$minutaxml->createElement('direccioncliente',CHtml::decode($xml_objeto->CLIENTE->DIRECCION)); 
		$direccioncliente=$cabecera->appendChild($direccioncliente); 
						
		$poblacioncliente=$minutaxml->createElement('poblacioncliente',0); 
		$poblacioncliente=$cabecera->appendChild($poblacioncliente); 
						
		$provinciacliente=$minutaxml->createElement('provinciacliente',CHtml::decode($xml_objeto->ORDEN->ID)); 
		$provinciacliente=$cabecera->appendChild($provinciacliente); 
						
		$paiscliente=$minutaxml->createElement('paiscliente','COLOMBIA'); 
		$paiscliente=$cabecera->appendChild($paiscliente);
						
		$telefonocliente=$minutaxml->createElement('telefonocliente',CHtml::decode($xml_objeto->CLIENTE->TELEFONO)); 
		$telefonocliente=$cabecera->appendChild($telefonocliente);
						
		$movilcliente=$minutaxml->createElement('movilcliente',CHtml::decode($xml_objeto->CLIENTE->TELEFONO)); 
		$movilcliente=$cabecera->appendChild($movilcliente);
		
			      	      
      	$contador_dir = strlen(CHtml::decode($xml_objeto->CLIENTE->DIRECCION)." ".CHtml::decode($xml_objeto->CLIENTE->DIRECCION2));
      	$lineas_dir = ceil($contador_dir/20);
      	
      	
      	$observacion_dir = strlen(CHtml::decode($xml_objeto->ORDEN->OBSERVACION));
      	$lineas_obs = ceil($observacion_dir/20);
        
      
      	$cont_numlineas = $cont_numlineas + $lineas_dir + $lineas_obs;
      
      	
        $complementodireccion = CHtml::decode($xml_objeto->CLIENTE->DIRECCION2);
		
		$emailcliente=$minutaxml->createElement('emailcliente',$complementodireccion); 
		$emailcliente=$cabecera->appendChild($emailcliente);
						
		$fechaminuta=$minutaxml->createElement('fechaminuta','0'); 
		$fechaminuta=$cabecera->appendChild($fechaminuta);
						
		$horaminuta=$minutaxml->createElement('horaminuta',$horaxml.$minutosxml); 
		$horaminuta=$cabecera->appendChild($horaminuta);
						
		$codmonedaminuta=$minutaxml->createElement('codmonedaminuta','1'); 
		$codmonedaminuta=$cabecera->appendChild($codmonedaminuta);
						
		$ivaincluido=$minutaxml->createElement('ivaincluido','1'); 
		$ivaincluido=$cabecera->appendChild($ivaincluido);
						
		$nifcliente=$minutaxml->createElement('nifcliente',CHtml::decode($xml_objeto->CLIENTE->TELEFONO)); 
		$nifcliente=$cabecera->appendChild($nifcliente);
		
		$lineas=$minutaxml->createElement('lineas'); 
		$lineas=$minuta->appendChild($lineas); 
										
		$numlineas=$minutaxml->createElement('numlineas', $cont_numlineas);
		$numlineas=$lineas->appendChild($numlineas);
		
		foreach($xml_objeto->ITEM as $base){
			
			$idbase = CHtml::decode($base->ITEMCONSECUTIVO);			
			$x = 0;
			$num_sublineas = count($xml_objeto->SUBITEM);
			$num_sublineas = $num_sublineas - 1;
			$contador_pedcomboadicional = 1;
			$codmodificadorlineamenuid = 0;
			foreach($xml_objeto->SUBITEM as $acompanantes){
				
				$idacompanante = CHtml::decode($acompanantes->ITEMCONSECUTIVO);
				
				if($idbase==$idacompanante){
										
					//echo $num_sublineas;
					if($x == 0){
						
						$codmodificadorlineamenuid = $acompanantes->CODIGO;
						
						$linea=$minutaxml->createElement('linea');
						$linea=$lineas->appendChild($linea);
						
						$codarticulo=$minutaxml->createElement('codarticulo', $acompanantes->CODIGO);
						$codarticulo=$linea->appendChild($codarticulo);
						
						$descripcion=$minutaxml->createElement('descripcion', $acompanantes->PRODUCTO);
						$descripcion=$linea->appendChild($descripcion);
						
						$unidades=$minutaxml->createElement('unidades', $acompanantes->CANTIDAD);
						$unidades=$linea->appendChild($unidades);
						
						$precio=$minutaxml->createElement('precio', $acompanantes->VALOR / 1);
						$precio=$linea->appendChild($precio);
						
						$precioiva=$minutaxml->createElement('precioiva', $acompanantes->VALOR);
						$precioiva=$linea->appendChild($precioiva);
						
						$codimpuesto=$minutaxml->createElement('codimpuesto', '19');
						$codimpuesto=$linea->appendChild($codimpuesto);
						
						$hora=$minutaxml->createElement('hora',$horaxml.$minutosxml);
						$hora=$linea->appendChild($hora);
						
						$esmenu=$minutaxml->createElement('esmenu', '1');
						$esmenu=$linea->appendChild($esmenu);
						
						$numlineasmenu=$minutaxml->createElement('numlineasmenu', $num_sublineas);
						$numlineasmenu=$linea->appendChild($numlineasmenu);
						
						$lineasmenu=$minutaxml->createElement('lineasmenu');
						$lineasmenu=$linea->appendChild($lineasmenu);
					}else{
						$lineamenu=$minutaxml->createElement('lineamenu');
						$lineamenu=$lineasmenu->appendChild($lineamenu);

						$codmodificadorlineamenu=$minutaxml->createElement('codmodificadorlineamenu', $codmodificadorlineamenuid);
						$codmodificadorlineamenu=$lineamenu->appendChild($codmodificadorlineamenu);

						$codarticulolineamenu=$minutaxml->createElement('codarticulolineamenu', $acompanantes->CODIGO);
						$codarticulolineamenu=$lineamenu->appendChild($codarticulolineamenu);

						$descripcionlineamenu=$minutaxml->createElement('descripcionlineamenu', $acompanantes->PRODUCTO);
						$descripcionlineamenu=$lineamenu->appendChild($descripcionlineamenu);

						$ordenlineamenu=$minutaxml->createElement('ordenlineamenu', $contador_pedcomboadicional);
						$ordenlineamenu=$lineamenu->appendChild($ordenlineamenu);

						$unidadeslineamenu=$minutaxml->createElement('unidadeslineamenu', $acompanantes->CANTIDAD);
						$unidadeslineamenu=$lineamenu->appendChild($unidadeslineamenu);
						
						$contador_pedcomboadicional++;
					}									
					$x++;
				}							
			}
			$contador_dir = strlen($xml_objeto->CLIENTE->DIRECCION." ".$xml_objeto->CLIENTE->DIRECCION2);
			$lineas_dir = ceil($contador_dir/20);
						  
			
			$complementodireccion = $xml_objeto->CLIENTE->DIRECCION." ".$xml_objeto->CLIENTE->DIRECCION2;
			
			
			for( $i=0; $i < $lineas_dir ; $i++ )
			{  
				$inicio = $i * 20;
				$complementodireccion1 = substr($complementodireccion,$inicio, 20);
				
				$linea=$minutaxml->createElement('linea');
				$linea=$lineas->appendChild($linea);

				$codarticulo=$minutaxml->createElement('codarticulo', '627');
				$codarticulo=$linea->appendChild($codarticulo);

				$descripcion=$minutaxml->createElement('descripcion', 'comentario');
				$descripcion=$linea->appendChild($descripcion);

				$unidades=$minutaxml->createElement('unidades', '1');
				$unidades=$linea->appendChild($unidades);

				$precio=$minutaxml->createElement('precio', '0.0');
				$precio=$linea->appendChild($precio);

				$precioiva=$minutaxml->createElement('precioiva', '0.0');
				$precioiva=$linea->appendChild($precioiva);

				$codimpuesto=$minutaxml->createElement('codimpuesto', '19');
				$codimpuesto=$linea->appendChild($codimpuesto);

				$hora=$minutaxml->createElement('hora', '0');
				$hora=$linea->appendChild($hora);

				$esmenu=$minutaxml->createElement('esmenu', '1');
				$esmenu=$linea->appendChild($esmenu);

				$numlineasmenu=$minutaxml->createElement('numlineasmenu', '1');
				$numlineasmenu=$linea->appendChild($numlineasmenu);

				$lineasmenu=$minutaxml->createElement('lineasmenu');
				$lineasmenu=$linea->appendChild($lineasmenu);

				$lineamenu=$minutaxml->createElement('lineamenu');
				$lineamenu=$lineasmenu->appendChild($lineamenu);

				$codmodificadorlineamenu=$minutaxml->createElement('codmodificadorlineamenu', '627');
				$codmodificadorlineamenu=$lineamenu->appendChild($codmodificadorlineamenu);

				$codarticulolineamenu=$minutaxml->createElement('codarticulolineamenu', '648');
				$codarticulolineamenu=$lineamenu->appendChild($codarticulolineamenu);

				$descripcionlineamenu=$minutaxml->createElement('descripcionlineamenu', $complementodireccion1);
				$descripcionlineamenu=$lineamenu->appendChild($descripcionlineamenu);

				$ordenlineamenu=$minutaxml->createElement('ordenlineamenu', '1');
				$ordenlineamenu=$lineamenu->appendChild($ordenlineamenu);

				$unidadeslineamenu=$minutaxml->createElement('unidadeslineamenu', '1');
				$unidadeslineamenu=$lineamenu->appendChild($unidadeslineamenu); 
			}
			
			$observacion_dir = strlen($xml_objeto->ORDEN->OBSERVACION);
			$lineas_obs = ceil($observacion_dir/20);            	      
			
			$complementobservacion = $xml_objeto->ORDEN->OBSERVACION;
			
			
			for( $i=0; $i < $lineas_obs ; $i++ ){    
				$inicio = $i * 20;
				$complementobservacion1 = substr($complementobservacion,$inicio, 20);
				
				$linea=$minutaxml->createElement('linea');
				$linea=$lineas->appendChild($linea);

				$codarticulo=$minutaxml->createElement('codarticulo', '627');
				$codarticulo=$linea->appendChild($codarticulo);

				$descripcion=$minutaxml->createElement('descripcion', 'comentario');
				$descripcion=$linea->appendChild($descripcion);

				$unidades=$minutaxml->createElement('unidades', '1');
				$unidades=$linea->appendChild($unidades);

				$precio=$minutaxml->createElement('precio', '0.0');
				$precio=$linea->appendChild($precio);

				$precioiva=$minutaxml->createElement('precioiva', '0.0');
				$precioiva=$linea->appendChild($precioiva);

				$codimpuesto=$minutaxml->createElement('codimpuesto', '19');
				$codimpuesto=$linea->appendChild($codimpuesto);

				$hora=$minutaxml->createElement('hora', '0');
				$hora=$linea->appendChild($hora);

				$esmenu=$minutaxml->createElement('esmenu', '1');
				$esmenu=$linea->appendChild($esmenu);

				$numlineasmenu=$minutaxml->createElement('numlineasmenu', '1');
				$numlineasmenu=$linea->appendChild($numlineasmenu);

				$lineasmenu=$minutaxml->createElement('lineasmenu');
				$lineasmenu=$linea->appendChild($lineasmenu);

				$lineamenu=$minutaxml->createElement('lineamenu');
				$lineamenu=$lineasmenu->appendChild($lineamenu);

				$codmodificadorlineamenu=$minutaxml->createElement('codmodificadorlineamenu', '627');
				$codmodificadorlineamenu=$lineamenu->appendChild($codmodificadorlineamenu);

				$codarticulolineamenu=$minutaxml->createElement('codarticulolineamenu', '648');
				$codarticulolineamenu=$lineamenu->appendChild($codarticulolineamenu);

				$descripcionlineamenu=$minutaxml->createElement('descripcionlineamenu', $complementobservacion1);
				$descripcionlineamenu=$lineamenu->appendChild($descripcionlineamenu);

				$ordenlineamenu=$minutaxml->createElement('ordenlineamenu', '1');
				$ordenlineamenu=$lineamenu->appendChild($ordenlineamenu);

				$unidadeslineamenu=$minutaxml->createElement('unidadeslineamenu', '1');
				$unidadeslineamenu=$lineamenu->appendChild($unidadeslineamenu); 
			}
			
		}

		$linea=$minutaxml->createElement('linea');
		$linea=$lineas->appendChild($linea);
		
		$codarticulo=$minutaxml->createElement('codarticulo', '325');
		$codarticulo=$linea->appendChild($codarticulo);
		
		$descripcion=$minutaxml->createElement('descripcion', 'domicilio');
		$descripcion=$linea->appendChild($descripcion);
		
		$unidades=$minutaxml->createElement('unidades', '1');
		$unidades=$linea->appendChild($unidades);
		
		$precio=$minutaxml->createElement('precio', CHtml::decode($xml_objeto->ORDEN->RECARGO)/1);
		$precio=$linea->appendChild($precio);
		
		$precioiva=$minutaxml->createElement('precioiva', CHtml::decode($xml_objeto->ORDEN->RECARGO));
		$precioiva=$linea->appendChild($precioiva);
		
		$codimpuesto=$minutaxml->createElement('codimpuesto', '19');
		$codimpuesto=$linea->appendChild($codimpuesto);
		
		$hora=$minutaxml->createElement('hora', '0');
		$hora=$linea->appendChild($hora);
		
		$esmenu=$minutaxml->createElement('esmenu', '1');
		$esmenu=$linea->appendChild($esmenu);
		
		$numlineasmenu=$minutaxml->createElement('numlineasmenu', '0');
		$numlineasmenu=$linea->appendChild($numlineasmenu);
		
		$totales=$minutaxml->createElement('totales'); 
		$totales=$minuta->appendChild($totales);
		
		$totalbruto=$minutaxml->createElement('totalbruto', CHtml::decode($xml_objeto->PAGO->VALOR) - (CHtml::decode($xml_objeto->PAGO->VALOR) / 1));
		$totalbruto=$totales->appendChild($totalbruto);
		
		$totalimpuestos=$minutaxml->createElement('totalimpuestos', '0.0');
		$totalimpuestos=$totales->appendChild($totalimpuestos);
		
		$totalneto=$minutaxml->createElement('totalneto', CHtml::decode($xml_objeto->PAGO->VALOR));
		$totalneto=$totales->appendChild($totalneto);
		
		$formasdepago=$minutaxml->createElement('formasdepago'); 
		$formasdepago=$minuta->appendChild($formasdepago);
		
		$numformasdepago=$minutaxml->createElement('numformasdepago', 1);
		$numformasdepago=$formasdepago->appendChild($numformasdepago);
		
		$formadepago=$minutaxml->createElement('formadepago');
		$formadepago=$formasdepago->appendChild($formadepago);
		
		switch ($xml_objeto->PAGO->TIPO) {
				case "EF":
					$codpago = 1;
					break;
				case "DA":
					$codpago = 2;
					break;
				case "BO":
					$codpago = 3;
					break;
                case "PO":
                	$codpago = 18;
                	break;
				case "RA":
                	$codpago = 20;
                	break;
				default:
				   $codpago = 1;
			}
			
		$codformapago=$minutaxml->createElement('codformapago', $codpago);
		$codformapago=$formadepago->appendChild($codformapago);
		
		$importeformapago=$minutaxml->createElement('importeformapago', CHtml::decode($xml_objeto->PAGO->VALOR));
		$importeformapago=$formadepago->appendChild($importeformapago);
		
		$minutaxml->formatOutput = true; 
		$minuta = $minutaxml->saveXML();
		
		$minuta = str_replace("ñ", "n", $minuta);
		$minuta = str_replace("Ñ", "N", $minuta);
		
		return $minuta;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Xmls the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
