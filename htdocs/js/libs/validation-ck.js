/*
 * Author:              Kyle Vermeulen
 * Date:                Updated - 2012/09/05
 * Dependencies:        Latest jQuery
 * TODO:                - add options to parse into the document for things like error colour, error types
 *                      - remove the smaller functions and consoldate them into their bigger purposes, e.g. validating a phone number, passwords, etc
 *                      - 
 * 
 *//* change log ---------------------------------------------------------------------
2012/12/19
    - added first variable for background colour on input errors
    - changed resetting of inputs to remove all inline styles on the element instead of just changing its colour.

2012/10/05
    - removed the preset # selector, this must now be included in the "target" variable when calling the function
    - removed 



---------------------------------------------------------------------------------*/function linktest(){alert("validation.js linked correctly")}function reset_all(e){for(i=0;i<e.length;i++){jQuery("#"+e[i]).val("");jQuery("#"+e[i]+"_error").html("")}}function clear_focus(e,t){jQuery(e).focus(function(){jQuery(this).val()==t&&jQuery(this).val("")});jQuery(e).focusout(function(){jQuery(this).val()==""&&jQuery(this).val(t)})}function validate_checkboxes(e){var t='<div class="bubble-left"></div><div class="bubble-inner">Please make at least 1 selection.</div><div class="bubble-right"></div>';jQuery("."+e).focus(function(){jQuery(e+"_error").html("")});jQuery("."+e).change(function(){jQuery(e+"_error").html("")});if(jQuery("."+e).is(":checked"))return!0;jQuery(e+"_error").html(t);return!1}function validate_file(e){var t=e.files[0];name=t.name;size=t.size;type=t.type;console.log(name)}function validate(e,t){jQuery(e).focus(function(){jQuery(e).removeAttr("style")});jQuery(e).change(function(){jQuery(e).removeAttr("style")});if(jQuery(e).val()!==""&&jQuery(e).val()!==t)return!0;jQuery(e).css("background",error);return!1}function valideate_tinymce(e){return tinymce.get(e).getContent()!==""?!0:!1}function validate_length(e,t){return e.length<t?!1:!0}function contains_num(e){split_string=e.split("");for(i=0;i<split_string.length;i++)if(!isNaN(split_string[i]))return!0;return!1}function contains_letter(e){split_string=e.split("");for(i=0;i<split_string.length;i++)if(isNaN(split_string[i]))return!0;return!1}function validate_password(e){var t='<div class="bubble-left"></div><div class="bubble-inner">Password must be at least 8 characters long and must contain a combination of letters and numbers.</div><div class="bubble-right"></div>';jQuery(e).focus(function(){jQuery(e+"_error").html("")});if(!validate_length(jQuery(e).val(),8)||!contains_letter(jQuery(e).val())||!contains_num(jQuery(e).val())){jQuery(e+"_error").html(t);return!1}return!0}function validate_email(e,t){var n=jQuery(e).val().indexOf("@"),r=jQuery(e).val().indexOf("."),i=jQuery(e).val().lastIndexOf("."),s=jQuery(e).val().length-1,o=jQuery(e).val().indexOf("@",n+1);jQuery(e).focus(function(){jQuery(e).removeAttr("style")});jQuery(e).change(function(){jQuery(e).removeAttr("style")});if(jQuery(e).val()==""||jQuery(e).val()==t){jQuery(e).css("background",error);return!1}if(n<0){jQuery(e).css("background",error);return!1}if(n==0){jQuery(e).css("background",error);return!1}if(r<0){jQuery(e).css("background",error);return!1}if(i<n){jQuery(e).css("background",error);return!1}if(i>=s){jQuery(e).css("background",error);return!1}if(o>0){jQuery(e).css("background",error);return!1}return!0}error="red";