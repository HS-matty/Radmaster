<?php
/*
 * Radmaster Toolkit
 * 
 * THIS FILE IS (inc. PUBLISHED) UNDER RADMASTER LICENSE (RML)  
 * "Hytex Solutions Limited" @ Minsk / BY (2000-2019)
 * http://hytex.radmaster.net
 * 
 */ 


class Element implements IteratorAggregate, arrayaccess,Countable{



	public $_id;

	public	$_name;
	public	$_title;
	public	$_type;
	public $_class;

	public $_value;

	public $_key;
	protected $_parent;

	protected $_child_class_name;

	protected $_class_name;

	/**
	 * default object type
	 *
	 * @var Element
	 */
	static protected  $_instance;

	public   $_elements = array();

	protected $_vars = array();

	protected $_actions = array();


	protected $_current_element_name;
	public  $_current_element;

	protected  $_search_element_index;


	protected $_properties = array();



	public $_success_status = true;

	public $_loop_end_flag = false;



	public  $_fields;



	public $_count;

	public function setCount($count){
		$this->_count = $count;
		return $this;
	}
	public function getCount(){
		return $this->_count;
	}

	public function setFields($fields){

		$this->_fields = $fields;
		return $this;
	}
	public function getFields(){
		return $this->_fields;
	}



	public $_app_class_name;

	public function setAppClassName($app_class_name){
		$this->_app_class_name = $app_class_name;
		return $this;
	}

	public function getAppClassName(){
		return $this->_app_class_name;
	}


	public function getAppPath(){

		$app_class_name = $this->getAppClassName();
		if($app_class_name){

			$app_class_name_path = Std_Class::getPathFromClassName($app_class_name);



		}
		return $app_class_name_path;

	}




	/**
	 * Enter description here...
	 *
	 * @var Std_Class
	 */
	public $_inherits;


	/**
	 * Enter description here...
	 *
	 * @param Std_Class $element
	 * @return Std_Class
	 */
	public function addInherit($element){

		if(!$this->_inherits) $this->_inherits = new Std_Class();
		/*		$element = new Std_Class();

		$element->setValue($obj);*/
		$this->_inherits->addElement($element);
		return $element;

	}


	/**
	 * Enter description here...
	 *
	 * @return Std_Class
	 */
	public function getInherits(){

		return $this->_inherits;


	}




	/**
	 * Enter description here...
	 *
	 * @param bool $flag
	 * @return Element
	 */
	public function setLoopEndFlag($flag){
		$this->_loop_end_flag = $flag;
		return $this;
	}


	/**
	 * Enter description here...
	 *
	 * @return bool
	 */
	public function getLoopEndFlag(){
		return $this->_loop_end_flag;

	}



	/**
	 * Enter description here...
	 *
	 * @param bool $status
	 * @return Element
	 */
	public function setSuccesStatus($status){
		$this->_success_status = $status;
		return $this;
	}


	/**
	 * Enter description here...
	 *
	 * @return bool
	 */
	public function getSuccesStatus(){
		return $this->_success_status;

	}


	public $_data;



	public function setData($data,$field_name = null){
		if($field_name) $this->_data[$field_name] = $data;
		else $this->_data = $data;
		return $this;
	}
	public function getData($field_name = null){
		$return_value = null;

		if($field_name) $return_value = $this->_data[$field_name];
		else  $return_value = $this->_data;

		return $return_value;
	}


	//*****************//
	// vars for zde autocomplete=)
	// by matty =)
	//

	/**
	 * default object type
	 *
	 * @var Ui_Element
	 */
	//public $style;



	//
	//end
	//



	public static function setInstance(Std_Class $instance){



		//need late static binding =)
		//if(get_class($instance) != get_class()) throw new Class_Exception('class of given instance ('.get_class($instance).') not equal to '.get_class());

		/*$class = new ReflectionClass($this);
		$class_name = $class->getName()*/

		if (!self::$_instance) self::$_instance = new self();

		self::$_instance = $instance;

		return  self::$_instance;

	}

	/**
	 * @return Std_CLass
	 */
	public static function getInstance(){



		if (!self::$_instance) self::$_instance = new self();


		return  self::$_instance;

	}





	public function _set($var){

		$this->_vars[] = $var;
	}

