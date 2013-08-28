<?php
/**
 * Prepares the end user alerts as properties of itself
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za> <kyle@fishgate.co.za>
 */

//require_once(SITE_ROOT . '/classes/ErrorLog.php');

class Alerts {
    private $json_string;
    private $json_data;
    
    /**
     * Dynamicaly sets each
     */
    public function __construct() {
        $this->json_string = file_get_contents(SITE_ROOT.ALERTS_FILE);  
        $this->json_data = json_decode($this->json_string);
        
        foreach($this->json_data as $key => $val){
            $this->{$key} = $val;
        }
    }
}

