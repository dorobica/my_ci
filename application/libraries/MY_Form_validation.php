<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	public function __construct($rules = array())
	{
		parent::__construct($rules);
	}

    public function valid_url($str)
    {
        $this->prep_url($str);
        $this->set_message('valid_url', 'The %s field must be a valid URL');
        if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str)) {
            return (bool) @fopen($str,"r");
        }
        return FALSE;
    }

    /* custom array fields validations */
    public function array_exact_length($array_obj, $params)
    {
        $params = explode(',',$params);

        $this->set_message('array_min_length', 'The %s must have exactly '.$params[0].' enteries');

        //check length
        if(isset($_POST[$params[1]]) && is_array($_POST[$params[1]]) && sizeof($_POST[$params[1]]) == $params[0]) {
            return FALSE;
        }
        return TRUE;
    }

    public function array_min_length($array_obj, $params)
    {
    	$params = explode(',',$params);

    	$this->set_message('array_min_length', 'The %s must have a minimum of '.$params[0].' enteries');
        //clear empty array fields
        foreach($_POST[trim($params[1])] as $k => $v) {
            if(is_string($v) && !strlen($v) || is_array($v) && !sizeof($v)) {
                unset($_POST[trim($params[1])][$k]);
            }
        }

    	//check length
    	if(sizeof($_POST[trim($params[1])]) < $params[0]) {
    		return FALSE;
    	}
    	return TRUE;
    }

    public function array_max_length($array_obj, $params)
    {
    	$params = explode(',',$params);

    	$this->set_message('array_max_length', 'The %s must have a maximum of '.$params[0].' enteries');

    	//check length
    	if(sizeof($_POST[$params[1]]) > $params[0]) {
    		return FALSE;
    	}
    	return TRUE;
    }

    /**
     * Validate CNP ( valid for 1800-2099 )
     * https://github.com/cristian-datu/CNP
     * @param string $p_cnp
     * @return boolean
     */
    public function valid_cnp($p_cnp) {

        $this->set_message('valid_cnp', 'The %s must be a valid CNP');

        // CNP must have 13 characters
        if(strlen($p_cnp) != 13) {
            return false;
        }
        $cnp = str_split($p_cnp);
        unset($p_cnp);
        $hashTable = array( 2 , 7 , 9 , 1 , 4 , 6 , 3 , 5 , 8 , 2 , 7 , 9 );
        $hashResult = 0;
        // All characters must be numeric
        for($i=0 ; $i<13 ; $i++) {
            if(!is_numeric($cnp[$i])) {
                return false;
            }
            $cnp[$i] = (int)$cnp[$i];
            if($i < 12) {
                $hashResult += (int)$cnp[$i] * (int)$hashTable[$i];
            }
        }
        unset($hashTable, $i);
        $hashResult = $hashResult % 11;
        if($hashResult == 10) {
            $hashResult = 1;
        }
        // Check Year
        $year = ($cnp[1] * 10) + $cnp[2];
        switch( $cnp[0] ) {
            case 1  : case 2 : { $year += 1900; } break; // cetateni romani nascuti intre 1 ian 1900 si 31 dec 1999
            case 3  : case 4 : { $year += 1800; } break; // cetateni romani nascuti intre 1 ian 1800 si 31 dec 1899
            case 5  : case 6 : { $year += 2000; } break; // cetateni romani nascuti intre 1 ian 2000 si 31 dec 2099
            case 7  : case 8 : case 9 : {                // rezidenti si Cetateni Straini
                $year += 2000;
                if($year > (int)date('Y')-14) {
                    $year -= 100;
                }
            } break;
            default : {
                return false;
            } break;
        }
        return ($year > 1800 && $year < 2099 && $cnp[12] == $hashResult);
    }

    public function alpha_spaces($str){

        return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
    }

    public function valid_cif($cif){

        if (!is_numeric($cif)) return FALSE;
        if ( strlen($cif)>10 ) return FALSE;

        $cifra_control=substr($cif, -1);
        $cif=substr($cif, 0, -1);
        while (strlen($cif)!=9){
        $cif='0'.$cif;
        }
        $suma=$cif[0] * 7 + $cif[1] * 5 + $cif[2] * 3 + $cif[3] * 2 + $cif[4] * 1 + $cif[5] * 7 + $cif[6] * 5 + $cif[7] * 3 + $cif[8] * 2;
        $suma=$suma*10;
        $rest=fmod($suma, 11);
        if ( $rest==10 ) $rest=0;

        if ($rest==$cifra_control) return TRUE;
        else return FALSE;
    }

}