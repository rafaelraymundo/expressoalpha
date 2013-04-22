<?php
/************************************************************************************************\
 *  Gerencia de projetos ageis                                                                   *
 *  by Rafael Raymundo da Silva (rafael2000@gmail.com)                                           *
 * ----------------------------------------------------------------------------------------------*
 *  This program is free software; you can redistribute it and/or modify it                      *
 *  under the terms of the GNU General Public License as published by the                        *
 *  Free Software Foundation; either version 2 of the License, or (at your                       *
 *  option) any later version.                                                                   *
 \***********************************************************************************************/
include_once('../header.inc.php');

class soremoveElement{

	var $db;
	var $projRemove;

	public function soremoveProject($projId){
		$projId = addslashes($_POST['projId']);

		include_once('../phpgwapi/inc/class.db.inc.php');

		$this->projRemove = $GLOBALS['phpgw']->db;

		//Insere o projeto guardando seu ID
		$this->projRemove->query("DELETE from phpgw_agile_projects where proj_id=$projId");
	}


	public function soremoveSprint($sprintId){

		include_once('../phpgwapi/inc/class.db.inc.php');
		include_once('inc/class.ldap_functions.inc.php');

		$sprintId = addslashes($_POST['sprintId']);
		$userId = addslashes($_POST['id_usr']);

		$ldap = new ldap_functions();

		$uid = $ldap->uidnumber2uid($userId);


		$streamExpresso = $GLOBALS['phpgw']->db;

		$sql = "SELECT up.* FROM phpgw_agile_users_projects up, phpgw_agile_sprints sp".
								" where  up.uprojects_id_user = '".$userId."' and sp.sprints_id = ".$sprintId." and up.uprojects_id_project = sp.sprints_id_proj";

		$canExclude = false;

		$streamExpresso->query($sql,__LINE__,__FILE__);
		if($streamExpresso->num_rows() > 0)
		{
			while($streamExpresso->next_record()){
				if( $streamExpresso->f('uprojects_user_admin')=="t"){
					$canExclude = true;
				}
			}
		}

		$stream2 = $GLOBALS['phpgw']->db;
		$sql2 = "SELECT p.proj_owner as proj_owner FROM phpgw_agile_sprints sp, phpgw_agile_projects p ".
				"where sp.sprints_id = ".$sprintId." and p.proj_id = sp.sprints_id_proj";
		$stream2->query($sql2,__LINE__,__FILE__);
		if($stream2->num_rows() > 0)
		{
			$stream2->next_record();
			if( $streamExpresso->f('proj_owner')==$uid){
				$canExclude = true;
			}
		}


		if(!$canExclude){
			echo "0";
			return;
		}

		$this->projRemove = $GLOBALS['phpgw']->db;
		//Insere o projeto guardando seu ID
		$this->projRemove->query("DELETE from phpgw_agile_sprints where sprints_id=$sprintId");
		echo "1";
	}





	public function soremoveTask($taskId){
		$sprintId = addslashes($_POST['taskId']);
		$userId = addslashes($_POST['id_usr']);

		include_once('../phpgwapi/inc/class.db.inc.php');
		include_once('inc/class.ldap_functions.inc.php');

		
		$ldap = new ldap_functions();
		$uid = $ldap->uidnumber2uid($userId);

		$streamExpresso = $GLOBALS['phpgw']->db;

		$sql = "SELECT up.* FROM phpgw_agile_tasks t, phpgw_agile_users_projects up ".
 			   "where  up.uprojects_id_user = '".$userId."' and t.tasks_id = ".$taskId." and up.uprojects_id_project = t.tasks_id_proj";

		$canExclude = false;
		$streamExpresso->query($sql,__LINE__,__FILE__);
		if($streamExpresso->num_rows() > 0)
		{
			while($streamExpresso->next_record()){
				if( $streamExpresso->f('uprojects_user_admin')=="t"){
					$canExclude = true;
				}
			}
		}

		$stream2 = $GLOBALS['phpgw']->db;
		$sql2 = "SELECT p.proj_owner as proj_owner FROM phpgw_agile_tasks t, phpgw_agile_projects p  ".
				"where t.tasks_id = ".$taskId." and p.proj_id = t.tasks_id_proj";
		$stream2->query($sql2,__LINE__,__FILE__);
		if($stream2->num_rows() > 0)
		{
			$stream2->next_record();
			if( $streamExpresso->f('proj_owner')==$uid){
				$canExclude = true;
			}
		}


		if(!$canExclude){
			echo "0";
			return;
		}

		$this->projRemove = $GLOBALS['phpgw']->db;
		//Insere o projeto guardando seu ID
		$this->projRemove->query("DELETE from phpgw_agile_tasks where tasks_id=$taskId");
		echo "1";
	}

}
