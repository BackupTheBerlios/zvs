<%strip%>
<%include file=header.tpl%>
<DIV ID="dek"></DIV>
<%/strip%> 
<SCRIPT TYPE="text/javascript">
<!--
	var offsetxpoint=-60; //Customize x offset of tooltip
	var offsetypoint=20; //Customize y offset of tooltip
	var ie=document.all;
	var ns6=document.getElementById && !document.all;
	var enabletip=false;
	if (ie||ns6)
	var tipobj=document.all? document.all["dek"] : document.getElementById? document.getElementById("dek") : "";
	
	document.onmousemove=positiontip;

    function openWindow(url){
    url = url + '/year.<%$tpl_navyear%>/month.<%$tpl_navmonth%>/navstep.<%$tpl_navstep%>';
    F1 = window.open(url,'booking','width=800,height=550,left=0,top=0,scrollbars=yes');
    F1.focus();
    }
	
	function openWindow2(url, name){
    url = url + '/year.<%$tpl_navyear%>/month.<%$tpl_navmonth%>/navstep.<%$tpl_navstep%>';
    F2 = window.open(url,name,'width=800,height=550,left=0,top=0,scrollbars=yes');
    F2.focus();
    }
	
<%if $tpl_oldreservations eq 'true'%>
	openWindow2('<%$wwwroot%>oldreservations.php', 'reservation');
<%/if%>	
<%if $tpl_birthdays eq 'true'%>
	openWindow2('<%$wwwroot%>birthdays.php', 'birthdays');
<%/if%>
//-->
</SCRIPT>

