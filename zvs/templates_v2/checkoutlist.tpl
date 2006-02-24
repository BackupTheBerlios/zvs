<%strip%>
<%include file=header.tpl%>
<%/strip%>
<SCRIPT TYPE="text/javascript">
<!--
    function openWindow(url){
    F1 = window.open(url,'checkin','width=800,height=550,left=0,top=0,scrollbars=yes');
    F1.focus();
    }
//-->
</SCRIPT>
<%strip%>
	<h1>##CHECK_OUT##</h1>
   	<table class="list">
     <colgroup>
     	<col width="100">
        <col width="200">
        <col width="200">
        <col width="80">
        <col width="80">
        <col width="100">
     </colgroup>    		
			<tr class="ListHeader">
				<th>##ROOM##</th>
		        <th>##FIRSTNAME##</th>
				<th>##LASTNAME##</th>
				<th>##FROM##</th>
				<th>##UNTIL##</th>
				<th>&nbsp;</th>
			</tr>
			<%section name=guest loop=$tpl_guests%>
			<tr class="ListL<%$tpl_guests[guest].color%>" onmouseover="this.className='ListHighlight'" onmouseout="this.className='ListL<%$tpl_guests[guest].color%>'" onclick="openWindow('<%$wwwroot%>editbook.php/bookid.<%$tpl_guests[guest].bookingid%>/bookingdetailid.<%$tpl_guests[guest].bookingdetailid%>/checkout.true');">
				<td><%$tpl_guests[guest].room%></td>			
				<td><%$tpl_guests[guest].lastname%></td>
				<td><%$tpl_guests[guest].firstname%></td>
				<td><%$tpl_guests[guest].startdate%></td>
				<td><%$tpl_guests[guest].enddate%></td>
				<td><%if $tpl_checkout eq 'true'%><a href="javascript:openWindow('<%$wwwroot%>editbook.php/bookid.<%$tpl_guests[guest].bookingid%>/bookingdetailid.<%$tpl_guests[guest].bookingdetailid%>/checkout.true');" class="dotted">##CHECK_OUT##</a><strong>&nbsp;&raquo;</strong><%else%>&nbsp;<%/if%></td>
			</tr>
			<%sectionelse%>
			<tr class="ListL0" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL0'">
			    <td colspan="6">##NO_ENTRYS##</td>
			</tr>
			<%/section%>
		</table>
<%include file=footer.tpl%>
<%/strip%>
