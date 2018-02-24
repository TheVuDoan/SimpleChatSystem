<header>
    <nav class="navbar">
        <div class="navbar-header">
          <div class="navbar-brand logo">Simple Chat System</div>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
            <div class="dropdown-toggle username" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <?php echo $this->Session->read('name').' '?><span class="caret"></span></div>
            <ul class="dropdown-menu">
                <li>
                    <?php
                        echo $this->html->link('Log out',array(
                            'controller' => 'users',
                            'action' => 'logout'
                        ));
                    ?>
                </li>
            </ul>
            </li>
        </ul>
    </nav>    
</header>
<div class="container-fluid">
    <div class="well">
    <?php
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        foreach($feed as $key => $value) {
            echo "<div class='row'>";
            echo "<div class='col-xs-1'><strong>";
            echo $value['Chat']['name'].": ";
            echo "</strong></div>";
            echo "<div class='col-xs-9'>";
            if($value['Chat']['type']=='1') {
                echo $value['Chat']['message']." ";
            } else {
                echo $this->Html->image('upload/'.$value['Chat']['file_name'], array(
                    'height' => '30%',
                    'width' => '30%',
                    'id' => 'myImg',
                    'onclick' => 'popup_function(this)'
                ));
            }
            echo "</div>";
            echo "<div class='col-xs-2 text-right'><em>";
            if($value['Chat']['update_at'] != NULL) {
                echo date('Y-m-d H:i:s', strtotime($value['Chat']['update_at']." UTC"));
            } else {
                echo date('Y-m-d H:i:s', strtotime($value['Chat']['create_at']." UTC"));
            }
            echo "</em><br>";
            if($this->Session->read('user_id') == $value['Chat']['user_id']) {
                echo "<div class='settings'>";
                echo "<i class='fa fa-bars' id='settings_button' aria-hidden='true'></i>";
                echo "<div class='settings_box'>";
                echo "<button id='delete' class='btn settings_option delete' type='submit' id_chat='".$value['Chat']['id']."'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button><br>";
                $new_message = "\"".htmlentities($value['Chat']['message'])."\"";
                echo "<button id='edit' href='#message' class='btn edit settings_option' type='submit' id_chat='".$value['Chat']['id']."' name_chat='".$value['Chat']['name']."' type_chat='".$value['Chat']['type']."' message_chat=".$new_message." file_name_chat='".$value['Chat']['file_name']."'/><i class='fa fa-pencil' aria-hidden='true'></i> Edit</button>";
                echo "</div>";
                echo "</div>";    
            }
            
            echo "</div>";
            echo "</div>";
        }
    ?>
    </div>
</div>
<div class="container-fluid">
        <h4><em>Say something to みなさん...</em></h4>
</div>
<div class="container-fluid">
<?php
    echo $this->Form->create('Chat', array(
        'inputDefaults' => array('div' => array('class' => 'form-group')),
        'enctype' => 'multipart/form-data'
    ));
    echo $this->Form->input('name', array(
        'required',
        'label' => array('style' => 'display: none'),
        'rows' => '1',
        'class' => 'form-control',
        'value' => $this->Session->read('name'),
        'style' => 'display: none',
        'placeholder' => 'Enter your name',
        'id' => 'name'
    ));
    echo $this->Form->input('message', array(
        'label' => 'Message',
        'class' => 'form-control',
        'placeholder' => 'Enter message here',
        'id' => 'message',
        'maxlength' => '200'
    ));
    echo $this->Form->button('Post', array(
        'class' => 'btn formpost',
        'id' => 'post_button'
    ));
    echo $this->Form->button('Edit', array(
        'class' => 'btn formpost',
        'id' => 'edit_button',
        'style' => 'display: none'
    ));
    echo $this->Form->button('Choose Photo', array(
        'class' => 'btn',
        'type' => 'button',   
        'id' => 'mybtn',
    ));
    echo "<span id='filename'>No file selected.</span>";    
    echo "<p class='help-block'><span id='text_counter'> 200</span>/200 characters left.</p>" ;
    echo $this->Form->input('', array(
        'type' => 'file',
        'name' => 'fileToUpload',
        'id' => 'uploadbtn',
        'style' => array('display : none')
    ));        
?>
</div>
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script src="../app/webroot/js/cake.chat.js"></script>