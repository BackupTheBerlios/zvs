<%include file=header.tpl%>
<script language="JavaScript">
<!--
function recover()
{
	var schema;
	if (document.recover.frm_file.value == "")
	{
	  alert('##PLEASE_DEFINE_BACKUPFILE##!');
	} else {
	 
		if (document.recover.frm_schema[document.recover.frm_schema.selectedIndex].value=="zvs_system") {
			schema = "##SYSTEM_DATA##";
		} else {
			schema = "##SYSTEM_DATA##";
		}
		if (confirm('##REALLY_RECOVER_SCHEMA## '+schema)) {
			document.recover.submit();
		}
	}
}
//-->
</script>
<%strip%>	
<div class="box750">
	<h2><span>##BACKUP_DATABASE##</span></h2>
	<div class="table">
		<ul class="buttonlist">
		<li><a href="<%$wwwroot%>backupdb.php/database.<%$tpl_db%>/backupdb.php">##BACKUP_HOTEL_DATA##</a></li>
		<li><a href="<%$wwwroot%>backupdb.php/database.zvs_system/backupdb.php">##BACKUP_SYSTEM_DATA##</a></li>
		</ul>
	</div>
</div>
<br/><br/>
<div class="box750">
	<h2><span>##RESTORE_DATABASE##</span></h2>
	<div class="table">
	<form name="recover" id="recover" method="post" action="<%$SCRIPT_NAME%>" enctype="multipart/form-data">
	<%if $tpl_ready eq "true"%>
	<p class="DefError">##DATA_SUCCESSFUL_IMPORTED##!</p>
	<%/if%>
	<table border="0">
		<tr>
			<td>
				<select name="frm_schema" id="frm_schema">
					<option value="<%$tpl_db%>">##HOTEL_DATA##</option>
					<option value="zvs_system">##SYSTEM_DATA##</option>
				</select>
			</td>
			<td>
				##BACKUP_FILE##: <input type="file" name="frm_file" id="frm_file"/>
			</td>
			<td>
				<a href="javascript:recover();" class="dotted">##IMPORT##</a><strong>&nbsp;&raquo;</strong>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
<%include file=footer.tpl%>
<%/strip%> 