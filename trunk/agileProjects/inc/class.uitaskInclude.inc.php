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

        include('inc/class.sotaskInclude.inc.php');
        include('../header.inc.php');

        class uitaskInclude{
	
		var $sprints;

                function uitaskInclude(){
			
			include_once('inc/class.ldap_functions.inc.php');
			$list = new ldap_functions();
			$this->sprints = new sotaskInclude();
			$sprints = $this->sprints->sotaskInclude();
			
			for($i=0;$i<count($this->sprints->sprintsElements['sprints_name']);$i++){
				$sprints.="<option value=\"".$this->sprints->sprintsIdElements['sprints_id'][$i]."\">".$this->sprints->sprintsElements['sprints_name'][$i]."</option>";

			}

			for($i=0;$i<count($this->sprints->usersElements['user_id']);$i++){
				$user_id.="<option value=\"".$this->sprints->usersElements['user_id'][$i]."\">".$list->uidnumber2cn($this->sprints->usersElements['user_id'][$i])."</option>";
			}

		        echo    "<button type=\"button\" onClick=\"javascript:dataRequest('tabs-2');\">:: Voltar ::</button><br/><br/>  

		        <h2>Incluir tarefa</h2>

			<div align=\"center\">
		        <table id='customers' border=2>
				<tr class=''><td>Incluir ao Sprint: </td><td>
								<select name=\"menu\" id=\"sprint\">
									<option value=\"0\" selected>Selecione um sprint</option>
									".$sprints."
								</select>
				</td></tr>
		                <tr class='alt'><td>Responsavel: </td><td>
		                                                <select name=\"menu\" id=\"responsable\">
		                                                        <option value=\"0\" selected>Selecione um participante</option>
									".$user_id."
		                                                </select>
		                </td></tr>
				<tr class=''><td>Titulo: </td><td><input type=\"text\" id=\"title\" size='40'></td></tr>
				<tr class='alt'><td>Subtitulo: </td><td><input type=\"text\" id=\"subtitle\" size='40'></td></tr>
				<tr class=''><td>Descricao: </td><td><textarea id=\"description\" cols=\"38\" rows=\"4\"></textarea></td></tr>
			</table>
			<button onclick=\"javascript:newTask(
						document.getElementById('sprint').selectedIndex,
						document.getElementById('responsable').selectedIndex,
						document.getElementById('title').value,
						document.getElementById('subtitle').value,
						document.getElementById('description').value
						);\" type=\"button\">:: Criar tarefa ::</button>
			";
		}//End function
	}//End class
?>
