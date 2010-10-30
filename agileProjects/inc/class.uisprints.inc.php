<?php
        /************************************************************************************************\
        *  Gerencia de projetos ageis                                                                   *
        *  by Rafael Raymundo da Silva (rafael.silva@serpro.gov.br, rafael2000@gmail.com)               *
        * ----------------------------------------------------------------------------------------------*
        *  This program is free software; you can redistribute it and/or modify it                      *
        *  under the terms of the GNU General Public License as published by the                        *
        *  Free Software Foundation; either version 2 of the License, or (at your                       *
        *  option) any later version.                                                                   *
        \***********************************************************************************************/

        class uisprints{

		function uisprints(){
			if($_SESSION['phpgw_info']['expresso']['agileProjects']['active'] == NULL){
                                echo "Primeiro selecione um projeto";
                                exit();
                        }
                        else{
                                echo("Projeto selecionado eh: ".$_SESSION['phpgw_info']['expresso']['agileProjects']['active']);
                        }
		}

        }
?>
