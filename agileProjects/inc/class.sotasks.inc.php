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

        class sotasks{
                var $sprints_name;
                var $sprintsElements;
		var $sprintsIdElements;
		var $usersElements;
		var $user_id;
		var $tasks_info;
		var $tasksElements;
		var $update_bubble;
		var $sprints_id;

                function sotaskInclude(){
                        include_once('../phpgwapi/inc/class.db.inc.php');
                        include_once('inc/class.ldap_functions.inc.php');

                        $projId = $_SESSION['phpgw_info']['expresso']['agileProjects']['active'];

                        $this->sprints_name = $GLOBALS['phpgw']->db;
			$this->user_id = $GLOBALS['phpgw']->db;
                        
                        $list = new ldap_functions();

                        $this->sprints_name->query('SELECT sprints_name,sprints_id FROM phpgw_agile_sprints WHERE sprints_id_proj='.$projId,__LINE__,__FILE__);
                        if($this->sprints_name->num_rows()){
                                $i=0;
                                while($this->sprints_name->next_record())
                                {
                                        $this->sprintsElements['sprints_name'][$i] = $this->sprints_name->f('sprints_name');
					$this->sprintsIdElements['sprints_id'][$i] = $this->sprints_name->f('sprints_id');
                                        $i++;
                                }
                        }
			$this->user_id->query('SELECT DISTINCT uprojects_id_user FROM phpgw_agile_users_projects WHERE uprojects_id_project='.$projId,__LINE__,__FILE__);
			if($this->user_id->num_rows()){
				$i=0;
				while($this->user_id->next_record())
				{
					$this->usersElements['user_id'][$i] = $this->user_id->f('uprojects_id_user');
					$i++;
				}
			}
                }

		function sotasksKanban($idCol){
			include_once('../phpgwapi/inc/class.db.inc.php');
			
			$projId = $_SESSION['phpgw_info']['expresso']['agileProjects']['active'];

			//Inicialmente obter o ID do SprintAtivo nesse projeto para buscar suas tarefas
			$this->sprints_id=$GLOBALS['phpgw']->db;
			$this->sprints_id->query("SELECT sprints_id from phpgw_agile_sprints WHERE sprints_id_proj=$projId AND sprints_status='t'",__LINE__,__FILE__);
			while($this->sprints_id->next_record()){
				$sprintsIdElements[] = $this->sprints_id->f('sprints_id');
			}
			if (!$sprintsIdElements[0]){
				$sprintsIdElements[0]=0;
			}	
			//-------------------------SprintID encontrado---------------------------------

			$this->tasks_info = $GLOBALS['phpgw']->db;
			$this->tasks_info->query("SELECT tasks_id,tasks_id_owner,tasks_title,tasks_description from phpgw_agile_tasks WHERE tasks_id_proj=$projId AND tasks_status='$idCol' AND tasks_id_sprints=$sprintsIdElements[0]",__LINE__,__FILE__);
			if($this->tasks_info->num_rows()){
				$i=0;
				while($this->tasks_info->next_record()){
					$this->tasksElements['tasks_id'][$i] = $this->tasks_info->f('tasks_id');
					$this->tasksElements['tasks_id_owner'][$i] = $this->tasks_info->f('tasks_id_owner');
					$this->tasksElements['tasks_title'][$i] = $this->tasks_info->f('tasks_title');
					$this->tasksElements['tasks_description'][$i] = $this->tasks_info->f('tasks_description');
					$i++;
				}
			}
		}
		function soupdateBubble($tasks_id,$tasks_status){
			include_once('../phpgwapi/inc/class.db.inc.php');

			$this->update_bubble = $GLOBALS['phpgw']->db;
			$this->update_bubble->query("UPDATE phpgw_agile_tasks SET tasks_status = '$tasks_status' WHERE tasks_id = $tasks_id",__LINE__,__FILE__);
		}
        }
?>
