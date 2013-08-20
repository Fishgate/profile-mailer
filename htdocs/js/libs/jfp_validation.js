/**
 * Author:              Kyle Vermeulen
 * Date:                Updated - 2013/08/05
 * Dependencies:        Latest jQuery, jQuery form plugin (http://malsup.com/jquery/form/)
 * TODO:                - add options to parse into the document for things like error colour, error types
 *                      - remove the smaller functions and consoldate them into their bigger purposes, e.g. validating a phone number, passwords, etc
 */

/** 
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
 */

error = "red";

function linktest(){
    alert('validation.js linked correctly');
}

function validate (target){
    if(target !== ''){
        return true;
    }else{
        jQuery(target).css('background', 'red');
        return false;
    }
}

function validate_file (target, filetypes_arr, max_size) {
    if(jQuery(target).val() !== ''){
        var file = jQuery(target)[0].files[0];
        var size = file.size;
        
        var value = jQuery(target).val();
        var lastDot = value.lastIndexOf('.');
        var type = value.substr(lastDot);
        
        is_valid_ext = false;

        for(var i in filetypes_arr){
            if(type === filetypes_arr[i]){
                is_valid_ext = true;
            }
        }
        
        if(is_valid_ext){
            if(max_size*1048576 > size){
                return true;
            }else{
                return false;
            }
        }else{
            return false;        
        }
    }else{
        return false;
    }
}

function validate_email (target){    
    var atSymbol    = target.indexOf('@');
    var dot         = target.indexOf('.');
    var lastDot     = target.lastIndexOf('.');
    var length      = (target.length)-1;
    var secondAt    = target.indexOf('@', (atSymbol+1));
    
    if(target == ''){
        return false;
    }
    else if(atSymbol < 0){
        return false;
    }
    else if(atSymbol == 0){
        return false;
    }
    else if(dot < 0){
        return false;
    }
    else if(lastDot < atSymbol){
        return false;
    }
    else if(lastDot >= length){
        return false;
    }
    else if(secondAt > 0){
        return false;
    }
    else{
        return true;
    }
}

/**
 * ^^^^^^^
 * 
 * jQuery form plugin compatible, I will redo the rest of the functions as I need them
 * but everything above this point is good to go!
 * 
 */



function clear_focus(target, defaultVal){
    jQuery(target).focus(function(){
        if(jQuery(this).val() == defaultVal){
            //jQuery(this).css('background-color', '#FFFFFF');
            jQuery(this).val('');
        }
    });
    
    jQuery(target).focusout(function(){
        if(jQuery(this).val() == ''){
            //jQuery(this).css('background-color', '#FFFFFF');
            jQuery(this).val(defaultVal);
        }
    });
}

function validate_checkboxes(target){
    var error = '<div class="bubble-left"></div><div class="bubble-inner">Please make at least 1 selection.</div><div class="bubble-right"></div>';

    jQuery('.' + target).focus(function(){
        jQuery(target + '_error').html('');
    })

    jQuery('.' + target).change(function(){
        jQuery(target + '_error').html('');
    })

    if(jQuery('.' + target).is(':checked')){
        return true;
    }else{
        jQuery(target + '_error').html(error);
        return false;
    }
}



function valideate_tinymce(target){    
    if(tinymce.get(target).getContent() !== ''){
        return true;
    }else{        
        return false;
    }

}

function validate_length(string, condition){
    if(string.length < condition){
        return false;
    }else{
        return true;
    }
}

function contains_num(string){
    split_string = string.split("");
    
    for(i=0; i<split_string.length; i++){
        if(!isNaN(split_string[i])){
            return true;
        }        
    }
    
    return false;
}

function contains_letter(string){
    split_string = string.split("");
    
    for(i=0; i<split_string.length; i++){
        if(isNaN(split_string[i])){
            return true;
        }        
    }
    
    return false;
}

function validate_password(target){
    var error = '<div class="bubble-left"></div><div class="bubble-inner">Password must be at least 8 characters long and must contain a combination of letters and numbers.</div><div class="bubble-right"></div>';
    
    jQuery(target).focus(function(){
        jQuery(target + '_error').html('');
    })
        
    if(!validate_length(jQuery(target).val(), 8) || !contains_letter(jQuery(target).val()) || !contains_num(jQuery(target).val())){
        jQuery(target + '_error').html(error);
        return false;
    }else{
        return true;
    }
}

