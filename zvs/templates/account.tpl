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
	<p align="right"><a href="<%$wwwroot%>account.php/showall.true/guestid.<%$tpl_guestid%>/type.<%$tpl_type%>/account.php"><img src="<%$wwwroot%>img/showall.png" border="0" width="16" height="16" boder="0" alt="alle anzeigen"></a></p>
    <p class="SubheadlineYellow">Zahlungseingang <%if $tpl_gast.lastname neq ""%>von <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></p>
	<!--<b>Kontostand: <%if $tpl_balance neq ""%><%$tpl_balance%><%else%>0.00<%/if%>&nbsp;EUR</b>-->
	<form name="account" id="account" action="<%$wwwroot%>account.php/guestid.<%$tpl_guestid%>/type.<%$tpl_type%>/account.php" method="post">
     <table boder="0" cellspacing="0" cellpadding="3" border="0" width="650">
      <tr>
	    <td class="ListL1Header" width="80"><strong>Datum</strong></td>
	    <td class="ListL1Header" width="300"><strong>Beschreibung</strong></td>
	    <td class="ListL1Header" width="80"><strong>Betrag</strong></td>
		<td class="ListL1Header"><strong>##BOOKING##</strong></td>
		<td class="ListL1Header" width="150">&nbsp;</td> 
	  </tr>
	  <tr>
	  	<td class="ListL0">&nbsp;</td>
		<td class="ListL0">
		<table border="0">
			<tr>
			  <td>
		Zahlungskategorie:</td>
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
		
		function confirmDelete() {
			Check = confirm("Dieser Vorgang verändert eine bestehende Rechnung! Fortfahren?");
			return Check;
		}
		
		function confirmDelete2() {
			Check = confirm("Buchung wirklich löschen?");
			return Check;
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
		<td class="ListL0"><input type="text" name="frm_amount" id="frm_amount" size="8"></td>
		<td class="ListL0"><select name="frm_bookingid" id="frm_bookingid">
		<%section name=book loop=$tpl_openbookings%>
			<option value="<%$tpl_openbookings[book].bookingid%>" class="<%if $tpl_openbookings[book].receipt neq ""%>mar<%else%>white<%/if%>"><%$tpl_openbookings[book].room%>:&nbsp;<%$tpl_openbookings[book].referenceid%>&nbsp;(<%$tpl_openbookings[book].start%>&nbsp;-&nbsp;<%$tpl_openbookings[book].end%>)</option>
		<%sectionelse%>
			<option>##NO_BOOKINGS##</option>
		<%/section%>
		</select></td>
		<td class="ListL0"><a href="javascript:document.account.submit();"><img src="<%$wwwroot%>img\button_kassa.png" width="73" heigh="24" border="0"></a></td>
	 </tr>
     <%section name=account loop=$tpl_accounts%>
       <tr>
         <td class="ListL<%$tpl_accounts[account].color%>"><%$tpl_accounts[account].thedate%></td>
		 <td class="ListL<%$tpl_accounts[account].color%>"><b><%$tpl_accounts[account].paycat%></b><br><%$tpl_accounts[account].description%></td>
   		 <td class="ListL<%$tpl_accounts[account].color%>" align="right"><%$tpl_accounts[account].amount%>&nbsp;EUR</td>
		 <td class="ListL<%$tpl_accounts[account].color%>"><%$tpl_accounts[account].room%>: <%if $tpl_accounts[account].receiptid neq ""%><a href="<%$wwwroot%>receiptrtf.php/receiptid.<%$tpl_accounts[account].receiptid%>/receiptrtf.php" target="_blank"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="Rechnung" border="0"></a>&nbsp;<%$tpl_accounts[account].referenceid%><%else%><%$tpl_accounts[account].breferenceid%><%/if%></td>
		 <td class="ListL<%$tpl_accounts[account].color%>"><a href="<%$wwwroot%>account.php/guestid.<%$tpl_guestid%>/type.<%$tpl_type%>/do.del/id.<%$tpl_accounts[account].accountid%>/account.php" onclick="return <%if $tpl_accounts[account].receiptid neq ""%>confirmDelete();<%else%>confirmDelete2();<%/if%>"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0" alt="l&ouml;schen"></a>&nbsp;</td>
       </tr>
     <%sectionelse%>
       <tr>
          <td class="ListL1" colspan="5">##NO_SALES##</td>
       </tr>
     <%/section%>
     </table>
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
<%include file=footer.tpl%>
<%/strip%>

