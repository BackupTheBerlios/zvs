<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: Rechnung <%if $tpl_changed eq 'true'%>&auml;ndern<%else%>erstellen<%/if%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/confirmleave.js"></script>
<script language="javascript" type="text/javascript">
<!--
function save()
{
	var msg = "<%if $tpl_changed eq 'true'%>Soll die Rechnung ge" + unescape('%E4') + "ndert werden?<%else%>Soll jetzt eine Rechnung erstellt werden?<%/if%>";
	if (confirm(msg) )
	{
		document.receipt.frm_action.value = "save";
		document.receipt.submit();
	}
}

function savedraft()
{
	document.receipt.frm_action.value = "savedraft";
	document.receipt.submit();
}
function del(id)
{
	document.receipt.frm_action.value = "del";
	document.receipt.frm_action_id.value = id;
	document.receipt.submit();
}
function add(id)
{
	document.receipt.frm_action.value = "add";
	document.receipt.frm_action_id.value = id;
	document.receipt.submit();
}

function openSplitWindow(url)
{
	F = window.open(url,'','width=800,height=600,scrollbars=yes,resizable=yes');
	F.focus();
}
function addToAccount(onreceipt, guestid){
	if (onreceipt == 'true')
	{
	<%if $tpl_receiptdata.data.receiptid neq -1%>	
		if (confirm('Achtung:\nEs wurde schon eine Rechnung erstellt! Diese Aktion '+unescape("%E4")+'ndert die bestehende Rechnung!'))
		{
	<%/if%>
    url = '<%$wwwroot%>addtoaccount.php';
	F2 = window.open('about:blank','addtoaccount','width=700,height=350,left=0,top=0,scrollbars=yes');
	oldaction = document.receipt.action;
	
	document.receipt.action = url;
	document.receipt.target = 'addtoaccount';	
	document.receipt.frm_on_receipt.value = onreceipt;
	document.receipt.frm_accountguestid.value = guestid;
	document.receipt.submit();
	document.receipt.target = '';
	document.receipt.action = oldaction;
    F2.focus();
	<%if $tpl_receiptdata.data.receiptid neq -1%>
		}
	<%/if%>		
	} else {
    url = '<%$wwwroot%>addtoaccount.php';
    F2 = window.open('about:blank','addtoaccount','width=700,height=350,left=0,top=0,scrollbars=yes');
	oldaction = document.receipt.action;
	document.receipt.action = url;
	document.receipt.target = 'addtoaccount';	
	document.receipt.frm_on_receipt.value = onreceipt;	
	document.receipt.frm_accountguestid.value = guestid;
	document.receipt.submit();
	document.receipt.target = '';
	document.receipt.action = oldaction;
    F2.focus();
	}
}
	
function deleteDraft(){
	var msg = "Soll der Rechnungsentwurf gel" + unescape('%F6') + "scht werden?";
	if (confirm(msg) )
	{
		document.receipt.frm_action.value = "deletedraft";
		document.receipt.submit();
	}
}	

function changeAddress(address)
{
  document.receipt.frm_address.value=address;
}
//-->
</script>
</HEAD>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<br>
<%strip%>
<%if $tpl_error eq 'true'%>
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
     <p class="SubheadlineYellow">Fehler</p>
	 Die Rechnung konnte nicht erstellt werden. Bitte &uuml;berpr&uuml;fen Sie, ob f&uuml;r den gew&auml;hlten Zeitraum Saisonzeiten und Preise definiert sind.
	 <p align="right"><a href="javascript:self.close();"><img src="<%$wwwroot%>img/button_schliessen.png" width="86" height="24" border="0"></a></p>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>	 

<%elseif $tpl_saved eq 'true'%>
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
     <p class="SubheadlineYellow">Rechnung</p>
	 Die Rechnung wurde erstellt und kann nun abgerufen werden: <a href="<%$tpl_location%>"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="Rechnung" border="0">&nbsp;Rechnung</a>
	 <p align="right"><a href="javascript:self.close();"><img src="<%$wwwroot%>img/button_schliessen.png" width="86" height="24" border="0"></a></p>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>	 
<%elseif $tpl_saved eq 'draft'%>
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
     <p class="SubheadlineYellow">Rechnung</p>
	 Der Rechnungsentwurf wurde gespeichert!
	 <p align="right"><a href="javascript:self.close();"><img src="<%$wwwroot%>img/button_schliessen.png" width="86" height="24" border="0"></a></p>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>	
