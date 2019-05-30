<?php
/*
 * Radmaster Toolkit
 * 
 * THIS FILE IS (inc. PUBLISHED) UNDER RADMASTER LICENSE (RML)  
 * "Hytex Solutions Limited" @ Minsk / BY (2000-2019)
 * http://hytex.radmaster.net
 * 
 */ 


class Std_Struct extends Std_Class_Ext {
	
	
	
	public $_fields = array ('name');
	
	public function setStruct($name){
		$this->setParam('name',$name);
		return $this;
	}
	
	   public function toArray()
    {
        return $this->getAllParam();
    }
	
}

?>