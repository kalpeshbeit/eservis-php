<?php

/**
 * Class that loads header and footer in every view
 */
class MY_Loader extends CI_Loader {

    public function template($vars = array(), $return = FALSE)
    {
        $content  = $this->view('templates/header', $vars, $return);

        if ($return)
        {  
            return $content;
        }
    } 
    
    //template za registraciju korisnika koji poziva forme za dovršetak registracije
    public function templateregister($vars = array(), $return = FALSE)
    {
        $content  = $this->view('templates/register', $vars, $return);

        if ($return)
        {
            return $content;
        }
    }

}