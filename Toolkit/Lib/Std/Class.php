<?php
/*
 * Radmaster Toolkit
 * 
 * THIS FILE IS (inc. PUBLISHED) UNDER RADMASTER LICENSE (RML)  
 * "Hytex Solutions Limited" @ Minsk / BY (2000-2019)
 * http://hytex.radmaster.net
 * 
 */ 
class Std_Class extends Element{



	public $_dependency_primary_element;
	public $_dependency_secondary_elements = array();



	public $_dependency = array();


	public $_class_data_path;

	public function setClassDataPath($path){

		$this->_class_data_path = $path;
		return $this;
	}

	public function getClassDataPath(){
		return $this->_class_data_path;
	}



	public $_app_class_name;

	public $_app_path;

	public function setAppPath($app_path){
		$this->_app_path = $app_path;
		return $this;
	}



	public function setAppClassName($app_class_name){
		$this->_app_class_name = $app_class_name;
		return $this;
	}

	public function getAppClassName(){
		return $this->_app_class_name;
	}


	public function getAppPath(){


		if(!$this->_app_path){

			$app_class_name = $this->getAppClassName();
			if($app_class_name){

				$app_class_name_path = Std_Class::getPathFromClassName($app_class_name);
				$this->setAppPath($app_class_name_path);

			}

		}

		return $this->_app_path;

	}






	/**
	 * Enter description here...
	 *
	 * @param Std_Class $center_element
	 * @return Std_Class
	 */
	public function setDependencyPrimaryElement(Std_Class $dependency_primary_element){

		$this->_dependency_primary_element = $dependency_primary_element;
		return $this->_dependency_primary_element;
	}


	public function addDependencySecondaryElement(Std_Class $dependency_secondary_element){

		$this->_dependency_secondary_elements[] = $dependency_secondary_element;
		return $this;
	}

	public function getDependencySecondaryElements(){

		return $this->_dependency_secondary_elements;

	}


	/**
	 * Enter description here...
	 *
	 * @return Std_Class
	 */
	public function getDependencyPrimaryElement(){

		return $this->_dependency_primary_element;

	}




	/**
	 * Enter description here...
	 *
	 * @param Dependency $dependency
	 * @return Dependency
	 */
	public function addDependency(Dependency $dependency = null){

		if(!$dependency) $dependency = new Dependency();
		$this->_dependency[] = $dependency;
		return $dependency;
	}



	/**
	 * Enter description here...
	 *
	 * @param string $name
	 * @return Dependency || Null
	 */
	public function getDependency($name = null){

		if(!$name) $name = 0;
		return $this->_dependency[$name];

	}


	/**
	 * Enter description here...
	 *
	 * @return array
	 */
	public function getAllDependencies(){

		return $this->_dependency;

	}


	static public $_default_path; //for include classed and etc


	public static function setDefaultPath($default_path){

		Std_Class::$_default_path = $default_path;
	}



	public function __construct($param = null,$registry_auto_set = false){


		//kind of bug
		//$type = $this->getType();//Std_Type::TYPE_Undefined

		//check for type

		$class_name = get_class($this);

		if($class_name == 'Output'){

			$test = 1;
		}




		if(!method_exists($this,'getType')){

			$class = get_class($this);

		}


		$class_name = get_class($this);

		$class_name_array = explode("_",$class_name);

		$type_name = $class_name_array[count($class_name_array)-1];

		$reflector = new ReflectionObject($this);
		$type = null;

		if($constant = $reflector->getConstant('TYPE_'.$type_name)){

			$type = $constant;

		}else{
			
			$type = Std_Type::TYPE_Undefined;

		}
		$this->setType($type);



		//if Std_Class object - $param => $name
		//else $param => $value


		if($type_name == 'Class' || $registry_auto_set || $type == Std_Type::TYPE_Undefined) {
			if($param) $this->setName($param);
			else $this->setName($type_name);
			
		}
		else $this->setValue($param);


		if($registry_auto_set){
			Registry::set($param,$this);
		}




		$this->onInit();

		return $this;

	}



	public function is_empty()
	{
		return empty($this->_data);
	}


	public function generateId($params_string,$auto_set = true){

		$id = sha1($params_string);
		if($auto_set) $this->setId($id);
		return $id;
	}


	public function getCurrentClassFileName(){
		$class = new ReflectionClass($this);

		return $class->getFileName();
	}


	public function setValueArray(array $arr){



		$_value = $this->getValue();
		if(!$_value || !($_value instanceof Std_Class) ) {

			$_value = new Std_Class();
			$this->setValue($_value);
		}



		foreach ($arr as $key => $val){

			if(!$el = $this->getValue()->getElement($key))	$el = $this->getValue()->addElement();
			$el->setName($key);
			$el->setValue($val);
			//$this->getValue()->addElement($el);
		}

		return $this;
	}

