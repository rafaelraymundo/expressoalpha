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
						$sprintId = addslashes($_POST['sprintId']);
	
                        include_once('../phpgwapi/inc/class.db.inc.php');
    
                        $this->projRemove = $GLOBALS['phpgw']->db;

                        //Insere o projeto guardando seu ID
                        $this->projRemove->query("DELETE from phpgw_agile_sprints where sprints_id=$sprintId");
				}
				
        		public function soremoveTask($taskId){
						$sprintId = addslashes($_POST['taskId']);
	
                        include_once('../phpgwapi/inc/class.db.inc.php');
    
                        $this->projRemove = $GLOBALS['phpgw']->db;

                        //Insere o projeto guardando seu ID
                        $this->projRemove->query("DELETE from phpgw_agile_tasks where tasks_id=$taskId");
				}
				
	}
