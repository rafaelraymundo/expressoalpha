<?php
        /************************************************************************************************\
        *  Gerencia de projetos ageis                                                                   *
        *  by Rafael Raymundo da Silva rafael2000@gmail.com)  					        *
        * ----------------------------------------------------------------------------------------------*
        *  This program is free software; you can redistribute it and/or modify it                      *
        *  under the terms of the GNU General Public License as published by the                        *
        *  Free Software Foundation; either version 2 of the License, or (at your                       *
        *  option) any later version.                                                                   *
        \***********************************************************************************************/

include_once('../header.inc.php');

        class soeditElement{

		//var $db;
                var $projId;
                var $resultNameDesc;
		var $resultProjDesc;
		var $resultUidNumber;
		var $resultUserAdmin;
		var $nameDesc;
		var $usrProj;
		var $usrTasks;
		var $resultTasks;

                public function soeditProject(){
                        include_once('../phpgwapi/inc/class.db.inc.php');
                        $projId = addslashes($_POST['projId']);
			$this->nameDesc = $GLOBALS['phpgw']->db;
			$this->usrProj = $GLOBALS['phpgw']->db;
			$this->usrTasks = $GLOBALS['phpgw']->db;

			$this->nameDesc->query('SELECT proj_name, proj_description FROM phpgw_agile_projects WHERE proj_id='.$projId,__LINE__,__FILE__);
			while($this->nameDesc->next_record())
                        {
                                $this->resultNameDesc = $this->nameDesc->f('proj_name');
				$this->resultProjDesc = $this->nameDesc->f('proj_description');
                        }
			$this->usrProj->query('SELECT uprojects_id_user,uprojects_user_admin FROM phpgw_agile_users_projects WHERE uprojects_id_project='.$projId,__LINE__,__FILE__);
			while($this->usrProj->next_record())
                        {
                             $this->resultUidNumber[] = $this->usrProj->f('uprojects_id_user');
                             $this->resultUserAdmin[] = $this->usrProj->f('uprojects_user_admin');
                        }
			$this->usrTasks->query('SELECT tasks_id_owner from phpgw_agile_tasks WHERE tasks_id_proj='.$projId,__LINE__,__FILE__);
			while($this->usrTasks->next_record())
			{
				$this->resultTasks[] = $this->usrTasks->f('tasks_id_owner');
			}
			
			
		//	print_r($this->resultUidNumber);
		//	print_r($this->resultUserAdmin);
		}//End soeditProject
	}//End Class soEditElement
?>
