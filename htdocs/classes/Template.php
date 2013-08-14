<?php
/**
 * Description of Template
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za>
 */
class Template {
    private $template_dir;
    private $template_file;
    private $template_string;
    private $form_output;
    private $textarea;
    private $lovelyString;
    
    /**
     * 
     * @var String Template name.
     */
    public $template_name;
    
    /**
     *
     * @var Array Listing of shortcode string matches in the email template to be ignored
     */
    public $ignore_matches;
    
    /**
     * 
     * @var Array Shortcode labels which will be considered as textareas instead of input type text.
     */
    public $textarea_matches;
    
    public function __construct() {
        $this->template_dir = TEMPLATE_DIR;
        $this->textarea = false;
    }
    
    /**
     * Opens the file template and returns it as a string.
     * 
     * @return String
     */
    private function openTemplate() {
        $this->template_file = fopen($this->template_dir . $this->template_name, 'r');
        $this->template_string = fread($this->template_file, filesize($this->template_dir . $this->template_name));
        $this->template_string = trim($this->template_string);
        fclose($this->template_file);
        
        return $this->template_string;
    }
    
    /**
     * Input matched elements found with preg_match and returns the appropriate 
     * markup to dynamicaly generate the quick send form.
     * 
     * @param String $preg_match Matched element from preg_match.
     * @return String Returns markup for dynamicaly generated form elements.
     */
    private function filterMatch($preg_match){
        $this->lovelyString = ucfirst(strtolower($preg_match));
        
        foreach($this->textarea_matches as $val){
            if($preg_match == $val){
                $this->textarea = true;
            }
        }
        
        if($this->textarea){            
            $this->textarea = false;
            return "<textarea name=\"$preg_match\" placeholder=\"$this->lovelyString\" id=\"$preg_match\"></textarea>";
        }else{    
            $this->textarea = false;
            return "<input placeholder=\"$this->lovelyString\" id=\"$preg_match\" name=\"$preg_match\" type=\"text\" />";
        }
    }

    
    private function ignoreMatch($input_string){
        foreach($this->ignore_matches as $ignore){
            if($input_string == $ignore){
                return true;
                break;
            }             
        }
        
        return false;
    }
    
    /**
     * Returns the entire markup block for the quick send form based
     * on shortcodes found in the selected template.
     * 
     * @return String
     * @throws Exception
     */
    public function generateForm() {        
        if(preg_match_all('/\[(.*)\]/', $this->openTemplate(), $matches)){
            foreach($matches[1] as $val){
                if(!$this->ignoreMatch($val)){
                    $this->form_output .= $this->filterMatch($val) . '<br />';
                }
            }
            
            return $this->form_output;
        }else{
            throw new Exception('<p>No shortcodes found in template file.</p>');
        }
    }
    
}
