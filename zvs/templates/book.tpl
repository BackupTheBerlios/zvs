<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: Buchen</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
</HEAD>
<script type="text/javascript" language="Javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);


function newGuest()
{
	document.book.frm_newguest.value = "true";
	document.book.submit();
}

function del()
{
    document.book.frm_step.value = "delete";
    document.book.submit();
}
function submit_onkeypress()
{
    if(window.event.keyCode==13)
    {
      document.book.submit();
    }
}
function openWindow(url)
{
  detailsWindow = window.open(url,"detailsWindow", "width=800,height=600,scrollbars=yes,resizable=yes");
  detailsWindow.focus();
}

function CheckForReservation(argValue)
{
    if (argValue == 2) {
         if (document.getElementById)
         {
              document.getElementById('reservationduration').style.visibility = 'visible';
         }
         else
         {
              document.layers['reservationduration'].visibility = 'show';
         }
    }
    else
    {
         if (document.getElementById)
         {
              document.getElementById('reservationduration').style.visibility = 'hidden';
         }
         else
         {
              document.layers['reservationduration'].visibility = 'hidden';
         }
    }
}
//-->
</script>
<%strip%>
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
     <p class="SubheadlineYellow">Buchung für <%$tpl_niceroom%></p>
     <form name="book" id="book" action="<%$wwwroot%>book.php" method="post">
     <input type="hidden" name="frm_startdate" id="frm_startdate" value="<%$tpl_startdate%>">
     <input type="hidden" name="frm_room" id="frm_room" value="<%$tpl_room%>">
     <input type="hidden" name="frm_enddate" id="frm_enddate" value="<%$tpl_enddate%>">
     <input type="hidden" name="frm_navmonth" id="frm_navmonth" value="<%$tpl_navmonth%>">
     <input type="hidden" name="frm_navyear" id="frm_navyear" value="<%$tpl_navyear%>">
     <input type="hidden" name="frm_navstep" id="frm_navstep" value="<%$tpl_navstep%>">
     <input type="hidden" name="frm_bookid" id="frm_bookid" value="<%$tpl_bookid%>">
     <%/strip%>
     <%if $tpl_step eq "2"%>
	 <%strip%>
     <input type="hidden" name="frm_step" id="frm_step" value="3">
     <input type="hidden" name="frm_days" id="frm_days" value="<%$tpl_days%>">
     <input type="hidden" name="frm_cat" id="frm_cat" value="<%$tpl_cat%>">
     <input type="hidden" name="frm_persons" id="frm_persons" value="<%$tpl_persons%>">
	 <input type="hidden" name="frm_children0" id="frm_children0" value="<%$tpl_children0%>">
     <input type="hidden" name="frm_children" id="frm_children" value="<%$tpl_children%>">
     <input type="hidden" name="frm_children2" id="frm_children2" value="<%$tpl_children2%>">	
     <input type="hidden" name="frm_children3" id="frm_children3" value="<%$tpl_children3%>">	  
     <input type="hidden" name="frm_bookingtype" id="frm_bookingtype" value="<%$tpl_bookingtype%>">
     <input type="hidden" name="frm_description" id="frm_description" value="<%$tpl_description%>">
     <input type="hidden" name="frm_reservationduration" id="frm_reservationduration" value="<%$tpl_reservationduration%>">
     <input type="hidden" name="frm_newguest" id="frm_newguest" value="false">
	  <p class="SubheadlineYellow">Gast suchen</p>
		<table width="100%" border="0" cellpadding="4" cellspacing="0">
       		<%if $tpl_notfound eq 'true'%>
       		<tr>
       		  <td colspan="2" class="DefError">keine G&auml;ste mit diesen Angaben gefunden!</td>
       		</tr>
       		<%/if%>
             <tr>
               <td><strong>Vorname</strong></td>
               <td><input name="frm_vorname" type="text" id="frm_vorname" size="30" value="<%$tpl_vorname%>" onKeyPress="submit_onkeypress();"></td>
             </tr>
             <tr>
               <td><strong>Nachname</strong></td>
               <td><input name="frm_nachname" type="text" id="frm_nachname" size="30" value="<%$tpl_nachname%>" onKeyPress="submit_onkeypress();"></td>
             </tr>
       		<%if $tpl_notfound eq 'true'%>
             <tr>
                <td colspan="2"><a href="javascript:newGuest();"><img src="<%$wwwroot%>img/button_newguest.png" width="131" height="24" border="0" alt="neuen Gast mit diesen Daten anlegen"></a>&nbsp;
				<a href="javascript:document.book.submit();"><img src="<%$wwwroot%>img/button_search.png" width="73" height="24" border="0" alt="neue Suche"></a>
				</td>
             </tr>
       		<%/if%>
        </table>
	 <%/strip%>
     <%elseif $tpl_step eq "3"%>
	 <%strip%>
          <input type="hidden" name="frm_step" id="frm_step" value="4">
          <input type="hidden" name="frm_days" id="frm_days" value="<%$tpl_days%>">
          <input type="hidden" name="frm_cat" id=frm_cat" value="<%$tpl_cat%>">
          <input type="hidden" name="frm_persons" id="frm_persons" value="<%$tpl_persons%>">
		  <input type="hidden" name="frm_children0" id="frm_children0" value="<%$tpl_children0%>">
          <input type="hidden" name="frm_children" id="frm_children" value="<%$tpl_children%>">
          <input type="hidden" name="frm_children2" id="frm_children2" value="<%$tpl_children2%>">
          <input type="hidden" name="frm_children3" id="frm_children3" value="<%$tpl_children3%>">		  		  
          <input type="hidden" name="frm_bookingtype" id="frm_bookingtype" value="<%$tpl_bookingtype%>">
		  <input type="hidden" name="frm_description" id="frm_description" value="<%$tpl_description%>">
	      <input type="hidden" name="frm_reservationduration" id="frm_reservationduration" value="<%$tpl_reservationduration%>">
	      <input type="hidden" name="frm_newguest" id="frm_newguest" value="false">		  
	       <p class="SubheadlineYellow">gefundene G&auml;ste</p>
       		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td colspan="2">&nbsp;</td>			   
               <td><strong>Nachname</strong></td>			   
               <td><strong>Vorname</strong></td>
               <td><strong>Ort</strong></td>
               <td><strong>Land</strong></td>
               <td>&nbsp;</td>
             </tr>
             <%section name=res loop=$tpl_result%>
             <tr>
               <td class="ListL<%$tpl_result[res].color%>" width="5"><input type="radio" name="frm_guestid" id="tpl_guestid" value="<%$tpl_result[res].guestid%>" <%if $tpl_selected eq $tpl_result[res].guestid%>checked="checked"<%/if%></td>
               <td class="ListL<%$tpl_result[res].color%>" width="5"><a href="javascript:openWindow('<%$wwwroot%>showgast.php/guestid.<%$tpl_result[res].guestid%>')"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a></td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].lastname%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].firstname%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].city%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].country_name%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><a href="javascript:openWindow('<%$wwwroot%>editgast.php/guestid.<%$tpl_result[res].guestid%>')"><img src="<%$wwwroot%>img/icon_antwort.gif" width="19" height="16" border="0" alt="Editieren"></a></td>
             </tr>
             <%sectionelse%>
             <tr>
               <td class="DefText" colspan="7">keine Eintr&auml;ge gefunden</td>
             <%/section%>
			</tr>
			<tr>
			<td colspan="7">
			<table border="0">
             <tr>
               <td><strong>Vorname</strong></td>
               <td><input name="frm_vorname" type="text" id="frm_vorname" size="30" value="<%$tpl_ofirstname%>"></td>
             </tr>
             <tr>
               <td><strong>Nachname</strong></td>
               <td><input name="frm_nachname" type="text" id="frm_nachname" size="30" value="<%$tpl_olastname%>"></td>
             </tr>
             <tr>
                <td colspan="2"><a href="javascript:document.book.frm_step.value='3';newGuest();"><img src="<%$wwwroot%>img/button_newguest.png" width="131" height="24" border="0" alt="neuen Gast mit diesen Daten anlegen"></a>&nbsp;
				<a href="javascript:document.book.frm_step.value='3';document.book.submit();"><img src="<%$wwwroot%>img/button_search.png" width="73" height="24" border="0" alt="neue Suche"></a>
				</td>
             </tr>
			</table>
			</td>
			</tr>
        </table>
		
	 <%/strip%>  
     <%elseif $tpl_step eq "4"%>
	<%strip%>
     <b>Buchung erfolgreich abgeschlossen:</b>
	 <br>
	 <table border="0" cellpadding="0" cellspacing="0">
	 	<tr>
	 		<td class="ListL1"><b>Ankunft:</b></td> 
			<td class="ListL1"><%$tpl_start%></td>
	 	</tr>
		<tr>
			<td class="ListL0"><b>Abreise:</b></td>
			<td class="ListL0"><%$tpl_end%></td>
		</tr>
		<tr>
			<td class="ListL1"><b>N&auml;chte:</b></td>
			<td class="ListL1"><%$tpl_nights%></td>
		</tr>
		<tr>
			<td class="ListL0"><b>Kategorie:</b></td>
			<td class="ListL0"><%section name=cat loop=$tpl_bcat%><%if $tpl_bcat[cat].bcatid eq $tpl_cat%><%$tpl_bcat[cat].name%><%/if%><%/section%></td>
		</tr>
		<tr>
			<td class="ListL1"><b>Belegungsart:</b></td>
			<td class="ListL1"><%if $tpl_bookingtype eq "P"%>Abgerechnet<%elseif $tpl_bookingtype eq "B"%>Buchung<%elseif $tpl_bookingtype eq "R"%>Reservierung bis <%$tpl_reservationduration%><%/if%></td>
		</tr>
		<tr>
			<td class="ListL0"><b>Erwachsene:</b></td>
			<td class="ListL0"><%$tpl_persons%></td>
		</tr>
		<tr>
			<td class="ListL1"><b><%$tpl_children_field0%>:</b></td>
			<td class="ListL1"><%$tpl_children0%></td>
		</tr>
		<tr>
			<td class="ListL0"><b><%$tpl_children_field1%>:</b></td>
			<td class="ListL0"><%$tpl_children%></td>
		</tr>
		<tr>
			<td class="ListL1"><b><%$tpl_children_field2%>:</b></td>
			<td class="ListL1"><%$tpl_children2%></td>
		</tr>
		<tr>
			<td class="ListL0"><b><%$tpl_children_field3%>:</b></td>
			<td class="ListL0"><%$tpl_children3%> </td>
		</tr>
     <%if $tpl_description neq ""%>
	 	<tr>
			<td class="ListL1"><b>Bemerkung:</b></td>
			<td class="ListL1"><%$tpl_description%></td>
		</tr>
  	 <%/if%>		
	 </table>


 	 <br><br>
 	 <%if $tpl_emailconfirmation neq ""%><a href="<%$tpl_emailconfirmation%>" target="_blank"><img src="<%$wwwroot%>img/button_emailbest.png" border="0" width="120" height="24" alt="eMail Best&auml;stigung"></a><%else%>&nbsp;<%/if%>
	<%/strip%>
     <%else%>
	 <%strip%>
     <input type="hidden" name="frm_step" id="frm_step" value="2">
     <table border="0">
     <tr>
      <td><b>Buchung vom <%$tpl_startnice%></b></td>
     </tr>
     <tr>
      <td><b>bis: </b> <select name="frm_days" id="frm_days">
          <%section name=day loop=$tpl_days%>
          <option value="<%$tpl_days[day].count%>"><%$tpl_days[day].date%>&nbsp;(<%$tpl_days[day].count%>&nbsp;<%if $tpl_days[day].count eq "1"%>Nacht<%else%>N&auml;chte<%/if%>)</option>
          <%/section%>
          </select> </td>
          <td>&nbsp;</td>
      </tr>
      <tr>
     <td>
     <b>Kategorie:</b> <select name="frm_cat" id="frm_cat">
          <%section name=cat loop=$tpl_bcat%>
          <option value="<%$tpl_bcat[cat].bcatid%>"><%$tpl_bcat[cat].name%></option>
          <%/section%>
          </select>
     </td>
     <td>&nbsp;</td>
     </tr>
      <tr>
     <td>
     <b>Belegungsart:</b> <select name="frm_bookingtype" id="frm_bookingtype" onChange="CheckForReservation(this.selectedIndex);">
          <option value="B">Buchung</option>
          <option value="P">Abgerechnet</option>
          <option value="R">Reservierung</option>
          </select>
     </td>
     <td><div id="reservationduration" style="position:relative; left:0px; top:0px; width:200px; height:25px; z-index:1; visibility: hidden;">
           <b>bis</b> <input name="frm_reservationduration" type="text" id="frm_reservationduration" size="10" value="<%$tpl_reservationduration%>">
              <%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar1Callback(date, month, year)
        {
            document.forms['book'].frm_reservationduration.value = date + '.' + month + '.' + year;
        }

        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;
        	
        	strDate = document.forms['book'].frm_reservationduration.value;
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
        calendar1.setOffsetX(-260);
        calendar1.setOffsetY(-140);
    //-->
    </script>
    <%strip%></div></td>
     </tr>     
     <tr>
     <td colspan="2">
     <b>Anzahl der Personen:</b>
     <br>
      Erwachsene: <select name="frm_persons" id="frm_persons">
         <option value="0">0</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         <option value="6">6</option>
		 <option value="7">7</option>
		 <option value="8">8</option>
		 <option value="9">9</option>
		 <option value="10">10</option>
       </select>
	   &nbsp;
      <%$tpl_children_field0%>: <select name="frm_children0" id="frm_children0">
         <option value="0">0</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         <option value="6">6</option>
		 <option value="7">7</option>
		 <option value="8">8</option>
		 <option value="9">9</option>
		 <option value="10">10</option>		 
       </select>

	   &nbsp;
      <%$tpl_children_field1%>: <select name="frm_children" id="frm_children">
         <option value="0">0</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         <option value="6">6</option>
		 <option value="7">7</option>
		 <option value="8">8</option>
		 <option value="9">9</option>
		 <option value="10">10</option>		 
       </select>
	   &nbsp;
      <%$tpl_children_field2%>: <select name="frm_children2" id="frm_children2">
         <option value="0">0</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         <option value="6">6</option>
		 <option value="7">7</option>
		 <option value="8">8</option>
		 <option value="9">9</option>
		 <option value="10">10</option>		 
       </select>
	   &nbsp;
      <%$tpl_children_field3%>: <select name="frm_children3" id="frm_children3">
         <option value="0">0</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         <option value="6">6</option>
		 <option value="7">7</option>
		 <option value="8">8</option>
		 <option value="9">9</option>
		 <option value="10">10</option>		 
       </select>	   	   
       </td>
       </tr>
       <tr>
		<td colspan="2"><b>Bemerkung:</b><br><textarea name="frm_description" id="frm_description" cols="50" rows="5"></textarea></td>
       </tr>
       </table>
	   <%/strip%>
       <%/if%>
	   <%strip%>
        </form>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><%if $tpl_edit eq "true"%><a href="javascript:del();"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a><%else%>&nbsp;<%/if%></td>
            <td align="right"><a href="<%if $tpl_step eq "4"%>javascript:window.opener.location.replace('<%$wwwroot%>index.php/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>');window.location.replace('<%$wwwroot%>editbook.php/bookid.<%$tpl_bookid%>/bookingdetailid.<%$tpl_bookingdetailid%>/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/navstep.<%$tpl_navstep%><%/if%>/editbook.php');<%else%>javascript:document.book.submit();<%/if%>"><img src="<%$wwwroot%>img/<%if $tpl_step eq "2"%>button_search.png<%else%>button_weiter.gif<%/if%>" width="73" height="24" border="0" alt="weiter"></a></td>
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
</body>
<%/strip%>
</html>
