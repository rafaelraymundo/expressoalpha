<!-- BEGIN body -->
<br><br>
<div id="tabs" style="margin: 2px 0pt 0pt 2.1em; height: 20%; width: 105em;">
	<ul>
		<li><a href="#tabs-1" onClick="javascript:dataRequest('tabs-1');">Projetos</a></li>
		<li><a href="#tabs-2" onClick="javascript:dataRequest('tabs-2');">Product Backlog</a></li>
		<li><a href="#tabs-3" onClick="javascript:dataRequest('tabs-3');">Sprint Backlog</a></li>
		<li><a href="#tabs-4" onClick="javascript:dataRequest('tabs-4');">Kanban</a></li>
	</ul>
			<div name="tabs" id="tabs-1">{projects}<script>dataRequest('tabs-1');</script></div>
			<div name="tabs" id="tabs-2"></div>
			<div name="tabs" id="tabs-3"></div>
			<div name="tabs" id="tabs-4"></div>
<!-- END body -->
