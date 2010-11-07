<?php
        echo    "<button type=\"button\" onClick=\"javascript:dataRequest('tabs-3');\">:: Voltar ::</button><br/><br/>  

        <h2>Incluir sprint</h2>

	<div align=\"center\">
        <table id='customers' border=2>
		<tr class=''><td>Nome do sprint: </td><td><input type=\"text\" id=\"name\" size='40'></td></tr>
		<tr class='alt'><td>Data inicial: </td><td><input OnKeyUp=\"mascara_data(this)\" type=\"text\" id=\"dt_start\" size='40'></td></tr>
		<tr class=''><td>Data final: </td><td><input OnKeyUp=\"mascara_data(this)\" type=\"text\" id=\"dt_end\" size='40'></td></tr>
		<tr class='alt'><td>Meta: </td><td><textarea id=\"goal\" cols=\"38\" rows=\"4\"></textarea></td></tr>
<!--		<tr class=''><td>Retrospectiva: </td><td><textarea id=\"retrospective\" cols=\"38\" rows=\"4\"></textarea></td></tr> -->
		
	</table>
	<button onclick=\"javascript:newSprint(
				document.getElementById('name').value,
				document.getElementById('dt_start').value,
				document.getElementById('dt_end').value,
				document.getElementById('goal').value
				);\" type=\"button\">:: Criar sprint ::</button>
	";
?>
