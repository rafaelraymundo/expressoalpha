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

        class sosaveElement{

                var $db;
                var $save_projects;
		var $save_partic;
		var $save_admin;
		var $delOldies;

                public function sosaveElement($projId,$name,$description,$particArray,$adminArray){
                        include_once('../phpgwapi/inc/class.db.inc.php');
		
			$particArray = unserialize($particArray);
			$adminArray = unserialize($adminArray);

			$numPartic = count($particArray);
                        $numAdmin = count($adminArray);

                        $this->save_projects = $GLOBALS['phpgw']->db;
			$this->save_partic = $GLOBALS['phpgw']->db;
			$this->save_admin = $GLOBALS['phpgw']->db;
			$this->delOldies = $GLOBALS['phpgw']->db;

			//Insere o projeto guardando seu ID
		//TODO: Fazer como UPDATE
			$delete = $this->delOldies->query('DELETE from phpgw_agile_users_projects WHERE uprojects_id_project=\''.$projId.'\'',__LINE__,__FILE__);
		
			//Realizando UPDATE da table phpgw_agile_projects
			$update_projects = $this->save_projects->query('UPDATE phpgw_agile_projects SET proj_name = \''.$name.'\', proj_description = \''.$description.'\' WHERE proj_id=\''.$projId.'\'',__LINE__,__FILE__);
			
			//Insere os usuarios participantes e posteriormente os administradores
			for($i=0;$i<$numPartic;$i++){
				$this->save_partic->query('INSERT INTO phpgw_agile_users_projects(uprojects_id_user, uprojects_id_project,uprojects_user_admin,uprojects_active) VALUES(\''.$particArray[$i].'\',\''.$projId.'\',FALSE,FALSE)',__LINE__,__FILE__);
			}
			for($i=0;$i<$numAdmin;$i++){
                                $this->save_admin->query('INSERT INTO phpgw_agile_users_projects(uprojects_id_user, uprojects_id_project,uprojects_user_admin,uprojects_active) VALUES(\''.$adminArray[$i].'\',\''.$projId.'\',TRUE,FALSE)',__LINE__,__FILE__);
                        }
	
		}
	}
?>
