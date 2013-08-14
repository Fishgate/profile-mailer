function disableForm(loader, submitBtn, loaderClass){
    $(loader).removeClass(loaderClass);
    $(submitBtn).attr('disabled','disabled');
};

function enableForm(loader, submitBtn, loaderClass){
    $(loader).addClass(loaderClass);
    $(submitBtn).removeAttr('disabled');
}

$(function(){
    //retina check --------------------------------------------------------------------------------------------------------
    var retina = (window.retina || window.devicePixelRatio > 1);
    if(retina){
      $('.decoration').css('top', '45px');
    }

    // import list form
    $('#upload').click(function(){
       var valid_file = validate_file('#fileupload', ['image/jpeg', 'image/gif'], 2);
       
       if(valid_file) {
           var options = {
                beforeSubmit:   function(){ console.log('I\'m about to submit!'); },
                success:        function(e){ console.log(e); },
                url:            'import.exec.php',             
                type:           'post',                
                resetForm:      true                           
            };
           
            $('#importlistform').ajaxSubmit(options);
       }else{
           // nothing!
       }
    }); 

    // login form --------------------------------------------------------------------------------------------------------
    function validate_login(arr){
        disableForm('#loader', '#login', 'invisible');
        
        var valid_username = validate(arr[0]['value']);
        var valid_password = validate(arr[1]['value']);
        
        if(valid_username && valid_password){
            return true;
        }else{
            alert('Please fill in your Username and Password.');
            enableForm('#loader', '#login', 'invisible');
            return false;
        }
    }

    function exec_login(e){
        var res = e.trim();

        if(res === 'success'){
            window.location = 'dashboard.php';
        }else{
            alert(e);
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
    
    // quick send --------------------------------------------------------------------------------------------------------
    $('#template').change(function(){       
        if($(this).val() != 0){
            $('#quicksendloader').removeClass('hidden');
            
            $.ajax({
                url: 'template.exec.php',
                type: 'GET',
                data: { 'template': $(this).val() },
                success: function(e){
                    $('#quicksendloader').addClass('hidden');
                    $('#form_elements').html(e);                                     
                },
                error: function(e){
                    $('#quicksendloader').addClass('hidden');
                    $('#form_elements').html(e);
                }
            });
        }else{
            $('#form_elements').html('<p>No template currently selected.</p>');
        }
        
    });
   
    function validate_quickSend(arr){
        var quicksend = true;
        
        if($('#template').val() != 0){
            for(i in arr){
                if(!validate(arr[i]['value'])){
                    quicksend = false;
                    break;
                }
            }
            
            if(!quicksend){
                alert('Please fill in all the form fields before submitting.');
                return false;
            }
        }else{
            alert('Please select a template.');
            return false;
        }
    }
    
    function exec_quicksend(){
        $('#form_elements').html('<p>No template currently selected.</p>');
    }
    
    $('#quicksendform').ajaxForm({
        url: 'mail.send.php',
        type: 'POST',
        beforeSubmit: validate_quickSend,
        success: exec_quicksend,
        resetForm: true
    });
    
    //DRAWS A PIE CHART --------------------------------------------------------------------------------------------------------
    var pieData = [
        {
            value: quicksend_data.unopened, //UNOPENED VALUE HERE
            color:"#E74C3C"
        },
        {
            value : quicksend_data.opened, //OPENED VALUE HERE
            color : "#2ECC71"
        }
   ];

   if($('#canvas').length > 0) {
       var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData);
   }

}); // end of document ready
