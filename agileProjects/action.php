<?php

header("Content-Type: text/html; charset=ISO-8859-1",true);

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
if($_POST['type'] == 'removeSprint'){
	include_once('inc/class.soremoveElement.inc.php');
	$projectRemove = new soremoveElement();
	$projectRemove->soremoveSprint($_POST['sprintId']);
}
if($_POST['type'] == 'removeTask'){
	include_once('inc/class.soremoveElement.inc.php');
	$projectRemove = new soremoveElement();
	$projectRemove->soremoveTask($_POST['taskId']);
}
if($_POST['type'] == 'editProject'){
	include_once('inc/class.uiprojectEdit.inc.php');
	$projectEdit = new uiprojectEdit($_POST['projId']);
}
if($_GET['type'] == 'activeProject'){
	$_SESSION['phpgw_info']['expresso']['agileProjects']['active'] = $_GET['projId'];
	$_SESSION['phpgw_info']['expresso']['agileProjects']['projectName'] = $_GET['projName'];
}
if($_GET['type'] == 'activeSprint'){
	include_once('inc/class.sosprints.inc.php');
	$sprintActive = new sosprints();
	$sprintActive->soactiveSprint($_GET['sprintId']);
}
if($_GET['type'] == 'taskInclude'){
	include_once('inc/class.uitaskInclude.inc.php');
	$taskInclude = new uitaskInclude($_GET['idTask']);
}
if($_POST['type'] == 'newTask'){
	include_once('inc/class.soinsertElement.inc.php');
	$newTask = new soinsertElement();
	$newTask->soinsertTask(	 $_POST['sprint'],
	$_POST['important'],
	$_POST['responsable'],
	$_POST['title'],
	$_POST['description'],
	$_POST['estimate'],
	$_POST['taskId']);
}
if($_POST['type'] == 'newSprint'){
	include_once('inc/class.soinsertElement.inc.php');
	$newSprint = new soinsertElement();
	$newSprint->soinsertSprint($_POST['name'],
	$_POST['dt_start'],
	$_POST['dt_end'],
	$_POST['goal']);
}
if($_GET['type'] == 'updateBubble'){
	include_once('inc/class.sotasks.inc.php');
	$sotasks = new sotasks();
	$sotasks->soupdateBubble($_GET['tasks_id'],
	$_GET['tasks_status']
	);
		
}
?>
