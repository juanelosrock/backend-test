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
            			            
            $this->onRest('post.filter.req.auth.ajax.user', function($validation) {	
                return true;                
            });
	}
}
