<?php
/*
 * Radmaster Toolkit
 * 
 * THIS FILE IS (inc. PUBLISHED) UNDER RADMASTER LICENSE (RML)  
 * "Hytex Solutions Limited" @ Minsk / BY (2000-2019)
 * http://hytex.radmaster.net
 * 
 */ 


class Sys_Shell_Console extends Std_Class{

	static $_command_promt_prefix = "R-Shell >>: ";

	static $_command_prompt_new_line = "\n";


	static $_console;

	protected $_log_in;
	protected $_log_out;


	protected $_handle_in;
	protected $_handle_out;



	public function onInit(){

		$this->_handle_in = fopen ("php://stdin","r");
		$this->_handle_out = fopen('php://stdout', 'w');

		$this->_log_in = new Std_Class();
		$this->_log_out = new Std_Class();

	}

	protected  function logMessage(){

	}


	/**
	 * Enter description here...
	 *
	 * @param unknown_type $params
	 * @return Sys_Shell_Console
	 */
	public static function start($params = null){

		if(!self::$_console)
		{
			$console = new Sys_Shell_Console();
			self::$_console = $console;
		}

		return self::$_console;
	}

	public static function getConsole(){
		return self::$_console;
	}

	/**
	 * Enter description here...
	 *
	 * @return Sys_Shell_Console
	 */
	public function showWelcomeMessage(){

		$this->cleanScrean();
		$this->newLine();
		$this->newLine();
		$this->output('********************************** ')->newLine();
		$this->output('***                            *** ')->newLine();
		$this->output('*** Welcome to Radmaster-Shell *** ')->newLine();
		$this->output('***                            *** ')->newLine();
		$this->output('********************************** ')->newLine();
		$this->newLine();
		$this->newLine();
		return $this;

	}


	/**
	 * Enter description here...
	 *
	 * @return Sys_Shell_Console
	 */
	public function showCommandPrompt(){

		return $this->output(Sys_Shell_Console::$_command_promt_prefix);
	}

	public function getCommandPromptString(){

		return Sys_Shell_Console::$_command_promt_prefix;
	}


	/**
	 * Enter description here...
	 *
	 * @return Sys_Shell_Console
	 */
	public function cleanScrean(){
		//system('cls');
		return $this;
		//return $this->output($clear_screen_string);

	}
	/**
	 * Enter description here...
	 *
	 * @return Sys_Shell_Console
	 */
	public function newLine(){

		return $this->output("\r\n");//Sys_Shell_Console::$_command_prompt_new_line);
	}

	public function input($message = null){

		$this->newLine();
		if($message) $this->output($message);
		$line = fgets($this->_handle_in);
		//$line = 'eded';
		return $line;

	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $string
	 * @return Sys_Shell_Console
	 */
	public function output($string){

		fwrite($this->_handle_out,$string);
		return $this;

	}

	public function onNewLine(){
		//readn
	}


}

?>