	public function addElementsFromArray(array $elements){

		foreach ($elements as $key=>$val){

			$el = $this->addElement();
			$el->setName($key);
			$el->setTitle($val);
			$el->setValue($val);
		}

		return $this;

	}



	public static function isClassFileExists($class_file,$class_name = null,$path = null, $extension = '.php'){

		if(!$class_file && $class_name) {

			$class_file = Std_Class::getPathFromClassName($class_name);
			$class_file .= $extension;
		}

		//$return_value = false;
		if(!$path) $path = Std_Class::$_default_path;

		$file = $path.'/'.$class_file;
		return file_exists($file);


	}

	/**
	 * Enter description here...
	 *
	 * @param string $class_name
	 * @return array
	 */
	public static function parseClassName($class_name){


		if($class_name) $class_name_array = preg_split("/\_/",$class_name);
		else $class_name_array = array();


		return $class_name_array;


		/*$class_name_parsed = '';
		if(count($class_name_array) > 1){
		foreach ($class_name_array as $key=> &$_class_name){
		if($key > 0) $class_name_parsed .= '/';
		$class_name_parsed .= $_class_name;
		}

		}*/


	}
	static function prepareClassNameParam($class_name_param){
		
		$return_value = '';
		//check for hungarion notation
		$class_name_hungarian_notation_array = Notation_Hungarian::parseClassName($class_name_param);
		if(count($class_name_hungarian_notation_array) >  1){
			$return_value = $class_name_param; 
		}else {
			
			$return_value = ucfirst(strtolower($class_name_param));
		}
		

		return $return_value;
	}

	static function assembleClassName($class_name = null,array $class_name_params = null){

		$assembled_class_name = '';
		if($class_name) $assembled_class_name = $class_name;

		if($class_name_params) {
			foreach ($class_name_params as $_class_name){
				if(!empty($assembled_class_name)) $assembled_class_name .= '_';
				$assembled_class_name .= Std_Class::prepareClassNameParam($_class_name);

			}
		}
		return $assembled_class_name;
	}


	static function getPathFromClassName($class_name,$exclude_array = null){

		$class_name_array = Std_Class::parseClassName($class_name,$divider = '/');

		if($exclude_array){
			foreach ($exclude_array as $key=>$exclude_value){

				if(in_array($exclude_value,$class_name_array)){


				}
			}

		}


		$path = '';
		//if(count($class_name_array) > 1){
		$real_key = 0;
		foreach ($class_name_array as $key=> $entity_name){

			if($exclude_array){
				if(in_array($entity_name,$class_name_array)){
					continue;
				}
			}

			if($real_key > 0) $path .= $divider;
			$path .= $entity_name;
			$real_key++;
		}



		//}else 	$file = PATH_LIB_RADMASTER.'/'.$class_name.'.php'; //$file = PATH_LIB.'/radmaster/lib/'.$class_name.

		return $path;
	}



	static public function findExistClassName(array $class_params_array, $class_add_to_check = 'Default', $path = null){

		$class_name = '';

		$success_class_name = '';






		$z = 10;

		while($z){

			$class_params_array_add_to_check = $class_params_array;




			$class_params_array_add_to_check[] = $class_add_to_check;

			$class_name = Std_Class::assembleClassName(null,$class_params_array);



			$class_name_add_to_check = Std_Class::assembleClassName(null,$class_params_array_add_to_check);


			//*=))))

			//** temporaly for grid

			$class_name_list = '';
			$class_name_length = strlen($class_name);

			$last_char = strtolower($class_name[$class_name_length-1]);
			if($last_char == 's'){
				if($class_name[$class_name_length-2] == 'e' && $class_name[$class_name_length-3] == 'i'){

					$class_name_without_last_char = substr($class_name, 0, -3);
					$class_name_without_last_char .= 'y';

				}else $class_name_without_last_char = substr($class_name, 0, -1);
				$class_name_list = $class_name_without_last_char.'_Grid';

			}else $last_char = null;


			//**





			if(Std_Class::isClassFileExists(null,$class_name)){
				$success_class_name = $class_name;
				break;
			}elseif ($last_char && Std_Class::isClassFileExists(null,$class_name_list)){
				$success_class_name = $class_name_list;
				//Registry::set($cl,1);
				break;

			}elseif (Std_Class::isClassFileExists(null,$class_name_add_to_check)){
				$success_class_name = $class_name_add_to_check;
				break;

			}else {

				array_pop($class_params_array);

			}
			if(count($class_params_array) == 1){
				//$class_name = '';
				break;
			}

			$z--;

		}
		return $success_class_name;

		//foreach ($class_params_array)

	}


	/**
	 * Enter description here...
	 *
	 * @return Std_Class
	 */
	public function deleteAllElements(){
		$this->_elements = array();
		return $this;
	}



}


?>