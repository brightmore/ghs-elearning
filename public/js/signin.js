$(function () {
	
	jQuery.support.placeholder = false;
	test = document.createElement('input');
	if('placeholder' in test) jQuery.support.placeholder = true;
	
	if (!$.support.placeholder) {
		
		$('.field').find ('label').show ();
		
	}
	
    $('#login').on('click',function(event){
       var username = $('#username').val();
        var password = $('#password').val();
        event.preventDefault();
    });
});