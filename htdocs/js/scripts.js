function ajaxform(){
    // do stuff here later
}

$(function(){
    $('#login').click(function(){
        var valid_name = validate('#username', null);
        var valid_password = validate('#password', null);
        
        if(valid_name && valid_password){
            $.ajax({
               url: 'login.auth.php',
               type: 'GET',
               data: $('#loginform').serialize(),
               success: function(result){
                   var res = result.trim();
                   
                   if(res === 'success'){
                       window.location = 'dashboard.php';
                   }else{
                       alert(res);
                   }
               },
               error: function(){
                    alert('Error authenticating password.');
               }
            });
        }else{
            alert('Please fill in your Username and Password.');
        }
    });
    
}); //end of document ready