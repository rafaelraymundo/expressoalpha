<?php
	/***********************************************************************************\
	*  This program is free software; you can redistribute it and/or modify it		   *
	*  under the terms of the GNU General Public License as published by the		   *
	*  Free Software Foundation; either version 2 of the License, or (at your		   *
	*  option) any later version.													   *
	\***********************************************************************************/

	$setup_info['agileProjects']['name'] = 'agileProjects';
	$setup_info['agileProjects']['version'] = '1.0.0';
	$setup_info['agileProjects']['app_order'] = 10;
	$setup_info['agileProjects']['enable'] = 1;

	$setup_info['agileProjects']['author'] = 'Rafael Raymundo da Silva (rafael2000@gmail.com)';
	$setup_info['agileProjects']['license']  = 'GPL';
	$setup_info['agileProjects']['description'] = 'Ferramenta para gerencia de projetos baseada em metodologias ageis';
	$setup_info['agileProjects']['note'] = '';
	$setup_info['agileProjects']['maintainer'] = array(
		'name'  => 'Rafael Raymundo da Silva',
		'email' => 'rafael2000@gmail.com'
	);


	/* The hooks this app includes, needed for hooks registration */
	$setup_info['agileProjects']['hooks'][] = 'admin';


	/* Dependencies for this app to work */
	$setup_info['agileProjects']['depends'][] = array(
		'appname' => 'phpgwapi',
		'versions' => Array('2.0','2.1','2.2')
	);
?>
