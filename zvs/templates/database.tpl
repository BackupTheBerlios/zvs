<%include file=header.tpl%>
<script language="JavaScript">
<!--
function recover()
{
	var schema;
	if (document.recover.frm_file.value == "")
	{
	  alert('Bitte eine Sicherungsdatei angeben!');
	} else {
	 
		if (document.recover.frm_schema[document.recover.frm_schema.selectedIndex].value=="zvs_system") {
			schema = "Systemdaten";
		} else {
			schema = "Hoteldaten";
		}
		if (confirm('Wirklich '+schema+' zur'+unescape("%FC")+'cksichern?\n Alle derzeitigen Daten werden gel'+unescape("%F6")+'scht! \n\n Bitte unbedingt die richtige Sicherungsdatei ausw'+unescape("%E4")+'hlen!')) {
			document.recover.submit();
		}
	}
}
//-->
</script>
<%strip%>	
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">##BACKUP_DATABASE##</p>
	<table border="0">
	<tr>
		<td>##HOTEL_DATA##</td>
		<td><a href="<%$wwwroot%>backupdb.php/database.<%$tpl_db%>/backupdb.php"><img src="<%$wwwroot%>img/button_exportdb.png" width="73" height="24" border="0" alt="##BACKUP_HOTEL_DATA##"></a></td>
	</tr>	
	<tr>
		<td>##SYSTEM_DATA##</td>
		<td><a href="<%$wwwroot%>backupdb.php/database.zvs_system/backupdb.php"><img src="<%$wwwroot%>img/button_exportdb.png" width="73" height="24" border="0" alt="##BACKUP_SYSTEM_DATA##"></a></td>
	</tr>
	</table>
	<form name="recover" id="recover" method="post" action="<%$SCRIPT_NAME%>" enctype="multipart/form-data">
	<p class="SubheadlineYellow">##RESTORE_DATABASE##</p>
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
				##BACKUP_FILE##: <input type="file" name="frm_file" id="frm_file">
			</td>
			<td>
				<a href="javascript:recover();"><img src="<%$wwwroot%>img/button_importdb.png" width="83" height="24" border="0" alt="##IMPORT##"></a>
			</td>
		</tr>
	</table>
	</form>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>


<%include file=footer.tpl%>
<%/strip%>

 