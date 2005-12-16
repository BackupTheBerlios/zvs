<%strip%>
<%include file=header.tpl%>
<div class="boxdyn">
	<h2><span>##PAYMENT_ENTRY## <%if $tpl_gast.lastname neq ""%>##FROM## <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%> <a href="<%$wwwroot%>account.php/showall.true/guestid.<%$tpl_guestid%>/type.<%$tpl_type%>/account.php"><img src="<%$wwwroot%>img/showall.png" border="0" width="16" height="16" boder="0" alt="##SHOW_ALL##"></a></span></h2>
 <div class="table">  
		<form accept-charset="utf-8" name="account" id="account" action="<%$wwwroot%>account.php/guestid.<%$tpl_guestid%>/type.<%$tpl_type%>/account.php" method="post">
     <table boder="0" cellspacing="0" cellpadding="3" border="0" width="650">
			<tr class="ListHeader">
				<th>##DATE##</th>
				<th>##DESCRIPTION##</th>
				<th>##AMOUNT##</th>
				<th>##BOOKING##</th>
				<th>&nbsp;</th>
			</tr>     
  	  <tr class="ListL0" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL0'">
	  	<td>&nbsp;</td>
		  <td>
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
				Check = confirm("##ATTENTION_CHANGES_BILL##");
				return Check;
			}
			
			function confirmDelete2() {
				Check = confirm("##REALLY_DELETE_BOOKING##?");
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
		<td><input type="text" name="frm_amount" id="frm_amount" size="8"/></td>
		<td><select name="frm_bookingid" id="frm_bookingid">
					<%section name=book loop=$tpl_openbookings%>
						<option value="<%$tpl_openbookings[book].bookingid%>" class="<%if $tpl_openbookings[book].receipt neq ""%>mar<%else%>white<%/if%>"><%$tpl_openbookings[book].room%>:&nbsp;<%$tpl_openbookings[book].referenceid%>&nbsp;(<%$tpl_openbookings[book].start%>&nbsp;-&nbsp;<%$tpl_openbookings[book].end%>)</option>
					<%sectionelse%>
						<option>##NO_BOOKINGS##</option>
					<%/section%>
				</select>
		</td>
		<td><a href="javascript:document.account.submit();" class="dotted">##ADD##</a></td>
	 </tr>
     <%section name=account loop=$tpl_accounts%>
       <tr class="ListL<%$tpl_accounts[account].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_accounts[account].color%>'">
         <td><%$tpl_accounts[account].thedate%></td>
		 		 <td><b><%$tpl_accounts[account].paycat%></b><br><%$tpl_accounts[account].description%></td>
   		 	 <td align="right"><%$tpl_accounts[account].amount%>&nbsp;EUR</td>
		     <td><%$tpl_accounts[account].room%>: <%if $tpl_accounts[account].receiptid neq ""%><a href="<%$wwwroot%>receiptrtf.php/receiptid.<%$tpl_accounts[account].receiptid%>/receiptrtf.php" target="_blank"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="##BILL##" border="0"></a>&nbsp;<%$tpl_accounts[account].referenceid%><%else%><%$tpl_accounts[account].breferenceid%><%/if%></td>
		     <td><a href="<%$wwwroot%>account.php/guestid.<%$tpl_guestid%>/type.<%$tpl_type%>/do.del/id.<%$tpl_accounts[account].accountid%>/account.php" onclick="return <%if $tpl_accounts[account].receiptid neq ""%>confirmDelete();<%else%>confirmDelete2();<%/if%>" class="dotted">##DELETE##</a>&nbsp;</td>
       </tr>
     <%sectionelse%>
       <tr>
          <td colspan="5">##NO_SALES##</td>
       </tr>
     <%/section%>
     </table>
	</form>
</div>
</div>
<%include file=footer.tpl%>
<%/strip%>

