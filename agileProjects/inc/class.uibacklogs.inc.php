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
	
	include('inc/class.sobacklogs.inc.php');
        include('../header.inc.php');

        class uibacklogs{

		var $listBacklogs;
		
		function uibacklogs(){
			if($_SESSION['phpgw_info']['expresso']['agileProjects']['active'] == NULL){
				echo "Primeiro selecione um projeto";
				exit();
			}
			else{
	                        echo("<div align=right>Projeto executado: ");
	                        print_r($_SESSION['phpgw_info']['expresso']['agileProjects']['projectName']);
        	                echo ("</div>");
				$this->listBacklogs = new sobacklogs();
				$this->listBacklogs->sobacklogs();
print_r($this->listBacklogs->tasksSprints['tasks_sprints']);
				$numBacklogs = count($this->listBacklogs->tasksElements['tasks_owner']);
			        echo    "<div><button type=\"button\" onClick=\"javascript:taskInclude();\">[ ".lang('Include task')." ]</button><br/><br/>";
				if (count($this->listBacklogs->tasksElements) > 0 ){
				   echo "
			        	<table id=\"customers\">
			                  <thead>
			                     <tr>
			                        <th>".lang('Responsable')."</th>
			                        <th>".lang('Title')."</th>
			                        <th>".lang('Description')."</th>
						<th>".lang('Sprint')."</th>
						<th>".lang('Actions')."</th>
			                     </tr>
			                  </thead>
			                  <tbody>";
				}
		                for($i=0;$i<$numBacklogs;$i++){

			                        echo    "<tr class=".$line.">
		                                  <td>".$this->listBacklogs->tasksElements['tasks_owner'][$i]."</td>
		                                  <td>".$this->listBacklogs->tasksElements['tasks_title'][$i]."</td>
						  <td>".$this->listBacklogs->tasksElements['tasks_description'][$i]."</td>
						  <td>".$this->listBacklogs->tasksElements['tasks_sprints'][$i]."</td>
						  <td>
							<!-- <img title='Editar' src='templates/default/images/edit.png'/> -->
							<img onclick=\"removeTask('".$this->listBacklogs->tasksElements['tasks_title'][$i]."',".$this->listBacklogs->tasksElements['tasks_id'][$i].",'".$this->listBacklogs->tasksElements['project_owner']."','".$_SESSION['phpgw_info']['expresso']['user']['userid']."');\" title='Excluir' src='templates/default/images/delete.png'/>
						  </td>
		                                </tr>";
					if($line == "alt"){
                         			$line="";
					}else{
						$line="alt";
					}
				}
				echo "</tbody></table>";	
			}
		}
        }
?>
