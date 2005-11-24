<%strip%>
<%include file=header.tpl%>
<div class="boxdyn">
	<h2><span>##NOTICE## <%if $tpl_gast.guestid neq ""%>##FOR##: <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></span></h2>
	<%if $tpl_gast.guestid neq ""%>&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="<%$wwwroot%>editinfo.php/guestid.<%$tpl_gast.guestid%>" class="dotted">##EDIT##</a></div><%/if%>
	  <br/>
	  <%$tpl_gast.additional_info|nl2br%>
	  <br/>
</div>
<%include file=footer.tpl%>
<%/strip%>

