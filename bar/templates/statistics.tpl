<%strip%>
<%include file=header.tpl%>
<form name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_newstart" id="frm_newstart" value="false">
<input type="hidden" name="frm_what" id="frm_what" value="<%$tpl_what%>">
<table width="300" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Statistiken &nbsp;&nbsp;
	<a href="<%$wwwroot%>statisticsrtf.php/what.<%$tpl_what%>/thedate.<%$tpl_theotherdate%>/start1.<%$tpl_theotherstart1%>/start.<%$tpl_theotherstart%>/end1.<%$tpl_theotherend1%>/end.<%$tpl_theotherend%>/thecat1.<%$tpl_thecat1%>/thecat2.<%$tpl_thecat2%>/thecat3.<%$tpl_thecat3%>/statisticsrtf.php"><img src="<%$wwwroot%>img/export.gif" width="20" height="20" border="0" alt="Export to RTF"></a>
	<a href="<%$wwwroot%>statisticscsv.php/what.<%$tpl_what%>/thedate.<%$tpl_theotherdate%>/start1.<%$tpl_theotherstart1%>/start.<%$tpl_theotherstart%>/end1.<%$tpl_theotherend1%>/end.<%$tpl_theotherend%>/thecat1.<%$tpl_thecat1%>/thecat2.<%$tpl_thecat2%>/thecat3.<%$tpl_thecat3%>/statisticscsv.php"><img src="<%$wwwroot%>img/export.gif" width="20" height="20" border="0" alt="Export to CSV"></a>
	</p>
	<a href="javascript:switchLayer('thedate');document.select.frm_what.value='thedate';document.select.submit();">Datum</a>
	&nbsp;<a href="javascript:switchLayer('timeline');document.select.frm_what.value='timeline';document.select.submit();">Zeitspanne (Datum)</a>
	&nbsp;<a href="javascript:switchLayer('timeline2');document.select.frm_what.value='timeline2';document.select.submit();">Zeitspanne (Monat)</a>
	<div id="thedate" name="thedate" style="visibility:visible">
	Datum: 
	<input name="frm_thedate" type="text" id="frm_thedate" size="10" value="<%$tpl_thedate%>"  onChange="javascript:document.select.frm_what.value='thedate';document.select.submit();"><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar1Callback(date, month, year)
        {
            document.forms['select'].frm_thedate.value = date + '.' + month + '.' + year;
			document.select.frm_what.value='thedate';
			document.forms['select'].submit();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_thedate.value;
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
	Kategorie:&nbsp;
	<select name="frm_cat1" id="frm_cat1" onChange="javascript:document.select.frm_what.value='thedate';document.select.submit();">
		<option value="-1">alle</option>
		<%section name="cat" loop=$tpl_cat%>
			<option value="<%$tpl_cat[cat].articlecatid%>" <%if $tpl_thecat1 eq $tpl_cat[cat].articlecatid%>selected="selected"<%/if%>><%$tpl_cat[cat].articlecat%></option>
		<%/section%>
	</select>
	</div>
	<div id="timeline" name="timeline" style="visibility:visible">
	von: 
	<input name="frm_start1" type="text" id="frm_start1" size="10" value="<%$tpl_start1%>"><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar2Callback(date, month, year)
        {
            document.forms['select'].frm_start1.value = date + '.' + month + '.' + year;
			document.select.frm_what.value='timeline';
			if (document.forms['select'].frm_end1.value != '')
			{
				document.forms['select'].submit();
			}
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_start1.value;
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
    <%strip%>	

	&nbsp;bis: 
	<input name="frm_end1" type="text" id="frm_end1" size="10" value="<%$tpl_end1%>"><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar3Callback(date, month, year)
        {
            document.forms['select'].frm_end1.value = date + '.' + month + '.' + year;
			document.select.frm_what.value='timeline';
			if (document.forms['select'].frm_start1.value != '')
			{
				document.forms['select'].submit();
			}
        }
        function calendar3GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_end1.value;
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

        calendar3 = new dynCalendar('calendar3', 'calendar3Callback', '<%$wwwroot%>img/');
		
		function submittheform()
		{
			document.select.frm_what.value='timeline';
			if ((document.forms['select'].frm_start1.value != '') && (document.forms['select'].frm_end1.value != ''))
			{
				document.forms['select'].submit();
			}
		}
    //-->
    </script>
    <%strip%>	
	<br>
	Kategorie:&nbsp;
	<select name="frm_cat2" id="frm_cat2" onchange="submittheform();">
		<option value="-1">alle</option>
		<%section name="cat" loop=$tpl_cat%>
			<option value="<%$tpl_cat[cat].articlecatid%>" <%if $tpl_thecat2 eq $tpl_cat[cat].articlecatid%>selected="selected"<%/if%>><%$tpl_cat[cat].articlecat%></option>
		<%/section%>
	</select>
	</div>
	<div id="timeline2" name="timeline2" style="visibility:visible">
	von: 
	<select name="frm_start" id="frm_start" onChange="javascript:document.select.frm_newstart.value='true';document.select.frm_what.value='timeline2';document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_thestart%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	&nbsp;
	bis: 
	<select name="frm_end" id="frm_end" onChange="javascript:document.select.frm_what.value='timeline2';document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_theend%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	<br>
	Kategorie:&nbsp;
	<select name="frm_cat3" id="frm_cat3" onChange="javascript:document.select.frm_what.value='timeline2';document.select.submit();">
		<option value="-1">alle</option>
		<%section name="cat" loop=$tpl_cat%>
			<option value="<%$tpl_cat[cat].articlecatid%>" <%if $tpl_thecat3 eq $tpl_cat[cat].articlecatid%>selected="selected"<%/if%>><%$tpl_cat[cat].articlecat%></option>
		<%/section%>
	</select>
	
	</div>	
			<table border="0" cellspacing="0" cellpadding="3" width="300">
				<tr>
					<td class="ListL1Header"><b>Anzahl:</b> </td>
					<td class="ListL1Header"><b>Artikel:</b> </td>
					<td class="ListL1Header"><b>Einzelpreis:</b> </td>
					<td class="ListL1Header"><b>Summe:</b> </td>
				</tr>
			<%section name=stat loop=$tpl_statistics%>
				<tr>
					<td class="ListL<%$tpl_statistics[stat].color%>"><%$tpl_statistics[stat].num%>&nbsp;</td>
					<td class="ListL<%$tpl_statistics[stat].color%>"><%$tpl_statistics[stat].description%>&nbsp;</td>
					<td class="ListL<%$tpl_statistics[stat].color%>" align="right"><%$tpl_statistics[stat].price%>&nbsp;</td>					
					<td class="ListL<%$tpl_statistics[stat].color%>" align="right"><%$tpl_statistics[stat].total%>&nbsp;</td>					
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
</form>
<%/strip%>
<script language="JavaScript" type="text/javascript">
var isIE, isDOM;
isIE = (document.all ? true : false);
isDOM = (document.getElementById ? true : false);


function switchLayer(layername)
{
	if (isIE)
	{
		element1 = document.all.thedate;
		element2 = document.all.timeline;
		element3 = document.all.timeline2;
		myelement = eval('document.all.'+layername);
	} else {
		element1 = document.getElementById("thedate");		
		element2 = document.getElementById("timeline");
		element3 = document.getElementById("timeline2");
		myelement = document.getElementById(layername);
	}	

	element1.style.display = 'none';
	element2.style.display = 'none';
	element3.style.display = 'none';
	myelement.style.display = '';
}

switchLayer('<%$tpl_what%>');
</script>
<%strip%>
<%include file=footer.tpl%>
<%/strip%>