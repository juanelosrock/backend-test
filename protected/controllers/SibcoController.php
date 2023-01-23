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
            			            
            $this->onRest('post.filter.req.auth.ajax.user', function($validation) {	
                return true;                
            });
	}
}