<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
        <p class="SubheadlineYellow">##ROOMPLAN## (<%if $tpl_view eq "type"%>##TYPE_OF_ALLOCATION##<%else%>##CATEGORIES_OF_BOOKING##<%/if%>) <%$tpl_monthname%>&nbsp;<%$tpl_year%>&nbsp;&nbsp;
        <a href="<%$wwwroot%>calendarpdf.php/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%><%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>" target='_blank'><img src="<%$wwwroot%>img/pdf.gif" hight="16" width="16" alt="##PDF_VERSION##" border="0"></a></p>
        <table border="0">
        <tr>
        <%if $tpl_view eq "type"%>
            <td class="colorchooser" bgcolor="<%$tpl_colorP%>"><img src="<%$wwwroot%>img/spacer.gif" width="10" height="10" boder="0"></td>
            <td>Abgerechnet</td>
            <td>&nbsp;</td>
            <td class="colorchooser" bgcolor="<%$tpl_colorB%>"><img src="<%$wwwroot%>img/spacer.gif" width="10" height="10" boder="0"></td>
            <td>Buchung</td>
            <td>&nbsp;</td>
            <td class="colorchooser" bgcolor="<%$tpl_colorR%>"><img src="<%$wwwroot%>img/spacer.gif" width="10" height="10" boder="0"></td>
            <td>Reservierung <td valign="right"><%if $tpl_numoldres > 0%>(<a href="javascript:openWindow2('<%$wwwroot%>oldreservations.php');"><%$tpl_numoldres%>&nbsp;<%if $tpl_numoldres > 1%>##EXPIRED_BOOKINGS##<%else%>##EXPIRED_BOOKING##<%/if%></a>)<%/if%></td></td>
            <td>&nbsp;</td>
        <%else%>
            <%section name=bcat loop=$tpl_bcat%>
            <td class="colorchooser" bgcolor="<%$tpl_bcat[bcat].catcolor%>"><a ONMOUSEOVER=" popup('<%$tpl_bcat[bcat].description|strip|escape:"quotes"%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><img src="<%$wwwroot%>img/spacer.gif" width="10" height="10" boder="0"></a></td>
            <td>
            <a ONMOUSEOVER=" popup('<%$tpl_bcat[bcat].description|strip|escape:"quotes"%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><%$tpl_bcat[bcat].name%></a>
            </td>
            <td>&nbsp;</td>
            <%/section%>
        <%/if%>
        </tr>
        </table>
        <form name="choosedate" action="<%$wwwroot%>index.php" method="post">
        <input type="hidden" name="frm_view" id="frm_view" value="<%$tpl_view%>">
        <table width="100%" boder="0">
        <tr>
          <td><a href="<%$wwwroot%>index.php<%$tpl_prev%>/direction.prev<%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>"><img src="<%$wwwroot%>img/button_prev.png" border="0" height="24" width="28" alt="##HOLE_MONTH_BACK##"></a>&nbsp;<a href="<%$wwwroot%>index.php<%$tpl_halfprev%>/direction.prev<%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>"><img src="<%$wwwroot%>img/button_halfprev.png" border="0" height="24" width="28" alt="##HALF_MONTH_BACK##"></a></td>
          <td align="center">
             <select name="month" id="month" onChange="javascript:document.choosedate.submit();">
               <option value="1" <%if $tpl_dropdownmonth eq "Januar"%>selected<%/if%>>##JANUARY##</option>
               <option value="2" <%if $tpl_dropdownmonth eq "Februar"%>selected<%/if%>>##FEBRUARY##</option>
               <option value="3" <%if $tpl_dropdownmonth eq "M&auml;rz"%>selected<%/if%>>##MARCH##</option>
               <option value="4" <%if $tpl_dropdownmonth eq "April"%>selected<%/if%>>##APRIL##</option>
               <option value="5" <%if $tpl_dropdownmonth eq "Mai"%>selected<%/if%>>##MAY##</option>
               <option value="6" <%if $tpl_dropdownmonth eq "Juni"%>selected<%/if%>>##JUNE##</option>
               <option value="7" <%if $tpl_dropdownmonth eq "Juli"%>selected<%/if%>>##JULY##</option>
               <option value="8" <%if $tpl_dropdownmonth eq "August"%>selected<%/if%>>##AUGUST##</option>
               <option value="9" <%if $tpl_dropdownmonth eq "September"%>selected<%/if%>>##SEPTEMBER##</option>
               <option value="10" <%if $tpl_dropdownmonth eq "Oktober"%>selected<%/if%>>##OCTOBER##</option>
               <option value="11" <%if $tpl_dropdownmonth eq "November"%>selected<%/if%>>##NOVEMBER##</option>
               <option value="12" <%if $tpl_dropdownmonth eq "Dezember"%>selected<%/if%>>##DECEMBER##</option>
             </select>&nbsp;
             <select name="year" id="year" onChange="javascript:document.choosedate.submit();">
               <%section name=y loop=$tpl_years%>
                 <option value="<%$tpl_years[y]%>" <%if $tpl_dropdownyear eq $tpl_years[y]%>selected<%/if%>><%$tpl_years[y]%></option>
               <%/section%>
            </select>
          </td>
          <td align="right"><a href="<%$wwwroot%>index.php<%$tpl_halfnext%>/direction.next<%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>"><img src="<%$wwwroot%>img/button_halfnext.png" border="0" height="24" width="28" alt="##HALF_MONTH_NEXT##"></a>&nbsp;<a href="<%$wwwroot%>index.php<%$tpl_next%>/direction.next<%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>"><img src="<%$wwwroot%>img/button_next.png" border="0" height="24" width="28" alt="##HOLE_MONTH_NEXT##"></a></td>
        </tr>
        </table>
        </form>
        <table cellpadding="0" cellspacing="0" border="0" class="calendar" width="100%">
          <tr>
            <td class="CalendarL1HeaderLeft">&nbsp;</td>
            <%section name=cal loop=$tpl_cal%>
            <td colspan="2" class="CalendarL1Header" align="center"><%$tpl_cal[cal].weekday%><br><%$tpl_cal[cal].date%></td>
            <%/section%>
          </tr>
        <%section name=room loop=$tpl_room%>
        <tr>
           <td class="CalendarL<%$tpl_room[room].color%>Left"><a ONMOUSEOVER=" popup('<%$tpl_room[room].infotxt|strip|escape:"quotes"%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><%$tpl_room[room].name%></a></td>
            <%section name=cal loop=$tpl_roomcal[room]%>
            <%if $tpl_roomcal[room][cal].firstday neq 'true' and $tpl_roomcal[room][cal].lastday neq 'true'%>
                 <td colspan="2" class="<%if $tpl_roomcal[room][cal].color neq ""%>CalendarRoom<%$tpl_room[room].color%><%else%>CalendarL<%$tpl_room[room].color%><%/if%>" align="center" bgcolor="<%if $tpl_view eq 'type'%><%$tpl_roomcal[room][cal].bookingtypecolor%><%else%><%$tpl_roomcal[room][cal].color%><%/if%>"><a href="javascript:openWindow('<%$wwwroot%><%if $tpl_roomcal[room][cal].bookid neq ""%>editbook.php/bookid.<%$tpl_roomcal[room][cal].bookid%>/bookingdetailid.<%$tpl_roomcal[room][cal].bookingdetailid%><%else%>book.php/start.<%$tpl_roomcal[room][cal].linkDate%>/room.<%$tpl_room[room].roomid%><%/if%>');" <%if $tpl_roomcal[room][cal].infotxt neq ""%>ONMOUSEOVER=" popup('<%$tpl_roomcal[room][cal].infotxt|strip|escape:"quotes"%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"<%/if%>><img src="<%$wwwroot%>img/spacer.gif" width="15" height="15" border="0" <%if $tpl_roomcal[room][cal].infotxt eq ""%>alt="<%$tpl_roomcal[room][cal].date%>"<%/if%>></a><!--<%$tpl_cal[cal].weekday%><br><%$tpl_cal[cal].date%>-->&nbsp;</td>
            <%else%>
                <%if $tpl_roomcal[room][cal].lastday eq 'true'%>
                     <td class="CalendarRoom<%$tpl_room[room].color%>" align="center" bgcolor="<%if $tpl_view eq 'type'%><%$tpl_roomcal[room][cal].lastdaydata.bookingtypecolor%><%else%><%$tpl_roomcal[room][cal].lastdaydata.color%><%/if%>"><a href="javascript:openWindow('<%$wwwroot%><%if $tpl_roomcal[room][cal].lastdaydata.bookid neq ""%>editbook.php/bookid.<%$tpl_roomcal[room][cal].lastdaydata.bookid%>/bookingdetailid.<%$tpl_roomcal[room][cal].lastdaydata.bookingdetailid%><%else%>book.php/start.<%$tpl_roomcal[room][cal].linkDate%>/room.<%$tpl_room[room].roomid%><%/if%>');" ONMOUSEOVER=" popup('<%$tpl_roomcal[room][cal].lastdaydata.infotxt|strip|escape:"quotes"%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><img src="<%$wwwroot%>img/spacer.gif" width="6" height="15" border="0"></a></td>
                <%else%>
                      <td class="CalendarL<%$tpl_room[room].color%>" align="center"><img src="<%$wwwroot%>img/spacer.gif" width="6" height="15" border="0"></td>
                <%/if%>
                <%if $tpl_roomcal[room][cal].firstday eq 'true'%>
                     <td class="CalendarRoom<%$tpl_room[room].color%>" align="center" bgcolor="<%if $tpl_view eq 'type'%><%$tpl_roomcal[room][cal].bookingtypecolor%><%else%><%$tpl_roomcal[room][cal].color%><%/if%>"><a href="javascript:openWindow('<%$wwwroot%><%if $tpl_roomcal[room][cal].bookid neq ""%>editbook.php/bookid.<%$tpl_roomcal[room][cal].bookid%>/bookingdetailid.<%$tpl_roomcal[room][cal].bookingdetailid%><%else%>book.php/start.<%$tpl_roomcal[room][cal].linkDate%>/room.<%$tpl_room[room].roomid%><%/if%>');" ONMOUSEOVER=" popup('<%$tpl_roomcal[room][cal].infotxt|strip|escape:"quotes"%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><img src="<%$wwwroot%>img/spacer.gif" width="6" height="15" border="0"></a></td>
                <%else%>
                     <td class="CalendarL<%$tpl_room[room].color%>" align="center"><a href="javascript:openWindow('<%$wwwroot%>book.php/start.<%$tpl_roomcal[room][cal].linkDate%>/room.<%$tpl_room[room].roomid%>');" ><img src="<%$wwwroot%>img/spacer.gif" width="6" height="15" border="0" alt="<%$tpl_roomcal[room][cal].date%>"></a></td>
                <%/if%>
            <%/if%>
            <%/section%>
        </tr>
        <%/section%>
        </table>
        <br>
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

