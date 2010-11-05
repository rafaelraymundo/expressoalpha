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
                                $this->listSprints = new sosprints();
                                $this->listSprints->sosprints();

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

                                                echo    "<tr class=".$line.">
                                                  <td>".$this->listSprints->sprintsElements['sprints_name'][$i]."</td>
                                                  <td>".$this->listSprints->sprintsElements['sprints_goal'][$i]."</td>
                                                  <td>".$this->listSprints->sprintsElements['sprints_dt_start'][$i]."</td>
                                                  <td>".$this->listSprints->sprintsElements['sprints_dt_end'][$i]."</td>
						  <td>".$this->listSprints->sprintsElements['sprints_retrospective'][$i]."</td>
                                                  <td><button type=\"button\" onClick=\"javascript:sprintExecute();\">[ ".lang('Execute sprint')." ]</button></td>
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
