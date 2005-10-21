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
<fieldset class="w400">
	<legend>##CHECK_OUT##</legend>
    	<table border="0" cellspacing="0" cellpadding="3" width="500">
			<tr>
				<td class="ListL1Header"><b>##ROOM##</b></td>
		    <td class="ListL1Header"><b>##FIRSTNAME##</b></td>
				<td class="ListL1Header"><b>##LASTNAME##</b></td>
				<td class="ListL1Header"><b>##FROM##</b></td>
				<td class="ListL1Header"><b>##UNTIL##</b></td>
				<td class="ListL1Header">&nbsp;</td>
			</tr>
			<%section name=guest loop=$tpl_guests%>
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
					  <%$tpl_guests[guest].startdate%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					  <%$tpl_guests[guest].enddate%>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>">
					<%if $tpl_checkout eq 'true'%><a href="javascript:openWindow('<%$wwwroot%>editbook.php/bookid.<%$tpl_guests[guest].bookingid%>/bookingdetailid.<%$tpl_guests[guest].bookingdetailid%>/checkout.true');"><img src="<%$wwwroot%>img/checkout.png" border="0" width="16" height="13" alt="##CHECK_OUT##"></a><%else%>&nbsp;<%/if%>
				</td>
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="5">##NO_ENTRYS##</td>
			</tr>
			<%/section%>
		</table>
</fieldset>
<%include file=footer.tpl%>
<%/strip%>
