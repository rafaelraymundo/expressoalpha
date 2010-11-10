<?php
        /************************************************************************************************\
        *  Gerencia de projetos ageis                                                                   *
        *  by Rafael Raymundo da Silva (rafael2000@gmail.com)               				*
        * ----------------------------------------------------------------------------------------------*
        *  This program is free software; you can redistribute it and/or modify it                      *
        *  under the terms of the GNU General Public License as published by the                        *
        *  Free Software Foundation; either version 2 of the License, or (at your                       *
        *  option) any later version.                                                                   *
        \***********************************************************************************************/

        class solists{

                var $db;
		var $projId;
		var $result;
		var $nameDesc;
		var $usrProj;

                public function solists(){
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

		public function soeditProject($projId){
			include_once('../header.inc.php');
                        include_once('../phpgwapi/inc/class.db.inc.php');
    
                        $projId = addslashes($projId);

                        $this->nameDesc = $GLOBALS['phpgw']->db;
                        $this->usrProj = $GLOBALS['phpgw']->db;

                        $this->nameDesc->query("SELECT proj_name, proj_description FROM phpgw_agile_projects WHERE proj_id=$projId",__LINE__,__FILE__);
                        $this->usrProj->query("SELECT * FROM phpgw_agile_users_projects WHERE proj_id=$projId",__LINE__,__FILE__);
		}

	    function quicksearch($params)
            {
                include_once("class.functions.inc.php");
                $functions = new functions;

                $search_for     = utf8_encode($params['search_for']);
                $field          = $params['field'];
                $ID                     = $params['ID'];

                $search_for     = explode(" ",$search_for);
                $aux="";
                foreach ($search_for as $search)
                {
                        if(!$aux)
                        {
                                $aux=$search;
                        }
                        else
                        {
                                if (strlen($search) > 2)
                                {
                                        $aux=$aux."*".$search;
                                }
                                else
                                {
                                        $aux=$aux." ".$search;
                                }
                        }
                }
                $search_for=$aux;

                $contacts_result = array();
                $contacts_result['field'] = $field;
                $contacts_result['ID'] = $ID;

                // follow the referral
                $this->ldapConnect(true);

		if ($this->ds)
                {
                        if (($field != 'null') && ($ID != 'null'))
                        {
                                $filter="(& (&(|(phpgwAccountType=u)(phpgwAccountType=g)(phpgwAccountType=l)(phpgwAccountType=i)(phpgwAccountType=s))(mail=*)) (|(cn=*$search_for*)(mail=*$search_for*)) (!(phpgwaccountvisible=-1)) )";
                                $justthese = array("cn", "mail", "telephoneNumber", "mobile", "phpgwAccountVisible", "uid", "employeeNumber", "ou");
                        }
                        else
                        {
                                $filter="(& (phpgwAccountType=u)(cn=*$search_for*) (!(phpgwaccountvisible=-1)) )";
                                $justthese = array("cn", "mail", "telephoneNumber", "mobile", "phpgwAccountVisible","jpegPhoto", "uid", "employeeNumber", "ou");
                        }
                        $sr=@ldap_search($this->ds, $this->ldap_context, $filter, $justthese, 0, $this->max_result + 1);
                        if(!$sr)
                                return null;
                        $count_entries = ldap_count_entries($this->ds,$sr);

                        // Get user org dn.
                        $user_dn = $_SESSION['phpgw_info']['expressomail']['user']['account_dn'];
                        $user_sector_dn = ldap_explode_dn ( $user_dn, false );
                        array_shift($user_sector_dn);
                        array_shift($user_sector_dn);
                        $user_sector_dn = implode(",", $user_sector_dn);

                        // New search only on user sector
                        if ($count_entries > $this->max_result)
                        {
                                // Close old ldap conection
                                ldap_close($this->ds);

                                // Reopen a local ldap connection, following referral
                                $this->ldapRootConnect(true);

                                $sr= ldap_search($this->ds, $user_sector_dn, $filter, $justthese);
                                if(!$sr)
                                        return null;
                                $count_entries = ldap_count_entries($this->ds,$sr);

				if ($count_entries > $this->max_result){
                                        $return = array();
                                        $return['status'] = false;
                                        $return['error'] = "many results";
                                        return $return;
                                }
                                else
                                {
                                        $quickSearch_only_in_userSector = true;
                                }
                        }

                        $info = ldap_get_entries($this->ds, $sr);

                        $tmp = array();
                        $tmp_users_from_user_org = array();

                        if (!$quickSearch_only_in_userSector) {
                                $catalogsNum=count($this->external_srcs);
                                for ($i=0; $i<=count($this->external_srcs); $i++)       {
                                        if ($this->external_srcs[$i]["quicksearch"]) {
                                                $this->ldapConnect(true,$i);
                                                $filter="(|(cn=*$search_for*)(mail=*$search_for*))";
                                                $justthese = array("cn", "mail", "telephoneNumber", "mobile", "phpgwAccountVisible", "uid","employeeNumber", "ou");
                                                $sr=@ldap_search($this->ds, $this->ldap_context, $filter, $justthese, 0, $this->max_result+1);
                                                if(!$sr)
                                                        return null;
                                                $count_entries = ldap_count_entries($this->ds,$sr);
                                                $search = ldap_get_entries($this->ds, $sr);
                                                for ($j=0; $j<$search["count"]; $j++) {
                                                        $info[] = $search[$j];
                                                }
                                                $info["count"] = count($info)-1;
                                        }
                                }
                        }

                        for ($i=0; $i<$info["count"]; $i++)
                        {
                                if ($quickSearch_only_in_userSector)
                                {
                                        $tmp[$info[$i]["mail"][0] . '%' . $info[$i]["telephonenumber"][0] . '%'. $info[$i]["mobile"][0] . '%' . $info[$i]["uid"][0] . '%' . $info[$i]["jpegphoto"]['count'] . '%' . $info[$i]["employeenumber"][0] . '%' . $info[$i]["ou"][0]] = utf8_decode($info[$i]["cn"][0]);
				}
                                else
                                {
                                        if (preg_match("/$user_sector_dn/i", $info[$i]['dn']))
                                        {
                                                $tmp_users_from_user_org[$info[$i]["mail"][0] . '%' . $info[$i]["telephonenumber"][0] . '%'. $info[$i]["mobile"][0] . '%' . $info[$i]["uid"][0] . '%' . $info[$i]["jpegphoto"]['count'] . '%' . $info[$i]["employeenumber"][0] . '%' . $info[$i]["ou"][0]] = utf8_decode($info[$i]["cn"][0]);
                                        }
                                        else
                                        {
                                                $tmp[$info[$i]["mail"][0] . '%' . $info[$i]["telephonenumber"][0] . '%'. $info[$i]["mobile"][0] . '%' . $info[$i]["uid"][0] . '%' . $info[$i]["jpegphoto"]['count'] . '%' . $info[$i]["employeenumber"][0] . '%' . $info[$i]["ou"][0]] = utf8_decode($info[$i]["cn"][0]);
                                        }
                                }
                        }
                        natcasesort($tmp_users_from_user_org);
                        natcasesort($tmp);

                        if (($field != 'null') && ($ID != 'null'))
                        {
                                $i = 0;

                                $tmp = array_merge($tmp, $tmp_users_from_user_org);
                                natcasesort($tmp);

                                foreach ($tmp as $info => $cn)
                                {
                                        $contacts_result[$i] = array();
                                        $contacts_result[$i]["cn"] = $cn;
                                        list ($contacts_result[$i]["mail"], $contacts_result[$i]["phone"], $contacts_result[$i]["mobile"], $contacts_result[$i]["uid"], $contacts_result[$i]["jpegphoto"], $contacts_result[$i]["employeenumber"], $contacts_result[$i]["ou"]) = split ('%', $info);
                                        $i++;
                                }
                                $contacts_result['quickSearch_only_in_userSector'] = $quickSearch_only_in_userSector;
                        }
                        else
                        {
                                $options_users_from_user_org = '';
                                $options = '';

				/* List of users from user org */
                                $i = 0;
                                foreach ($tmp_users_from_user_org as $info => $cn)
                                {
                                        $contacts_result[$i] = array();
                                        $options_users_from_user_org .= $this->make_quicksearch_card($info, $cn);
                                        $i++;
                                }

                                /* List of users from others org */
                                foreach ($tmp as $info => $cn)
                                {
                                        $contacts_result[$i] = array();
                                        $options .= $this->make_quicksearch_card($info, $cn);
                                        $i++;
                                }

                                if ($quickSearch_only_in_userSector)
                                {
                                        if ($options != '')
                                        {
                                                $head_option =
                                                        '<tr class="quicksearchcontacts_unselected">' .
                                                                '<td colspan="2" width="100%" align="center">' .
                                                                        str_replace("%1", $this->max_result,$this->functions->getLang('More than %1 results were found')) . '.<br>' .
                                                                        $this->functions->getLang('Showing only the results found in your organization') . '.';
                                                                '</td>' .
                                                        '</tr>';
                                                $contacts_result = $head_option . $options_users_from_user_org . $options;
                                        }
                                        else
                                        {
                                                $return = array();
                                                $return['status'] = false;
                                                $return['error'] = "many results";
                                                return $return;
                                        }
                                }
                                else
                                {
					if (($options_users_from_user_org != '') && ($options != ''))
                                        {
                                                $head_option0 =
                                                        '<tr class="quicksearchcontacts_unselected">' .
                                                                '<td colspan="2" width="100%" align="center" style="background:#EEEEEE"><B>' .
                                                                        $this->functions->getLang('Users from your organization') . '</B> ['.count($tmp_users_from_user_org).']';
                                                                '</td>' .
                                                        '</tr>';

                                                $head_option1 =
                                                        '<tr class="quicksearchcontacts_unselected">' .
                                                                '<td colspan="2" width="100%" align="center" style="background:#EEEEEE"><B>' .
                                                                        $this->functions->getLang('Users from others organizations') . '</B> ['.count($tmp).']';
                                                                '</td>' .
                                                        '</tr>';
                                        }
                                        $contacts_result = $head_option0 . $options_users_from_user_org . $head_option1 . $options;
                                }
                        }
                }
                ldap_close($this->ds);
                return $contacts_result;
            }
	}
