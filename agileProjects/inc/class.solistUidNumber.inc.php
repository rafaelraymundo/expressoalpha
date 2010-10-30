<?php
        /************************************************************************************************\
        *  Gerencia de projetos ageis                                                                   *
        *  by Rafael Raymundo da Silva (rafael.silva@serpro.gov.br, rafael2000@gmail.com)               *
        * ----------------------------------------------------------------------------------------------*
        *  This program is free software; you can redistribute it and/or modify it                      *
        *  under the terms of the GNU General Public License as published by the                        *
        *  Free Software Foundation; either version 2 of the License, or (at your                       *
        *  option) any later version.                                                                   *
        \***********************************************************************************************/

        class listUidNumber{

                var $db;
                var $projId;
                var $result;
                var $nameDesc;
                var $usrProj;

                function list_users_projects(){
                        include_once('../phpgwapi/inc/class.db.inc.php');
                        $this->result = $GLOBALS['phpgw']->db;
                        $this->result->query('SELECT * FROM phpgw_agile_projects',__LINE__,__FILE__);
                        if($this->result->num_rows())
                        {
                                $i=0;
                                while ($this->result->next_record())
                                {
                                        $this->projId[$i] = array($this->result->f('proj_id'));
                                        $this->db[$i] = array(
                                                $this->result->f('proj_name'), 
                                                $this->result->f('proj_owner'),
                                                $this->result->f('proj_description'));
                                                //print_r($this->db);
                                        $i++;
                                }
    
                        }
		}
}
