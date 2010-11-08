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


        class sotaskInclude{
                var $sprints_name;
                var $sprintsElements;
		var $sprintsIdElements;
		var $usersElements;
		var $user_id;
    

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
			
/*$t=count($this->sprintsElements['sprints_name']);
echo ($t);
print_r($this->sprintsElements);
*/
                }
        }
?>
