var easyform_scr = document.getElementsByTagName('script');
var easyform_src = easyform_scr[easyform_scr.length - 1].getAttribute("src");

jQuery(document).ready(function($){
    
    var easyform_plugin_path = easyform_src.substr(0, easyform_src.lastIndexOf("/"));
    easyform_plugin_path = easyform_plugin_path.substr(0, easyform_plugin_path.lastIndexOf("/") + 1);
    
    var easyform_request_path = easyform_plugin_path + 'requests/';

    
    $('#form_builder .plus_btn').live('click', function(){
        var this_row = $(this).parent().parent();
        
        $.ajax({
            type: "POST",
            url: easyform_request_path + "add_row.request.php",
            data: "",
            success: function(retval){
                this_row.after(retval);
            }
        });
        
    });
    
    $('#form_builder .minus_btn').live('click', function(){
        var last_col = 0;
        
        $(this).parent().parent().remove();
    });
    
    $('#form_builder tbody').sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function(ev){
			/*
            $('#form_builder tr').each(function(index){
            
                $(this).find('input[field="field_name"]').attr('name', 'field_name[' + index + ']');
                $(this).find('input[field="field_label"]').attr('name', 'field_label[' + index + ']');
                $(this).find('select[field="field_type"]').attr('name', 'field_type[' + index + ']');
                $(this).find('input[field="field_value"]').attr('name', 'field_value[' + index + ']');
                
                $(this).find('input[field="field_required"]').attr('name', 'field_required[' + index + ']');
            });
            */
        }
    });
    
    $('.checkbox[name="merlic_easyform_recaptcha"]').change(function(){
        if ($(this).is(':checked')) {
            $('input[name="merlic_easyform_recaptcha_public"]').addClass('required');
            $('input[name="merlic_easyform_recaptcha_private"]').addClass('required');
        }
        else {
            $('input[name="merlic_easyform_recaptcha_public"]').removeClass('required');
            $('input[name="merlic_easyform_recaptcha_private"]').removeClass('required');
        }
    });
    
    $("#easyform").submit(function(){
        /*
         alert('Handler for .submit() called.');
         return false;
         */
    })
    
});

//-----------------------------------------------------------------------------------------------------------------//
jQuery(function($){
    $.easy.forms();
    $.easy.showhide();
});

