<?php
/*
 * Radmaster Toolkit
 * 
 * THIS FILE IS (inc. PUBLISHED) UNDER RADMASTER LICENSE (RML)  
 * "Hytex Solutions Limited" @ Minsk / BY (2000-2019)
 * http://hytex.radmaster.net
 * 
 */ 
class Registry extends Std_Class_Ext  {
	
		/**
	 * @return Std_CLass
	 */
	public static function getInstance(){



		if (!self::$_instance) self::$_instance = new self();


		return  self::$_instance;

	}
	
	
	/**
	 * Enter description here...
	 *
	 * @return Logic_Class_App_Acl_User_Session
	 */
	public function getAclUserSession(){
		return Registry::get('Acl_User_Session');
	}


}

?>