	public function _get(){
		return $this->_vars;
	}

	public function setChildClassName($class_name){
		$this->_child_class_name = $class_name;
		return $this;
	}

	public function getChildClassName($class_name){
		return $this->_child_class_name;
	}

	public static function factory($name = null,$class_name = null){

		if(!$class_name) $class_name = 'Element';

		if($name) $class_name = $class_name.'_'.ucfirst($name);

		return new $class_name($name);



	}

	public function __construct($element_name = null,$registry_auto_set = false){
		$this->_name = $element_name;
		if($registry_auto_set){
			Registry::set($element_name,$this);
		}
		$this->onInit();

		return $this;

	}


	public function __destruct(){

		$this->onEnd();
	}

	public function onEnd(){

	}
	/**
	 * Enter description here...
	 *
	 * @param array $array
	 * @param string $class
	 * @return Std_Class
	 */
	public static function fromArray($array, $class = 'Std_Class',$obj = null){


		if($obj){

			$return_value = $obj;

		}else $return_value = new $class;

		foreach ($array as $el_string){

			if(count($sub_el_array = split('-',$el_string)) > 1){

				$param_el = $return_value->addElement($el_string);
				foreach ($sub_el_array as $sub_el_array_item){
					$param_el->addElement($sub_el_array_item)->setValue($sub_el_array_item);
				}




			}else 	$return_value->addElement($el_string)->setValue($el_string);

		}


		return $return_value;

	}

	/*public function fromString($string){



	}
	*/
	public function onInit(){


	}


	public function onDestroy(){


	}

	/**
	 * Enter description here...
	 *
	 * @param string  $type
	 * @return Element
	 */
	public function setType($type){
		$this->_type = $type;
		return $this;
	}


	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getType(){
		return $this->_type;
	}


	/**
	 * Enter description here...
	 *
	 * @param string  $type
	 * @return Element
	 */
	public function setClass($class){
		$this->_class = $class;
		return $this;
	}


	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getClass(){
		return $this->_class;
	}


	public function setParent($parent){
		$this->_parent = $parent;
		return $this;
	}
	public function getParent(){
		return $this->_parent;
	}






	public function setCurrentElement($name){



		$current_element = null;
		foreach ($this->_elements as $e){

			if(strtolower($e->getName()) == strtolower($name)) {
				$this->_current_element_name = $name;
				$this->_current_element = $e;

				break;
			}

		}
		return $this;

	}


	public function setCurrentElementClassName($class_name){

		$class_name_array = Std_Class::parseClassName($class_name);

		if(strtolower($class_name_array[0]) == 'menu' ) array_shift($class_name_array);
		if(strtolower($class_name_array[0]) == 'app' ) array_shift($class_name_array);

		$class_name_param = $class_name_array[0];
		$this->setCurrentElement($class_name_param);

		$current_element = $this->getCurrentElement();
		$current_element_name = $current_element->getName();

		if(isset($class_name_array[1]) && ( strtolower($current_element_name) == strtolower($class_name_param) )){


			//	check next current element ;DD
			array_shift($class_name_array);
			$class_name_shifted	= Std_Class::assembleClassName(null,$class_name_array);
			$current_element->setCurrentElementClassName($class_name_shifted);


		}


	}

	public function getCurrentElement(){
		/*@var $e Element*/


		if(!$this->_current_element) $this->_current_element = $this->_elements[0];
		return $this->_current_element;
	}

	/**
	 * Enter description here...
	 *
	 * @param string  $name
	 * @return Ui_Element
	 */
	public function setName($name){
		$this->_name = $name;
		return $this;
	}

	/**
	 * Enter description here...
	 *
	 * @param mixed $value
	 * @return Ui_Element
	 */
	public function setValue($value){
		$this->_value = $value;
		return $this;
	}


	public function setValue_by_reference(&$value){
		$this->_value = $value;
		return $this;
	}

	public function &getValue_by_reference(){
		return $this->_value;
	}


	public function getValue($param = null){

		$return_value = null;
		if(_is_array($this->_value) && $param){

			$return_value = $this->_value->findValue($param);
		}
		else {
			$return_value =  $this->_value;
		}


		return $return_value;
	}

	public function getValueString(){
		return (string) $this->getValue();
	}

