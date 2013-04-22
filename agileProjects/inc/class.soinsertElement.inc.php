<?php
/************************************************************************************************\
 *  Gerencia de projetos ageis                                                                   *
 *  by Rafael Raymundo da Silva (rafael2000@gmail.com)  						*
 * ----------------------------------------------------------------------------------------------*
 *  This program is free software; you can redistribute it and/or modify it                      *
 *  under the terms of the GNU General Public License as published by the                        *
 *  Free Software Foundation; either version 2 of the License, or (at your                       *
 *  option) any later version.                                                                   *
 \***********************************************************************************************/
include_once('../header.inc.php');

class soinsertElement{

	var $db;
	var $insert_projects;
	var $insert_partic;
	var $insert_admin;
	var $insert_sprint;
	var $insert_task;

	public function soinsertProject($name,$description,$particArray,$adminArray){
		include_once('../phpgwapi/inc/class.db.inc.php');

		$particArray = unserialize($particArray);
		$adminArray = unserialize($adminArray);

		$numPartic = count($particArray);
		$numAdmin = count($adminArray);
		
		$name = utf8_decode($name);
		$description = utf8_decode($description);

		$this->insert_projects = $GLOBALS['phpgw']->db;
		$this->insert_partic = $GLOBALS['phpgw']->db;
		$this->insert_admin = $GLOBALS['phpgw']->db;

		//Insere o projeto guardando seu ID
		$proj_id = $this->insert_projects->query('INSERT INTO phpgw_agile_projects(proj_name,proj_description,proj_owner) VALUES(\''.$name.'\',\''.$description.'\',\''.$_SESSION['phpgw_info']['expresso']['user']['userid'].'\') RETURNING proj_id',__LINE__,__FILE__);
		$proj_id=substr($proj_id, 7);
			
		//Insere os usuarios participantes e posteriormente os administradores
		for($i=0;$i<$numPartic;$i++){
			$this->insert_partic->query('INSERT INTO phpgw_agile_users_projects(uprojects_id_user, uprojects_id_project,uprojects_user_admin,uprojects_active) VALUES(\''.$particArray[$i].'\',\''.$proj_id.'\',FALSE,FALSE)',__LINE__,__FILE__);
		}
		for($i=0;$i<$numAdmin;$i++){
			$this->insert_admin->query('INSERT INTO phpgw_agile_users_projects(uprojects_id_user, uprojects_id_project,uprojects_user_admin,uprojects_active) VALUES(\''.$adminArray[$i].'\',\''.$proj_id.'\',TRUE,FALSE)',__LINE__,__FILE__);
		}
	}

	public function soinsertSprint($name,$dt_start,$dt_end,$goal){
		include_once('../phpgwapi/inc/class.db.inc.php');
		$this->insert_sprint = $GLOBALS['phpgw']->db;
		
		$name = utf8_decode($name);
		$goal = utf8_decode($goal);

		
		$errors = false;
		
		$dIni =    split ('[/.-]', $dt_start);
		$dFim =    split ('[/.-]', $dt_end);
		
		if(trim($name)==""){
			echo "- Nome do Sprint deve ser informado\n";
			$errors = true;
		}
		
		
		
		if(trim($dt_start)==""){
			echo "- Data inicial deve ser informada\n";
			$errors = true;
		}
		
		if(trim($dt_start)!=""&&(count($dIni)<3||!checkdate($dIni[1], $dIni[0], $dIni[2]))){
			echo "- Data inicial inválida\n";
			$errors = true;
		}
		
		if(trim($dt_end)==""){
			echo "- Data final deve ser informada\n";
			$errors = true;
		}
		
		if(trim($dt_end)!=""&&(count($dFim)<3||!checkdate($dFim[1], $dFim[0], $dFim[2]))){
			echo "- Data final inválida\n";
			$errors = true;
		}
		
		if(trim($goal)==""){
			echo "- Meta do Sprint deve ser informado\n";
			$errors = true;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		if($errors){
			return;
		}
		
		$dIni = $dIni[2]."-".$dIni[1]."-".$dIni[0];
		$dFim = $dFim[2]."-".$dFim[1]."-".$dFim[0];
		
		
		
		//Insere o sprint
		$sprint_insert = $this->insert_sprint->query('INSERT INTO phpgw_agile_sprints(sprints_id_proj, sprints_name, sprints_dt_start, sprints_dt_end, sprints_goal) VALUES(\''.$_SESSION['phpgw_info']['expresso']['agileProjects']['active'].'\',\''.$name.'\',\''.$dIni.'\',\''.$dFim.'\', \''.$goal.'\')',__LINE__,__FILE__);
	}

	public function soinsertTask($sprint,$priority,$responsable,$title,$description,$estimate){
		//system("echo $sprint >/tmp/control.txt");
		include_once('../phpgwapi/inc/class.db.inc.php');
		 
		if($priority != 'true'){
			$priority = 'f';
		}
		else{
			$priority = 't';
		}
		
		$error = false;
		
		if($sprint==""||$sprint==0){
			echo "- A Tarefa deve ser associada a um Sprint\n";
			$error = true;
		}
		
		if(trim($title)==""){
			echo "- O Título da tarefa é obrigatório\n";
			$error = true;
		}
		
		if(trim($estimate)==""){
			echo "- Estimativa deve ser informada\n";
			$error = true;
		}else{
			if(!is_numeric($estimate)){
				echo "- Estimativa deve ser númerica\n";
				$error = true;
			}
		}
		
		if($error){
			return;
		}

		$this->insert_task = $GLOBALS['phpgw']->db;
		
		$title = utf8_decode($title);
		$description = utf8_decode($description);

		//Insere a tarefa
		$task_insert = $this->insert_task->query('INSERT INTO phpgw_agile_tasks(tasks_id_sprints,tasks_priority, tasks_id_proj, tasks_id_owner, tasks_title, tasks_description, tasks_status, tasks_estimate) VALUES('.$sprint.',\''.$priority.'\','.$_SESSION['phpgw_info']['expresso']['agileProjects']['active'].','.$responsable.',\''.$title.'\',\''.$description.'\',\'sprintBacklog\','.$estimate.');',__LINE__,__FILE__);
	}
}
?>
