function disableForm(e,t,n){$(e).removeClass(n);$(t).attr("disabled","disabled")}function enableForm(e,t,n){$(e).addClass(n);$(t).removeAttr("disabled")}$(function(){function n(t){var n=validate_file("#fileupload",[".csv",".xls"],2);if(!n){$.growl.error({message:e.FILE_INVALID});return!1}}function r(e){var t=e.trim();t==="success"?console.log(t):$.growl.error({message:e})}function s(t){disableForm("#loader","#login","invisible");var n=validate(t[0].value),r=validate(t[1].value);if(n&&r)return!0;$.growl.error({message:e.EMPTY_USER_PASS});enableForm("#loader","#login","invisible");return!1}function o(e){var t=e.trim();if(t==="success")window.location="dashboard.php";else{$.growl.error({message:e});enableForm("#loader","#login","invisible")}}function u(t){disableForm("#quickSendLoader","#send","invisible");var n=!0;if($("#template").val()==0){$.growl.error({message:e.NO_TEMPLATE_SELECTED});enableForm("#quickSendLoader","#send","invisible");return!1}for(i in t)if(!validate(t[i].value)){n=!1;break}if(!n){$.growl.error({message:e.EMPTY_FORM_FIELDS});enableForm("#quickSendLoader","#send","invisible");return!1}}function a(t){var n=t.trim();if(n==="success"){$("#form_elements").html("<p>No template currently selected.</p>");enableForm("#quickSendLoader","#send","invisible");$.growl.notice({title:"Success!",message:e.QUICKSEND_SUCCCESS})}else{enableForm("#quickSendLoader","#send","invisible");$.growl.error({message:t})}}var e={};$.ajax({url:"alerts.json",async:!1,dataType:"json",success:function(t){e=t}});var t=window.retina||window.devicePixelRatio>1;$("#importlistform").ajaxForm({url:"import.exec.php",type:"post",beforeSubmit:n,success:r,resetForm:!0});$("#loginform").ajaxForm({url:"login.auth.php",type:"get",beforeSubmit:s,success:o,resetForm:!0});$("#template").change(function(){if($(this).val()!=0){$("#templateSelectLoader").removeClass("hidden");$.ajax({url:"template.exec.php",type:"GET",data:{template:$(this).val()},success:function(e){$("#templateSelectLoader").addClass("hidden");$("#form_elements").html(e)},error:function(e){$("#templateSelectLoader").addClass("hidden");$("#form_elements").html(e)}})}else $("#form_elements").html(e.EMPTY_TEMPLATE)});$("#quicksendform").ajaxForm({url:"mail.send.php",type:"POST",beforeSubmit:u,success:a,resetForm:!0});if($("#canvas").length>0)var f=[{value:quicksend_data.unopened,color:"#E74C3C"},{value:quicksend_data.opened,color:"#2ECC71"}],l=(new Chart(document.getElementById("canvas").getContext("2d"))).Pie(f)});