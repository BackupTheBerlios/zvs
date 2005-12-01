<%strip%>
<%include file=header.tpl%>
<form id="save" name="save" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%if $tpl_gast.guestid neq ""%><%$tpl_gast.guestid%><%else%>0<%/if%>">
<div class="boxdyn">
	<h2><span>##NOTICE## <%if $tpl_gast.guestid neq ""%>##FOR##: <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></span></h2>
	<%if $tpl_gast.guestid neq ""%>&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:document.save.submit();" onClick="unsetaltered();" class="dotted">##SAVE##</a></div><%/if%>
	  <br/>
	  <textarea name="frm_info" id="frm_info" cols="100" rows="20"><%$tpl_gast.additional_info%></textarea>
	  <br/>
</div>
</form>
<%include file=footer.tpl%>
<%/strip%>