<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: abgelaufene Reservierungen</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>

<script language="Javascript">
<!--
function submitform(id)
{
	var thefield, thedate;
	thefield = 'document.reservation.frm_reservationduration'+id+'.value';
	thedate = eval(thefield);
	if (thedate != '')
	{
		document.reservation.frm_id.value = id;
		document.reservation.frm_date.value = thedate;
		document.reservation.submit();
	} else {
		alert('Bitte Datum eingeben');
	}
}

function res_all()
{
	var thefield, thedate;
	thefield = 'document.reservation.frm_reservationduration.value';
	thedate = eval(thefield);
	if (thedate != '')
	{
		document.reservation.frm_res_all.value = 'true';
		document.reservation.frm_date.value = thedate;
		document.reservation.submit();
	} else {
		alert('Bitte Datum eingeben');
	}
}
function del_all()
{
		document.reservation.frm_del_all.value = 'true';
		document.reservation.submit();
}


function setCheckboxes(the_form, do_check)
{
    var elts      = document.forms[the_form].elements['frm_ids[]'];

    var elts_cnt  = (typeof(elts.length) != 'undefined')
                  ? elts.length
                  : 0;

    if (elts_cnt) {
        for (var i = 0; i < elts_cnt; i++) {
            elts[i].checked = do_check;
        } // end for
    } else {
        elts.checked        = do_check;
    } // end if... else

    return true;
}
//-->
</script>
<%strip%>
</HEAD>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<br><br><br>
<form name="reservation" id="reservation" action="<%$wwwroot%>oldreservations.php" method="post">
<input type="hidden" id="frm_id" name="frm_id" value="">
<input type="hidden" id="frm_date" name="frm_date" value="">
<input type="hidden" name="frm_navmonth" id="frm_navmonth" value="<%$tpl_navmonth%>">
<input type="hidden" name="frm_navyear" id="frm_navyear" value="<%$tpl_navyear%>">
<input type="hidden" name="frm_navstep" id="frm_navstep" value="<%$tpl_navstep%>">
<input type="hidden" name="frm_res_all" id="frm_res_all" value="false">
<input type="hidden" name="frm_del_all" id="frm_del_all" value="false">
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
		<p class="SubheadlineYellow">Abgelaufene Reservierungen</p>
		<%section name=page loop=$tpl_pages%>
		<%if $tpl_pages[page].number eq $tpl_thispageno%>&lt;<%/if%><a href="<%$tpl_wwwroot%>oldreservations.php/start.<%$tpl_pages[page].start%>/oldreservations.php">Seite <%$tpl_pages[page].number%></a><%if $tpl_pages[page].number eq $tpl_thispageno%>&gt;<%/if%>&nbsp;
		<%/section%>
		<br><br>
		<table border="0" cellpadding="4" cellspacing="0">
             <tr>
			   <td class="ListL1">&nbsp;</td>
               <td class="ListL1"><strong>Gast</strong></td>
			   <td class="ListL1"><strong>von</strong></td>
			   <td class="ListL1"><strong>bis</strong></td>
			   <td class="ListL1"><strong>l&ouml;schen</strong></td>
			   <td class="ListL1"><strong>verl&auml;ngern</strong></td>
              </tr>
              <%/strip%>
              <%section name=res loop=$tpl_oldreservations%>
               <tr>
			     <td class="ListL<%$tpl_oldreservations[res].color%>"><input type="checkbox" name="frm_ids[]" id="frm_ids[]" value="<%$tpl_oldreservations[res].bookingid%>"></td>
                 <td class="ListL<%$tpl_oldreservations[res].color%>"><%if $tpl_oldreservations[res].salutation neq "n/a"%><%$tpl_oldreservations[res].salutation%>&nbsp;<%/if%><%if $tpl_oldreservations[res].academictitle neq ""%><%$tpl_oldreservations[res].academictitle %>&nbsp;<%/if%><%$tpl_oldreservations[res].firstname %>&nbsp;<%$tpl_oldreservations[res].lastname %></td>
                 <td class="ListL<%$tpl_oldreservations[res].color%>"><%$tpl_oldreservations[res].startdate%></td>
				 <td class="ListL<%$tpl_oldreservations[res].color%>"><%$tpl_oldreservations[res].enddate%></td>
				 <td class="ListL<%$tpl_oldreservations[res].color%>"><a href="<%$wwwroot%>oldreservations.php/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/navstep.<%$tpl_navstep%><%/if%>/del.<%$tpl_oldreservations[res].bookingid%>/oldreservations.php"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0" alt="Reservierung l&ouml;schen"></a></td>
				 <td class="ListL<%$tpl_oldreservations[res].color%>"><input name="frm_reservationduration<%$tpl_oldreservations[res].bookingid%>" type="text" id="frm_reservationduration<%$tpl_oldreservations[res].bookingid%>" size="10" value="<%$tpl_reservationduration%>">

    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar<%$tpl_oldreservations[res].bookingid%>Callback(date, month, year)
        {
            document.forms['reservation'].frm_reservationduration<%$tpl_oldreservations[res].bookingid%>.value = date + '.' + month + '.' + year;
        }

        function calendar<%$tpl_oldreservations[res].bookingid%>GetValue()
        {
        	var strDate, arrDate, month, year, day;
        	
        	strDate = document.forms['reservation'].frm_reservationduration<%$tpl_oldreservations[res].bookingid%>.value;
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

        calendar<%$tpl_oldreservations[res].bookingid%> = new dynCalendar('calendar<%$tpl_oldreservations[res].bookingid%>', 'calendar<%$tpl_oldreservations[res].bookingid%>Callback', '<%$wwwroot%>img/');
        calendar<%$tpl_oldreservations[res].bookingid%>.setOffsetX(-260);
        calendar<%$tpl_oldreservations[res].bookingid%>.setOffsetY(-140);
    //-->
    </script>
			   <input type="button" value="verl&auml;ngern" onclick="submitform('<%$tpl_oldreservations[res].bookingid%>');"></td>
              <tr>
			  <%sectionelse%>
			  <tr>
			  	<td class="ListL0" colspan="5">Es liegen keine abgelaufenen Reservierungen vor</td>
			  </tr>
              <%/section%>
		      <%strip%>
            </table>
			<br><br>	
       <table border="0" cellspacing="5" cellpadding="0">
          <tr>
			<td><a href="#" onclick="setCheckboxes('reservation', true); return false;">Alle ausw�hlen</a>
            &nbsp;/&nbsp;
            <a href="#" onclick="setCheckboxes('reservation', false); return false;">Auswahl entfernen</a></td>
			<td>Ausgew&auml;hlte&nbsp;</td>
			<td><a href="javascript:del_all();"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0" alt="Reservierung l&ouml;schen"></a></td>
			<td><input name="frm_reservationduration" type="text" id="frm_reservationduration" size="10" value="">
    <%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendarCallback(date, month, year)
        {
            document.forms['reservation'].frm_reservationduration.value = date + '.' + month + '.' + year;
        }

        function calendarGetValue()
        {
        	var strDate, arrDate, month, year, day;
        	
        	strDate = document.forms['reservation'].frm_reservationduration.value;
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

        calendar = new dynCalendar('calendar', 'calendarCallback', '<%$wwwroot%>img/');
        calendar.setOffsetX(-260);
        calendar.setOffsetY(-140);
    //-->
    </script>
	<%strip%>
			   <input type="button" value="verl&auml;ngern" onclick="res_all();"></td>
		</tr>
		</table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right"><a href="javascript:window.opener.location.replace('<%$wwwroot%>index.php/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>');self.close();"><img src="<%$wwwroot%>img/button_schliessen.png" width="86" height="24" border="0"></a></td>
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
</body>
</html>
<%/strip%>