$(function(){
    // initiate tinyMCE
    if($('#tinymce').length > 0){
        tinymce.init({
            selector: '#tinymce',
            menubar: false,
            toolbar: 'undo redo | bold italic underline'
        });
    }

    // login form authentication
    $('#login').click(function(){        
        var valid_name = validate('#username', null);
        var valid_password = validate('#password', null);
        
        if(valid_name && valid_password){
            $('#loader').removeClass('invisible');
            $('#login').attr('disabled','disabled');
            
            $.ajax({
               url: 'login.auth.php',
               type: 'GET',
               data: $('#loginform').serialize(),
               success: function(result){
                   var res = result.trim();
                   
                   if(res === 'success'){
                       window.location = 'dashboard.php';
                   }else{
                       $("#loader").addClass('invisible');
                       $('#login').removeAttr('disabled');
                       
                       alert(res);
                   }
               },
               error: function(){
                    $("#loader").addClass('invisible');
                    $('#login').removeAttr('disabled');
                    
                    alert('Error authenticating password.');
               }
            });
        }else{            
            alert('Please fill in your Username and Password.');
        }
    });
    
    // quick send authentication
    $('#send').click(function(){
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
                   //jquery serialize doesnt get the value form tinymc, so just make our own json object
                   name: $('#name').val(), 
                   email: $('#email').val(), 
                   message: tinymce.get('tinymce').getContent() 
               }, 
               success: function(result){
                   var res = result.trim();
              
                   if(res === 'success'){
                       console.log(res);
                   }else{
                       $("#loader").addClass('invisible');
                       $('#send').removeAttr('disabled');
                       
                       alert(res);
                   }
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
    });
    
}); // end of document ready
