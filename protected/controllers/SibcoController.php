<?php

class SibcoController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			array(
				'RestfullYii.filters.ERestFilter + 
			 	REST.GET, REST.PUT, REST.POST, REST.DELETE, REST.OPTIONS'
			),
		);
	}
	
	public function actions()
	{
			return array(
				'REST.'=>'RestfullYii.actions.ERestActionProvider',
			);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 'actions'=>array('REST.GET', 'REST.PUT', 'REST.POST', 'REST.DELETE', 'REST.OPTIONS'),
			'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function restEvents()
	{
            $this->onRest('req.post.registertoken.render', function($data) {						
                $identity = new UserIdentity($data['nick'], $data['clave']);
                $identity->authenticate();
                if ($identity->errorCode == UserIdentity::ERROR_NONE){
                    $token = array(
                    "nick" => $data['nick'],				
                    "clave" => $data['clave'],
                    "date" => $data['date'],
                    "number" => $data['number']
                    );

                    $jwt = Yii::app()->JWT->encode($token);

                    echo CJSON::encode(['name'=>$identity->username,'token'=>$jwt,'vendedor'=>$identity->vendedor, 'tienda'=>$identity->tienda]);	
                }else{
                    echo CJSON::encode($identity->errorCode);//Aqui ponemos el error de logueo
                }			
            });
			
			$this->onRest('req.post.validardireccion.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){  
						$criteria = new CDbCriteria();
						$criteria->compare('url2', $data['url']);
						$tienda = Tiendas::model()->find($criteria);
						if(!empty($tienda)){
							$ciudad = $data['ciudad'];
							$nomenclatura = $data['nomenclatura'];
							$cll = $data['cll'];
							$cra = $data['cra'];
							$ctrlcll = $data['ctrlcll'];
							$ctrlcra = $data['ctrlcra'];
							$direccion = Clientes::cobertura($ciudad, $nomenclatura, $cll, $cra, $ctrlcll, $ctrlcra, $tienda->ID);             		                    	                    	
							echo $direccion; 
						}else{
							echo "-1";
						}
						                                                                   
                    } 
                }  
            });
			
			$this->onRest('req.post.ciudadesdomicilio.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){                                              
						$query = "SELECT ciudad.nombre,ciudad.codintegracion,tiendas.mensajenocobertura FROM ciudad INNER JOIN tiendas ON ciudad.ID = tiendas.ciudad WHERE ciudad.estado = 1 AND tiendas.url2 = '".$data['url']."' ORDER BY ciudad.nombre ASC";
						$command=Yii::app()->db->createCommand($query); 
						$salida = $command->queryAll();              		                    	                    	
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Ciudades')
						]); 
                                                                      
                    } 
                }  
            }); 
			
			$this->onRest('req.post.ciudadesmesa.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){                                              
						$query = "SELECT ciudad.nombre,ciudad.codintegracion,tiendas.mensajenocobertura FROM ciudad INNER JOIN tiendas ON ciudad.ID = tiendas.ciudad WHERE ciudad.estado = 1 AND tiendas.url = '".$data['url']."' ORDER BY ciudad.nombre ASC";
						$command=Yii::app()->db->createCommand($query); 
						$salida = $command->queryAll();              		                    	                    	
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Ciudades')
						]); 
                                                                      
                    } 
                }  
            }); 
			
			$this->onRest('req.post.nuevomenu.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){ 
						$pdv = 2;										
						$query = 'SELECT ID FROM tiendas WHERE codintegracion = '.$data['tienda'];
						$command=Yii::app()->db->createCommand($query);
						$tienda = $command->queryAll();		
						if(!empty($tienda)){
							foreach($tienda as $informacion){
								$pdv = $informacion['ID'];
							}							
						}
                        $query = 'SELECT producto.descuento as descuento, producto.valordescuento as valordescuento, producto.foto as fotoproducto, tiendas.foto as foto, tiendas.mensajecierre as tiendamensaje, tiendas.mensajenocobertura as mensajenocobertura, tiendas.nombre as tiendanombre, tiendas.descripcion as tiendadescripcion, tiendas.direccion as tiendadireccion, tiendas.color as tiendacolor, tiendas.valordelivery as tiendadelivery, tiendas.apertura as tiendaapertura, tiendas.cierre as tiendacierre, tiendas.endpoint as tiendaendpoint, tiendas.horario as tiendahorario, tiendas.tiempoentrega as tiendatiempoentrega, menucategoria.ID as comboid, menucategoria.nombre as combonombre, producto.ID as productoid, producto.nombre as productonombre, producto.descripcion as productodescripcion, producto.precio, producto.posicion, producto.apertura, producto.cierre, producto.codintegracion  FROM menucategoria INNER JOIN producto ON menucategoria.ID = producto.menucategoria INNER JOIN tiendas ON menucategoria.tienda = tiendas.ID WHERE menucategoria.tienda = '.$pdv.' AND menucategoria.estado = 1 AND producto.estado = 1 order by menucategoria.posicion ASC';
						$command=Yii::app()->db->createCommand($query);
						$salida2 = $command->queryAll();	
						$salida = array();
						if(!empty($salida2)){
							foreach($salida2 as $info){	
								
								$horario = 0;
								$estadotienda = 0;
								$fechas = array("Mon"=>"L","Tue"=>"M","Wed"=>"MI","Thu"=>"J","Fri"=>"V","Sat"=>"S","Sun"=>"D");
								$diahoy = date('D');
								$normadia = $fechas[$diahoy];

								$variable = $info['tiendahorario'];
								$arrayvariables = explode("-", $variable);

								if (in_array($normadia, $arrayvariables)) {
									$horario = 1;
								}
								
								$horarios = strtotime(date('H:i'));
								$abre = strtotime($info['tiendaapertura']);
								$cierra = strtotime($info['tiendacierre']);
								
								if($horarios >= $abre && $horarios < $cierra){
									$estadotienda = 1;
								}
									
								$salida[$info['combonombre']] = array(
									"combo" => $info['combonombre'],
									"comboid" => $info['comboid'],	
									"foto" => $info['foto'],									
									"tiendanombre" => $info['tiendanombre'],
									"tiendadescripcion" => $info['tiendadescripcion'],
									"tiendadireccion" => $info['tiendadireccion'],
									"tiendadelivery" => $info['tiendadelivery'],
									"tiendaapertura" => $info['tiendaapertura'],
									"tiendacierre" => $info['tiendacierre'],
									"tiendaendpoint" => $info['tiendaendpoint'],
									"tiendahorario" => $horario,
									"tiendaestado" => $estadotienda,
									"tiendacolor" => $info['tiendacolor'],
									"tiendamensaje" => $info['tiendamensaje'],
									"tiendanocobertura" => $info['mensajenocobertura'],
									"tiendatiempoentrega" => $info['tiendatiempoentrega'],
									"productos"=>array()
								);															
							}
							foreach($salida2 as $info){
								
								$estadoproducto = 0;
								$horarios = strtotime(date('H:i'));
								$abre = strtotime($info['apertura']);
								$cierra = strtotime($info['cierre']);
								
								if($horarios >= $abre && $horarios < $cierra){
									$estadoproducto = 1;
								}
								if($estadoproducto == 1){
									$producto = array(
										"id"=>$info['productoid'],
										"nombre"=>$info['productonombre'],
										"descripcion"=>$info['productodescripcion'],
										"precio"=>$info["precio"],
										"fotoproducto"=>$info["fotoproducto"],
										"valordescuento" => $info['valordescuento'],
										"descuento" => $info['descuento'],
										"estadoproducto" => $estadoproducto
									);
									array_push($salida[$info['combonombre']]['productos'], $producto);
								}
							}
						}
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Clientes')
						]); 
                                                                      
                    } 
                }  
            });

			$this->onRest('req.post.productomenu.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){  					
                        $query = 'SELECT categoriaadicionales.ID AS idcategoria, categoriaadicionales.nombre AS nombrecat, categoriaadicionales.tipo, categoriaadicionales.producto, categoriaadicionales.posicion AS catposicion, categoriaadicionales.MIN AS minimo, categoriaadicionales.MAX AS maximo, categoriaadicionales.obligatorio, categoriaadicionales.estado, adicionales.ID AS adicionalesid, adicionales.nombre AS adicionalnombre, adicionales.precio, adicionales.codintegracion, adicionales.posicion AS adiposicion FROM categoriaadicionales INNER JOIN adicionales  ON categoriaadicionales.ID = adicionales.categoriaadicional WHERE adicionales.estado = 1 and categoriaadicionales.producto = '.$data['producto'];
						$command=Yii::app()->db->createCommand($query);
						$salida2 = $command->queryAll();	
						$salida = array();
						if(!empty($salida2)){
							foreach($salida2 as $info){
								$salida[$info['idcategoria']] = array(
									"idcategoria" => $info['idcategoria'],
									"nombrecat" => $info['nombrecat'],	
									"producto" => $info['producto'],	
									"catposicion" => $info['catposicion'],	
									"minimo" => $info['minimo'],	
									"maximo" => $info['maximo'],	
									"obligatorio" => $info['obligatorio'],	
									"estado" => $info['estado'],	
									"adicionales"=>array()
								);															
							}
							foreach($salida2 as $info){
								$producto = array(
									"adicionalesid"=>$info['adicionalesid'],
									"adicionalnombre"=>$info['adicionalnombre'],
									"precio"=>$info['precio'],
									"codintegracion"=>$info["codintegracion"],
									"adiposicion"=>$info["adiposicion"]
								);
								array_push($salida[$info['idcategoria']]['adicionales'], $producto);
							}
						}
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Clientes')
						]); 
                                                                      
                    } 
                }  
            });
			
			$this->onRest('req.post.bdcombos.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){  
						$pdv = 2;
						$query = 'SELECT ID FROM tiendas WHERE codintegracion = '.$data['pdv'];
						$command=Yii::app()->db->createCommand($query);
						$tienda = $command->queryAll();		
						if(!empty($tienda)){
							foreach($tienda as $informacion){
								$pdv = $informacion['ID'];
							}							
						}                        
						$query = "SELECT producto.ID, producto.nombre, producto.precio, producto.codintegracion FROM menucategoria INNER JOIN producto ON menucategoria.ID = producto.menucategoria WHERE tienda = ".$pdv;
						$command=Yii::app()->db->createCommand($query);
						$salida = $command->queryAll();                		                    	                    	
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Clientes')
						]); 
                                                                      
                    } 
                }  
            });

			$this->onRest('req.post.bdadiciones.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){                      
                        $pdv = 2;
						$query = 'SELECT ID FROM tiendas WHERE codintegracion = '.$data['pdv'];
						$command=Yii::app()->db->createCommand($query);
						$tienda = $command->queryAll();		
						if(!empty($tienda)){
							foreach($tienda as $informacion){
								$pdv = $informacion['ID'];
							}							
						}  
						$query = "SELECT adicionales.ID, adicionales.nombre, adicionales.precio, adicionales.codintegracion FROM adicionales INNER JOIN categoriaadicionales ON adicionales.categoriaadicional = categoriaadicionales.ID INNER JOIN producto ON categoriaadicionales.producto = producto.ID WHERE producto.restaurante = ".$pdv;
						$command=Yii::app()->db->createCommand($query); 
						$salida = $command->queryAll();              		                    	                    	
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Clientes')
						]); 
                                                                      
                    } 
                }  
            }); 
			
			
			$this->onRest('req.post.setxml.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){                                              						
						$xmlgenerado = Xmls::generarxml($data['xml']);							
						$pedidogenerado = Pedidos::generarpedido($data['logpedido'],$data['telefono'],$data['ciudad'],$data['punto'],$data['direccion'] );						
						//print_r($xmlgenerado);
						$xml = new Xmls;
						$xml->punto = $data['punto'];
						$xml->pedido = $pedidogenerado;
						$xml->xml = $xmlgenerado;
						$xml->estado = 0;
						$xml->save();
						
						$query = "SELECT * FROM xmls WHERE ID = ".$xml->ID;
						$command=Yii::app()->db->createCommand($query); 
						$salida = $command->queryAll(); 
						//$xml_presentar = Xmls::model()->findByPk($xml->ID);
						
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Xmls')
						]);
                                                                      
                    } 
                }  
            }); 
			
			$this->onRest('req.post.getsuscripcion.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){                                              						
						$criteria = new CDbCriteria();
						$criteria->compare('telefono',$data['documento']);
						$cliente = Clientes::model()->findAll($criteria);
						
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($cliente,'Object Cliente')
						]);
                                                                      
                    } 
                }  
            });
			
			$this->onRest('req.post.getcliente.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){                                              						
						$criteria = new CDbCriteria();
						$criteria->compare('telefono',$data['documento']);
						$cliente = Clientes::model()->findAll($criteria);
						
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($cliente,'Object Cliente')
						]);
                                                                      
                    } 
                }  
            });
			
			$this->onRest('req.post.datamesa.render', function($data) {
                if(isset($data['token'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($data['token'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){   							
						$url = base64_decode($data['url']);
						$query = "SELECT tiendas.ID, tiendas.ciudad, ciudad.nombre FROM tiendas INNER JOIN ciudad ON tiendas.ciudad = ciudad.ID WHERE tiendas.url = '".$url."'";
						$command=Yii::app()->db->createCommand($query); 
						$salida = $command->queryAll(); 
						
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Mesas')
						]);
                                                                      
                    } 
                }  
            });
            			            
            $this->onRest('post.filter.req.auth.ajax.user', function($validation) {	
                return true;                
            });
	}
}
