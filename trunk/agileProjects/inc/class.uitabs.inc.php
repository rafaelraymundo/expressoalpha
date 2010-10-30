<?php
	/************************************************************************************************\
        *  Gerencia de projetos ageis                                                                   *
        *  by Rafael Raymundo da Silva (rafael.silva@serpro.gov.br, rafael2000@gmail.com)               *
        * ----------------------------------------------------------------------------------------------*
        *  This program is free software; you can redistribute it and/or modify it                      *
        *  under the terms of the GNU General Public License as published by the                        *
        *  Free Software Foundation; either version 2 of the License, or (at your                       *
        *  option) any later version.                                                                   *
        \************************************************************************************************/
//	if(isset($_GET['aba1'])){
		//echo $_GET['aba1'];
		//$uitabs = new uitabs;
		//$this->uitabs->uitabs($_GET['aba1']);
//		$uitabs = CreateObject('agileProjects.uitabs');
		//print_r($uitabs);
		//$uitabsContent = $this->$uitabs->uitabs($_GET['aba1']);
//	}
		/*
	class uitabs{
		function uitabs($x=NULL){
			if ($x=='teste1'){
				$variavel[0] = "temos o projeto aqui";
				return($variavel);
				
			}
/*else
{
			//TODO: Criar os objetos, vindos de class.<AbaDoObjeto>.inc.php
*/		//	$variavel[0] = "temos o projeto aqui";
/*			$variavel[1] = "os backlogs sao muito importantes";
			$variavel[2] = "aqui nos temos os sprints";
			$variavel[3] = "um kanban eh essencial";
// * * * * * * * * * * * * * *
			$ObjectContent[0] = CreateObject('agileProjects.uiprojects'); //nome da classe eh uitabs
			$ObjectContent[1] = CreateObject('agileProjects.uibacklogs');
			$ObjectContent[2] = CreateObject('agileProjects.uisprints');
			$ObjectContent[3] = CreateObject('agileProjects.uikanban');

			$ObjectContent = Array ('uiprojects'	=> CreateObject('agileProjects.uiprojects'),
						'uibacklogs'	=> CreateObject('agileProjects.uibacklogs'),
						'uisprints'	=> CreateObject('agileProjects.uisprints'),
						'uikanban'	=> CreateObject('agileProjects.uikanban')
					);

        		$uitabsContent[0] = $ObjectContent[uiprojects]->uiprojects();
			$uitabsContent[1] = $ObjectContent[uibacklogs]->uibacklogs();
			$uitabsContent[2] = $ObjectContent[uisprints]->uisprints();
			$uitabsContent[3] = $ObjectContent[uikanban]->uikanban();

// * * * * * * * * * * * * * *

			return($variavel);
//}
//			return("<H1>Nessa aba sera apresentado o quadro de kanban, em forma de postits. Sera possivel move-los entre as acoes do quadro. Ele sera gerado de acordo com o scrint selecionado</H1>");

		}
		function teste1(){
		alert("Projetos");
		}
		function teste2(){
		alert("Backlogs");
		}
		
		function projects(){

		}
		
		function backlogs(){

		}
		
		function sprints(){

		}
		
		function kanban(){

		}

	}
