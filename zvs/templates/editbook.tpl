<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: <%if $tpl_checkin eq "true"%>Check In<%elseif $tbpl_checkout eq "true"%>Check Out<%else%>Buchung &auml;ndern<%/if%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
<script type="text/javascript" language="Javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function setstep(step)
{
    document.book.frm_step.value = step;
    document.book.submit();
}

function delescort(guestid)
{
	document.book.frm_delescortid.value = guestid;
	document.book.frm_step.value = 'delescort';
	document.book.submit();
}

function addPosEscort(guestid)
{
	document.book.frm_addPosEscortid.value = guestid;
	document.book.frm_step.value = 'addPosEscort';
	document.book.submit();
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

function openWindow(url, windowname)
{
  detailsWindow = window.open(url, windowname, "width=800,height=600,scrollbars=yes,resizable=yes");
  detailsWindow.focus();
}

//-->
</script>
<%strip%>
</HEAD>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<%if $tpl_checkedin eq "true"%>
<%/strip%>
<script language="JavaScript">
<!--
	window.opener.location.replace('<%$wwwroot%>checkinlist.php');
	self.close();
//-->
</script>
<%strip%>
<%elseif $tpl_checkedout eq "true"%>
<%/strip%>
<script language="JavaScript">
<!--
	window.opener.location.replace('<%$wwwroot%>checkoutlist.php');
	self.close();
//-->
</script>
<%strip%>
<%else%>
<br>
<form name="book" id="book" action="<%$wwwroot%>editbook.php" method="post">
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
     <p class="SubheadlineYellow"><%if $tpl_checkin eq "true"%>Check In<%elseif $tpl_checkout eq "true"%>Check Out<%else%>Buchung &auml;ndern<%/if%></p>

     <input type="hidden" name="frm_bookid" id="frm_bookid" value="<%$tpl_bookid%>">
     <input type="hidden" name="frm_bookingdetailid" id="frm_bookingdetailid" value="<%$tpl_bookingdetailid%>">
     <input type="hidden" name="frm_navmonth" id="frm_navmonth" value="<%$tpl_navmonth%>">
     <input type="hidden" name="frm_navyear" id="frm_navyear" value="<%$tpl_navyear%>">
     <input type="hidden" name="frm_navstep" id="frm_navstep" value="<%$tpl_navstep%>">
     <input type="hidden" name="frm_start" id="frm_start" value="<%$tpl_bookdata.start%>">
	 <input type="hidden" name="frm_end" id="frm_end" value="<%$tpl_bookdata.end%>">	 
     <input type="hidden" name="frm_roomid" id="frm_roomid" value="<%$tpl_bookdata.roomid%>">
     <input type="hidden" name="frm_checkin" id="frm_checkin" value="<%$tpl_checkin%>">
     <input type="hidden" name="frm_checkout" id="frm_checkout" value="<%$tpl_checkout%>">	 
     <input type="hidden" name="frm_step" id="frm_step" value="2">
     <input type="hidden" name="frm_delescortid" id="frm_delescortid" value="">
	 <input type="hidden" name="frm_addPosEscortid" id="frm_addPosEscortid" value="">
	 <input type="hidden" name="frm_addressid" id="frm_addressid" value="<%$tpl_bookdata.addressid%>">
	 <input type="hidden" name="frm_guestid" id="frm_guestid" value="<%$tpl_bookdata.gastid%>">
     <%if $tpl_step eq "10"%>
     Buchung erfolgreich gel&ouml;scht!
     <%elseif $tpl_step eq "91"%>
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
               <td class="ListL<%$tpl_result[res].color%>" width="5"><input type="checkbox" name="frm_addguestid[]" id="frm_addguestid[]" value="<%$tpl_result[res].guestid%>" <%if $tpl_selected eq $tpl_result[res].guestid%>checked="checked"<%/if%></td>
               <td class="ListL<%$tpl_result[res].color%>" width="5"><a href="javascript:openWindow('<%$wwwroot%>showgast.php/guestid.<%$tpl_result[res].guestid%>','detailsWindow')"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a></td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].lastname%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].firstname%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].city%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].country_name%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><a href="javascript:openWindow('<%$wwwroot%>editgast.php/guestid.<%$tpl_result[res].guestid%>','detailsWindow')"><img src="<%$wwwroot%>img/icon_antwort.gif" width="19" height="16" border="0" alt="Editieren"></a></td>
             </tr>
             <%sectionelse%>
             <tr>
               <td class="DefText" colspan="4">keine Eintr&auml;ge gefunden</td>
             <%/section%>

        </table>
     <%elseif $tpl_step eq "90"%>
