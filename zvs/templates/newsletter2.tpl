<%include file=header.tpl%>
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

	<%if $tpl_sent eq 'true'%>
	<table width="100%" boder="0">
	<tr>
		<td class="SubheadlineYellow">Newsletter versenden</td>
	</tr>
	</table>	
		Der Newsletter wurde an <%$tpl_number%>&nbsp;Adressaten versendet.
	<%else%>
	<table width="100%" boder="0">
	<tr>
		<td class="SubheadlineYellow">Newsletter versenden</td>
		<td align="right"><a href="javascript:alert('Diese Funktion ist aus Sicherheitsgründen deaktiviert');" onClick="unsetaltered();"><img src="<%$wwwroot%>/img/button_email.png" width="82" height="24" border="0" alt="Absenden"></a></td>
	</tr>
	</table>	
	<form name="newsletter" id="newsletter" method="post" action="<%$SCRIPT_NAME%>">
	<table border="0" cellpadding="10" cellspacing="0">
		<tr>
			<td valign="top"><b>Kategorien ausw&auml;hlen:</b><br>
				<input type="checkbox" name="frm_andop" id="frm_andop" value="yes"> und Verknüpfung<br><br>
				<%section name="cat" loop=$tpl_cat%>
					<input type="checkbox" name="frm_cat[]" id="frm_cat[]" value="<%$tpl_cat[cat].catid%>">&nbsp;<%$tpl_cat[cat].cat%>&nbsp;(<%$tpl_cat[cat].count%>) <br>
				<%/section%>
			</td>
			<td valign="top">
				<b>Absendername:</b><br>
				<input type="input" name="frm_sender" id="frm_sender" value="<%$tpl_hotelname%>" size="80"><br>
				<br>
				<b>Absenderemail:</b><br>
				<input type="input" name="frm_senderemail" id="frm_senderemail" value="<%$tpl_hotelemail%>" size="80">
				<br><br>
				<table boder="0" cellpadding="2">
					<tr>
						<td><b>Anhang:</b></td>
						<td><b>Anhang 2:</b></td>
					</tr>
					<tr>
						<td><input type="file" name="frm_file1" id="frm_file1" value=""></td>
						<td><input type="file" name="frm_file2" id="frm_file2" value=""></td>
					</tr>
				</table>
			</td>
		</tr>					
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<b>Betreff:</b><br>
				<input type="input" name="frm_subject" id="frm_subject" value="" size="120">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<b>Mail:</b><br>
				<input type="checkbox" id="frm_salutation" name="frm_salutation" value="yes"> automatische Anrede einf&uuml;gen<br>
				<textarea name="frm_body" id="frm_body" cols="120" rows="10"></textarea>
			</td>
		</tr>	
			
	</table>

	
	</form>
	<%/if%>
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

