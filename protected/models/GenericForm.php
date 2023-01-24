<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GenericForm extends CFormModel
{
    public function formatOutputError($data){
        $message = "Object Dont Save";
        $salida = $data;
        return [
            'success'=>false,
            'message'=>$message,
            'data'=>$salida
        ];
    }
    public function formatOutputList($data){
        $message = null;
        $salida = ['totalCount'=>count($data),'data'=>$data];
        if(empty($data)){
            $message = 'Empty Object';
        }else{
            $message = 'Record(s) Found';
        }
        
        return [
            'success'=>true,
            'message'=>$message,
            'data'=>$salida
        ];
    }
    
    public function formatOutput($data,$info,$success=true){
        $message = $info;
        $salida = ['totalCount'=>count($data),'data'=>$data];                
        return [
            'success'=>$success,
            'message'=>$message,
            'data'=>$salida
        ];
    }

	public function formatOutputAdmin($data,$info,$total){
        $message = $info;
        $salida = ['totalCount'=>$total,'data'=>$data];                
        return [
            'success'=>true,
            'message'=>$message,
            'data'=>$salida
        ];
    } 
}