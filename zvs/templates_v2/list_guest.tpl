<%strip%>
<%include file=header.tpl%>
<div class="boxdyn">
		<h2><span>##ATTENDANCE_LIST## (##CHECKED_IN##) <a href="<%$wwwroot%>list_guest_csv.php/bcat.<%$tpl_thebookcat%>/list_guest_csv.php"><img src="<%$wwwroot%>img/export.png" width="16" height="16" border="0" alt="##EXPORT_CSV##"></a>
	<a href="<%$wwwroot%>list_guest_rtf.php/bcat.<%$tpl_thebookcat%>/list_guest_rtf.php"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="##EXPORT_RTF##" border="0"></a></span></h2>
		<br/>
  <div class="table">
<form accept-charset="utf-8" name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">

	##CATEGORY_OF_BOOKING##: 
	<select name="frm_bookcat" id="frm_bookcat" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_thebookcat eq "-1"%>selected<%/if%>>##ALL##</option>
	<%section name="bookcat" loop="$tpl_bookcat%>
		<option value="<%$tpl_bookcat[bookcat].bcatid%>" <%if $tpl_thebookcat eq $tpl_bookcat[bookcat].bcatid%>selected<%/if%>><%$tpl_bookcat[bookcat].name%></option>
	<%/section%>
	</select>	
	<br>
    	<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr class="ListHeader">
			  <th>##ROOM##</th>
				<th>##LASTNAME##</th>
				<th>##FIRSTNAME##</th>
				<th>##EMAIL##</th>
				<th>##FROM##</th>
				<th>##UNTIL##</th>
				<th>##CATEGORY_OF_BOOKING##</th>
				<th>##STATUS_OF_BOOKING##</th>
				<th>##ADULT##</th>
				<th><%$tpl_children0_field%></th>
				<th><%$tpl_children1_field%></th>
				<th><%$tpl_children2_field%></th>
				<th><%$tpl_children3_field%></th>								
			</tr>	    	
			<%section name=guest loop=$tpl_guests%>
			<tr class="ListL<%$tpl_guests[guest].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_guests[guest].color%>'">
			<%if $smarty.section.guest.last%>
				<td colspan="8" align="right"><b>Summe:</b></td>			
				<td><%$tpl_guests[guest].person%></td>				
				<td><%$tpl_guests[guest].children0%></td>
				<td><%$tpl_guests[guest].children1%></td>
				<td><%$tpl_guests[guest].children2%></td>
				<td><%$tpl_guests[guest].children3%></td>															
			</tr>
			<%else%>			
				<td><%$tpl_guests[guest].room%></td>			
				<td><%$tpl_guests[guest].lastname%></td>
				<td><%$tpl_guests[guest].firstname%></td>
				<td><a href="mailto:<%$tpl_guests[guest].email%>"><%$tpl_guests[guest].email%></a></td>
				<td><%$tpl_guests[guest].startdate%></td>
				<td><%$tpl_guests[guest].enddate%></td>
				<td><%$tpl_guests[guest].bookingcat%></td>	
				<td><%$tpl_guests[guest].bookingtype%></td>					
				<td><%$tpl_guests[guest].person%></td>				
				<td><%$tpl_guests[guest].children0%></td>
				<td><%$tpl_guests[guest].children1%></td>
				<td><%$tpl_guests[guest].children2%></td>
				<td><%$tpl_guests[guest].children3%></td>															
			<%/if%>
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="13">keine Eintr&auml;ge</td>
			</tr>
			<%/section%>
		</table>
</form>
</div>
</div>
<%include file=footer.tpl%>
<%/strip%>