<%/strip%>	 
<script language="javascript"  type="text/javascript">

<!--

  function submit_onkeypress()
  {
    if(window.event.keyCode==13)
    {
   	  setstep(91);
    }
  }

// -->

</script>	 
<%strip%>
	  <p class="SubheadlineYellow">Gast suchen</p>
		<table width="100%" border="0" cellpadding="4" cellspacing="0">
       		<%if $tpl_notfound eq 'true'%>
       		<tr>
       		  <td colspan="2" class="DefError">keine G&auml;ste mit diesen Angaben gefunden! <a href="javascript:setstep('editescort');">neue Suche</a></td>
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
        </table>
     <%else%>
	 <table border="0" width="100%">
	 <tr>
	 	<td>
     <table border="0" cellspacing="0" cellpadding="3">
       <tr>
         <td class="ListL1"><%if $tpl_checkaddress eq 'false'%><span class="DefError"><%/if%><strong>Name:</strong><%if $tpl_checkaddress eq 'false'%></span><%/if%></td>
         <td class="ListL1"><%if $tpl_step eq "changeguest"%><select name="frm_guest" id="frm_guest">
          <%section name=guest loop=$tpl_guestlist%>
          <option value="<%$tpl_guestlist[guest].guest_id%>" <%if $tpl_bookdata.gastid eq $tpl_guestlist[guest].guest_id%>selected="selected"<%/if%>><%$tpl_guestlist[guest].lastname%>, <%$tpl_guestlist[guest].firstname%>&nbsp;(<%$tpl_guestlist[guest].city%>)</option>
          <%/section%>
          </select><%else%>
		  	 <%if $tpl_checkaddress eq 'false'%><span class="DefError"><%/if%><%$tpl_bookdata.name%><%if $tpl_checkaddress eq 'false'%></span><%/if%>&nbsp;<a href="javascript:window.opener.location.replace('<%$wwwroot%>editgast.php/guestid.<%$tpl_bookdata.gastid%>');window.opener.focus();"><img src="<%$wwwroot%>img/edit.png" hight="16" width="16" alt="Gast bearbeiten" border="0"></a>
		  <%/if%>	 
		 </td>
			 
         <td class="ListL1">&nbsp;</td>
         <td class="ListL1"><%if $tpl_step eq "changeguest"%><a href="javascript:setstep('saveguest');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('changeguest');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL0"><strong>Zimmer:</strong></td>
         <td class="ListL0"><%if $tpl_step eq "editroom"%><select name="frm_room" id="frm_room">
          <%section name=room loop=$tpl_rooms%>
          <option value="<%$tpl_rooms[room].roomid%>"><%$tpl_rooms[room].name%></option>
          <%/section%>
          </select><%else%><%$tpl_bookdata.room%><%/if%></td>
          <td class="ListL0">&nbsp;</td>
         <td class="ListL0"><%if $tpl_step eq "editroom"%><a href="javascript:setstep('saveroom');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editroom');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL1"><strong>vom:</strong></td>
         <td class="ListL1"><%if $tpl_step eq "editstart"%>
		 <select name="frm_extdays" id="frm_extdays">
		 <%section name=day loop=$tpl_extdays%>
		 	<option value="<%$tpl_extdays[day].thedate%>" <%if $tpl_bookdata.start eq $tpl_extdays[day].thedate%>selected="selected"<%/if%>><%$tpl_extdays[day].date%></option>
		 <%/section%>
		 </select>
		 <%else%>
		  <%$tpl_bookdata.nicestart%>
		  <%/if%></td>
         <td class="ListL1">&nbsp;</td>
         <td class="ListL1"><%if $tpl_step eq "editstart"%><a href="javascript:setstep('savestart');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editstart');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL0"><strong>bis:</strong></td>
         <td class="ListL0"><%if $tpl_step eq "editend"%>
		 <select name="frm_extdays" id="frm_extdays">
		 <%section name=day loop=$tpl_extdays%>
		 	<option value="<%$tpl_extdays[day].thedate%>" <%if $tpl_bookdata.end eq $tpl_extdays[day].thedate%>selected="selected"<%/if%>><%$tpl_extdays[day].date%></option>
		 <%/section%>
		 </select>
		 <%else%>
		 <%$tpl_bookdata.niceend%>
		 <%/if%>
		 </td>
         <td class="ListL0">&nbsp;</td>
         <td class="ListL0"><%if $tpl_step eq "editend"%><a href="javascript:setstep('saveend');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editend');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL1"><strong>N&auml;chte:</strong></td>
         <td class="ListL1"><%if $tpl_step eq "editdays"%><select name="frm_days" id="frm_days">
          <%section name=day loop=$tpl_days%>
          <option value="<%$tpl_days[day]%>" <%if $tpl_days[day] eq $tpl_bookdata.days%>selected<%/if%>><%$tpl_days[day]%></option>
          <%/section%>
          </select><%else%><%$tpl_bookdata.days%><%/if%></td>
         <td class="ListL1">&nbsp;</td>
         <td class="ListL1"><%if $tpl_step eq "editdays"%><a href="javascript:setstep('savedays');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editdays');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL0"><strong>Kategorie:</strong></td>
         <td class="ListL0"><%if $tpl_step eq "editcat"%><select name="frm_cat" id="frm_cat">
          <%section name=cat loop=$tpl_bcat%>
          <option value="<%$tpl_bcat[cat].bcatid%>" <%if $tpl_bookdata.catid eq $tpl_bcat[cat].bcatid%>selected<%/if%>><%$tpl_bcat[cat].name%></option>
          <%/section%>
          </select><%else%><%$tpl_bookdata.catname%><%/if%></td>
         <td class="ListL0">&nbsp;</td>
         <td class="ListL0"><%if $tpl_step eq "editcat"%><a href="javascript:setstep('savecat');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editcat');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL1"><strong>Belegungsart:</strong></td>
         <td class="ListL1"><%if $tpl_step eq "edittype"%><select name="frm_bookingtype" id="frm_bookingtype"  onChange="CheckForReservation(this.selectedIndex);">
          <option value="P" <%if $tpl_bookdata.bookingtype eq 'P'%>selected<%/if%>>Abgerechnet</option>
          <option value="B" <%if $tpl_bookdata.bookingtype eq 'B'%>selected<%/if%>>Buchung</option>
          <option value="R" <%if $tpl_bookdata.bookingtype eq 'R'%>selected<%/if%>>Reservierung</option>
          </select>
          </td>
          <td class="ListL1">
          <div id="reservationduration" style="position:relative; left:0px; top:0px; width:130px; height:25px; z-index:1; visibility: <%if $tpl_bookdata.bookingtype eq 'R'%>show<%else%>hidden<%/if%>;">
           <strong>bis:</strong> <input name="frm_reservationduration" type="text" id="frm_reservationduration" size="10" value="<%if $tpl_bookdata.reservationuntil eq "00.00.0000"%><%$tpl_reservationduration%><%else%><%$tpl_bookdata.reservationuntil%><%/if%>">
            <%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
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
				day = arrDate;
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}
			
         return strDate
        }

        calendar1 = new dynCalendar('calendar1', 'calendar1Callback', '<%$wwwroot%>img/');
          calendar1.setOffsetX(-220);
          calendar1.setOffsetY(-220);
    //-->
    </script>
    <%strip%>
    </div>

          <%else%><%$tpl_bookdata.bookingtypename%> <%if $tpl_bookdata.bookingtype eq 'R'%>&nbsp;bis <%$tpl_bookdata.reservationuntil%><%/if%></td><td class="ListL1">&nbsp;<%/if%></td>
          <td class="ListL1"><%if $tpl_step eq "edittype"%><a href="javascript:setstep('savetype');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('edittype');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
      </tr>
      <tr>
         <td class="ListL0"><%if $tpl_overload eq 'true'%><span class="DefError"><%/if%><strong>Erwachsene:</strong><%if $tpl_overload eq 'true'%></span><%/if%></td>
         <td class="ListL0"><%if $tpl_step eq "editpersons"%><select name="frm_persons" id="frm_persons">
         <option value="1" <%if $tpl_bookdata.persons eq "1"%>selected<%/if%>>1</option>
         <option value="2" <%if $tpl_bookdata.persons eq "2"%>selected<%/if%>>2</option>
         <option value="3" <%if $tpl_bookdata.persons eq "3"%>selected<%/if%>>3</option>
         <option value="4" <%if $tpl_bookdata.persons eq "4"%>selected<%/if%>>4</option>
         <option value="5" <%if $tpl_bookdata.persons eq "5"%>selected<%/if%>>5</option>
         <option value="6" <%if $tpl_bookdata.persons eq "6"%>selected<%/if%>>6</option>
       </select><%else%><%if $tpl_overload eq 'true'%><span class="DefError"><%/if%><%$tpl_bookdata.persons%><%if $tpl_overload eq 'true'%></span><%/if%><%/if%></td>
         <td class="ListL0">&nbsp;</td>
         <td class="ListL0"><%if $tpl_step eq "editpersons"%><a href="javascript:setstep('savepersons');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editpersons');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL1"><%if $tpl_overload eq 'true'%><span class="DefError"><%/if%><strong><%$tpl_children1_field%>:</strong><%if $tpl_overload eq 'true'%></span><%/if%></td>
         <td class="ListL1"><%if $tpl_step eq "editchildren"%><select name="frm_children" id="frm_children">
         <option value="0" <%if $tpl_bookdata.children eq "0"%>selected<%/if%>>0</option>
         <option value="1" <%if $tpl_bookdata.children eq "1"%>selected<%/if%>>1</option>
         <option value="2" <%if $tpl_bookdata.children eq "2"%>selected<%/if%>>2</option>
         <option value="3" <%if $tpl_bookdata.children eq "3"%>selected<%/if%>>3</option>
         <option value="4" <%if $tpl_bookdata.children eq "4"%>selected<%/if%>>4</option>
         <option value="5" <%if $tpl_bookdata.children eq "5"%>selected<%/if%>>5</option>
         <option value="6" <%if $tpl_bookdata.children eq "6"%>selected<%/if%>>6</option>
       </select><%else%><%if $tpl_overload eq 'true'%><span class="DefError"><%/if%><%$tpl_bookdata.children%><%if $tpl_overload eq 'true'%></span><%/if%><%/if%></td>
         <td class="ListL1">&nbsp;</td>
         <td class="ListL1"><%if $tpl_step eq "editchildren"%><a href="javascript:setstep('savechildren');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editchildren');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL1"><%if $tpl_overload eq 'true'%><span class="DefError"><%/if%><strong><%$tpl_children2_field%>:</strong><%if $tpl_overload eq 'true'%></span><%/if%></td>
         <td class="ListL1"><%if $tpl_step eq "editchildren2"%><select name="frm_children2" id="frm_children2">
         <option value="0" <%if $tpl_bookdata.children2 eq "0"%>selected<%/if%>>0</option>
         <option value="1" <%if $tpl_bookdata.children2 eq "1"%>selected<%/if%>>1</option>
         <option value="2" <%if $tpl_bookdata.children2 eq "2"%>selected<%/if%>>2</option>
         <option value="3" <%if $tpl_bookdata.children2 eq "3"%>selected<%/if%>>3</option>
         <option value="4" <%if $tpl_bookdata.children2 eq "4"%>selected<%/if%>>4</option>
         <option value="5" <%if $tpl_bookdata.children2 eq "5"%>selected<%/if%>>5</option>
         <option value="6" <%if $tpl_bookdata.children2 eq "6"%>selected<%/if%>>6</option>
       </select><%else%><%if $tpl_overload eq 'true'%><span class="DefError"><%/if%><%$tpl_bookdata.children2%><%if $tpl_overload eq 'true'%></span><%/if%><%/if%></td>
         <td class="ListL1">&nbsp;</td>
         <td class="ListL1"><%if $tpl_step eq "editchildren2"%><a href="javascript:setstep('savechildren2');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editchildren2');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
       <tr>
         <td class="ListL1"><%if $tpl_overload eq 'true'%><span class="DefError"><%/if%><strong><%$tpl_children3_field%>:</strong><%if $tpl_overload eq 'true'%></span><%/if%></td>
         <td class="ListL1"><%if $tpl_step eq "editchildren3"%><select name="frm_children3" id="frm_children3">
         <option value="0" <%if $tpl_bookdata.children3 eq "0"%>selected<%/if%>>0</option>
         <option value="1" <%if $tpl_bookdata.children3 eq "1"%>selected<%/if%>>1</option>
         <option value="2" <%if $tpl_bookdata.children3 eq "2"%>selected<%/if%>>2</option>
         <option value="3" <%if $tpl_bookdata.children3 eq "3"%>selected<%/if%>>3</option>
         <option value="4" <%if $tpl_bookdata.children3 eq "4"%>selected<%/if%>>4</option>
         <option value="5" <%if $tpl_bookdata.children3 eq "5"%>selected<%/if%>>5</option>
         <option value="6" <%if $tpl_bookdata.children3 eq "6"%>selected<%/if%>>6</option>
       </select><%else%><%if $tpl_overload eq 'true'%><span class="DefError"><%/if%><%$tpl_bookdata.children3%><%if $tpl_overload eq 'true'%></span><%/if%><%/if%></td>
         <td class="ListL1">&nbsp;</td>
         <td class="ListL1"><%if $tpl_step eq "editchildren3"%><a href="javascript:setstep('savechildren3');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editchildren3');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>
	   
       <tr>
         <td class="ListL0"><strong>Bemerkung:</strong></td>
         <td class="ListL0"><%if $tpl_step eq "editinfo"%><textarea name="frm_description" id="frm_description" cols="50" rows="5"><%$tpl_bookdata.description%></textarea><%else%><%$tpl_bookdata.description|truncate:30:"...":false%><%/if%>&nbsp;</td>
         <td class="ListL0">&nbsp;</td>
         <td class="ListL0"><%if $tpl_step eq "editinfo"%><a href="javascript:setstep('saveinfo');"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0" alt="Speichern"></a><%else%><a href="javascript:setstep('editinfo');"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0" alt="Bearbeiten"></a><%/if%></td>
       </tr>	
	   	   	   	   
       <tr>
         <td class="ListL1" valign="top"><strong>Begleitung:</strong></td>
         <td class="ListL1" valign="top" colspan="3">
		    <table border="0" cellspacing="0" cellpadding="3">
		        <tr>
		        <td colspan="3">&nbsp;</td>
		  		<td><a href="javascript:setstep('editescort');"><img src="<%$wwwroot%>img/shutter_plus.gif" border="0" width="13" height="13" alt="hinzuf&uuml;gen"></a></td>
		  		</tr>
			<%section name=escort loop=$tpl_bookdata.additionalguests%>
				<tr>
				<td><a href="javascript:openWindow('<%$wwwroot%>showgast.php/guestid.<%$tpl_bookdata.additionalguests[escort].guestid%>','detailsWindow')"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a></td>
				<td><%if $tpl_addoverload eq 'true'%><span class="DefError"><%/if%><%$tpl_bookdata.additionalguests[escort].lastname%><%if $tpl_addoverload eq 'true'%></span><%/if%></td>
				<td><%if $tpl_addoverload eq 'true'%><span class="DefError"><%/if%><%$tpl_bookdata.additionalguests[escort].firstname%><%if $tpl_addoverload eq 'true'%></span><%/if%></td>
				<td><a href="javascript:delescort(<%$tpl_bookdata.additionalguests[escort].guestid%>);"><img src="<%$wwwroot%>img/shutter_minus.gif" border="0" width="13" height="13" alt="l&ouml;schen"></a></td>
				</tr>
			<%/section%>
			</table>
		 </td>
       </tr>
     </table>
		</td>
		<td valign="top">
		<b>Begleitpersonen aus anderen Buchungen:</b>
		<br><br>
     <table boder="0" cellspacing="0" cellpadding="3">
		<tr>
			<td class="ListL1">&nbsp;</td>
			<td class="ListL1">
	  			<strong>Nachname</strong>
	  		</td>
			<td class="ListL1">
	  			<strong>Vorname</strong>
	  		</td>
			<td class="ListL1">&nbsp;</td>
		</tr>
     <%section name=posEscort loop=$tpl_posEscorts%>
       <tr>
		 <td class="ListL<%$tpl_posEscorts[posEscort].color%>"><a href="javascript:addPosEscort(<%$tpl_posEscorts[posEscort].guestid%>);"><img src="<%$wwwroot%>img/shutter_plus.gif" border="0" width="13" height="13" alt="hinzuf&uuml;gen"></a></td>
         <td class="ListL<%$tpl_posEscorts[posEscort].color%>"><%$tpl_posEscorts[posEscort].lastname%></td>
		 <td class="ListL<%$tpl_posEscorts[posEscort].color%>"><%$tpl_posEscorts[posEscort].firstname%></td>
         <td class="ListL<%$tpl_posEscorts[posEscort].color%>"><a href="javascript:openWindow('<%$wwwroot%>showgast.php/guestid.<%$tpl_posEscorts[posEscort].guestid%>','guest');"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a></td>		 
       </tr>
     <%sectionelse%>
       <tr>
          <td colspan="3">bisher keine Buchungen mit weiteren Begleitpersonen</td>
       </tr>
     <%/section%>
     </table>
		
		</td>
	 </tr>
	 </table>

     <br>
        <%/if%>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><%if $tpl_checkin neq "true" and $tpl_checkout neq "true" and ($tpl_step eq "0" or $tpl_step eq "")%><a href="javascript:setstep('del');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0" alt="L&ouml;schen"></a><%else%><%if $tpl_checkin eq "true" and $tpl_step neq "90" and $tpl_step neq "91"%><a href="javascript:setstep('checkin');"><img src="<%$wwwroot%>img/button_checkin.png" border="0" width="74" height="24" alt="Check in"></a><%elseif $tpl_checkout eq "true" and $tpl_step neq "90" and $tpl_step neq "91"%><a href="javascript:setstep('checkout');"><img src="<%$wwwroot%>img/button_checkout.png" border="0" width="80" height="24" alt="Check out"></a><%else%>&nbsp;<%/if%><%/if%></td>
            <td align="center"><%if $tpl_step eq "0" or $tpl_step eq ""%><a href="<%$wwwroot%>meldescheinrtf.php/bookid.<%$tpl_bookid%>/meldeschein.rtf" target="_blank"><img src="<%$wwwroot%>img/button_meldeschein.png" width="96" height="24" border="0" alt="Meldeschein"></a><%else%>&nbsp;<%/if%></td>
			<td align="center"><%if $tpl_step eq "0" or $tpl_step eq ""%><a href="javascript:openWindow('<%$wwwroot%>checkopenbookings.php/bookid.<%$tpl_bookid%>/checkopenbookings.php','receiptWindow');"><img src="<%$wwwroot%>img/button_rechnung.png" border="0" width="80" height="24" alt="Rechnung"></a><%else%>&nbsp;<%/if%></td>
            <td align="center"><%if ($tpl_step eq "0" or $tpl_step eq "") and $tpl_emailconfirmation neq ""%><a href="<%$tpl_emailconfirmation%>" target="_blank"><img src="<%$wwwroot%>img/button_emailbest.png" border="0" width="120" height="24" alt="eMail Best&auml;stigung"></a><%else%>&nbsp;<%/if%></td>			
            <td align="right"><a href="javascript:<%if $tpl_step eq "90"%>setstep(91);<%elseif $tpl_step eq "91"%>setstep(92);<%else%>window.opener.location.replace('<%$wwwroot%><%if $tpl_checkin eq "true"%>checkinlist.php<%elseif $tpl_checkout eq "true"%>checkoutlist.php<%else%>index.php/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%><%/if%>');self.close();<%/if%>">
			<%if $tpl_step eq "90" or $tpl_step eq "91"%> 
			 <img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" border="0" alt="weiter">
			 <%else%>
			 <img src="<%$wwwroot%>img/button_schliessen.png" width="86" height="24" border="0" alt="schliessen"> 
			 <%/if%></a></td>
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
        <%if ($tpl_step eq '90' and $tpl_notfound eq 'true') or $tpl_step eq '91'%>
        <br>
        <input type="hidden" name="frm_escort" id="frm_escort" value="true">
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
      <span class="SubheadlineYellow">neuen Gast anlegen&nbsp;&nbsp;&nbsp;</span>
	  <input type="checkbox" name="frm_keepaddress" id="frm_keepaddress" value="true" checked="checked"> Adresse(n) vom Hauptgast &uuml;bernehmen
	  <br>
			<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td><strong>Anrede</strong></td>
               <td> <select name="frm_salutation" id="frm_salutation">
                    <%section name=sal loop=$tpl_salutation%>
                        <option value="<%$tpl_salutation[sal].salutation_id%>"><%$tpl_salutation[sal].salutation%></option>
                    <%/section%>
               </select> </td>
               <td><strong>Titel</strong></td>
               <td><input name="frm_academictitle" type="text" id="frm_academictitle" size="30" value=""></td>
               <td><strong>Geschlecht</strong></td>
               <td> <select name="frm_gender" id="frm_gender">
                   <option value="M">m</option>
                   <option value="F">w</option>
                 </select> </td>
             </tr>
             <tr>
               <td><strong>Vorname</strong></td>
               <td><input name="frm_firstname" type="text" id="frm_firstname" size="30" value="<%$tpl_vorname%>"></td>
               <td><strong>Nachname</strong></td>
               <td><input name="frm_lastname" type="text" id="frm_lastname" size="30" value="<%$tpl_nachname%>"></td>
               <td><strong>Sprache</strong></td>
               <td> <select name="frm_language" id="frm_language">
                   <option value="2">D</option>
                   <option value="3">E</option>
                   <option value="4">I</option>
                 </select> </td>
             </tr>
             <tr>
               <td><strong>Beruf</strong></td>
               <td><input name="frm_job" type="text" id="frm_job" size="30" value=""></td>
               <td><strong>Firma</strong></td>
               <td><input name="frm_company" type="text" id="frm_company" size="30" value=""></td>
               <td><strong>Du/Sie</strong></td>
               <td> <select name="frm_formal_greeting" id="frm_formal_greeting">
                   <option value="N">Du</option>
                   <option value="Y">Sie</option>
                 </select> </td>
             </tr>
             <tr>
               <td><strong>Geburtsdatum</strong></td>
               <td><input name="frm_date_of_birth" type="text" id="frm_date_of_birth" size="10" value=""><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar1Callback(date, month, year)
        {
            document.forms['book'].frm_date_of_birth.value = date + '.' + month + '.' + year;
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['book'].frm_date_of_birth.value;
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
    <%strip%> &nbsp;&nbsp;<input type="checkbox" name="frm_reminder" id="reminder" value="Y"> erinnern</td></td>
	<td><strong>Geburtsort</strong></td>
	<td><input type="text" name="frm_birthplace" id="frm_birthplace" size="30" value=""></td>
	<td colspan="2">&nbsp;</td>
            </tr>
  <tr>
	<td><strong>Staatsangeh&ouml;rigkeit</strong></td>
	<td colspan="2"><select id="frm_nationality" name="frm_nationality">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
	<td><strong>Ausweisdokument</strong></td>
	<td><select name="frm_identification" id="frm_identification">
           <option value="P">Personalausweis</option>	
           <option value="R">Reisepass</option>
           <option value="F">F&uuml;hrerschein</option>                   
        </select></td>
	<td><strong>Ausweis-Nummer</strong></td>
    <td><input name="frm_passport" type="text" id="frm_passport" size="30" value=""></td>
	<td colspan="2">&nbsp;</td>
 </tr>
 <tr>            
 	<td><strong>Ausstellungsbeh&ouml;rde</strong></td>
	<td><input name="frm_agency" type="text" id="frm_agency" size="30" value=""></td>
	<td><strong>Ausstellungsdatum</strong></td>
	<td><input name="frm_issue_date" type="text" id="frm_issue_date" size="10" value=""><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar2Callback(date, month, year)
        {
            document.forms['book'].frm_issue_date.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['book'].frm_issue_date.value;
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

        calendar2 = new dynCalendar('calendar2', 'calendar2Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%></td>
	<td colspan="2"><input type="checkbox" name="frm_status" id="frm_status" value="Y"> <strong>Stammgast</strong></td>

               
    
             </tr> 
			
             <tr>
               <td colspan="6" align="right" valign="bottom"><a href="javascript:setstep(93);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a></td>
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
        <%/if%>
</form>
</body>
<%/if%>
<%/strip%>
</html>
