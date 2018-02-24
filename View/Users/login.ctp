<div class="login-box">
  <div class="login-logo">
    <h1>Simple Chat System</h1>
  </div>
  
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php
        $error_num = $this->Session->read('error');
        echo $this->Form->create('User');
        echo $this->Form->input('e-mail', array(
            'label' => array(
                "style" => "display:none"
            ),
            'type' => 'email', 
            'class' => 'form-control',
            'placeholder' => 'Email',
            'div' => array(
                'class' => 'form-group has-feedback'
            ),
            'before' => "<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
        ));
        if($error_num == '3') {
            echo "<p class='error'>Email does not existed</p>";
        }
        echo $this->Form->input('password', array(
            'label' => array(
                "style" => "display:none"
            ),
            'type' => 'password', 
            'class' => 'form-control',
            'placeholder' => 'Password',
            'div' => array(
                'class' => 'form-group has-feedback'
            ),
            'before' => "<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
        ));
        echo $this->Form->button('Sign In', array(
            'class' => 'btn formpost btn-flat'
        ));
        if($error_num == '1') {
            echo "<p class='error'>Wrong password</p>";
        }
        echo "<a href='add' class='text-center'>Register a new membership</a>"
    ?>
  </div>
</div>
