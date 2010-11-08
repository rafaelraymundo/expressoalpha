<?php
	
	if(!isset($GLOBALS['phpgw_info'])){
        	$GLOBALS['phpgw_info']['flags'] = array(
	                'currentapp' => 'agileProjects',
	                'nonavbar'   => true,
	                'noheader'   => true
	        );
	}
	require_once '../header.session.inc.php';

	$currentTab = $_GET['tabs'];
	switch($currentTab){
		case 'tabs-1': 
                        include_once('inc/class.uiprojects.inc.php');
                        $projectsGui = new uiprojects();
			echo $projectsGui->output;
		   break;

		case 'tabs-2':
                        include_once('inc/class.uibacklogs.inc.php');
                        $uibacklogs = new uibacklogs();
		   break;

		case 'tabs-3':
                        include_once('inc/class.uisprints.inc.php');
                        $sprintsGui = new uisprints();
                   break;

		case 'tabs-4':
			include_once('inc/class.uikanban.inc.php');
			$kanbanGui = new uikanban();
                   break;
	}
		if($_POST['type'] == 'project'){
			include_once('inc/class.soinsertElement.inc.php');
			$projectInsert = new soinsertElement();
			$projectInsert->soinsertProject(   $_POST['name'],
                                                          $_POST['description'],
                                                          $_POST['particArray'],
                                                          $_POST['adminArray']);
		}
		if($_POST['type'] == 'saveProject'){
                        include_once('inc/class.sosaveElement.inc.php');
                        $projectSave = new sosaveElement(   	$_POST['projId'],
								$_POST['name'],
                                                                $_POST['description'],
                                                                $_POST['particArray'],
                                                                $_POST['adminArray']);
                }	
		if($_POST['type'] == 'removeProject'){
			include_once('inc/class.soremoveElement.inc.php');
			$projectRemove = new soremoveElement();
			$projectRemove->soRemoveProject($_POST['projId']);
		}
		if($_POST['type'] == 'editProject'){
			include_once('inc/class.uiprojectEdit.inc.php');
			$projectEdit = new uiprojectEdit($_POST['projId']);
		}
                if($_GET['type'] == 'activeProject'){
			$_SESSION['phpgw_info']['expresso']['agileProjects']['active'] = $_GET['projId'];
                       // include_once('inc/class.uibacklogs.inc.php');
                       // $uibacklogs = new uibacklogs($_GET['projId']);
                }
                if($_GET['type'] == 'taskInclude'){
			include_once('inc/class.uitaskInclude.inc.php');
			$taskInclude = new uitaskInclude();
                }
		if($_POST['type'] == 'newTask'){
			system("echo \"TESTE\" >/tmp/control.txt");

			include_once('inc/class.soinsertElement.inc.php');
			$newTask = new soinsertElement();
			$newTask->soinsertTask(	 $_POST['sprint'],
						 $_POST['responsable'],
						 $_POST['title'],
						 $_POST['subtitle'],
						 $_POST['description']);
		}
		if($_POST['type'] == 'newSprint'){
			include_once('inc/class.soinsertElement.inc.php');
			$newSprint = new soinsertElement();
			$newSprint->soinsertSprint($_POST['name'],
                                                   $_POST['dt_start'],
                                                   $_POST['dt_end'],
                                                   $_POST['goal']);
		}
?>
