<%strip%>
<%include file=header.tpl%>
<%/strip%>
<SCRIPT TYPE="text/javascript">
<!--
    function openWindow(url){
    F1 = window.open(url,'checkin','width=800,height=600,left=0,top=0,scrollbars=yes');
    F1.focus();
    }
//-->
</SCRIPT>
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
    <p class="SubheadlineYellow">##CHECK_IN##</p>
    	<table border="0" cellspacing="0" cellpadding="3" width="500">
			<tr>
			    <td class="ListL1Header"><b>##FIRSTNAME##</b></td>
				<td class="ListL1Header"><b>##LASTNAME##</b></td>
				<td class="ListL1Header"><b>##FROM##</b></td>
				<td class="ListL1Header"><b>##UNTIL##</b></td>
				<td class="ListL1Header">&nbsp;</td>
			</tr>
			<%section name=guest loop=$tpl_guests%>
			<tr>
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
					<a href="javascript:openWindow('<%$wwwroot%>editbook.php/bookid.<%$tpl_guests[guest].bookingid%>/bookingdetailid.<%$tpl_guests[guest].bookingdetailid%>/checkin.true');"><img src="<%$wwwroot%>img/checkin.png" border="0" width="15" height="13" alt="Check in"></a>
				</td>
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="5">##NO_ENTRYS##</td>
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
