$(document).ready(function(){
    $('#generateURL').click(function(){
        $.ajax({
            data: {longurl: $('#url').val().trim()}, 
            url: $('#urlForm').attr('action'), 
            success: function(result){
			    $('#generateShortURL').html(result).show();
            },
            error: function(xhr,status,error){
                $('#generateShortURL').html('Oops! something wrong. Please try again!').show();
            }
        });
        return false;
    });

    $('.formWrapper input#url').bind('keypress', function(e) {
		if (e.keyCode == 13) {
			document.getElementById("generateURL").click();
			return false;
		}
	});
});