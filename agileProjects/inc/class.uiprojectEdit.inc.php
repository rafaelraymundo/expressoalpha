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

        include('inc/class.soeditElement.inc.php');

        class uiprojectEdit{

                var $output;
                var $editElement;

                public function uiprojectEdit(){
			include_once('inc/class.ldap_functions.inc.php');
		
                        //Novo objeto, classe solists
                        $this->editElement = new soeditElement($_POST['projId']);
			$editElement = $this->editElement->soeditProject();
			$projId = $_POST['projId'];

			$numUser = count($this->editElement->resultUidNumber);
			if($this->editElement->resultTasks){
				$usrTasks=implode("|", $this->editElement->resultTasks);
			}
			$list = new ldap_functions();
			for($i=0;$i<$numUser;$i++){
			
				$uidNumber = $this->editElement->resultUidNumber[$i];
				$isAdmin = $this->editElement->resultUserAdmin[$i];
				if ($isAdmin == 't'){
					$admin .= "<option value=\"".$uidNumber."\">".$list->uidnumber2cnmail($uidNumber)."</option>";
				}
				else{
					$part .= "<option value=\"".$uidNumber."\">".$list->uidnumber2cnmail($uidNumber)."</option>";
				}
			}
	echo    "<button type=\"button\" onClick=\"javascript:dataRequest('tabs-1');\">:: Voltar ::</button><br/><br/>	

	<h2>Incluir projeto</h2>

	<div align=\"center\">
	<table id='customers' border=2>
	        <tr class='alt'><td width=\"47%\"><b>Nome do Projeto:</b> <input type=\"text\" id=\"name\" value=\"".$this->editElement->resultNameDesc."\"size='40'></td><td></td><td></td></tr>
		<tr class=''><td><b>Descricao:</b><br/><textarea id=\"description\" cols=\"52\" rows=\"5\">".$this->editElement->resultProjDesc."</textarea></td><td></td><td></td></tr>
		<tr class='alt'><td width=\"45%\"><br><br><br><b>Participantes do projeto</b><br/><select size=\"13\" style=\"width: 450px;\" name=\"participants[]\" id=\"user_list\">\"".$part."\"</select></td>
		<td width=\"10px\" valign=\"middle\" align=\"center\">
		
		<button onclick=\"javascript:add_user('user_list','user_list_in');\" type=\"button\"><img style=\"vertical-align: middle;\" src=\"templates/default/images/add.png\"/> Adicionar</button><br/><br/>
		<button onclick=\"javascript:remove_user('user_list','".$usrTasks."');\" type=\"button\"><img style=\"vertical-align: middle;\" src=\"templates/default/images/rem.png\"/> Remover</button>
		</td>
		<td valign=\"bottom\">	
		<font color=\"red\"><span id=\"cal_span_searching\"></span></font><br>
		Buscar por:	<input autocomplete=\"off\" size=\"37\" id=\"cal_input_searchUser\" value=\"\">
		<button type=\"button\" onClick=\"javascript:userInclude(document.getElementById('cal_input_searchUser').value,'user_list_in');\">Buscar</button><br><br><br><select size=\"13\" multiple=\"\" style=\"width: 450px;\" id=\"user_list_in\"></select></td>
	        </tr>
	
	<tr/><tr/><tr/>
	<td></td>
	<tr>

        	<td><br><br><br><b>Administradores do projeto</b><br/> <select size=\"13\" style=\"width: 450px;\" name=\"participants[]\" id=\"user_list2\">\"".$admin."\"</select></td>
	        <td width=\"30px\" valign=\"middle\" align=\"center\">

		<button onclick=\"javascript:add_user('user_list2','user_list_in2');\" type=\"button\"><img style=\"vertical-align: middle;\" src=\"templates/default/images/add.png\"/> Adicionar</button><br/><br/>
                <button onclick=\"javascript:remove_user('user_list2');\" type=\"button\"><img style=\"vertical-align: middle;\" src=\"templates/default/images/rem.png\"/> Remover</button>
		</td>

	        <td valign=\"bottom\">        
	                        <font color=\"red\"><span id=\"cal_span_searching\"></span></font>    <br>
        	Buscar por:     <input autocomplete=\"off\" size=\"20\" id=\"cal_input_searchUser2\" value=\"\">
		<button type=\"button\" onClick=\"javascript:userInclude(document.getElementById('cal_input_searchUser2').value,'user_list_in2');\">Buscar</button><br><br><br><select size=\"13\" multiple=\"\" style=\"width: 450px;\" id=\"user_list_in2\"></select></td>
	        </tr>
	</table>
	<button type=\"button\" onclick=\"javascript:saveProject(
				$projId,
				document.getElementById('name').value,
				document.getElementById('description').value,
				document.getElementById('user_list'),
				document.getElementById('user_list2')
				);\">:: Salvar projeto ::</button>
</div>";
		}//End Funcion uiprojectEdit
}//End Class uiprojectEdit

?>
