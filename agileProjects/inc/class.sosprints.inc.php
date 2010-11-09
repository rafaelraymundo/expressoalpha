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


        class sosprints{
                var $sprints_name;
                var $sprints_goal;
                var $sprints_dt_start;
                var $sprints_dt_end;
                var $sprints_retrospective;
    
                var $sprints;
                var $sprintsElements;
		var $sprintActive;
    

                function sosprintsList(){
                        include_once('../phpgwapi/inc/class.db.inc.php');
                        include_once('inc/class.ldap_functions.inc.php');

                        $projId = $_SESSION['phpgw_info']['expresso']['agileProjects']['active'];

                        $this->sprints_name = $GLOBALS['phpgw']->db;
                        $this->sprints_goal = $GLOBALS['phpgw']->db;
                        $this->sprints_dt_start = $GLOBALS['phpgw']->db;
                        $this->sprints_dt_end = $GLOBALS['phpgw']->db;
                        $this->sprints_retrospective = $GLOBALS['phpgw']->db;

                        $this->sprints = $GLOBALS['phpgw']->db;
                        $list = new ldap_functions();

                        $this->sprints->query('SELECT * FROM phpgw_agile_sprints WHERE sprints_id_proj='.$projId.' ORDER BY sprints_status DESC',__LINE__,__FILE__);
                        if($this->sprints->num_rows()){
                                $i=0;
                                while($this->sprints->next_record())
                                {
					$this->sprintsElements['sprints_id'][$i] = $this->sprints->f('sprints_id');
                                        $this->sprintsElements['sprints_name'][$i] = $this->sprints->f('sprints_name');
                                        $this->sprintsElements['sprints_goal'][$i] = $this->sprints->f('sprints_goal');
                                        $this->sprintsElements['sprints_dt_start'][$i] = $this->sprints->f('sprints_dt_start');
                                        $this->sprintsElements['sprints_dt_end'][$i] = $this->sprints->f('sprints_dt_end');
                                        $this->sprintsElements['sprints_retrospective'][$i] = $this->sprints->f('sprints_retrospective');
					$this->sprintsElements['sprints_status'][$i] = $this->sprints->f('sprints_status');
                                        $i++;
                                }
                        }
		}
			function soactiveSprint($sprintId){
				include_once('../header.inc.php');
				include_once('../phpgwapi/inc/class.db.inc.php');
				include_once('inc/class.ldap_functions.inc.php');

				$projId = $_SESSION['phpgw_info']['expresso']['agileProjects']['active'];

				$this->sprintActive = $GLOBALS['phpgw']->db;

				$this->sprintActive->query('UPDATE phpgw_agile_sprints SET sprints_status=false WHERE sprints_id_proj='.$projId,__LINE__,__FILE__);
				$this->sprintActive->query('UPDATE phpgw_agile_sprints SET sprints_status=true WHERE sprints_id_proj='.$projId.' AND sprints_id='.$sprintId,__LINE__,__FILE__);	
			}
        }
