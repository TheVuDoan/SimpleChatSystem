<?php 
class UsersController extends AppController {
    public function login() {
        $IsLoggedIn = $this->Session->check('email');
        if($IsLoggedIn) {
            $this->redirect(array(
                'controller' => 'chats',
                'action' => 'feed',
            ));
        }
        if ($this->request->is('post')) {
        	$this->Session->destroy();
            $data = $this->User->find('all');
            $IsEmailExisted = 0;
            $request_data = $this->request->data;
            $EncryptionPassword = hash('sha256',$request_data['User']['password']);
            foreach($data as $key => $value) {
                if($request_data['User']['e-mail'] === $value['User']['e-mail']) {
                    if($EncryptionPassword === $value['User']['password']) {
                        $this->Session->write('email', $value['User']['e-mail']);
                        $this->Session->write('name', $value['User']['name']);
                        $this->Session->write('user_id', $value['User']['id']);
                        $this->Session->write('error', '0');
                        $this->redirect(array(
                            'controller' => 'chats',
                            'action' => 'feed',
                        ));
                    } else $this->Session->write('error', '1');
                    $IsEmailExisted = 1;
                }
            }
            if(!$IsEmailExisted) {
                $this->Session->write('error', '3');
            }
        } else {
        	$this->Session->destroy();
        }
    }
    public function add() {
        if ($this->request->is('post')) {
        	$this->Session->destroy();	
            $data = $this->User->find('all');
            $request_data = $this->request->data;
            $ok = 1;
            foreach($data as $key => $value) {
                if($request_data['User']['e-mail'] === $value['User']['e-mail']) {
                    $this->Session->write('error', '3');
                    $ok = 0;
                }
            }
            if ($request_data['User']['retypePassword'] !== $request_data['User']['password']) {
                $this->Session->write('error' ,'2');
                $ok = 0;
            }
            if($ok) {
                $this->User->create();
                $userdata = $this->request->data['User'];
                $userdata['password'] = hash('sha256',$request_data['User']['password']);
                $userdata = array_splice($userdata,0,3);
                if ($this->User->save($userdata)) {
                    $lastCreated = $this->User->find('first', array(
                        'order' => array('User.id' => 'desc')
                    ));
                    $this->Session->write('email', $userdata['e-mail']);
                    $this->Session->write('name', $userdata['name']);
                    $this->Session->write('user_id', $lastCreated['User']['id']);
                    $this->Session->write('error', '0');
                    $this->redirect(array(
                        'controller' => 'chats',
                        'action' => 'feed',
                    ));
                }
            }     
        } else {
        	$this->Session->destroy();
        }
    }
    public function logout() {
        $this->Session->destroy();
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'login',
        ));
    }
}