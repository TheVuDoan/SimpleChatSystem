//counting character
function updateRemainingChars(){
    const textLength = $("#message").val().length;
    $("#text_counter").html(200 - textLength);
    if(textLength > 0) {
		$("#mybtn").attr("disabled",true);
	} else {
		$("#mybtn").attr("disabled",false);
	}
}
$("#message").on("change keyup paste", updateRemainingChars);
//upload function
$("#mybtn").click(function() {
    $("#uploadbtn").click();
});
$("#uploadbtn").on('change',function() {
    $("#filename").text($("#uploadbtn").val());
	if($("#filename").text() !== "No file selected." && $("#filename").text() !== ""){
		$("#message").attr("disabled",true);
		txt = $("#filename").text();
		console.log(txt);
		for(i = txt.length-1; i >= 0; --i) {
			if(txt[i] == "\\") {
				new_txt = txt.substring(i+1);
				break;
			}
		}
		console.log(new_txt);
		$("#filename").html(new_txt); 
	}
	else {
		$("#message").attr("disabled",false);
	}
});
//show fullscreen image
var modal = document.getElementById('myModal');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
function popup_function(img){
    modal.style.display = "block";
    modalImg.src = img.src;
}
var span = document.getElementsByClassName("close")[0];
console.log(span);
span.onclick = function() { 
    modal.style.display = "none";
}
//edit function
$('.edit').click(function() {
    chat_name = $(this).attr('name_chat');
    chat_message = $(this).attr('message_chat');
    chat_id = $(this).attr('id_chat');
    chat_type = $(this).attr('type_chat');
    $('#name').val(chat_name);
    if(chat_type == '1') {
        $('#message').val(chat_message);
    }
    $('#send_button').html('Edit');
    $('#ChatFeedForm').attr("action", "edit/" + chat_id);
    const textLength = $("#message").val().length;
    if(textLength > 0) {
        $("#mybtn").attr("disabled",true);
    } else {
        $("#mybtn").attr("disabled",false);
    }
    $('#post_button').attr('style','display: none');
    $('#edit_button').attr('style','display: inline');
    $('html, body').animate({
        scrollTop: $( $(this).attr('href') ).offset().top
    }, 500);
});
//show and hide modify box
var flag = 0;
$(".settings").click(function(e) {
    if (flag == 0) {
        $(this).children().css("display","inline-block");
        flag = 1;
        e.stopPropagation();
        $('.settings_box#nomore').toggle();
        $("body > *").not("body .settings_box").click(function() {
            $(".settings_box").hide();
            flag = 0;
        });   
    }
});
//edit alert
$('#edit_button').click(function(t) {
    t.preventDefault(); 
    var form = $(this).parents('form');
    swal({
        title: "Are you sure?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(
    function(isConfirm) {
        if(isConfirm) {
            form.submit();
        }
    });
});
//delete alert
$('.delete').click(function() {
    id=$(this).attr('id_chat');
    console.log(id);
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this message!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(
    function(isConfirm) {
        if(isConfirm) {
            location.href="delete/"+id;
        }
    });
});