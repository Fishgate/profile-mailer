<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Template
 *
 * @author Owner
 */
class Template {
    private $template_dir;
    private $template_file;
    private $template_string;
    private $form_output;
    private $textarea;
    
    /**
     * 
     * @var String Template name.
     */
    public $template_name;
    
    /**
     * 
     * @var Array Shortcode labels which will be considered as textareas instead of input type text.
     */
    public $textarea_matches;
    
    public function __construct() {
        $this->template_dir = TEMPLATE_DIR;
        $this->textarea = false;
    }

    private function openTemplate() {
        $this->template_file = fopen($this->template_dir . $this->template_name, 'r');
        $this->template_string = fread($this->template_file, filesize($this->template_dir . $this->template_name));
        $this->template_string = trim($this->template_string);
        fclose($this->template_file);
        
        return $this->template_string;
    }
    
    private function filterMatch($preg_match){
        foreach($this->textarea_matches as $val){
            if($preg_match == $val){
                $this->textarea = true;
            }
        }
        
        if($this->textarea){            
            $this->textarea = false;
            return "$preg_match:<br /><textarea name=\"$preg_match\" id=\"tinymce\"></textarea>";
        }else{    
            $this->textarea = false;
            return "<input placeholder=\"$preg_match\" id=\"$preg_match\" name=\"$preg_match\" type=\"text\" />";
        }
    }
    
    public function generateForm() {        
        if(preg_match_all('/\[(.*)\]/', $this->openTemplate(), $matches)){
            foreach($matches[1] as $val){
                $this->form_output .= $this->filterMatch($val) . '<br />';
            }
            
            return $this->form_output;
        }else{
            throw new Exception('<p>No shortcodes found in template file.</p>');
        }
    }
    
}
