<?php
        /************************************************************************************************\
        *  Gerencia de projetos ageis                                                                   *
        *  by Rafael Raymundo da Silva (rafael2000@gmail.com)						*
        * ----------------------------------------------------------------------------------------------*
        *  This program is free software; you can redistribute it and/or modify it                      *
        *  under the terms of the GNU General Public License as published by the                        *
        *  Free Software Foundation; either version 2 of the License, or (at your                       *
        *  option) any later version.                                                                   *
        \***********************************************************************************************/

include('../phpgwapi/inc/class.common.inc.php');
include('inc/class.sotasks.inc.php');
$GLOBALS['phpgw_info'] = array();
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'agileProjects';


        class uikanban{
		
		var $template_dir;
		var $public_functions = array(
                        'uikanban' => True,
			'columns'  => True,
			'task'	   => True,
			'moveJS'   => True
		);

		function uikanban(){
                        if($_SESSION['phpgw_info']['expresso']['agileProjects']['active'] == ''){
                                echo "Primeiro selecione um projeto";
				exit();
                        }
                        echo("<div align=right>Projeto executado: ");
                        print_r($_SESSION['phpgw_info']['expresso']['agileProjects']['projectName']);
                        echo ("</div>");

			echo "	<div class=\"container\">
				<ul class=\"column\" style=\"width:1213px;\">";
			$col .= $this->columns("Planejadas","sprintBacklog");
			$col .= $this->columns("Em execu&ccedil;&atilde;o","doing");
			$col .= $this->columns("Testes","tests");
			$col .= $this->columns("Prontas","done");
			
			echo $col."</ul></div>";
		}
		
		function columns($colName,$idCol){
			include_once('inc/class.ldap_functions.inc.php');
			$sotasks = new sotasks();
			$list = new ldap_functions();

			$col.= "<li style=\"width:303px\">";
			$col.= "<div class=\"block_title\">";
			$col.= "<h2>".$colName."</h2>";
			$col.= "<div id=\"$idCol\" class=\"block connectedSortable\">";
			switch($idCol){
				case 'sprintBacklog':
					$sotasks->sotasksKanban('sprintBacklog');
					for($i=0;$i<count($sotasks->tasksElements['tasks_id_owner']);$i++){
						$tasks_id=$sotasks->tasksElements['tasks_id'][$i];
						$tasks_priority=$sotasks->tasksElements['tasks_priority'][$i];
						$tasks_title=$sotasks->tasksElements['tasks_title'][$i];
						$tasks_description=$sotasks->tasksElements['tasks_description'][$i];
						$tasks_estimate=$sotasks->tasksElements['tasks_estimate'][$i];
						$col.= $this->task($list->uidnumber2cn($sotasks->tasksElements['tasks_id_owner'][$i]),$tasks_id,$tasks_priority,$tasks_title,$tasks_description,$tasks_estimate);
                        		}
				break;
				case 'doing':
					$sotasks->sotasksKanban('doing');
                                        for($i=0;$i<count($sotasks->tasksElements['tasks_id_owner']);$i++){
                                                $tasks_id=$sotasks->tasksElements['tasks_id'][$i];
						$tasks_priority=$sotasks->tasksElements['tasks_priority'][$i];
                                                $tasks_title=$sotasks->tasksElements['tasks_title'][$i];
                                                $tasks_description=$sotasks->tasksElements['tasks_description'][$i];
						$col.= $this->task($list->uidnumber2cn($sotasks->tasksElements['tasks_id_owner'][$i]),$tasks_id,$tasks_priority,$tasks_title,$tasks_description,$tasks_estimate);
                                        }					
				break;
				case 'tests':
					$sotasks->sotasksKanban('tests');
                                        for($i=0;$i<count($sotasks->tasksElements['tasks_id_owner']);$i++){
                                                $tasks_id=$sotasks->tasksElements['tasks_id'][$i];
						$tasks_priority=$sotasks->tasksElements['tasks_priority'][$i];
                                                $tasks_title=$sotasks->tasksElements['tasks_title'][$i];
                                                $tasks_description=$sotasks->tasksElements['tasks_description'][$i];
						$col.= $this->task($list->uidnumber2cn($sotasks->tasksElements['tasks_id_owner'][$i]),$tasks_id,$tasks_priority,$tasks_title,$tasks_description,$tasks_estimate);
                                        }					
				break;
				case 'done':
					$sotasks->sotasksKanban('done');
                                        for($i=0;$i<count($sotasks->tasksElements['tasks_id_owner']);$i++){
                                                $tasks_id=$sotasks->tasksElements['tasks_id'][$i];
						$tasks_priority=$sotasks->tasksElements['tasks_priority'][$i];
                                                $tasks_title=$sotasks->tasksElements['tasks_title'][$i];
                                                $tasks_description=$sotasks->tasksElements['tasks_description'][$i];
						$col.= $this->task($list->uidnumber2cn($sotasks->tasksElements['tasks_id_owner'][$i]),$tasks_id,$tasks_priority,$tasks_title,$tasks_description,$tasks_estimate);
                                        }
				break;
			}
			$col.=	"</div>";
			$col.= "</li>";
		
			return($col);
		}
		function task($owner='',$tasks_id,$tasks_priority,$tasks_title='',$tasks_description='',$tasks_estimate){
			if($tasks_priority == 't'){
				$tasks_priority ="mark_red";
			}
			else{
				$tasks_priority="mark_green";
			}
			$task.="<div data-id=".$tasks_id." class=\"buble\" style=\"\">
	                    <div class=\"buble-content\">
	                        <span class=\"task\">
	                        <span class=\"msg_list\">
	                                <span class=\"title-bar\">
	                                        <img height='15px' width='10px' src='templates/default/images/".$tasks_priority.".png'><span style=\"float:right;margin-left:2%;\">".$owner."</span>
	                                </span>
	                                <B>".$tasks_title."</B>
	                                <button class=\"msg_head\">+</button>
	                                <div class=\"msg_body\" style=\"background-color:#fbf9a5; display: none;\">".$tasks_description."</div>
	                                <span class=\"footer\"> Estimativa: ".$tasks_estimate." pontos</span>
        	                </span></span>
                	    </div>
	                </div>
	";	
			return($task);
		}
        }
?>
