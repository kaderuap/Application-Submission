jQuery(document).ready(function () {
    jQuery('.number_check').on('keypress', function(event){
        var nlenth = jQuery(this).val().length;
        if( ( event.which != 8 && isNaN(String.fromCharCode(event.which)) && event.which != 32 && event.which != 44 ) || nlenth > 10 ){
            event.preventDefault();
        }
  	});
});