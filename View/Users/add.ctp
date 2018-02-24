<div class="register-box">
  <div class="register-logo">
    <h1>Simple Chat System</h1>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>
    <?php
        $error_num = $this->Session->read('error');
        echo $this->Form->create('User');
        echo $this->Form->input('name', array(
            'placeholder' => 'Username',
            'label' => array(
                'style' => 'display: none'
            ),
            'class' => 'form-control',
            'type' => 'text',
            'div' => array(
                'class' => 'form-group has-feedback'          
            ),
            'before' =>'<span class="glyphicon glyphicon-user form-control-feedback"></span>'
        ));
        echo $this->Form->input('e-mail', array(
            'placeholder' => 'Email',
            'label' => array(
                'style' => 'display: none'
            ),
            'class' => 'form-control',
            'type' => 'email',
            'div' => array(
                'class' => 'form-group has-feedback'          
            ),
            'before' =>'<span class="glyphicon glyphicon-envelope form-control-feedback"></span>'
        ));
        if($error_num == '3') {
            echo "<p class='error'>Email existed</p>";
        }
        echo $this->Form->input('password', array(
            //  
            'placeholder' => 'Password',
            'label' => array(
                'style' => 'display: none'
            ),
            'class' => 'form-control',
            'type' => 'password',
            'div' => array(
                'class' => 'form-group has-feedback'          
            ),  
            'before' =>'<span class="glyphicon glyphicon-lock form-control-feedback"></span>'
        ));
        //check password again
        echo $this->Form->input('retypePassword', array(
            'placeholder' => 'Retype password',
            'label' => array(
                'style' => 'display: none'
            ),
            'class' => 'form-control',
            'type' => 'password',
            'div' => array(
                'class' => 'form-group has-feedback'          
            ),
            'before' =>'<span class="glyphicon glyphicon-log-in form-control-feedback"></span>'
        ));
        if($error_num == '2') {
            echo "<p class='error'>Passwords do not match</p>";
        }
        echo "<a href='login' class='text-center'>I already have a membership</a>";
        echo $this->Form->button('Register', array(
            'label' => array(
                'style' => 'display: none'
            ),
            'class' => 'btn btn-flat formpost',
        ));
    ?>
  </div>
</div>