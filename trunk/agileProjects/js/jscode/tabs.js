	//------------------------------Tabs---------------------------------- 
	$(function(){
                                // Tabs
                                $('#tabs').tabs();
                
                                //hover states on the static widgets
                                $('#dialog_link, ul#icons li').hover(
                                        function() { $(this).addClass('ui-state-hover'); }, 
                                        function() { $(this).removeClass('ui-state-hover'); }
                                );
                    });
	//-------------------End Tabs----------------------------------------
	//---------------------Columns---------------------------------------
	$(document).ready(function(){
        
	        $('a[href^="http://"]') .attr({ target: "_blank" });
 
        	function smartColumns() {
                
                	$("ul.column").css({ 'width' : "260px"});
                
	                var colWrap = $("ul.column").width();
	                var colNum = Math.floor(colWrap / 300); 
	                var colFixed = Math.floor(colWrap / colNum);
                
                
        	        $("ul.column").css({ 'width' : colWrap});
                	$("ul.column li").css({ 'width' : colFixed});
        	}       
        
	        smartColumns(); 
	
	// -----------Resize columns----------- 
        //	$(window).resize(function () {
        //      	smartColumns();
        //	});         
	});
	//-------------------End Columns----------------------------------
	//-----------------------Tasks------------------------------------
	/*$(document).ready(function(){
                $("#sprintBacklog,#doing,#tests,#done").sortable({
                    connectWith: '.connectedSortable',
                    receive: function(event, ui) { 
                        //alert($(ui.item).attr('data-id') + ' -> ' + $(this).attr('id'));
                        //Do something with the recently dropped item here
                    }
                }).disableSelection();
 
            });
        //Expand for details
        $(document).ready(function()
        {
                //hide the all of the element with class msg_body
                $(".msg_body").hide();
                //toggle the componenet with class msg_body
                $(".msg_head").click(function()
                {
                        $(this).next(".msg_body").slideToggle(600);
                });
        });
*/	//-------------------End Tasks---------------------------------------
	//----------------Alter Tabs----------------------------------------
	function dataRequest(tabRequest){
		tab = tabRequest;
		http = new XMLHttpRequest();
		http.onreadystatechange = stateProc;
		http.open("GET","/agileProjects/action.php?tabs="+tabRequest+"");
		http.send(null);
		respostServer = http.responseXML;
	}
	function stateProc() {
		if ( http.readyState == 4) { // Complete 
			if ( http.status == 200) { // server reply is OK
				document.getElementById('tabs-1').innerHTML = '';
				document.getElementById('tabs-2').innerHTML = ''; 
				document.getElementById('tabs-3').innerHTML = '';
				document.getElementById('tabs-4').innerHTML = ''; 
				document.getElementById(tab).innerHTML = http.responseText; 
				//------------------------------------------------------
				//Acoes responsaveis pelo movimento da Tarefas do Kanban
				//------------------------------------------------------
				if(tab == 'tabs-4'){
                        	        $(document).ready(function(){
					   $("#sprintBacklog,#doing,#tests,#done").sortable({
                    				connectWith: '.connectedSortable',
                    				receive: function(event, ui) { 
			//			  alert($(ui.item).attr('data-id') + ' -> ' + $(this).attr('id'));
                        			  //Do something with the recently dropped item here
                    				}
                			   }).disableSelection();
 
            				});
        				//Expand for details
        				$(document).ready(function()
        				{
                				//hide the all of the element with class msg_body
                				$(".msg_body").hide();
                				//toggle the componenet with class msg_body
                				$(".msg_head").click(function()
                				{
                        				$(this).next(".msg_body").slideToggle(600);
                				});
        				});
                		}	
			} else { 
				alert( "Problema: " + http.statusText );  
			} 
		}
	}
	//-------------------Fim Alter tabs-----------------------------------
	//---------------Include Project--------------------------------------
        function projectInclude(projId, projOwner,userLog){

		if(projOwner!='' && userLog!='' && projId!=''){
			if(projOwner != userLog){
				alert("Voce nao tem permissao para editar esse projeto");
				exit();
			}
		}

	                http = new XMLHttpRequest();
	                http.onreadystatechange = stateIncludeProject;
	                http.open("GET","/agileProjects/inc/class.uiprojectInclude.inc.php?type=editProj&projId="+projId+"");
	                http.send(null);
	                respostServer = http.responseXML;
        }
        function stateIncludeProject() {
                if ( http.readyState == 4) { // Complete 
                        if ( http.status == 200) { // server reply is OK
                                document.getElementById('tabs-1').innerHTML = ''; 
                                document.getElementById('tabs-1').innerHTML = http.responseText ;
                        } else {
                                alert( "Problema: " + http.statusText );
                        }
                }
        }
	//----------------Fim Include Project---------------------------------
        //---------------Include Tasks------------------------------------------
        function taskInclude(){

		http = new XMLHttpRequest();
		http.onreadystatechange = stateIncludeTask;
		http.open("GET","action.php?type=taskInclude");
		http.send(null);
		respostServer = http.responseXML;
        }
        function stateIncludeTask() {
                if ( http.readyState == 4) { // Complete 
                        if ( http.status == 200) { // server reply is OK
                                document.getElementById('tabs-2').innerHTML = ''; 
                                document.getElementById('tabs-2').innerHTML = http.responseText ;
                        } else {
                                alert( "Problema: " + http.statusText );
                        }
                }
        }
        //----------------Fim Include Tasks-------------------------------------
        //---------------Include Tasks------------------------------------------
        function sprintInclude(){

                        http = new XMLHttpRequest();
                        http.onreadystatechange = stateIncludeSprint;
                        http.open("GET","/agileProjects/inc/sprintInclude.inc.php");
                        http.send(null);
                        respostServer = http.responseXML;
        }
        function stateIncludeSprint() {
                if ( http.readyState == 4) { // Complete 
                        if ( http.status == 200) { // server reply is OK
                                document.getElementById('tabs-3').innerHTML = '';
                                document.getElementById('tabs-3').innerHTML = http.responseText ;
                        } else {
                                alert( "Problema: " + http.statusText );
                        }
                }
        }
        //----------------Fim Include Tasks-------------------------------------	
	//---------------Include Users----------------------------------------
	function userInclude(filter, boxField){
		field = boxField;
                http = new XMLHttpRequest();
                http.onreadystatechange = stateUserInclude;
                http.open("GET","/agileProjects/controller.php?action=agileProjects.ldap_functions.search_users_only&tipo=search&filtro="+filter+"");
                http.send(null);
                respostServer = http.responseXML;
        }
        function stateUserInclude() {
                if ( http.readyState == 4) { // Complete 
                        if ( http.status == 200) { // server reply is OK
                                document.getElementById(field).innerHTML = ''; 
                                document.getElementById(field).innerHTML = http.responseText;
                        } else {
                                alert( "Problema: " + http.statusText );
                        }
                }
        }