	public function getValueInt(){
		$return_value = null;

		if(is_numeric($number = $this->getValueString())) {
			$return_value = (int) $number;
		}
		return $number;
	}


	public function getName(){
		return $this->_name;
	}


	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getClassName(){
		return $this->_class_name;
	}

	public function getCurrentClassName(){


		return get_class($this);
	}

	public function getCurrentClassNameLastElement(){

		$class_name = get_class($this);
		$class_name_array = Std_Class::parseClassName($class_name);
		$class_name_last_element = $class_name_array[count($class_name_array)-1];
		return $class_name_last_element;
	}

	/**
	 * Enter description here...
	 *
	 * @param string $class_name
	 */
	public function setClassName($class_name){
		$this->_class_name = $class_name;
		return $this;
	}

	public function getTitle(){
		return $this->_title;
	}


	/**
	 * Enter description here...
	 *
	 * @param string  $title
	 * @return Ui_Element
	 */
	public function setTitle($title){
		$this->_title = $title;
		return $this;
	}

	/**
	 * Enter description here...
	 *
	 * @return array
	 */
	public function getElements(){
		return $this->_elements;
	}


	public function removeElement($element_name){


		$new_elements = array();
		foreach ($this->_elements as $e){
			if($e->getName() != $element_name) $new_elements[] = $e;
		}
		$this->_elements = $new_elements;


	}




	/**
	 * Enter description here...
	 *
	 * @param Ui_Element $element = null | string element_name
	 * @return Element
	 */
	public function addElement($_element = null,$class = 'Std_Class'){



		if(is_string($_element) || !$_element){
			if($_element) $_element = str_replace('-','_',$_element);
			//$element = self::factory($_element,get_class($this));//

			if(is_string($class)) $element = new $class($_element);
			elseif (is_object($class)){
				$element = $class;
				$element->setName($_element);
			}else throw new Exception('wrong params for addElement');


		}
		elseif (is_subclass_of($_element,'Element') || get_class($_element) == 'Element') {
			$element = $_element;

		}
		else  throw new Exception('wrong type for '.$_element);


		$this->_elements[] = $element;

		return $element;


	}





	/**
	 * get field by name
	 *
	 * @param string $name | int $index 
	 * @return Element
	 */
	public function getElement($param,$field_name = 'name'){



		if(is_numeric($param)) $_arr = array('index'=>$param);
		elseif(is_string($param)) $_arr = array($field_name=>$param);
		else $_arr =& $param;

		return $this->searchElement($_arr);


	}


	public function getAction($name){

		$return_value = null;
		foreach ($this->_actions as $action){
			if($action->getName() == $name){
				$return_value = $action;
				break;
			}

		}

		return $return_value;

	}


	/**
	 * ..
	 *
	 * @return Element || NULL
	 */
	public function getFirstElement(){

		return $this->_elements[0];

	}

	/**
	 * ..
	 *
	 * @return Element || NULL
	 */
	public function getLastElement(){

		$return_value = null;

		if($count = count($this->_elements)){
			$return_value = $this->_elements[$count-1];
		}

		return $return_value;

	}


	/**
	 * ..
	 *
	 * @return Element || NULL
	 */
	public function searchElement($params){



		/*@var $f Ui_Element*/
		$search_result = null;

		$this->_search_element_index = null;
		//todo: make multiparams search


		$keys = array_keys($params);

		if($keys[0] == 'index'){
			$search_result = $this->_elements[$params[$keys[0]]];
			if($search_result) $this->_search_element_index = $params[$keys[0]];


		}else
		foreach ($this->_elements as $i => $e){



			if ($e->$keys[0] == $params[$keys[0]]) {
				$this->_search_element_index = $i;
				$search_result = $e;
				break;
			}

			/*
			foreach($params as  $param){

			if($e->$param[0] == $param[1]) {
			$search_result = $e;
			break;
			}
			}*/
		}
		return $search_result;

	}

	/*	public function getSearchElementIndex(){
	return $this->search_element_index;
	}*/

