<?php 
/*
 * Radmaster Toolkit
 * 
 * THIS FILE IS (inc. PUBLISHED) UNDER RADMASTER LICENSE (RML)  
 * "Hytex Solutions Limited" @ Minsk / BY (2000-2019)
 * http://hytex.radmaster.net
 * 
 */ 

class Notation_Hungarian extends Std_Class{


	/**
	 * Enter description here...
	 *
	 * @param string $class_name
	 */
	static function parseClassName($class_name){
		
		$class_name_array = array();
		
		$matches_class_name = preg_split('/(?=[A-Z])/',$class_name);

		if(count($matches_class_name) >2 ){

			array_shift($matches_class_name);

			//$count = count($matches_class_name);


			
			foreach ($matches_class_name as $key => $class_name_el){

				$class_el_string = ucfirst(strtolower($class_name_el));
				$class_name_array[] = $class_el_string;
			}
		}

		return $class_name_array;
	}

}

?>