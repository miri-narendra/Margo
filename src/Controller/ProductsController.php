<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

App::uses('AppController','Controller');
class ProductsController extends AppController{
public function add(){
    $this->layout = false;
    $response = array('status'=>'failed', 'message'=>'HTTP method not allowed');
if($this->request->is('post')){
        
        //get data from request object
        $data = $this->request->input('json_decode', true);
        if(empty($data)){
            $data = $this->request->data;
        }
        
        //response if post data or form data was not passed
        $response = array('status'=>'failed', 'message'=>'Please provide form data');
            
        if(!empty($data)){
            //call the model's save function
            if($this->Product->save($data)){
                //return success
                $response = array('status'=>'success','message'=>'Product successfully created');
            } else{
                $response = array('status'=>'failed', 'message'=>'Failed to save data');
            }
        }
    }
        
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response->send();
}

public function view($id = null){
    $this->layout = false;
    //set default response
    $response = array('status'=>'failed', 'message'=>'Failed to process request');
    
    //check if ID was passed
    if(!empty($id)){
        
        //find data by ID
        $result = $this->Product->findById($id);
        if(!empty($result)){
            $response = array('status'=>'success','data'=>$result);  
        } else {
            $response['message'] = 'Found no matching data';
        }  
    } else {
        $response['message'] = "Please provide ID";
    }
        
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response->send();
}


}
?>