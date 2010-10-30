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


	class sobacklogs{
		var $tasks_owner;
		var $tasks_title;
		var $tasks_subtitle;
		var $tasks_description;
		var $tasks_status;
		
		var $tasks;
		var $tasksElements;
		

		function sobacklogs(){
			include_once('../phpgwapi/inc/class.db.inc.php');
			include_once('inc/class.ldap_functions.inc.php');

			$projId = $_SESSION['phpgw_info']['expresso']['agileProjects']['active'];

			$this->tasks_owner = $GLOBALS['phpgw']->db;
                        $this->tasks_title = $GLOBALS['phpgw']->db;
                        $this->tasks_subtitle = $GLOBALS['phpgw']->db;
                        $this->tasks_description = $GLOBALS['phpgw']->db;
                        $this->tasks_status = $GLOBALS['phpgw']->db;

			$this->tasks = $GLOBALS['phpgw']->db;
			$list = new ldap_functions();

			$this->tasks->query('SELECT * FROM phpgw_agile_tasks WHERE tasks_id_proj='.$projId,__LINE__,__FILE__);
			if($this->tasks->num_rows()){
				$i=0;
				while($this->tasks->next_record())
        	                {
					$this->tasksElements['tasks_owner'][$i] = $list->uidnumber2cn($this->tasks->f('tasks_id_owner'));
					$this->tasksElements['tasks_title'][$i] = $this->tasks->f('tasks_title');
					$this->tasksElements['tasks_subtitle'][$i] = $this->tasks->f('tasks_subtitle');
					$this->tasksElements['tasks_description'][$i] = $this->tasks->f('tasks_description');
					$this->tasksElements['tasks_status'][$i] = $this->tasks->f('tasks_status');
					$i++;
				}
			}
		}
	}
