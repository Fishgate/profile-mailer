$(function(){
    
    //RETINA CHECK QUERY
    var retina = (window.retina || window.devicePixelRatio > 1);
    if(retina){
      $('.decoration').css('top', '45px');
    }
    
    // initiate tinyMCE
    if($('#tinymce').length > 0){
        tinymce.init({
            selector: '#tinymce',
            menubar: false,
            toolbar: 'undo redo | bold italic underline'
        });
    }
    
    // import list form
    $('#upload').click(function(){
       var valid_file = validate_file('#fileupload', ['image/jpeg', 'image/gif'], 2);
       
       if(valid_file) {
           var formData = new FormData($('#importlistform')[0]);
           
            $.ajax({
                url: 'upload.php',
                type: 'POST',
                xhr: function() {
                    myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){
                        myXhr.upload.addEventListener('progress',progressHandlerFunction, false);
                    }
                    return myXhr;
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
       }
    }); 

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
                   
                   console.log(res);
                   
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
    });
    
    //DRAWS A CHART -- *TEST
    var pieData = [
        {
            value: 27,//UNOPENED VALUE HERE
            color:"#E74C3C"
        },
        {
            value : 50,//OPENED VALUE HERE
            color : "#2ECC71"
        }
   ];

   if($('#canvas').length > 0) {
       var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData);
   }
    
    
}); // end of document ready
