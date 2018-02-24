<?php
App::uses('AppController', 'Controller');
 
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

class ChatsController extends AppController {
    public function feed() {
        $IsLoggedIn = $this->Session->check('email');
        if(!$IsLoggedIn) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login',
            ));
        }
        if ($this->request->is('post')) {
            $message = $this->request->data['Chat']['message'];
            if($_FILES['fileToUpload']['name'] !== ""){
                $this->Chat->create();
                $this->request->data['Chat']['create_at'] = date("Y-m-d h:i:s");
                $this->request->data['Chat']['user_id'] = $this->Session->read('user_id');
                $this->request->data['Chat']['message'] = "";
                $this->request->data['Chat']['type'] = "2";
                $target_dir = "img/upload/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $file_name = date("Y-m-d-h-i-s")."-".$this->request->data['Chat']['name']."-".generateRandomString();
                $file_name = hash('md5',$file_name);
                $this->request->data['Chat']['file_name'] = $file_name . "." . $imageFileType;
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target_dir.$this->request->data['Chat']['file_name']);
                    $uploadOk = 1;
                    if ($this->Chat->save($this->request->data['Chat'])) {
                        $this->redirect(array(
                            'controller' => 'chats',
                            'action' => 'feed'
                        ));
                    }
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            if($message !== "") {
                $this->Chat->create();
                $this->request->data['Chat']['message'] = $message;
                $this->request->data['Chat']['create_at'] = date("Y-m-d h:i:s");
                $this->request->data['Chat']['user_id'] = $this->Session->read('user_id');
                $this->request->data['Chat']['type'] = "1";
                $this->request->data['Chat']['file_name'] = "";
                if ($this->Chat->save($this->request->data['Chat'])) {
                    $this->redirect(array(
                        'controller' => 'chats',
                        'action' => 'feed'
                    ));
                }    
            }
        }
        $data = $this->Chat->find('all',array(
            'order' => array('create_at' => "desc")
        ));
        $this->set('feed',$data);
    }
    public function delete($id) {
        $this->Chat->delete($id);
        $this->redirect(
            array(
                'controller' => 'chats',
                'action' => 'feed'
            )
        );
    }
    public function edit($id){
        if ($this->request->is('post')) {
            $this->Chat->id = $id;
            $this->request->data['Chat']['update_at'] = date("Y-m-d h:i:s");
            $this->Chat->save($this->request->data['Chat']);
            $this->redirect(array(
                'controller' => 'Chats',
                'action' => 'feed'
            ));
        }
    }
}
?>