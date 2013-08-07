function disableForm(loader, submitBtn, loaderClass){
    $(loader).removeClass(loaderClass);
    $(submitBtn).attr('disabled','disabled');
};

function enableForm(loader, submitBtn, loaderClass){
    $(loader).addClass(loaderClass);
    $(submitBtn).removeAttr('disabled');
}

$(function(){
    //retina check
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
                clearForm:      true,                          
                resetForm:      true                           
            };
           
            $('#importlistform').ajaxSubmit(options);
       }else{
           // nothing!
       }
    }); 

    // login form    
    function validate_login(arr){
        disableForm('#loader', '#login');
        
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
        url: 'login.auth.php',
        type: 'get',
        beforeSubmit: validate_login,
        success: exec_login,
        clearForm: true,
        resetForm: true
    });
    
    // quick send
    $('#template').change(function(){       
        if($(this).val() != 0){
            $('#quicksendloader').removeClass('hidden');
            
            $.ajax({
                url: 'template.exec.php',
                type: 'GET',
                data: { 'template': $(this).val() },
                success: function(e){
                    console.log(e);
                    $('#quicksendloader').addClass('hidden');
                    $('#form_elements').html(e);                                     
                },
                error: function(e){
                    $('#quicksendloader').addClass('hidden');
                    console.log(e);
                    $('#form_elements').html(e);
                }
            });
        }else{
            $('#form_elements').html('<p>No template currently selected.</p>');
        }
        
    });
   
    function validate_quickSend(){
        
        //these fields are determined by the template chosen
        
    }
    
    function exec_quicksend(){
        
    }
    
    $('#quicksendform').ajaxForm({
        url: 'mail.send.php',
        type: 'post',
        beforeSubmit: validate_quickSend,
        success: exec_quicksend,
        clearForm: true,
        resetForm: true
    });
    
    /*$('#send').click(function(){
        
        var valid_name = validate('#name', null);
        var valid_email = validate_email('#email', null);
        var valid_tinymce = valideate_tinymce('tinymce');
        
        if(valid_name && valid_email && valid_tinymce){           
            $('#loader').removeClass('invisible');
            $('#send').attr('disabled','disabled');
            
            $.ajax({
               url: 'mail.send.php',
               type: 'POST',
               data: { 
                   //jquery serialize doesnt get the value from tinymc, so just make our 
                   //own json object of exactly what we need to submit to the php script
                   name: $('#name').val(), 
                   email: $('#email').val(), 
                   message: tinymce.get('tinymce').getContent(),
                   template: $('#template :selected').val()
               }, 
               success: function(result){
                   var res = result.trim();
                   
                   if(res === 'success'){
                       alert('Quick send has been successfully sent!');
                   }else{
                       alert(res);
                   }
                   
                   $("#loader").addClass('invisible');
                   $('#send').removeAttr('disabled');
               },
               error: function(){
                    $("#loader").addClass('invisible');
                    $('#send').removeAttr('disabled');
                    
                    alert('Error sending email.');
                }
            });
        }else{            
            alert('Please fill in all the required fields correctly before trying to send an email.');
        }
        
    });*/
    
    //DRAWS A CHART -- *TEST
    var pieData = [
        {
            value: 1, //UNOPENED VALUE HERE
            color:"#E74C3C"
        },
        {
            value : 1, //OPENED VALUE HERE
            color : "#2ECC71"
        }
   ];

   if($('#canvas').length > 0) {
       var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData);
   }

}); // end of document ready
