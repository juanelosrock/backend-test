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
			
			$this->onRest('req.get.paises.render', function($data) {
				
                if(isset($_SERVER['HTTP_AUTHORIZATION'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($_SERVER['HTTP_AUTHORIZATION'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){  
						
						$connection = Mongodb::getConect();
						$coleccion = $connection->itdelivery->paises;	
						$orden = ['sort' => ['_id' => -1]];
						$query = [];
						if(isset($data)){
							$query = ['codigo' => $data];
						}	
						$resultado = $coleccion->find($query,$orden);
						//$resultado = $coleccion->find(['pedido.fecha' => date('Y-m-d')]);
						$salida = CJSON::decode(CJSON::encode($resultado), true);
						
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Paises')
						]); 						
                    } 
                }  
            });	
			
			$this->onRest('req.put.paises.render', function($data) {
				
                if(isset($_SERVER['HTTP_AUTHORIZATION'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($_SERVER['HTTP_AUTHORIZATION'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){  
						
						$pais = [
							"nombre" => $data['nombre'],
							"moneda" => $data['moneda'],
							"codigo" => $data['codigo'],
							"bandera" => $data['bandera'],
						];
						
						$connection = Mongodb::getConect();
						$coleccion = $connection->itdelivery->paises;	
						
						$query = ['codigo' => $data['codigo']];								
						$resultado = $coleccion->findOne($query);							
						$validacion = CJSON::decode(CJSON::encode($resultado), true);
						if(empty($validacion)){
							$resultado = $coleccion->insertOne( $pais );							
							$query = ['codigo' => $data['codigo']];								
							$resultado = $coleccion->findOne($query);							
							$salida = CJSON::decode(CJSON::encode($resultado), true);
							$this->emitRest('req.render.json', [
								GenericForm::formatOutput($salida,'Object Paises')
							]); 
						}else{
							$salida = [
								"Error" => "El codigo ya existe",
							];
							$this->emitRest('req.render.json', [
								GenericForm::formatOutput($salida,'Object Paises',false)
							]); 
						}
												
                    } 
                }  
            });

			$this->onRest('req.post.paises.render', function($data) {
				
                if(isset($_SERVER['HTTP_AUTHORIZATION'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($_SERVER['HTTP_AUTHORIZATION'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){  
						
						$salida = [];
						
						$connection = Mongodb::getConect();
						$coleccion = $connection->itdelivery->paises;
						$data_update = [];
						if(isset($data['nombre'])){
							$data_update['nombre'] = $data['nombre'];
						}
						if(isset($data['moneda'])){
							$data_update['moneda'] = $data['moneda'];
						}
						if(isset($data['bandera'])){
							$data_update['bandera'] = $data['bandera'];
						}
						if(!empty($data_update)){
							$resultado = $coleccion->updateOne( ['codigo' => $data['codigo']],['$set' => $data_update], ['upsert' => true] );																			
							$query = ['codigo' => $data['codigo']];								
							$resultado = $coleccion->findOne($query);							
							$salida = CJSON::decode(CJSON::encode($resultado), true);
						}
						
						
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Paises')
						]); 						
                    } 
                }  
            });

			$this->onRest('req.delete.paises.render', function($data) {
				
                if(isset($_SERVER['HTTP_AUTHORIZATION'])){
                    $token = json_decode(json_encode(Yii::app()->JWT->decode($_SERVER['HTTP_AUTHORIZATION'])), True);                                       
                    $identity = new UserIdentity($token['nick'], $token['clave']);
                    $identity->authenticate();
                    if ($identity->errorCode == UserIdentity::ERROR_NONE){  						
						$connection = Mongodb::getConect();
						$coleccion = $connection->itdelivery->paises;																							
						$query = ['codigo' => $data];								
						$resultado = $coleccion->deleteOne($query);													
						$salida = [
							"Delete" => "El codigo ".$data." ha sido borrado",
						]; 
						
						$this->emitRest('req.render.json', [
							GenericForm::formatOutput($salida,'Object Paises')
						]); 						
                    } 
                }  
            });
            			            
            $this->onRest('post.filter.req.auth.ajax.user', function($validation) {	
                return true;                
            });
	}
}
