<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: ##MAKE_BILL##</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="Javascript">
<!--
function openWindow(url, windowname)
{
  detailsWindow = window.open(url, windowname, "width=800,height=600,scrollbars=yes,resizable=yes");
  detailsWindow.focus();
}

//-->
</script>
</HEAD>
<%strip%>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<br>
<form name="receipt" id="receipt" action="<%$tpl_location%>" method="post">
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
	<%if $tpl_type eq 'bookings'%>
     <p class="SubheadlineYellow">##ADD_BOOKING_TO_BILL##</p>
	 <br>
	 <table boder="0" cellspacing="0" cellpadding="0">
	 	<tr>
			<td class="ListL1">&nbsp;</td>
			<td class="ListL1"><strong>##FROM##</strong></td>
			<td class="ListL1"><strong>##UNTIL##</strong></td>
			<td class="ListL1"><strong>##ROOM##</strong></td>
		</tr>
	 <%section name="ob" loop=$tpl_openBookings%>
	 	<tr>
			<td class="ListL<%$tpl_openBookings[ob].color%>"><input type="checkbox" name="frm_bookidarr[]" id="frm_bookidarr[]" value="<%$tpl_openBookings[ob].bookingid%>" <%$tpl_openBookings[ob].selected%>></td>
			<td class="ListL<%$tpl_openBookings[ob].color%>"><%$tpl_openBookings[ob].start%></td>
			<td class="ListL<%$tpl_openBookings[ob].color%>"><%$tpl_openBookings[ob].end%></td>
			<td class="ListL<%$tpl_openBookings[ob].color%>"><%$tpl_openBookings[ob].room%></td>
		</tr>
	 <%/section%>
	 </table>
	 <p align="right"><a href="javascript:document.receipt.submit();"><img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" border="0" alt="weiter"></a></p>
	 <%else%>
	     <p class="SubheadlineYellow">##THERE_ARE_MORE_BILLS_FOR_THIS_BOOKING##:</p>
		 <br>	
		 <table boder="0" cellspacing="5" cellpadding="0"> 
			<%section name="r" loop=$tpl_receipts%>
			<tr>
				<td><a href="javascript:openWindow('<%$wwwroot%>receipt.php/receiptid.<%$tpl_receipts[r].receiptid%>/bookid.<%$tpl_bookid%>/guestid.<%$tpl_receipts[r].guestid%>/receipt.php','receipt<%$smarty.section.r.index%>');"><img src="<%$wwwroot%>img/button_rechnung.png" border="0" width="80" height="24" alt="##BILL##"></a></td>
				<td><%$tpl_receipts[r].name%></td>
			</tr>
			<%/section%>
			<%section name="r" loop=$tpl_draftreceipts%>
			<tr>
				<td><a href="javascript:openWindow('<%$wwwroot%>receipt.php/draftreceiptid.<%$tpl_draftreceipts[r].draftreceiptid%>/bookid.<%$tpl_bookid%>/guestid.<%$tpl_draftreceipts[r].guestid%>/receipt.php','receipt<%$smarty.section.r.index%>');"><img src="<%$wwwroot%>img/button_rechnung.png" border="0" width="80" height="24" alt="##BILL##"></a></td>
				<td><%$tpl_draftreceipts[r].name%>&nbsp;(Rechnungsentwurf)</td>
			</tr>
			<%/section%>
 		 </table>		 
	 <%/if%>
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
</body>
<%/strip%>