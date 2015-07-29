function validate_naplatni_uredjaj() {
	var validate = true;

    // naplatni uredjaj
    if ($('#naplatniuredjaj').val() == '' || !$.isNumeric($('#naplatniuredjaj').val()) || $('#naplatniuredjaj').val() == 0) {
        $('#naplatniuredjaj_form_group').addClass('has-error');
        var validate = false;
    } else {
        $('#naplatniuredjaj_form_group').removeClass('has-error');
        $('#naplatniuredjaj_form_group').addClass('has-success');
    } 
    
    
    
    // naplatni uredjaj
    if ($('#poslovniprostor').val() == '' || $('#poslovniprostor').val() == 0) {
        $('#poslovniprostor_form_group').addClass('has-error');
        var validate = false;
    } else {
        $('#poslovniprostor_form_group').addClass('has-success');
    }
    

	return validate;
} 


