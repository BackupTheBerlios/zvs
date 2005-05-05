<%strip%>
<%include file=header.tpl%>
<form name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Anwesenheitsliste (Checked In)&nbsp;&nbsp;
	<a href="<%$wwwroot%>list_guest_csv.php/bcat.<%$tpl_thebookcat%>/list_guest_csv.php"><img src="<%$wwwroot%>img/export.gif" width="20" height="20" border="0" alt="Export nach CSV"></a>
	<a href="<%$wwwroot%>list_guest_rtf.php/bcat.<%$tpl_thebookcat%>/list_guest_rtf.php"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="Export nach RTF" border="0"></a>
	</p>
	Buchungskategorie: 
	<select name="frm_bookcat" id="frm_bookcat" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_thebookcat eq "-1"%>selected<%/if%>>alle</option>
	<%section name="bookcat" loop="$tpl_bookcat%>
		<option value="<%$tpl_bookcat[bookcat].bcatid%>" <%if $tpl_thebookcat eq $tpl_bookcat[bookcat].bcatid%>selected<%/if%>><%$tpl_bookcat[bookcat].name%></option>
	<%/section%>
	</select>	
	<br>
    	<table border="0" cellspacing="0" cellpadding="3" width="500">
			<tr>
				<td class="ListL1Header"><b>Zimmer</b></td>
			    <td class="ListL1Header"><b>Nachname</b></td>				
			    <td class="ListL1Header"><b>Vorname</b></td>
				<td class="ListL1Header"><b>Email</b></td>
				<td class="ListL1Header"><b>von</b></td>
				<td class="ListL1Header"><b>bis</b></td>
				<td class="ListL1Header"><b>Buchungskategorie</b></td>
				<td class="ListL1Header"><b>Buchungsstatus</b></td>
				<td class="ListL1Header"><b>Erwachsene</b></td>
				<td class="ListL1Header"><b><%$tpl_children0_field%></b></td>
				<td class="ListL1Header"><b><%$tpl_children1_field%></b></td>
				<td class="ListL1Header"><b><%$tpl_children2_field%></b></td>
				<td class="ListL1Header"><b><%$tpl_children3_field%></b></td>								
			</tr>
			<%section name=guest loop=$tpl_guests%>
			<%if $smarty.section.guest.last%>
			<tr>
				<td colspan="8" class="ListL<%$tpl_guests[guest].color%>" align="right">
					  <b>Summe: </b>
				</td>			
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].person%>
				</td>				
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].children0%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].children1%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].children2%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].children3%>
				</td>															
			</tr>
			</tr>
			<%else%>			
			<tr>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].room%>
				</td>			
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].lastname%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].firstname%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].email%>&nbsp;
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].startdate%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].enddate%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].bookingcat%>
				</td>	
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].bookingtype%>
				</td>					
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].person%>
				</td>				
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].children0%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].children1%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].children2%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].children3%>
				</td>															
			</tr>
			<%/if%>
			<%sectionelse%>
			<tr>
			    <td colspan="13">keine Eintr&auml;ge</td>
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
