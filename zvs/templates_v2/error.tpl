<%strip%>
<%include file=header.tpl%>
<div class="box750">
	<h2><span>##FAILURE_HAPPENED##</span></h2>
	<div class="table">
	<h3>##FAILURE_MESSAGE_REPORT##:</h3>
  <b>##PAGE##:</b><br/>
	<%$tpl_page%></br></br>
	<b>##TYPE##:</b><br/>
	<%$tpl_errortype%></br></br>
	<b>##CLASS/FUNCTION##:</b><br/>
	<%$tpl_classname%></br></br>
  <b>##MORE_INFORMATION##:</b></br>
	<%$tpl_info%></br></br>
  <b>##DATABASE_INFORMATION##:</b></br>
	<%$tpl_dbinfo%></br></br>
	</div>
</div>
<%include file=footer.tpl%>
<%/strip%>
