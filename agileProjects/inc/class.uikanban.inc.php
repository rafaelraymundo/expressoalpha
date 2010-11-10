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

//include('../phpgwapi/inc/common_functions.inc.php');
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

//			$template_dir = '/var/www/expresso/agileProjects/templates/'.$GLOBALS['phpgw_info']['user']['preferences']['common']['template_set'];
//			$template = CreateObject('phpgwapi.Template', $this->template_dir);

			//echo "o temp: <b>".$this->template_dir."</b> teve isso";
			echo "	<div class=\"container\">
				<ul class=\"column\" style=\"width:1213px;\">";
//			$col .= $this->columns("Planejadas","sprintBacklog",$this->task());
			$col .= $this->columns("Planejadas","sprintBacklog");
			$col .= $this->columns("Em execu&ccedil;&atilde;o","doing");
			$col .= $this->columns("Testes","tests");
			$col .= $this->columns("Prontas","done");
			
			echo $col."</ul></div>";
		}
		
		function columns($colName,$idCol){
			$sotasks = new sotasks();

			$col.= "<li style=\"width:303px\">";
			$col.= "<div id=\"$idCol\" class=\"block connectedSortable\">";
			$col.= "<h2>".$colName."</h2>";
//			$col.=$task;
			switch($idCol){
				case 'sprintBacklog':
					$sotasks->sotasksKanban('sprintBacklog');
					for($i=0;$i<count($sotasks->tasksElements['tasks_id_owner']);$i++){
						$tasks_id=$sotasks->tasksElements['tasks_id'][$i];
						$tasks_title=$sotasks->tasksElements['tasks_title'][$i];
						$tasks_description=$sotasks->tasksElements['tasks_description'][$i];
						$col.= $this->task($tasks_id,$tasks_title,$tasks_description);
                        		}

				case 'doing':
					$sotasks->sotasksKanban('doing');

				case 'tests':
					$sotasks->sotasksKanban('tests');

				case 'done':
					$sotasks->sotasksKanban('done');
			}
//			$col.=              "<p>Aqui vao as tarefas em backlog.</p>";
			$col.=	"</div>";
			$col.= "</li>";
		
			return($col);
		}
		function task($tasks_id,$tasks_title='',$tasks_description=''){
		$task.="<div data-id=\"buble".$tasks_id."\" class=\"buble\" style=\"\">
                    <div class=\"buble-content\">
                        <span class=\"task\">
                        <span class=\"msg_list\">
                                <span class=\"title-bar\"> Titulo da tarefa 
                                        <span style=\"margin-left: 20%;\">Joao da Silva</span>
                                </span>
                                ".$tasks_title."
                                <button class=\"msg_head\">+</button>
                                <div class=\"msg_body\" style=\"display: none;\">".$tasks_description."</div>
                                <span class=\"footer\"> Estimativa: xxx dias</span>
                        </span></span>
                    </div>
                </div>
";	
		return($task);
		}
        }
?>
