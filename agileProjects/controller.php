<?php
if(!isset($GLOBALS['phpgw_info'])){
        $GLOBALS['phpgw_info']['flags'] = array(
                'currentapp' => 'agileProjects',
                'nonavbar'   => true,
                'noheader'   => true
        );
}
require_once '../header.session.inc.php';

	//	Explode action from cExecuteForm function
	$cExecuteFormReturn = false;
 	if( isset( $_POST['_action'] ) ) { 		
 		if($_FILES) {
 			$count_files = $_POST['countFiles'];
			$array_files = array(); 		
 			for($idx = 1; $idx <= $count_files; $idx++) { 		
 				if($_FILES['file_'.$idx] && !$_FILES['file_'.$idx]['error'])
 					$array_files[] = $_FILES['file_'.$idx]; 					 
 			}
 			$_POST['FILES'] = $array_files;
 		} 		  		
 		list($app,$class,$method) = explode('.',@$_POST['_action']);
 		$cExecuteFormReturn = true;
 	}
 		//	Explode action from cExecute function
 	else if($_GET['action'])
		list($app,$class,$method) = explode('.',@$_GET['action']);
	// NO ACTION
	else
		return $_SESSION['response'] = 'Post-Content-Length';
		
	
	
	// Load dinamically class file.
	if($app == '$this')
		$filename = 'inc/class.'.$class.'.inc.php';
	else
		$filename = '../'.$app.'/inc/class.'.$class.'.inc.php';
		
	include_once($filename);	
	
	// Create new Object  (class loaded).	
	$obj = new $class;
	
	// Prepare parameters for execution.	
	$params = array();
	
	// If array $_POST is not null , the submit method is POST. 
	if($_POST) {
		$params = $_POST;
	}
	// If array $_POST is null , and the array $_GET > 1, the submit method is GET.
	else if(count($_GET) > 1)	{		
		array_shift($_GET);
		$params = $_GET;
	}

	$result = array();
	
	
	// if params is not empty, then class method with parameters.	
	if($params)
		$result = $obj -> $method($params);
	else 		
		$result = $obj -> $method();
		
	// Return result serialized.	
	
		
	if(isset($_GET['noexecute'])){
 		echo $result;
 		return;
 	}

	if(!$cExecuteFormReturn){
		echo serialize($result);
	}
	else{
		$_SESSION['response'] = $result;
	}
?>
