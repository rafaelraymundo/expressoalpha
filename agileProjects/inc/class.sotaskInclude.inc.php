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
                var $sprint_name;
                var $sprintsElements;
    

                function sotaskInclude(){
                        include_once('../phpgwapi/inc/class.db.inc.php');
                        include_once('inc/class.ldap_functions.inc.php');

                        $projId = $_SESSION['phpgw_info']['expresso']['agileProjects']['active'];

                        $this->sprint_name = $GLOBALS['phpgw']->db;
                        
                        $list = new ldap_functions();

                        $this->sprint_name->query('SELECT sprint_name FROM phpgw_agile_sprints WHERE sprints_id_proj='.$projId,__LINE__,__FILE__);
                        if($this->sprint_name->num_rows()){
                                $i=0;
                                while($this->sprint_name->next_record())
                                {
                                        $this->sprintsElements['sprint_name'][$i] = $this->sprint_name->f('sprint_name');
                                        $i++;
                                }
                        }
                }
        }
?>