	public function __get($var_name)
	{

		if($var_name == 'style'){

			$dd = 'dd';
		}

		$return_value = null;

		if(preg_match("/^element_(.*)/",$var_name,$result)){
			$var_name = $result[1];
		}

		if(!preg_match('/^\_/',$var_name)) {
			$_var_name = '_'.$var_name;

			if(property_exists($this,$_var_name) && ($this->$_var_name !== NULL)){
				$return_value = $this->$_var_name;
			}else{

				if(!$return_value = $this->getElement($var_name)){
					//$return_value = new Std_Class();
					//$return_value = $this->addParam($var_name,$return_value);

				}
			}

		}



		return $return_value;
	}



	/**
	 * Enter description here...
	 *
	 * @param unknown_type $name
	 * @param unknown_type $value
	 * @return Std_Class
	 */
	public function addParam($name,$value){

		return $this->setProperty($name,$value);
	}
	public function setParam($name,$value){

		return $this->setProperty($name,$value);
	}

	public function getParam($name){

		return $this->getProperty($name);
	}


	public function getClassParam($name){

		return $this->getProperty($name);
	}

	public function setParams($params){

		foreach ($params as $key=>&$value){
			$this->addParam($key,$value);

		}

	}

	public function setVar($name,$value){

		return $this->setProperty($name,$value,true);
	}

	public function getVar($name){

		return $this->getProperty($name);
	}



	public function setProperty($name,$value,$_underline = true){
		if($_underline) $name = '_'.$name;
		$this->$name  = $value;
		return $this;

	}

	public function getProperty($name){
		$name = '_'.$name;
		return $this->$name;
	}

	public function setId($id){
		$this->_id = $id;
		return $this;
	}
	public function getId(){
		return $this->_id;
	}



	public function __toString(){
		return (string) $this->_value;
	}


	/* array access implementation */


	public function getIterator() {
		return new ArrayIterator($this->_elements);
	}


	public function hasElements(){
		$return_value = false;
		if(!empty($this->_elements)) $return_value = true;

		return $return_value;
	}


	public function getSearchElementIndex(){
		return $this->_search_element_index;

	}

	public function getParams() {
		$arr = get_object_vars($this);
		$new_arr = array();
		foreach ($arr as $key=>&$val){
			if(preg_match('/^_(.*)/',$key,$matches)){
				$new_arr[$matches[1]] = $val;
			}

		}

		return $new_arr;

	}

	public function getAllParam(){
		return $this->getParams();
	}



	//array access interface

	public function offsetSet($offset, $value) {

		if(is_a($value,'Element')){

			$el = $value;
		}else{
			$el = new Element();
			$el->setValue($value);
		}


		if (is_null($offset)) {
			$this->_elements[] = $el;
		} else {
			$this->_elements[$offset] = $value;
		}
	}
	public function offsetExists($offset) {
		return isset($this->_elements[$offset]);
	}
	public function offsetUnset($offset) {
		unset($this->_elements[$offset]);
	}
	public function offsetGet($offset) {
		return isset($this->_elements[$offset]) ? $this->_elements[$offset] : null;
	}



	public static function set($param_name,$value){

		self::getInstance()->setParam($param_name,$value);
	}

	/**
	 *  ...
	 *
	 * @param string $param_name
	 * @return Std_Class
	 */
	public static function get($param_name){
		return self::getInstance()->getParam($param_name);
	}



	//countable interface realization;

	public function count(){
		return count($this->_elements);
	}




	public function setVarsFromArray(array $arr)

	{

		foreach ($arr as $key => &$value){

			$this->setVar($key,$value);
		}

		return $this;


	}


	public function getElementsAsArray(){ //$is_associative = true,$include_values  = true

		$elements_array = array();

		foreach ($this->getElements() as $key=> $el){
			/*if($include_values){

			$value = $el->getValue();

			} else $value= $el->getName();*/
			$elements_array[] = $el->getName();


		}
		return $elements_array;
	}



	/*public function onSubmit(){

	$class_name =  get_class($this);
	$function_name = $class_name.'_onSubmit';
	call_user_func($function_name) ;

	}

	public function onLoad(){

	$class_name =  get_class($this);
	$function_name = $class_name.'_onLoad';
	call_user_func($function_name) ;


	//exit();


	}*/


	public function getParamInt($param_name){
		return (int) $this->getParam($param_name);
	}


	public function getFieldValue($field_name){
		return $this->_data[$field_name];
	}
}

?>