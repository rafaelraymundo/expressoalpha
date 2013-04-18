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

include('inc/class.sosprints.inc.php');
include('../header.inc.php');

class uisprints{

	var $listSprints;

	function uisprints(){
		if($_SESSION['phpgw_info']['expresso']['agileProjects']['active'] == NULL){
			echo "Primeiro selecione um projeto";
			exit();
		}
		else{
			echo("<div align=right>Projeto executado: ");
			print_r($_SESSION['phpgw_info']['expresso']['agileProjects']['projectName']);
			echo ("</div>");
			$this->listSprints = new sosprints();
			$this->listSprints->sosprintsList();

			$numBacklogs = count($this->listSprints->sprintsElements['sprints_name']);
			echo    "<div><button type=\"button\" onClick=\"javascript:sprintInclude();\">[ ".lang('Include sprint')." ]</button><br/><br/>";
			if (count($this->listSprints->sprintsElements) > 0 ){
				echo "
                                        <table id=\"customers\">
                                          <thead>
                                             <tr>
                                                <th>".lang('Name')."</th>
                                                <th>".lang('Goal')."</th>
                                                <th>".lang('Start date')."</th>
                                                <th>".lang('End date')."</th>
                                                <th>".lang('Retrospective')."</th>
						<th>".lang('Actions')."</th>
                                             </tr>
                                          </thead>
                                          <tbody>";
			}
			for($i=0;$i<$numBacklogs;$i++){
				$sel = '';
				$unsel='';

				if(($this->listSprints->sprintsElements['sprints_status'][$i]) == 't'){
					$sel = '<B>';
					$unsel = '</B>';
				}

				echo    "<tr class=".$line.">
                                                  <td>".$sel.$this->listSprints->sprintsElements['sprints_name'][$i].$unsel."</td>
                                                  <td>".$sel.$this->listSprints->sprintsElements['sprints_goal'][$i].$unsel."</td>
                                                  <td>".$sel.$this->listSprints->sprintsElements['sprints_dt_start'][$i].$unsel."</td>
                                                  <td>".$sel.$this->listSprints->sprintsElements['sprints_dt_end'][$i].$unsel."</td>
						  <td>".$sel.$this->listSprints->sprintsElements['sprints_retrospective'][$i].$unsel."</td>
                                                  <td>
							<img onclick=\"activeSprint(".$this->listSprints->sprintsElements['sprints_id'][$i].");\" title='Abrir' src='templates/default/images/open.png'/>
							<!-- <img title='Editar' src='templates/default/images/edit.png'/> -->
							<img onclick=\"removeSprint('".$this->listSprints->sprintsElements['sprints_name'][$i]."',".$this->listSprints->sprintsElements['sprints_id'][$i].",'".$this->listSprints->sprintsElements['project_owner']."','".$_SESSION['phpgw_info']['expresso']['user']['userid']."');\" title='Excluir' src='templates/default/images/delete.png'/>
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
