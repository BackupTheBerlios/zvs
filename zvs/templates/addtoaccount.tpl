<%strip%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: <%$tpl_title%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<%/strip%>
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/confirmleave.js"></script>
<%if $tpl_close eq "true"%>
<script language="JavaScript" type="text/javascript">
<!--
	opener.location.reload();
    self.close();
//-->
</script>
<%/if%>
<%strip%>
</HEAD>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<br>
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
     <p class="SubheadlineYellow">##PAYMENT_ENTRY## ##FOR## <%$tpl_bookdate.bookingreferenceid%>&nbsp;(<%$tpl_bookdate.start%>&nbsp;-&nbsp;<%$tpl_bookdate.end%>)</p>
<form name="account" id="account" action="<%$SCRIPTNAME%>" method="post">
	<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%$tpl_guestid%>">
	<input type="hidden" name="frm_bookingid" id="frm_bookingid" value="<%$tpl_bookingid%>">
	<input type="hidden" name="frm_receiptid" id="frm_receiptid" value="<%$tpl_receiptid%>">	
	<input type="hidden" name="frm_on_receipt" id="frm_on_receipt" value="<%$tpl_on_receipt%>">
	<%section name=id loop=$tpl_bookids%>
	<input type="hidden" name="frm_bookids[]" id="frm_bookids[]" value="<%$tpl_bookids[id]%>">
	<%/section%>	
     <table boder="0" cellspacing="0" cellpadding="3" border="0" width="650">
      <tr>
	    <td class="ListL1Header" width="300"><strong>##DESCRIPTION##</strong></td>
	    <td class="ListL1Header" width="80"><strong>##AMOUNT##</strong></td>
		<td class="ListL1Header" width="150">&nbsp;</td> 
	  </tr>
	  <tr>
		<td class="ListL0">
			<table border="0">
			<tr>
			  <td>
		##PAYMENT_CATEGORY##:</td>
		<td>
		 <select name="frm_paycat" id="frm_paycat">
		 <%section name=pcat loop=$tpl_pcats%>
		 	<option value="<%$tpl_pcats[pcat].catid%>"><%$tpl_pcats[pcat].cat%></option>
		 <%/section%>
		 </select>
		 </td>
		 </tr>
		 <tr>
		 <td>##PAYMENT_ENTRY##:</td>
		 <td>
	<input name="frm_date_payment" type="text" id="frm_date_payment" size="10" value="<%$tpl_thedate%>"><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar1Callback(date, month, year)
        {
            document.forms['account'].frm_date_payment.value = date + '.' + month + '.' + year;
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['account'].frm_date_payment.value;
        	if (strDate != "")
			{
				arrDate = strDate.split(".");
				month = arrDate[1]-1;
				year = arrDate[2];
				day = arrDate[0];
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}
         return strDate
        }

        calendar1 = new dynCalendar('calendar1', 'calendar1Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%>	
		</td>
		</tr>
		<tr> 
		 <td colspan="2"><textarea name="frm_description" id="frm_description" rows="3" cols="50"></textarea></td>
		</tr>
	</table>
	</td>	
		<td class="ListL0"><input type="text" name="frm_amount" id="frm_amount" size="8" value="<%$tpl_difference%>"></td>
		<td class="ListL0"><a href="javascript:document.account.submit();"><img src="<%$wwwroot%>img\button_<%if $tpl_on_receipt eq "false"%>zahlung<%else%>kassa<%/if%>.png" width="73" heigh="24" border="0"></a></td>
	 </tr>
	 </table>
	 <%section name="i" loop="$tpl_bookings"%>
 		<%if $tpl_bookingid neq $tpl_bookings[i].bookid%>
	 	<%if $smarty.section.i.index eq 0 %>
			<b>##SET_STATUS_OF_ADDITIONAL_BOOKINGS##:</b><br>
		<%/if%>
			<input type="checkbox" name="frm_bookings[]" id="frm_bookings[]" value="<%$tpl_bookings[i].bookid%>" checked="checked"> <%$tpl_bookings[i].bookingreferenceid%>&nbsp;(<%$tpl_bookings[i].start%>&nbsp;-&nbsp;<%$tpl_bookings[i].end%>)<br>
		<%/if%> 
	 <%/section%>
</form>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>	 
</body>
</html>
<%/strip%>
