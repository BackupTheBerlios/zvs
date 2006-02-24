<%include file=header.tpl%>
<script language="JavaScript" type="text/javascript">
<!--
    function openWindow(url){
    F1 = window.open(url,'checkin','width=800,height=600,left=0,top=0,scrollbars=yes');
    F1.focus();
    }
//-->
</script>
<%strip%>
<h1>##CHECK_IN##</h1>
   	<table class="list">
     <colgroup>
        <col width="200">
        <col width="200">
        <col width="90">
        <col width="90">
        <col width="110">
     </colgroup>
			<tr class="ListHeader">
			  <th>##LASTNAME##</th>
			  <th>##FIRSTNAME##</th>
			  <th>##FROM##</th>
			  <th>##UNTIL##</th>
			  <th>&nbsp;</th>
			</tr>
			<%section name=guest loop=$tpl_guests%>
			<tr class="ListL<%$tpl_guests[guest].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_guests[guest].color%>'" onclick="openWindow('<%$wwwroot%>editbook.php/bookid.<%$tpl_guests[guest].bookingid%>/bookingdetailid.<%$tpl_guests[guest].bookingdetailid%>/checkin.true');">
				<td><%$tpl_guests[guest].lastname%></td>
				<td><%$tpl_guests[guest].firstname%></td>
				<td><%$tpl_guests[guest].startdate%></td>
				<td><%$tpl_guests[guest].enddate%></td>
				<td><a href="javascript:openWindow('<%$wwwroot%>editbook.php/bookid.<%$tpl_guests[guest].bookingid%>/bookingdetailid.<%$tpl_guests[guest].bookingdetailid%>/checkin.true');" class="dotted">##CHECK_IN##</a><strong>&nbsp;&raquo;</strong></td>
			</tr>
			<%sectionelse%>
			<tr class="ListL0" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL0'">
			    <td colspan="5">##NO_ENTRYS##</td>
			</tr>
			<%/section%>
		</table>
<%/strip%>
<%include file=footer.tpl%>

