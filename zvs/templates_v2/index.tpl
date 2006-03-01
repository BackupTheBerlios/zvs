<%include file=header.tpl%>
<%strip%>
<h1>##ROOMPLAN## (<%if $tpl_view eq "type"%>##TYPE_OF_ALLOCATION##<%else%>##CATEGORIES_OF_BOOKING##<%/if%> <%$tpl_monthname%>&nbsp;<%$tpl_year%>&nbsp;&nbsp;<a href="<%$wwwroot%>calendarpdf.php/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%><%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>" target='_blank'><img src="<%$wwwroot%>img/pdf.gif" style="height:16px; width:16px; border:0px;" alt="##PDF_VERSION##"></a>)</h1>

  <form accept-charset="utf-8" name="choosedate" id="choosedate" action="<%$wwwroot%>index.php" method="post">
  <input type="hidden" name="frm_view" id="frm_view" value="<%$tpl_view%>"/>
	<p style="text-align: center;"><%if $tpl_numoldres > 0%><a href="javascript:openWindow2('<%$wwwroot%>oldreservations.php','reservation');"><span class="button"><%$tpl_numoldres%>&nbsp;<%if $tpl_numoldres > 1%>##EXPIRED_BOOKINGS##<%else%>##EXPIRED_BOOKING##<%/if%></span></a><%/if%></p>
        <table style="width:100%; border:0px;">
        <tr>
          <td><a href="<%$wwwroot%>index.php<%$tpl_prev%>/direction.prev<%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>" onclick="displayCalendar('<%$wwwroot%>', '<%$tpl_navmonth%>', '<%$tpl_navyear%>', '<%$tpl_view%>',''); return false;"><img src="<%$wwwroot%>img/button_prev.png" style="border:0px; height:24px; width:28px;" alt="##HOLE_MONTH_BACK##"></a>&nbsp;<a href="<%$wwwroot%>index.php<%$tpl_halfprev%>/direction.prev<%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>"><img src="<%$wwwroot%>img/button_halfprev.png" style="border:0px; height:24px; width:28px;" alt="##HALF_MONTH_BACK##"></a></td>
          <td align="center">
             <select name="month" id="month" onChange="displayCalendar('<%$wwwroot%>', this.value, '<%$tpl_navyear%>', '<%$tpl_view%>',''); return false;">
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
             <select name="year" id="year" onChange="displayCalendar('<%$wwwroot%>', '<%$tpl_navmonth%>', this.value, '<%$tpl_view%>',''); return false;">
               <%section name=y loop=$tpl_years%>
                 <option value="<%$tpl_years[y]%>" <%if $tpl_dropdownyear eq $tpl_years[y]%>selected<%/if%>><%$tpl_years[y]%></option>
               <%/section%>
            </select>
          </td>
          <td align="right"><a href="<%$wwwroot%>index.php<%$tpl_halfnext%>/direction.next<%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>"><img src="<%$wwwroot%>img/button_halfnext.png" border="0" height="24" width="28" alt="##HALF_MONTH_NEXT##"></a>&nbsp;<a href="<%$wwwroot%>index.php<%$tpl_next%>/direction.next<%if $tpl_view neq ""%>/view.<%$tpl_view%><%/if%>" ><img src="<%$wwwroot%>img/button_next.png" border="0" height="24" width="28" alt="##HOLE_MONTH_NEXT##"></a></td>
        </tr>
        </table>
		<a href="#" onclick="new Ajax.Updater('calendar','<%$wwwroot%>ajax_calendar.php',{method: 'post', parameters: 'month=<%$tpl_navmonth%>&year=<%$tpl_navyear%>'});">show</a>
<div id="calendar"></div>		
        <br/>
        <table style="border:0px;">
        <tr>
        <%if $tpl_view eq "type"%>
            <td class="colorchooser" style="background-color:<%$tpl_colorP%>;">&nbsp;</td>
            <td>##CLEARED##</td>
            <td>&nbsp;</td>
            <td class="colorchooser" style="background-color:<%$tpl_colorB%>;">&nbsp;</td>
            <td>##BOOKING##</td>
            <td>&nbsp;</td>
            <td class="colorchooser" style="background-color:<%$tpl_colorR%>;">&nbsp;</td>
            <td>##ADVANCE_BOOKING##</td>
            <td>&nbsp;</td>
        <%else%>
            <%section name=bcat loop=$tpl_bcat%>
            <td class="colorchooser" style="background-color:<%$tpl_bcat[bcat].catcolor%>;" onmouseover="popup('<%$tpl_bcat[bcat].description|strip|escape:"quotes"|replace:'"':'&#34;'%>','<%$wwwroot%>');" onmouseout="kill()">&nbsp;</a></td>
            <td <%if $tpl_bcat[bcat].description neq ""%> onmouseover="popup('<%$tpl_bcat[bcat].description|strip|escape:"quotes"|replace:'"':'&#34;'%>','<%$wwwroot%>');" onmouseout="kill()"<%/if%>><%$tpl_bcat[bcat].name%></td>
            <td>&nbsp;</td>
            <%/section%>
        <%/if%>
      	</tr>
		</table>
	</form>
		</div>
</div>
<div id="overlay" style="filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<%$wwwroot%>css/overlay.png', sizingMethod='scale'); display:none;";><div id="center"><div id="loading"><img src="<%$wwwroot%>/img_v2/loading.gif" width="128" height="128"/>Kalender wird geladen...</div></div></div>
<div id="dek"></div>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
	var offsetxpoint=60; //Customize x offset of tooltip
	var offsetypoint=20; //Customize y offset of tooltip
	var ie=document.all;
	var ns6=document.getElementById && !document.all;
	var enabletip=false;
	if (ie||ns6)
	var tipobj=document.all? document.all["dek"] : document.getElementById? document.getElementById("dek") : "";
	
	document.onmousemove=positiontip;

    function openWindow(url){
    url = url + '/year.<%$tpl_navyear%>/month.<%$tpl_navmonth%>/navstep.<%$tpl_navstep%>';
    F1 = window.open(url,'booking','width=800,height=800,left=0,top=0,scrollbars=yes');
    F1.focus();
    }
	
	function openWindow2(url, name){
    url = url + '/year.<%$tpl_navyear%>/month.<%$tpl_navmonth%>/navstep.<%$tpl_navstep%>';
    F2 = window.open(url,name,'width=800,height=560,left=0,top=0,scrollbars=yes');
    F2.focus();
    }
	
<%if $tpl_oldreservations eq 'true'%>
	openWindow2('<%$wwwroot%>oldreservations.php', 'reservation');
<%/if%>	
<%if $tpl_birthdays eq 'true'%>
	openWindow2('<%$wwwroot%>birthdays.php', 'birthdays');
<%/if%>
//-->
</script>
<%include file=footer.tpl%>

