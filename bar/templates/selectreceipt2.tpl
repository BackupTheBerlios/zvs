<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--

function submit_onkeypress()
{
    if(window.event.keyCode==13)
    {
      check();
    }
}
//-->
</script>
<%strip%>
</HEAD>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<br>
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
        <p class="SubheadlineYellow">Liste &uuml;ber Zeitraum erstellen f&uuml;r <%$tpl_guest%></p>
		<%if $tpl_guestarticles%>
				<table border="0" cellpadding="3" cellspacing="0">
				   <tr>
				      <td class="ListL1Header"><b>Anzahl</b></td>
				   	  <td class="ListL1Header"><b>Artikel</b></td>
					  <td class="ListL1Header"><b>Datum</b></td>
					  <td class="ListL1Header"><b>Preis</b></td>
					  <td class="ListL1Header"><b>Total</b></td>
					  <td class="ListL1Header"><b>Bezahlt</b></td>
					  <td class="ListL1Header" colspan="2"><b>Erstellt</b></td>					  
					  <td class="ListL1Header" colspan="2"><b>Letzte &Auml;nderung</b></td>					  
				   </tr>
				   <tr>
					<td class="ListL1Footer" colspan="6">&nbsp;</td>
					<td class="ListL1Footer">von</td>
					<td class="ListL1Footer">am</td>
					<td class="ListL1Footer">von</td>
					<td class="ListL1Footer">am</td>
				   </tr>	
				  <%section name=guestarticle loop=$tpl_guestarticles%>				   
					<tr>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].num%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].description%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%if $tpl_guestarticles[guestarticle].timestamp neq ""%><%$tpl_guestarticles[guestarticle].timestamp%>&nbsp;Uhr<%/if%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>" align="right"><%if $tpl_guestarticles[guestarticle].price neq ""%><%$tpl_guestarticles[guestarticle].price%>&nbsp;EUR<%/if%>&nbsp;</td>			  
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>" align="right"><%if $tpl_guestarticles[guestarticle].total1 neq ""%><%$tpl_guestarticles[guestarticle].total1%>&nbsp;EUR<%/if%>&nbsp;</td>	
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>" align="right"><%if $tpl_guestarticles[guestarticle].total2 neq ""%><%$tpl_guestarticles[guestarticle].total2%>&nbsp;EUR<%/if%>&nbsp;</td>						  
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].inserteduser%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%if $tpl_guestarticles[guestarticle].inserted neq ""%><%$tpl_guestarticles[guestarticle].inserted%><%/if%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].updateduser%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%if $tpl_guestarticles[guestarticle].updated neq ""%><%$tpl_guestarticles[guestarticle].updated%><%/if%>&nbsp;</td>
					</tr>
				  <%/section%>
				</table>
		
		<%else%>
		<form name="timeline" id="timeline" method="get" action="<%$wwwroot%>selectreceipt2.php">
		<input type="hidden" name="frm_theguestid" id="frm_theguestid" value="<%$tpl_theguestid%>">
		<table border="0">
			<tr>
				<td><b>von:</b></td>
				<td><input name="frm_start" type="text" id="frm_start" size="10" value=""><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar1Callback(date, month, year)
        {
            document.forms['timeline'].frm_start.value = date + '.' + month + '.' + year;
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['timeline'].frm_start.value;
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
</td>
			</tr>
			<tr>
				<td><b>bis:</b></td>
				<td><input name="frm_end" type="text" id="frm_end" size="10" value=""><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar2Callback(date, month, year)
        {
            document.forms['timeline'].frm_end.value = date + '.' + month + '.' + year;
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['timeline'].frm_end.value;
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
			</tr>	
			<tr>
				<td colspan="2" align="right"><a href="javascript:document.timeline.submit();"><img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" border="0"></a></td>
			</tr>		
		</table>
		</form>
		<%/if%>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
<%/strip%>
<%if not $tpl_guestarticles%>
<script language="Javascript" type="text/javascript">
<!--
	document.timeline.frm_start.focus();
//-->
</script>
<%/if%>
<%strip%>
<%include file=footer.tpl%>
<%/strip%>