<%else%>
<form name="receipt" id="receipt" action="<%$wwwroot%>receipt.php" method="post">
<input type="hidden" name="frm_bookid" id="frm_bookid" value="<%$tpl_bookid%>">
	<%section name=id loop=$tpl_bookids%>
	<input type="hidden" name="frm_bookids[]" id="frm_bookids[]" value="<%$tpl_bookids[id]%>">
	<%/section%>	
<input type="hidden" name="frm_difference" id="frm_difference" value="<%$tpl_difference%>">	
<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%$tpl_receiptdata.data.guestid%>">
<input type="hidden" name="frm_accountguestid" id="frm_accountguestid" value="<%$tpl_receiptdata.data.guestid%>">
<input type="hidden" name="frm_action" id="frm_action" value="recalc">
<input type="hidden" name="frm_action_id" id="frm_action_id" value="">
<input type="hidden" name="frm_on_receipt" id="frm_on_receipt" value="">
<input type="hidden" name="frm_receiptid" id="frm_receiptid" value="<%$tpl_receiptdata.data.receiptid%>">
<input type="hidden" name="frm_draftreceiptid" id="frm_draftreceiptid" value="<%$tpl_receiptdata.data.draftreceiptid%>">
<input type="hidden" name="frm_changed" id="frm_changed" value="<%$tpl_changed%>">
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
     <p class="SubheadlineYellow">Rechnung  <%if $tpl_changed eq 'true'%>&auml;ndern<%else%>erstellen<%/if%><%if $tpl_draft eq 'true'%>&nbsp;(Rechnungsentwurf geladen) <a href="javascript:deleteDraft();"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0" alt="l&ouml;schen"></a><%/if%></p>
	 <%section name=id loop=$tpl_addguests%>
	 	<%if $smarty.section.id.first%><strong>Splitrechnung anfertigen:</strong><br><table boder="0"><%/if%>
	 	<tr>
			<td><a href="javascript:openSplitWindow('<%$wwwroot%>checkopenbookings.php/bookid.<%$tpl_bookid%>/guestid.<%$tpl_addguests[id].guestid%>/direct.true/receipt.php');"><%$tpl_addguests[id].lastname%>, <%$tpl_addguests[id].firstname%></a></td>
			<td><a href="javascript:openSplitWindow('<%$wwwroot%>checkopenbookings.php/bookid.<%$tpl_bookid%>/guestid.<%$tpl_addguests[id].guestid%>/direct.true/receipt.php');"><img src="<%$wwwroot%>img/button_rechnung.png" border="0" width="80" height="24" alt="Splitrechnung"></a></td>
			<td><a href="javascript:addToAccount('true',<%$tpl_addguests[id].guestid%>);"><img src="<%$wwwroot%>img\button_kassa.png" width="73" heigh="24" border="0" alt="Zahlung hinzuf&uuml;gen"></a></td>
			<td><%if $tpl_addguests[id].sum neq 0.00%>Anzahlung: <%$tpl_addguests[id].sum%>&nbsp;EUR<%/if%></td>
		</tr>
		<%if $smarty.section.id.last%></table><br><%/if%>
	 <%/section%>
	 <b>Anschrift:</b><br>
	 <%/strip%>
	 <textarea name="frm_address" id="frm_address" cols="80" rows="7"><%$tpl_receiptdata.data.address%></textarea><%strip%>
	 <br>
	 <%section name="add" loop=$tpl_addresses%>
	 	<%if $tpl_addresses[add].type eq 'P'%><a href="javascript:changeAddress('<%$tpl_addresses[add].address%>')">privat</a>&nbsp;<%elseif $tpl_addresses[add].type eq 'B'%><a href="javascript:changeAddress('<%$tpl_addresses[add].address%>')">gesch&auml;ftlich</a>&nbsp;<%elseif $tpl_addresses[add].type eq 'O'%><a href="javascript:changeAddress('<%$tpl_addresses[add].address%>')">weitere</a>&nbsp;<%/if%>
	 <%/section%>
		<br><br>
		<b>Rechnung</b> <%if $tpl_receiptdata.data.receiptid neq -1%><b>Nummer:</b> <%$tpl_receiptdata.data.referenceid%>&nbsp; <%/if%><b>vom</b> <input type="text" id="frm_receiptdate" name="frm_receiptdate" size="10" value="<%$tpl_receiptdata.data.receipt_date%>"><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar1Callback(date, month, year)
        {
            document.forms['receipt'].frm_receiptdate.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['receipt'].frm_receiptdate.value;
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
		<br>
		<%section name=id loop=$tpl_receiptdata.data.start_date%>
		<br>
		<b>Aufenthalt vom</b> <input type="text" id="frm_start_<%$smarty.section.id.index%>" name="frm_start_<%$smarty.section.id.index%>" size="10" value="<%$tpl_receiptdata.data.start_date[id]%>"><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar2<%$smarty.section.id.index%>Callback(date, month, year)
        {
            document.forms['receipt'].frm_start_<%$smarty.section.id.index%>.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2<%$smarty.section.id.index%>GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['receipt'].frm_start_<%$smarty.section.id.index%>.value;
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

        calendar2<%$smarty.section.id.index%> = new dynCalendar('calendar2<%$smarty.section.id.index%>', 'calendar2<%$smarty.section.id.index%>Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%>
	&nbsp;&nbsp; 
 <b>bis</b> <input type="text" id="frm_end_<%$smarty.section.id.index%>" name="frm_end_<%$smarty.section.id.index%>" size="10" value="<%$tpl_receiptdata.data.end_date[id]%>"><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar3<%$smarty.section.id.index%>Callback(date, month, year)
        {
            document.forms['receipt'].frm_end_<%$smarty.section.id.index%>.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar3<%$smarty.section.id.index%>GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['receipt'].frm_end_<%$smarty.section.id.index%>.value;
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

        calendar3<%$smarty.section.id.index%> = new dynCalendar('calendar3<%$smarty.section.id.index%>', 'calendar3<%$smarty.section.id.index%>Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%> 
	<%/section%>	
	<br><br>
	<%if $tpl_changed neq 'true' && $tpl_receiptdata.data.pauscherror neq ''%>
	<p class="DefError"><%$tpl_receiptdata.data.pauscherror%></p>
	<br><br>
	<%/if%>
		<select name="frm_article" id="frm_article">
			<option value="-1">Artikel ausw&auml;hlen</option>
			<%section name=art loop=$tpl_articles%>
			<option value="<%$tpl_articles[art].articleid%>"><%$tpl_articles[art].article%></option>
			<%/section%>
		</select>
		<br><br>
		<table border="0" cellspacing="0" cellpadding="3">
			<tr>
				<td class="ListL1">&nbsp;</td>
				<td class="ListL1"><b>Artikel</b></td>
				<td class="ListL1"><b>Menge</b></td>
				<td class="ListL1"><b>Netto-Einzel</b></td>
				<td class="ListL1"><b>MwSt</b></td>
				<td class="ListL1"><b>Brutto-Einzel</b></td>
				<td class="ListL1"><b>Netto-Gesamt</b></td>
				<td class="ListL1"><b>Brutto-Gesamt</b></td>
			</tr>
			<%section name=items loop=$tpl_receiptdata.items%>
				<tr>
				<td class="ListL<%$tpl_receiptdata.items[items].color%>"><a href="javascript:add(<%$smarty.section.items.rownum%>);"><img src="<%$wwwroot%>img/shutter_plus.gif" border="0" width="13" height="13" alt="hinzuf&uuml;gen"></a><%if $tpl_allowdelete eq 'true'%><a href="javascript:del(<%$smarty.section.items.rownum%>);"><img src="<%$wwwroot%>img/shutter_minus.gif" border="0" width="13" height="13" alt="l&ouml;schen"></a><%/if%></td>
				<td class="ListL<%$tpl_receiptdata.items[items].color%>">
						<input type="hidden" name="frm_itemid_<%$tpl_receiptdata.items[items].id%>" id="frm_itemid_<%$tpl_receiptdata.items[items].id%>" value="<%$tpl_receiptdata.items[items].itemid%>">
						<%/strip%>
						<textarea cols="40" rows="3" id="frm_article_<%$tpl_receiptdata.items[items].id%>" name="frm_article_<%$tpl_receiptdata.items[items].id%>"><%$tpl_receiptdata.items[items].article%></textarea>
						<%strip%>
					</td>
					<td class="ListL<%$tpl_receiptdata.items[items].color%>">
						<input type="text" name="frm_number_<%$tpl_receiptdata.items[items].id%>" id="frm_number_<%$tpl_receiptdata.items[items].id%>" size="3" value="<%$tpl_receiptdata.items[items].number%>">
					</td>
					<td class="ListL<%$tpl_receiptdata.items[items].color%>"><%$tpl_receiptdata.items[items].netto_single%>&nbsp;EUR</td>
					<td class="ListL<%$tpl_receiptdata.items[items].color%>"><input type="text" name="frm_mwst_<%$tpl_receiptdata.items[items].id%>" id="frm_mwst_<%$tpl_receiptdata.items[items].id%>" size="3" value="<%$tpl_receiptdata.items[items].mwst%>">%</td>
					<td class="ListL<%$tpl_receiptdata.items[items].color%>">
						<input type="text" size="6" id="frm_brutto_<%$tpl_receiptdata.items[items].id%>" name="frm_brutto_<%$tpl_receiptdata.items[items].id%>" value="<%$tpl_receiptdata.items[items].brutto_single%>"> EUR
					</td>
					<td class="ListL<%$tpl_receiptdata.items[items].color%>" align="right"><%$tpl_receiptdata.items[items].netto%>&nbsp;EUR</td>
					<td class="ListL<%$tpl_receiptdata.items[items].color%>" align="right"><%$tpl_receiptdata.items[items].brutto%>&nbsp;EUR</td>				</tr>
			<%/section%>
				<tr>
					<td colspan="6" class="ListL<%$tpl_nextcolor%>">&nbsp;</td>
					<td class="ListL<%$tpl_nextcolor%>" align="right"><%$tpl_receiptdata.data.price_netto_total%>&nbsp;EUR</td>
					<td class="ListL<%$tpl_nextcolor%>" align="right"><b><%$tpl_receiptdata.data.price_total%>&nbsp;EUR</b></td>
				</tr>
			<%section name=comm loop=$tpl_commission%>
				<tr>
					<td class="ListL<%$tpl_commission[comm].color%>">&nbsp;</td>
					<td colspan="6" class="ListL<%$tpl_commission[comm].color%>"><%$tpl_commission[comm].description|nl2br%>&nbsp;<input type="hidden" name="frm_commissionid[]" id=name="frm_commissionid[]" value="<%$tpl_commission[comm].accountid%>"></td>
					<td class="ListL<%$tpl_commission[comm].color%>" align="right"><%if $smarty.section.comm.last%><b><%/if%><%$tpl_commission[comm].amount%>&nbsp;EUR<%if $smarty.section.comm.last%></b><%/if%></td>
				</tr>		
			<%/section%>
			   <tr>
			   		<td class="ListL0" colspan="8"><img src="<%$wwwroot%>img/spacer.gif" height="1"></td>
			   </tr>
			<%section name=comm2 loop=$tpl_commission2%>
				<tr>
					<td class="ListL<%$tpl_commission2[comm2].color%>">&nbsp;</td>
					<td colspan="6" class="ListL<%$tpl_commission2[comm2].color%>"><%$tpl_commission2[comm2].description|nl2br%>&nbsp;<input type="hidden" name="frm_commission2id[]" id=name="frm_commission2id[]" value="<%$tpl_commission2[comm2].accountid%>"></td>
					<td class="ListL<%$tpl_commission2[comm2].color%>" align="right"><%if $smarty.section.comm2.last%><b><%/if%><%$tpl_commission2[comm2].amount%>&nbsp;EUR<%if $smarty.section.comm2.last%></b><%/if%></td>
				</tr>		
			<%/section%>
		</table>
		<br>
		<table border="0" width="100%">
			<tr>
				<td><a href="javascript:document.receipt.submit();"><img src="<%$wwwroot%>img/button_recalc.png" border="0" width="105" height="24" alt="neu berechnen"></a>&nbsp;<a href="javascript:addToAccount('true',<%$tpl_receiptdata.data.guestid%>);"><img src="<%$wwwroot%>img\button_kassa.png" width="73" heigh="24" border="0" alt="Zahlung hinzuf&uuml;gen"></a><%if $tpl_receiptdata.data.receiptid neq -1%>&nbsp;<a href="javascript:addToAccount('false',<%$tpl_receiptdata.data.guestid%>);"><img src="<%$wwwroot%>img\button_zahlung.png" width="73" heigh="24" border="0" alt="Zahlung nach Rechnungserstellung hinzuf&uuml;gen"></a><%/if%></td>
				<%if $tpl_changed neq 'true'%><td align="right"><a href="javascript:savedraft();"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Rechnungsentwurf speichern"></a></td><%/if%>
				<td align="right"><a href="javascript:save();"><img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" border="0" alt="Rechnung erstellen"></a></td>
			</tr>
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
</form>
<%/if%>
<%/strip%>
</body>