$( document ).ready(function() {

    //Placing the elements in intro.html
    $.ajax({
        type : "POST",
        url : "includes/file_bars.php",
        cache : true,
        success:function(html){
            $("#files_bar").html(html);
        }
    });
});
