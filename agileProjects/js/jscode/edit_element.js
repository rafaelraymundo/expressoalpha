//---------------------Include/remove users---------------------------------------------
function remove_user(out,usrTasks){
	select_users = document.getElementById(out);
	array_usrTasks = usrTasks.split("|");
	for(i=0;i<array_usrTasks.length;i++){
		if(array_usrTasks[i] == select_users.value){
			alert("O usuario nao pode ser removido pois possui tarefas pendentes");
			return;	
		}
	}
	        for(var i = 0;i < select_users.options.length; i++){
        	        if(select_users.options[i].selected)
                	        select_users.options[i--] = null;
		}
}

function add_user(out, inp)
{
                //Verifica a versao do FF
                var agt = navigator.userAgent.toLowerCase();
                var is_firefox_0 = agt.indexOf('firefox/1.0') != -1 && agt.indexOf('firefox/0.') ? true : false;

                var select_available_users = document.getElementById(inp);
                var select_users = document.getElementById(out);
                var count_available_users = select_available_users.length;
                var count_users = select_users.options.length;
                var new_options = ''; 
    
                for (i = 0 ; i < count_available_users ; i++) {
                        if (select_available_users.options[i].selected) {
                                if(document.all) {
                                        if ( (select_users.innerHTML.indexOf('value='+select_available_users.options[i].value)) == '-1' ) { 
                                                new_options +=  '<option value='
                                                                        + select_available_users.options[i].value
                                                                        + '>' 
                                                                        + select_available_users.options[i].text
                                                                        + '</option>';
                                        }
                                }
                                else if ( (select_users.innerHTML.indexOf('value="'+select_available_users.options[i].value+'"')) == '-1' ) { 
                                                new_options +=  '<option value='
                                                                        + select_available_users.options[i].value
                                                                        + '>' 
                                                                        + select_available_users.options[i].text
                                                                        + '</option>';
                                }
                        }
                }
                if (new_options != '') {
                        if(is_firefox_0)
                                fixBugInnerSelect(select_users,'###' + new_options + select_users.innerHTML);
                        else
                                select_users.innerHTML = '###' + new_options + select_users.innerHTML;
                        select_users.outerHTML = select_users.outerHTML;
                }
}
//-----------------------Fim include/remove users-----------------------------------
//----------------------Serialize Arrays--------------------------------------------
	function serialize( mixed_value ) {
	    var _getType = function( inp ) {
		var type = typeof inp, match;
		var key;
		if (type == 'object' && !inp) {
		    return 'null';
		}
		if (type == "object") {
		    if (!inp.constructor) {
		        return 'object';
		    }
		    var cons = inp.constructor.toString();
		    match = cons.match(/(\w+)\(/);
		    if (match) {
		        cons = match[1].toLowerCase();
		    }
		    var types = ["boolean", "number", "string", "array"];
		    for (key in types) {
		        if (cons == types[key]) {
		            type = types[key];
		            break;
		        }
		    }
		}
		return type;
	    };
	    var type = _getType(mixed_value);
	    var val, ktype = '';
	    
	    switch (type) {
		case "function": 
		    val = ""; 
		    break;
		case "undefined":
		    val = "N";
		    break;
		case "boolean":
		    val = "b:" + (mixed_value ? "1" : "0");
		    break;
		case "number":
		    val = (Math.round(mixed_value) == mixed_value ? "i" : "d") + ":" + mixed_value;
		    break;
		case "string":
		    val = "s:" + mixed_value.length + ":\"" + mixed_value + "\"";
		    break;
		case "array":
		case "object":
		    val = "a";
		    var count = 0;
		    var vals = "";
		    var okey;
		    var key;
		    for (key in mixed_value) {
		        ktype = _getType(mixed_value[key]);
		        if (ktype == "function") { 
		            continue; 
		        }
		        
		        okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
		        vals += serialize(okey) +
		                serialize(mixed_value[key]);
		        count++;
		    }
		    val += ":" + count + ":{" + vals + "}";
		    break;
	    }
	    if (type != "object" && type != "array") {
	      val += ";";
	  }
	    return val;
	}
//---------------------Fim serialize arrays-----------------------------------------
//----------------------Count Values------------------------------------------------
	function countValues(val){
		var num=val.length;
		users = new Array(num);
		for(i=0;i<num;i++){
			users[i]=val.options[i].value;
		}
		return(users);
	}

//--------------------Fim Count Values----------------------------------------------
//----------------------Cria Projeto------------------------------------------------
	function newProject(name, description,partic,admin){
		var particArray = serialize(countValues(partic));
		var adminArray = serialize(countValues(admin));
                http = new XMLHttpRequest();
                var url = "action.php";
                var params = "type=project&name="+name+"&description="+description+"&particArray="+particArray+"&adminArray="+adminArray;
                http.open("POST",url,true);
    
                //Send the proper header information along with the request
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.setRequestHeader("Content-length", params.length);
                http.setRequestHeader("Connection", "close");

                http.onreadystatechange = function() {//Call a function when the state changes.
                        if(http.readyState == 4 && http.status == 200) {
                                alert("Projeto criado com sucesso");
				dataRequest('tabs-1');
                        }
                }
                http.send(params);
        }
//-----------------------Fim Cria Projeto-------------------------------------------
//----------------------Cria Sprint-------------------------------------------------
        function newSprint(name, dt_start,dt_end, goal){
                http = new XMLHttpRequest();
                var url = "action.php";
                var params = "type=newSprint&name="+name+"&dt_start="+dt_start+"&dt_end="+dt_end+"&goal="+goal;
                http.open("POST",url,true);
    
                //Send the proper header information along with the request
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.setRequestHeader("Content-length", params.length);
                http.setRequestHeader("Connection", "close");

                http.onreadystatechange = function() {//Call a function when the state changes.
                        if(http.readyState == 4 && http.status == 200) {
                                alert("Sprint criado com sucesso");
                                dataRequest('tabs-3');
                        }
                }
                http.send(params);
        }
//-----------------------Fim Cria Sprint--------------------------------------------
//----------------------Cria Tarefa-------------------------------------------------
        function newTask(sprint,responsable,title,subtitle,description){
                http = new XMLHttpRequest();
                var url = "action.php";
                var params = "type=newTask&sprint="+sprint+"&responsable="+responsable+"&title="+title+"&subtitle="+subtitle+"&description="+description;
                http.open("POST",url,true);
    
                //Send the proper header information along with the request
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.setRequestHeader("Content-length", params.length);
                http.setRequestHeader("Connection", "close");

                http.onreadystatechange = function() {//Call a function when the state changes.
                        if(http.readyState == 4 && http.status == 200) {
                                alert("Tarefa criada com sucesso");
                                dataRequest('tabs-2');
                        }
                }
                http.send(params);
        }
//-----------------------Fim Cria Tarefa--------------------------------------------
//----------------------Cria Projeto------------------------------------------------
        function saveProject(projId,name,description,partic,admin){
                var particArray = serialize(countValues(partic));
                var adminArray = serialize(countValues(admin));
                http = new XMLHttpRequest();
                var url = "action.php";
                var params = "type=saveProject&projId="+projId+"&name="+name+"&description="+description+"&particArray="+particArray+"&adminArray="+adminArray;
                http.open("POST",url,true);
    
                //Send the proper header information along with the request
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.setRequestHeader("Content-length", params.length);
                http.setRequestHeader("Connection", "close");

                http.onreadystatechange = function() {//Call a function when the state changes.
                        if(http.readyState == 4 && http.status == 200) {
                                alert("Projeto salvo com sucesso");
                                dataRequest('tabs-1');
                        }
                }
                http.send(params);
        }
//-----------------------Fim Cria Projeto-------------------------------------------
//---------------------Remove Projeto-----------------------------------------------
	function removeProject(projName, projId, projOwner,userLog){
		if(projOwner != userLog){
			alert("Voce nao tem permissao para excluir esse projeto.");
		}
		else{
			var answer = confirm("Tem certeza que deseja excluir o projeto ["+projName+"] ?");
			if (answer){
				http = new XMLHttpRequest();
		                var url = "action.php";
		                var params = "type=removeProject&projId="+projId;
		                http.open("POST",url,true);

        		        //Send the proper header information along with the request
		                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		                http.setRequestHeader("Content-length", params.length);
		                http.setRequestHeader("Connection", "close");

        		        http.onreadystatechange = function() {//Call a function when the state changes.
	                        	if(http.readyState == 4 && http.status == 200) {
	                                	alert("Projeto excluido com sucesso");
		                                dataRequest('tabs-1');
					}
                		}
                		http.send(params);
			}
		}
	}
//-------------------Fim remove projeto---------------------------------------------
//---------------------listUidNumbers-----------------------------------------------
	function listUidNumber(usr, projId){
		http = new XMLHttpRequest();
                url = "action.php";
                params = "type=listUidNumbers&projId="+projId+"&usr="+usr;
                http.open("POST",url,true);
		
		//Send the proper header information along with the request
                                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                http.setRequestHeader("Content-length", params.length);
                                http.setRequestHeader("Connection", "close");

                                http.onreadystatechange = function() {//Call a function when the state changes.
                                        if(http.readyState == 4 && http.status == 200) {
						return(http.responseText);
					}
				}
	}
//-------------------End listUidNumbers---------------------------------------------
//------------------------Edit Project----------------------------------------------
	function editProject(projId, projOwner, userLog){
                if(projOwner != userLog){
                        alert("Voce nao tem permissao para editar esse projeto.");
                }
                else{
                                http = new XMLHttpRequest();
                                var url = "action.php";
                                var params = "type=editProject&projId="+projId;
                                http.open("POST",url,true);

                                //Send the proper header information along with the request
                                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                http.setRequestHeader("Content-length", params.length);
                                http.setRequestHeader("Connection", "close");

                                http.onreadystatechange = function() {//Call a function when the state changes.
                                        if(http.readyState == 4 && http.status == 200) {
						document.getElementById('tabs-1').innerHTML = ''; 
		                                document.getElementById('tabs-1').innerHTML = http.responseText;
                                        }
                                }
                                http.send(params);
                }
	}
//--------------------Fim Edit Project----------------------------------------------
//----------------------Active Project----------------------------------------------
        function activeProject(projId,activeId){
	//		active = "active_project"+activeId;
	//		unactive = "active_project"+projId;
                        http = new XMLHttpRequest();
                        http.onreadystatechange = stateActiveProject;
                        http.open("GET","/agileProjects/action.php?type=activeProject&projId="+projId);
                        http.send(null);
                        respostServer = http.responseXML;
        }
        function stateActiveProject() {
                if ( http.readyState == 4) { // Complete 
                        if ( http.status == 200) { // server reply is OK
				dataRequest('tabs-1');
				alert("Projeto carregado com sucesso ");
                        } else {
                                alert( "Problema: " + http.statusText );
                        }
                }
        }
//----------------------Fim Active Project------------------------------------------
//----------------------Active Sprint-----------------------------------------------
        function activeSprint(sprintId){
                        http = new XMLHttpRequest();
                        http.onreadystatechange = stateActiveSprint;
                        http.open("GET","/agileProjects/action.php?type=activeSprint&sprintId="+sprintId);
                        http.send(null);
                        respostServer = http.responseXML;
        }
        function stateActiveSprint() {
                if ( http.readyState == 4) { // Complete 
                        if ( http.status == 200) { // server reply is OK
				dataRequest('tabs-3');
                                alert("Sprint carregado com sucesso ");
                        } else {
                                alert( "Problema: " + http.statusText );
                        }
                }
        }
//----------------------Fim Active Sprint-------------------------------------------
//---------------------Verifica data------------------------------------------------
          function mascara_data(d){ 
              var mydata = ''; 
              data = d.value; 
              mydata = mydata + data; 
              if (mydata.length == 2){ 
                  mydata = mydata + '/'; 
                  d.value = mydata; 
              } 
              if (mydata.length == 5){ 
                  mydata = mydata + '/'; 
                  d.value = mydata; 
              } 
              if (mydata.length == 10){ 
                  verifica_data(d); 
              } 
          }
          
            function verifica_data (d) { 

            dia = (d.value.substring(0,2)); 
            mes = (d.value.substring(3,5)); 
            ano = (d.value.substring(6,10)); 
            

            situacao = ""; 
            // verifica o dia valido para cada mes 
            if ((dia < 01)||(dia < 01 || dia > 30) && (  mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || dia > 31) { 
                situacao = "falsa"; 
            } 

            // verifica se o mes e valido 
            if (mes < 01 || mes > 12 ) { 
                situacao = "falsa"; 
            }

            // verifica se e ano bissexto 
            if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
                situacao = "falsa"; 
            } 
    
            if (d.value == "") { 
                situacao = "falsa"; 
            } 
    
            if (situacao == "falsa") { 
                alert("Data incorreta");
                d.value = ""; 
                d.focus(); 
            } 
          }
//--------------------Fim Verifica data---------------------------------------------
