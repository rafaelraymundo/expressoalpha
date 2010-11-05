<?php
	/************************************************************************************************\
	*  Gerencia de projetos ageis									*
	*  by Rafael Raymundo da Silva (rafael2000@gmail.com)						*
	* ----------------------------------------------------------------------------------------------*
	*  This program is free software; you can redistribute it and/or modify it			*
	*  under the terms of the GNU General Public License as published by the			*
	*  Free Software Foundation; either version 2 of the License, or (at your			*
	*  option) any later version.									*
	\************************************************************************************************/

	$GLOBALS['phpgw_info'] = array();
        $GLOBALS['phpgw_info']['flags']['currentapp'] = 'agileProjects';
        include('../header.inc.php');

        echo '<link type="text/css" href="templates/default/css/jquery-ui-1.8.4.custom.css" rel="stylesheet" />';
	echo '<link type="text/css" href="templates/default/css/columns.css" rel="stylesheet" />';
	echo '<link type="text/css" href="templates/default/css/kanban.css" rel="stylesheet" />';
	echo '<link type="text/css" href="templates/default/css/tables.css" rel="stylesheet" />';
        echo '<script type="text/javascript" src="js/jscode/jquery-1.4.2.min.js"></script>';
	//Carregando common_functions e os scripts necessários para montar as abas
	$obj = CreateObject("agileProjects.functions");
        $scripts = 	"js/jscode/common_functions.js,".
			"js/jscode/jquery-ui-1.8.4.custom.min.js,".
			"js/jscode/tabs.js,".
			"js/jscode/edit_element.js";
	echo $obj -> getFilesJs($scripts);

        $c = CreateObject('phpgwapi.config','agileProjects');
        $c->read_repository();
        $current_config = $c->config_data;
  	
        $_SESSION['phpgw_info']['expresso']['user'] = $GLOBALS['phpgw_info']['user'];
        $_SESSION['phpgw_info']['expresso']['server'] = $GLOBALS['phpgw_info']['server'];
        $_SESSION['phpgw_info']['expresso']['global_denied_users'] = $GLOBALS['phpgw_info']['server']['global_denied_users'];
        $_SESSION['phpgw_info']['expresso']['global_denied_groups'] = $GLOBALS['phpgw_info']['server']['global_denied_groups'];
//	$_SESSION['phpgw_info']['expresso']['agileProjects']['active'] = 1;
        
	$template = CreateObject('phpgwapi.Template',PHPGW_APP_TPL);
        $template->set_file(Array('agileProjects' => 'index.tpl'));
        $template->set_block('agileProjects','body');

	//Para teste, apresentar o login/conta do usuario corrente
	//print_r($_SESSION['phpgw_info']['expresso']['user']['userid']);
	//print_r($_SESSION['phpgw_info']['expresso']['user']['account_id']);

	//TODO: uitabs ira retornar um array de 4 posicoes, cada uma referente a uma aba
 /*       $uitabs = CreateObject('agileProjects.uitabs'); //nome da classe eh uitabs
	
	$uitabsContent = $uitabs->uitabs();
	
        $var = Array(	'projects'	=> $uitabsContent[0],
		);
        $template->set_var($var);
*/	$template->pfp('out','body');

        $GLOBALS['phpgw']->common->phpgw_footer();
?>
