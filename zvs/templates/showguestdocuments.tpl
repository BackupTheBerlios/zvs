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
	<p align="right"><a href="<%$wwwroot%>showguestdocuments.php/showall.true/guestid.<%$tpl_guestid%>/type.<%$tpl_type%>/showguestdocuments.php"><img src="<%$wwwroot%>img/showall.png" border="0" width="16" height="16" boder="0" alt="alle anzeigen"></a></p>
    <p class="SubheadlineYellow">Buchungen <%if $tpl_gast.lastname neq ""%>von <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></p>
     <table boder="0" cellspacing="0" cellpadding="3" width="500">
      <tr>
	    <td class="ListL1Header" width="80"><strong>von</strong></td>
	    <td class="ListL1Header" width="80"><strong>bis</strong></td>
	    <td class="ListL1Header" width="340"><strong>Buchungsnummer</strong></td>
	  </tr>
     <%section name=book loop=$tpl_bookings%>
       <tr>
         <td class="ListL<%$tpl_bookings[book].color%>"><%$tpl_bookings[book].start_date%></td>
		 <td class="ListL<%$tpl_bookings[book].color%>"><%$tpl_bookings[book].end_date%></td>
   		 <td class="ListL<%$tpl_bookings[book].color%>"><%$tpl_bookings[book].reference_id%>
       </tr>
     <%sectionelse%>
       <tr>
          <td class="ListL0" colspan="3">Es liegen keine Buchungen vor</td>
       </tr>
     <%/section%>
     </table>
	    <p class="SubheadlineYellow">letzte Aufenthalte <%if $tpl_gast.lastname neq ""%>von <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></p>
     <table boder="0" cellspacing="0" cellpadding="3" width="500">
	   <tr>
	    <td class="ListL1Header" width="80"><strong>von</strong></td>
	    <td class="ListL1Header" width="80"><strong>bis</strong></td>
	    <td class="ListL1Header" width="170"><strong>Buchungsnummer</strong></td>
	    <td class="ListL1Header" width="170"><strong>Bucher</strong></td>
	   </tr>
     <%section name=stay loop=$tpl_laststays%>
       <tr>
         <td class="ListL<%$tpl_laststays[stay].color%>"><%$tpl_laststays[stay].start_date%></td>
		 <td class="ListL<%$tpl_laststays[stay].color%>"><%$tpl_laststays[stay].end_date%></td>
		 <td class="ListL<%$tpl_laststays[stay].color%>"><%$tpl_laststays[stay].reference_id%></td>
		 <td class="ListL<%$tpl_laststays[stay].color%>"><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_laststays[stay].thisguestid%>"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a> <%$tpl_laststays[stay].firstname%>&nbsp;<%$tpl_laststays[stay].lastname%></td>
       </tr>
     <%sectionelse%>
       <tr>
          <td class="ListL0" colspan="4">Es liegen keine Aufenthalte vor</td>
       </tr>
     <%/section%>
     </table>
	<br><br>
	    <p class="SubheadlineYellow">letzte Meldebescheinigungen <%if $tpl_gast.lastname neq ""%>von <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></p>
     <table boder="0" cellspacing="0" cellpadding="3" width="500">
	   <tr>
	    <td class="ListL1Header" width="80"><strong>von</strong></td>
	    <td class="ListL1Header" width="80"><strong>bis</strong></td>
	    <td class="ListL1Header" width="340"><strong>Meldebescheinigung</strong></td>
	   </tr>
     <%section name=melde loop=$tpl_meldedocuments%>
       <tr>
		 <td class="ListL<%$tpl_meldedocuments[melde].color%>"><%$tpl_meldedocuments[melde].start_date%></td>
		 <td class="ListL<%$tpl_meldedocuments[melde].color%>"><%$tpl_meldedocuments[melde].end_date%></td>
         <td class="ListL<%$tpl_meldedocuments[melde].color%>"> <a href="<%$wwwroot%>meldescheinrtf.php/bookid.<%$tpl_meldedocuments[melde].booking_id%>" target="_blank"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="Meldebescheinigung" border="0"></a></td>
       </tr>
     <%sectionelse%>
       <tr>
          <td class="ListL0" colspan="3">Es liegen keine Meldebescheinigungen vor</td>
       </tr>
     <%/section%>
     </table>
	<br><br>
	    <p class="SubheadlineYellow">Rechnungen <%if $tpl_gast.lastname neq ""%>von <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></p>
     <table boder="0" cellspacing="0" cellpadding="3" width="500">
	   <tr>
	    <td class="ListL1Header" width="14">&nbsp;</td>
		<td class="ListL1Header" width="80"><strong>Rechnungsdatum</strong></td>
		<td class="ListL1Header" width="180"><strong>Rechnungsnummer</strong></td>
	    <td class="ListL1Header" width="80"><strong>von</strong></td>
	    <td class="ListL1Header" width="80"><strong>bis</strong></td>
	    <td class="ListL1Header" width="160"><strong>Rechnung</strong></td>
	   </tr>
     <%section name=receipt loop=$tpl_lastreceipts%>
       <tr>
		 <td class="ListL<%$tpl_lastreceipts[receipt].color%>"><img src="<%$wwwroot%>img/<%$tpl_lastreceipts[receipt].type%><%$tpl_lastreceipts[receipt].color%>.png" width="14" height="14" border="0"></td>	   
		 <td class="ListL<%$tpl_lastreceipts[receipt].color%>"><%$tpl_lastreceipts[receipt].receipt_date%></td>		 
		 <td class="ListL<%$tpl_lastreceipts[receipt].color%>"><%$tpl_lastreceipts[receipt].reference_id%></td>
		 <td class="ListL<%$tpl_lastreceipts[receipt].color%>"><%$tpl_lastreceipts[receipt].start_date%></td>
		 <td class="ListL<%$tpl_lastreceipts[receipt].color%>"><%$tpl_lastreceipts[receipt].end_date%></td>

         <td class="ListL<%$tpl_lastreceipts[receipt].color%>"><a href="<%$wwwroot%>receiptrtf.php/receiptid.<%$tpl_lastreceipts[receipt].receipt_id%>/receiptrtf.php" target="_blank"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="Rechnung" border="0"></a>&nbsp;<a href="<%$wwwroot%>receipt.php/receiptid.<%$tpl_lastreceipts[receipt].receipt_id%>/guestid.<%$tpl_lastreceipts[receipt].guest_id%>/bookid.<%$tpl_lastreceipts[receipt].book_id%>/receipt.php" target="_blank"><img src="<%$wwwroot%>img/edit.png" hight="16" width="16" alt="Rechnung &auml;ndern" border="0"></a></td>
       </tr>
     <%sectionelse%>
       <tr>
          <td class="ListL0" colspan="6">Es liegen keine Rechnungen vor</td>
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

