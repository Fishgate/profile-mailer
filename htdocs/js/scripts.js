function disableForm(loader, submitBtn, loaderClass){
    $(loader).removeClass(loaderClass);
    $(submitBtn).attr('disabled','disabled');
}

function enableForm(loader, submitBtn, loaderClass){
    $(loader).addClass(loaderClass);
    $(submitBtn).removeAttr('disabled');
}

$(function(){
    //JSON alerts prep --------------------------------------------------------------------------------------------------------
    var alerts = {};
    
    $.ajax({
    	url: "alerts.json",
    	async: false,
    	dataType: 'json',
    	success: function(data) {
        alerts = data;
    	}
    });
    
    //retina check --------------------------------------------------------------------------------------------------------------
    var retina = (window.retina || window.devicePixelRatio > 1);
    

    // import list form --------------------------------------------------------------------------------------------------------
    function validate_import(arr){
        disableForm('#importLoader', '#upload', 'invisible');
        
        var valid_file = validate_file('#fileupload', ['.csv'], 2);
        
        if(!valid_file){
            $.growl.error({message: alerts.FILE_INVALID});
            return false;
        }
    }
    
    function exec_import(result){
        var res = result.trim();
        res = JSON.parse(res);
        
        if(res.result === 'success'){
            window.location = 'importconfig.php?id=' + res.id;
        }else{
            $.growl.error({message: result});
            enableForm('#importLoader', '#upload', 'invisible');
        }        
    }
    
    $('#importlistform').ajaxForm({
        url:            'importlist.exec.php',
        type:           'post',
        beforeSubmit:   validate_import,
        success:        exec_import,
        resetForm:      true
    });

    // login form --------------------------------------------------------------------------------------------------------------
    function validate_login(arr){
        disableForm('#loader', '#login', 'invisible');
        
        var valid_username = validate(arr[0]['value']);
        var valid_password = validate(arr[1]['value']);
        
        if(valid_username && valid_password){
            return true;
        }else{
            $.growl.error({message: alerts.EMPTY_USER_PASS});            
            enableForm('#loader', '#login', 'invisible');
            return false;
        }
    }

    function exec_login(result){
        var res = result.trim();

        if(res === 'success'){
            window.location = 'dashboard.php';
        }else{
            $.growl.error({message: result});
            enableForm('#loader', '#login', 'invisible');
        }
    }

    $('#loginform').ajaxForm({
        url:            'login.auth.php',
        type:           'get',
        beforeSubmit:   validate_login,
        success:        exec_login,
        resetForm:      true
    });
    
    // quick send --------------------------------------------------------------------------------------------------------------
    $('#template').change(function(){
        if($(this).val() != 0){
            $('#templateSelectLoader').removeClass('hidden');
            
            $.ajax({
                url: 'template.exec.php',
                type: 'GET',
                data: { 'template': $(this).val() },
                success: function(e){
                    $('#templateSelectLoader').addClass('hidden');
                    $('#form_elements').html(e);                                     
                },
                error: function(e){
                    $('#templateSelectLoader').addClass('hidden');
                    $('#form_elements').html(e);
                }
            });
        }else{
            $('#form_elements').html(alerts.EMPTY_TEMPLATE);
        }
        
    });
   
    function validate_quickSend(arr){
        disableForm('#quickSendLoader', '#send', 'invisible');
        
        var quicksend = true;
        
        if($('#template').val() != 0){
            for(i in arr){
                if(!validate(arr[i]['value'])){
                    quicksend = false;
                    break;
                }
            }
            
            if(!quicksend){
                $.growl.error({message: alerts.EMPTY_FORM_FIELDS});
                enableForm('#quickSendLoader', '#send', 'invisible');
                return false;
            }
        }else{
            $.growl.error({message: alerts.NO_TEMPLATE_SELECTED});
            enableForm('#quickSendLoader', '#send', 'invisible');
            return false;
        }
    }
    
    function exec_quicksend(result){
        var res = result.trim();

        if(res === 'success'){
            $('#form_elements').html('<p>No template currently selected.</p>');
            enableForm('#quickSendLoader', '#send', 'invisible');
            
            $.growl.notice({title: "Success!", message: alerts.QUICKSEND_SUCCCESS});
        }else{
            enableForm('#quickSendLoader', '#send', 'invisible');
            $.growl.error({message: result});
        }
        
    }
    
    $('#quicksendform').ajaxForm({
        url: 'mail.send.php',
        type: 'POST',
        beforeSubmit: validate_quickSend,
        success: exec_quicksend,
        resetForm: true
    });
    
    //DRAWS A PIE CHART --------------------------------------------------------------------------------------------------------------
   if ($('#canvas').length > 0) {
       var pieData = [
            { value: quicksend_data.unopened, color:"#E74C3C" },
            { value : quicksend_data.opened, color : "#2ECC71" }
       ];
       
       var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData);
   }

}); // end of document ready
