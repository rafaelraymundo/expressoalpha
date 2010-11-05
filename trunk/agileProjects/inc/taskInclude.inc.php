<?php
        echo    "<button type=\"button\" onClick=\"javascript:dataRequest('tabs-2');\">:: Voltar ::</button><br/><br/>  

        <h2>Incluir tarefa</h2>

	<div align=\"center\">
        <table id='customers' border=2>
		<tr class=''><td>Incluir ao Sprint: </td><td>
						<select name=\"menu\">
							<option value=\"0\" selected>Selecione um sprint</option>
							<option value=\"1\">one</option>
							<option value=\"2\">two</option>
							<option value=\"3\">three</option>
							<option value=\"other\">other, please specify:</option>
						</select>
		</td></tr>
                <tr class='alt'><td>Responsavel: </td><td>
                                                <select name=\"menu\">
                                                        <option value=\"0\" selected>Selecione um participante</option>
                                                        <option value=\"1\">one</option>
                                                        <option value=\"2\">two</option>
                                                        <option value=\"3\">three</option>
                                                        <option value=\"other\">other, please specify:</option>
                                                </select>
                </td></tr>
		<tr class=''><td>Titulo: </td><td><input type=\"text\" id=\"name\" size='40'></td></tr>
		<tr class='alt'><td>Subtitulo: </td><td><input type=\"text\" id=\"name\" size='40'></td></tr>
		<tr class=''><td>Descricao: </td><td><textarea id=\"description\" cols=\"38\" rows=\"4\"></textarea></td></tr>
	</table>
	<button onclick=\"javascript:newTask(
				document.getElementById('name').value,
				document.getElementById('description').value,
				document.getElementById('user_list'),
				document.getElementById('user_list2')
				);\" type=\"button\">:: Criar tarefa ::</button>
	";
?>
