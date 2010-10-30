<?php
	echo    "<button type=\"button\" onClick=\"javascript:dataRequest('tabs-1');\">:: Voltar ::</button><br/><br/>	

	<h2>Incluir projeto</h2>

	<div align=\"center\">
	<table id='customers' border=2>
	        <tr class='alt'><td width=\"47%\"><b>Nome do Projeto:</b> <input type=\"text\" id=\"name\" size='40'></td><td></td><td></td></tr>
		<tr class=''><td><b>Descricao:</b><br/><textarea id=\"description\" cols=\"52\" rows=\"5\"></textarea></td><td></td><td></td></tr>
		<tr class='alt'><td width=\"45%\"><br><br><br><b>Participantes do projeto</b><br/><select size=\"13\" style=\"width: 450px;\" name=\"participants[]\" id=\"user_list\"></select></td>
		<td width=\"10px\" valign=\"middle\" align=\"center\">
		
		<button onclick=\"javascript:add_user('user_list','user_list_in');\" type=\"button\"><img style=\"vertical-align: middle;\" src=\"templates/default/images/add.png\"/> Adicionar</button><br/><br/>
		<button onclick=\"javascript:remove_user('user_list');\" type=\"button\"><img style=\"vertical-align: middle;\" src=\"templates/default/images/rem.png\"/> Remover</button>
		</td>
		<td valign=\"bottom\">	
		<font color=\"red\"><span id=\"cal_span_searching\"></span></font><br>
		Buscar por:	<input autocomplete=\"off\" size=\"37\" id=\"cal_input_searchUser\" value=\"\">
		<button type=\"button\" onClick=\"javascript:userInclude(document.getElementById('cal_input_searchUser').value,'user_list_in');\">Buscar</button><br><br><br><select size=\"13\" multiple=\"\" style=\"width: 450px;\" id=\"user_list_in\"></select></td>
	        </tr>
	
	<tr/><tr/><tr/>
	<td></td>
	<tr>

        	<td><br><b><br><br><br>Administradores do projeto</b><br/> <select size=\"13\" style=\"width: 450px;\" name=\"participants[]\" id=\"user_list2\"></select></td>
	        <td width=\"30px\" valign=\"middle\" align=\"center\">

		<button onclick=\"javascript:add_user('user_list2','user_list_in2');\" type=\"button\"><img style=\"vertical-align: middle;\" src=\"templates/default/images/add.png\"/> Adicionar</button><br/><br/>
                <button onclick=\"javascript:remove_user('user_list2');\" type=\"button\"><img style=\"vertical-align: middle;\" src=\"templates/default/images/rem.png\"/> Remover</button>
		</td>

	        <td valign=\"bottom\">        
	                        <font color=\"red\"><span id=\"cal_span_searching\"></span></font>    <br>
        	Buscar por:     <input autocomplete=\"off\" size=\"37\" id=\"cal_input_searchUser2\" value=\"\">
		<button type=\"button\" onClick=\"javascript:userInclude(document.getElementById('cal_input_searchUser2').value,'user_list_in2');\">Buscar</button><br><br><br><select size=\"13\" multiple=\"\" style=\"width: 450px;\" id=\"user_list_in2\"></select></td>
	        </tr>
	</table>
	<button type=\"button\" onclick=\"javascript:newProject(
				document.getElementById('name').value,
				document.getElementById('description').value,
				document.getElementById('user_list'),
				document.getElementById('user_list2')
				);\">:: Criar projeto ::</button>
</div>";
//document.getElementById('user_list').options[0].value

?>
