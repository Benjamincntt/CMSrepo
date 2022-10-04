$(document).ready(function() {
    $('#summernote').summernote({
        height:200
    });
    $('#selectAllBoxes').click(function(event){
        if(this.checked)
            $('.checkBoxes').each(function(){this.checked = true;});
        else
            $('.checkBoxes').each(function(){this.checked = false;});
    });
});

var div_box = "<div id='load-screen'><div id='loading'></div></div>";
$("body").prepend(div_box);
$('#load-screen').delay(700).fadeOut(600, function(){
    $(this).remove();
});
function loadUsersOnline(){
    $.get("function.php?onlineUsers=result",function(data){
        $(".users-online").text(data);
    });
}
setInterval(function(){
    loadUsersOnline();
},500);
