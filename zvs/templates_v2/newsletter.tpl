<%include file=header.tpl%>
<%strip%>	
<div class="box750">
<h2><span>##NEWSLETTER##</span></h2>
	<%if $tpl_sent eq 'true'%>
		<p>##NEWSLETTER_1## <%$tpl_number%> ##NEWSLETTER_2##</p>
	<%else%>
<form accept-charset="utf-8" name="newsletter" id="newsletter" method="post" action="<%$SCRIPT_NAME%>">	
	<table border="0" cellpadding="10" cellspacing="0">
		<tr>
			<td valign="top"><label for="frm_cat" class="left">##SELECT_CATEGORIES##</label><br/>
				<input type="checkbox" name="frm_andop" id="frm_andop" value="yes" class="nomargin">##AND_OP##<br/><br/>
				<%section name="cat" loop=$tpl_cat%>
					<input type="checkbox" name="frm_cat[]" id="frm_cat[]" value="<%$tpl_cat[cat].catid%>" class="nomargin"/>&nbsp;<%$tpl_cat[cat].cat%>&nbsp;(<%$tpl_cat[cat].count%>) <br/>
				<%/section%>
			</td>
			<td valign="top">
				<label for="frm_sender" class="left">##SENDER_NAME##</label><br/>
				<input type="text" name="frm_sender" id="frm_sender" value="<%$tpl_hotelname%>" size="80" class="nomargin"/><br/>
				<br/>
				<label for="frm_senderemail" class="left">##SENDER_MAIL##</label><br/>
				<input type="text" name="frm_senderemail" id="frm_senderemail" value="<%$tpl_hotelemail%>" size="80" class="nomargin"/>
				<br/><br/>
				<table border="0" cellpadding="2">
					<tr>
						<td><label for="frm_file1" class="left">##ATTACHMENT##</label></td>
						<td><label for="frm_file2" class="left">##ATTACHMENT## 2</label></td>
					</tr>
					<tr>
						<td><input type="file" name="frm_file1" id="frm_file1" value="" class="nomargin"/></td>
						<td><input type="file" name="frm_file2" id="frm_file2" value="" class="nomargin"/></td>
					</tr>
				</table>
			</td>
		</tr>					
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<label for="frm_subject" class="left">##SUBJECT##</label><br/>
				<input type="text" name="frm_subject" id="frm_subject" value="" size="120" class="nomargin"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<label for="frm_body" class="left">##EMAIL##</label><br/>
				<span class="clear"><input type="checkbox" id="frm_salutation" name="frm_salutation" value="yes" class="nomargin"/>##AUTOMATIC_SALUTATION##</span><br/>
				<textarea name="frm_body" id="frm_body" cols="120" rows="10"></textarea>
			</td>
		</tr>	
		<tr>
			<td colspan="2">
				<p align="right"><input type="submit" onClick="unsetaltered();" value="##SEND## &raquo;" /></p>
			</td>
		</tr>	
	</table>
	</form>
	<%/if%>
</div>
<%include file=footer.tpl%>
<%/strip%>

