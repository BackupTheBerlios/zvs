<%strip%>
<%include file=header.tpl%>
<br>
<form name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
<input name="frm_newstart" id="frm_newstart" type="hidden" value="false">
<table width="450" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Mitarbeiterzeiten</p>
	von: 
	<select name="frm_start" id="frm_start" onChange="javascript:document.select.frm_newstart.value='true';document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_thestart%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	&nbsp;
	bis: 
	<select name="frm_end" id="frm_end" onChange="javascript:document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_theend%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	<br>
	<table border="0" cellspacing="0" cellpadding="3" width="550">
		<tr>
				<td class="ListL1">
		  			<strong>Kommen</strong>
		  		</td>	
				<td class="ListL1">
		  			<strong>Gehen</strong>
		  		</td>					
				<td class="ListL1">
		  			<strong>Zeit</strong>
		  		</td>	
		   </tr>				   
			<%section name=list loop=$tpl_list%>
				<tr>
				    <td class="ListL<%$tpl_list[list].color%>"><%$tpl_list[list].start_date%>&nbsp;</td>
					<td class="ListL<%$tpl_list[list].color%>"><%$tpl_list[list].end_date%>&nbsp;</td>
					<td class="ListL<%$tpl_list[list].color%>"><%$tpl_list[list].diff%>&nbsp;</td>					
				</tr>
			<%/section%>
		</table>
	
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</form>
<%include file=footer.tpl%>
<%/strip%>

