
/*summernote WYSIWYG initializer script*/
$(document).ready(function() {
    $('#summernote').summernote({
        height: 200
    });
});

/*checking/unchecking all boxes in posts status edit bulk option*/
$(document).ready(function (){
    $('#selectAllBoxes').click(function (event){
        if (this.checked){
            $('.checkBoxes').each(function (){
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function (){
                this.checked = false;
            });
        }
    });

/*code for the admin loader*/
var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(700).fadeOut(600, function (){
        $(this).remove();
    });

});

/*showing users online (without reloading the page - using ajax) function*/
function loadUsersOnline() {
    //sending the request to the database
    $.get("functions.php?get-online-users=result", function (data) {
        $(".show-users-online").text(data);
    });
}
//setting database request interval
setInterval(function (){
    loadUsersOnline();
},500); //time in milliseconds
/*loadUsersOnline();*/
