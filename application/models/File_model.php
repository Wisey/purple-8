<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// Obtain contents of input, per-char.
	public function load($file){
		if(file_exists($file)){
			$contents = file_get_contents($file);
			if(!empty($contents)){
				return str_split(trim($contents));
			}
		}
		return FALSE;
	}
}
