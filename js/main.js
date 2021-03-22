/*eslint-env browser, jquery*/
function ajaxSubmit(){
    $.ajax({
        url: "/php/final.php",
        type: "POST",
        data:{
            service : $("#serv").val(),
            pass : $("#pass").val(),
            length : $("#leng").val()
        },
        success: function(data){
            $("#out").attr("disabled", false);
            $("#out").val(data);
        }
    });
    return false;
}

$("#showPass").click(function(){
    if($(this).hasClass("glyphicon-eye-close")){
        $(this).removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
        $("#out").attr("type", "text");
    }
    else{
        $(this).removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
        $("#out").attr("type", "password");
    }
});

$("#copy").click(function(){
    $("#copy").className = "btn btn-default glyphicon glyphicon-copy fix-glyph"
    $("#copyarea").val($("#out").val());
    $("#copyarea").select();
    
    document.execCommand("copy") ? $("#copy").addClass("btn-success") : $("#copy").addClass("btn-error")
    return false;
});