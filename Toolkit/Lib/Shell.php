<?php
/*
 * Radmaster Toolkit
 * 
 * THIS FILE IS (inc. PUBLISHED) UNDER RADMASTER LICENSE (RML)  
 * "Hytex Solutions Limited" @ Minsk / BY (2000-2019)
 * http://hytex.radmaster.net
 * 
 */ 


define('PATH_APP',PATH_ROOT.'/App');

require_once('_include.php');

require_once(PATH_RADMASTER_LIBRARY.'/Registry.php');

$registry = Registry::getInstance();

$console = Sys_Shell_Console::start();


$console->showWelcomeMessage()->newLine();

while(true){

	//$console->output('test!test!test');

	$input_string = trim($console->input($console->getCommandPromptString()));

//	$console->output('your input:')->output($input_string);;

	if($input_string == 'app'){

		
		require_once('z:/web-server-root/cms/index.php');
		
		$app_output = _run_test();
		$console->output($app_output);
		
	}elseif ($input_string == 'dir'){
		
	//	require_once('')
		//$app = new 
		
	}
	else if($input_string == 'exit') {
		
		$console->newLine()->output('.. exiting ..');
		break;
	}else {
		
		$console->output('command not found');
		
	}



}

?>