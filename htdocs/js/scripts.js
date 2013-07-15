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
               url: 'login.auth.php',
               type: 'GET',
               data: $('#sendform').serialize(),
               success: function(result){
                   var res = result.trim();
                   
                   if(res === 'success'){
                       window.location = 'dashboard.php';
                   }else{
                       $("#loader").addClass('invisible');
                       $('#send').removeAttr('disabled');
                       
                       alert(res);
                   }
               },
               error: function(){
                    $("#loader").addClass('invisible');
                    $('#send').removeAttr('disabled');
                    
                    alert('Error authenticating password.');
               }
            });
        }else{            
            alert('Please fill in your Username and Password.');
        }
        
    });
    
}); // end of document ready
