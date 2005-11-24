<%strip%>
<%include file=header.tpl%>

<div class="boxdyn">
	<h2><span>##BOOKING_PLURAL## <%if $tpl_gast.lastname neq ""%>##FROM## <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%> <a href="<%$wwwroot%>showguestdocuments.php/showall.true/guestid.<%$tpl_guestid%>/type.<%$tpl_type%>/showguestdocuments.php"><img src="<%$wwwroot%>img/showall.png" border="0" width="16" height="16" boder="0" alt="##SHOW_ALL##"></a></span></h2>
 <div class="table">  
     <table boder="0" cellspacing="0" cellpadding="3" width="500">
			<colgroup>
      	<col width="80">
      	<col width="80">
      	<col width="340">
     	</colgroup>		     
      <tr class="ListHeader">
	    <th><strong>##FROM##</th>
	    <th><strong>##UNTIL##</th>
	    <th><strong>##BOOKING_NUMBER##</th>
	  </tr>
     <%section name=book loop=$tpl_bookings%>
       <tr class="ListL<%$tpl_bookings[book].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_bookings[book].color%>'">
         <td><%$tpl_bookings[book].start_date%></td>
		 		 <td><%$tpl_bookings[book].end_date%></td>
   		 	 <td><%$tpl_bookings[book].reference_id%>
       </tr>
     <%sectionelse%>
       <tr class="ListL0" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL0'">
          <td colspan="3">##NO_BOOKINGS##</td>
       </tr>
     <%/section%>
     </table>
     <br/>
	   <h3>##LAST_STAYS## <%if $tpl_gast.lastname neq ""%>##OF## <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></h3>
     <table boder="0" cellspacing="0" cellpadding="3" width="500">
			<colgroup>
      	<col width="80">
      	<col width="80">
      	<col width="170">
      	<col width="170">
     	</colgroup>		     
	   <tr class="ListHeader">
	    <th>##FROM##</th>
	    <th>##UNTIL##</th>
	    <th>##BOOKING_NUMBER##</th>
	    <th>##NAME##</th>
	   </tr>
     <%section name=stay loop=$tpl_laststays%>
       <tr class="ListL<%$tpl_laststays[stay].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_laststays[stay].color%>'">
         <td><%$tpl_laststays[stay].start_date%></td>
		 		 <td><%$tpl_laststays[stay].end_date%></td>
		 		 <td><%$tpl_laststays[stay].reference_id%></td>
		 		 <td><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_laststays[stay].thisguestid%>" class="dotted" title="##SHOW##"><%$tpl_laststays[stay].lastname%>, <%$tpl_laststays[stay].firstname%></a></td>
       </tr>
     <%sectionelse%>
       <tr class="ListL0" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL0'">
          <td colspan="4">##NO_STAYS##</td>
       </tr>
     <%/section%>
     </table>
	  <br/>
	  <h3>##LAST_REGISTRATION_CARDS## <%if $tpl_gast.lastname neq ""%>##OF## <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></h3>
     <table boder="0" cellspacing="0" cellpadding="3" width="500">
			<colgroup>
      	<col width="80">
      	<col width="80">
      	<col width="340">
     	</colgroup>     
	   <tr class="ListHeader">
	    <th>##FROM##</th>
	    <th>##UNTIL##</th>
	    <th>##REGISTRATION_CARD##</th>
	   </tr>
     <%section name=melde loop=$tpl_meldedocuments%>
       <tr class="ListL<%$tpl_meldedocuments[melde].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_meldedocuments[melde].color%>'">
		 		<td><%$tpl_meldedocuments[melde].start_date%></td>
		 		<td><%$tpl_meldedocuments[melde].end_date%></td>
        <td><a href="<%$wwwroot%>meldescheinrtf.php/bookid.<%$tpl_meldedocuments[melde].booking_id%>" target="_blank" class="dotted">##SHOW##</a></td>
       </tr>
     <%sectionelse%>
       <tr class="ListL0" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL0'">
          <td colspan="3">Es liegen keine Meldebescheinigungen vor</td>
       </tr>
     <%/section%>
     </table>
		<br/>
	   <h3>##BILLS## <%if $tpl_gast.lastname neq ""%>##OF## <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></h3>
     <table boder="0" cellspacing="0" cellpadding="3" width="550">
   		<colgroup>
   			<col width="14">
   			<col width="80">
   			<col width="180">
				<col width="80">
				<col width="80">				
				<col width="210">
 			</colgroup>		
	   <tr class="ListHeader">
	    <th>&nbsp;</th>
			<th>##INVOICE_DATE##</th>
			<th>##INVOICE_NUMBER##</th>
	    <th>##FROM##</th>
	    <th>##UNTIL##</th>
	    <th>##BILL##</th>
	   </tr>
     <%section name=receipt loop=$tpl_lastreceipts%>
       <tr class="ListL<%$tpl_lastreceipts[receipt].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_lastreceipts[receipt].color%>'">
		 		<td><img src="<%$wwwroot%>img/<%$tpl_lastreceipts[receipt].type%>.png" width="14" height="14" border="0"></td>	   
		 		<td><%$tpl_lastreceipts[receipt].receipt_date%></td>		 
		 		<td><%$tpl_lastreceipts[receipt].reference_id%></td>
		 		<td><%$tpl_lastreceipts[receipt].start_date%></td>
		 		<td><%$tpl_lastreceipts[receipt].end_date%></td>
        <td><a href="<%$wwwroot%>receiptrtf.php/receiptid.<%$tpl_lastreceipts[receipt].receipt_id%>/receiptrtf.php" target="_blank" class="dotted">##SHOW##</a>&nbsp;<a href="<%$wwwroot%>receipt.php/receiptid.<%$tpl_lastreceipts[receipt].receipt_id%>/guestid.<%$tpl_lastreceipts[receipt].guest_id%>/bookid.<%$tpl_lastreceipts[receipt].book_id%>/receipt.php" target="_blank" class="dotted">##EDIT##</a></td>
       </tr>
     <%sectionelse%>
       <tr class="ListL0" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL0'">
          <td>##NO_INVOICE##</td>
       </tr>
     <%/section%>
     </table>
 </div>
</div>
<%include file=footer.tpl%>
<%/strip%>

