<%strip%>
<%include file=header.tpl%>
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Mitarbeiter Anwesenheitsliste &nbsp;&nbsp;</p>
		<br>
    	<table border="0" cellspacing="0" cellpadding="3">
			<tr>
			    <td class="ListL1Header"><b>Name</b></td>				
				<td class="ListL1Header"><b>seit</b></td>
			</tr>
			<%section name=employee loop=$tpl_employees%>
			<tr>
				<td class="ListL<%$tpl_employees[employee].color%>" valign="top">
					  <%$tpl_employees[employee].firstname%>&nbsp;<%$tpl_employees[employee].lastname%>
				</td>			
				<td class="ListL<%$tpl_employees[employee].color%>" valign="top">
					  <%$tpl_employees[employee].start_date%>
				</td>		
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="2">kein Mitarbeiter anwesend</td>
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

<%include file=footer.tpl%>
<%/strip%>
