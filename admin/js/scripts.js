
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
});
