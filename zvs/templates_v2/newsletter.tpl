<%include file=header.tpl%>
<%strip%>	
<form accept-charset="utf-8" name="newsletter" id="newsletter" method="post" action="<%$SCRIPT_NAME%>">
<fieldset class="w400">
	<legend>##NEWSLETTER##</legend>
	<%if $tpl_sent eq 'true'%>
		##NEWSLETTER_1## <%$tpl_number%> ##NEWSLETTER_2##
	<%else%>

	<table border="0" cellpadding="10" cellspacing="0">
		<tr>
			<td valign="top"><b>##SELECT_CATEGORIES##</b><br>
				<input type="checkbox" name="frm_andop" id="frm_andop" value="yes" class="nomargin"> ##AND_OP##<br><br>
				<%section name="cat" loop=$tpl_cat%>
					<input type="checkbox" name="frm_cat[]" id="frm_cat[]" value="<%$tpl_cat[cat].catid%>" class="nomargin">&nbsp;<%$tpl_cat[cat].cat%>&nbsp;(<%$tpl_cat[cat].count%>) <br/>
				<%/section%>
			</td>
			<td valign="top">
				<b>##SENDER_NAME##</b><br>
				<input type="text" name="frm_sender" id="frm_sender" value="<%$tpl_hotelname%>" size="80" class="nomargin"><br>
				<br>
				<b>##SENDER_MAIL##</b><br>
				<input type="text" name="frm_senderemail" id="frm_senderemail" value="<%$tpl_hotelemail%>" size="80" class="nomargin">
				<br><br>
				<table boder="0" cellpadding="2">
					<tr>
						<td><b>##ATTACHMENT##</b></td>
						<td><b>##ATTACHMENT## 2</b></td>
					</tr>
					<tr>
						<td><input type="file" name="frm_file1" id="frm_file1" value="" class="nomargin"></td>
						<td><input type="file" name="frm_file2" id="frm_file2" value="" class="nomargin"></td>
					</tr>
				</table>
			</td>
		</tr>					
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<b>##SUBJECT##</b><br>
				<input type="text" name="frm_subject" id="frm_subject" value="" size="120" class="nomargin">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<b>##EMAIL##</b><br>
				<input type="checkbox" id="frm_salutation" name="frm_salutation" value="yes" class="nomargin">##AUTOMATIC_SALUTATION##<br/>
				<textarea name="frm_body" id="frm_body" cols="120" rows="10"></textarea>
			</td>
		</tr>	
		<tr>
			<td colspan="2">
				<p align="right"><input type="submit" onClick="unsetaltered();" value="##SEND## &raquo;" ></p>
			</td>
		</tr>	
	</table>
	<%/if%>
</fieldset>
	
	
	</form>




<%include file=footer.tpl%>
<%/strip%>

