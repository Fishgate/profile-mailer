/**
 * Author:              Kyle Vermeulen
 * Date:                Updated - 2013/08/05
 * Dependencies:        Latest jQuery, jQuery form plugin (http://malsup.com/jquery/form/)
 * TODO:                - add options to parse into the document for things like error colour, error types
 *                      - remove the smaller functions and consoldate them into their bigger purposes, e.g. validating a phone number, passwords, etc
 *//** 
 * change log ---------------------------------------------------------------------
 *
 * 2013/08/12
 *  - removed default value argument in favour of html 5 placeholder attribute
 *
 * 2013/08/05
 *  - migrating this to work with jquery form plugin
 * 
 * 2013/07/31
 *  - worked in some XMLhttpRequest 2 into the file validation
 * 
 * 2012/12/19
 *  - added first variable for background colour on input errors.
 *  - changed resetting of inputs to remove all inline styles on the element instead of just changing its colour.
 * 
 * 2012/10/05
 *  - removed the preset # selector, this must now be included in the "target" variable when calling the function.
 *  - removed 
 * 
 */function linktest(){alert("validation.js linked correctly")}function validate(e){if(e!=="")return!0;jQuery(e).css("background","red");return!1}function validate_file(e,t,n){if(jQuery(e).val()!==""){var r=jQuery(e)[0].files[0],i=r.size,s=jQuery(e).val(),o=s.lastIndexOf("."),u=s.substr(o);is_valid_ext=!1;for(var a in t)u===t[a]&&(is_valid_ext=!0);return is_valid_ext?n*1048576>i?!0:!1:!1}return!1}function validate_email(e){var t=e.indexOf("@"),n=e.indexOf("."),r=e.lastIndexOf("."),i=e.length-1,s=e.indexOf("@",t+1);return e==""?!1:t<0?!1:t==0?!1:n<0?!1:r<t?!1:r>=i?!1:s>0?!1:!0}function clear_focus(e,t){jQuery(e).focus(function(){jQuery(this).val()==t&&jQuery(this).val("")});jQuery(e).focusout(function(){jQuery(this).val()==""&&jQuery(this).val(t)})}function validate_checkboxes(e){var t='<div class="bubble-left"></div><div class="bubble-inner">Please make at least 1 selection.</div><div class="bubble-right"></div>';jQuery("."+e).focus(function(){jQuery(e+"_error").html("")});jQuery("."+e).change(function(){jQuery(e+"_error").html("")});if(jQuery("."+e).is(":checked"))return!0;jQuery(e+"_error").html(t);return!1}function valideate_tinymce(e){return tinymce.get(e).getContent()!==""?!0:!1}function validate_length(e,t){return e.length<t?!1:!0}function contains_num(e){split_string=e.split("");for(i=0;i<split_string.length;i++)if(!isNaN(split_string[i]))return!0;return!1}function contains_letter(e){split_string=e.split("");for(i=0;i<split_string.length;i++)if(isNaN(split_string[i]))return!0;return!1}function validate_password(e){var t='<div class="bubble-left"></div><div class="bubble-inner">Password must be at least 8 characters long and must contain a combination of letters and numbers.</div><div class="bubble-right"></div>';jQuery(e).focus(function(){jQuery(e+"_error").html("")});if(!validate_length(jQuery(e).val(),8)||!contains_letter(jQuery(e).val())||!contains_num(jQuery(e).val())){jQuery(e+"_error").html(t);return!1}return!0}error="red";