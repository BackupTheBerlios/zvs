<%strip%>
<%include file=header.tpl%>
<form name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_newstart" id="frm_newstart" value="false">
<input type="hidden" name="frm_what" id="frm_what" value="<%$tpl_what%>">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Einnahmen&nbsp;&nbsp;
	<a href="<%$wwwroot%>list_income_csv.php/what.<%$tpl_what%>/thedate.<%$tpl_theotherdate%>/start1.<%$tpl_theotherstart1%>/start.<%$tpl_theotherstart%>/end1.<%$tpl_theotherend1%>/end.<%$tpl_theotherend%>/paycat.<%$tpl_thepaycat%>/list_income_csv.php"><img src="<%$wwwroot%>img/export.gif" width="20" height="20" border="0" alt="Export to CSV"></a>
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
	&nbsp;
	Zahlungskategorie:
	<select name="frm_paycat1" id="frm_paycat1" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_thepaycat eq "-1"%>selected<%/if%>>alle</option>
	<%section name="paycat" loop="$tpl_paycat%>
		<option value="<%$tpl_paycat[paycat].catid%>" <%if $tpl_thepaycat eq $tpl_paycat[paycat].catid%>selected<%/if%>><%$tpl_paycat[paycat].cat%></option>
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
    //-->
    </script>
    <%strip%>	
	&nbsp;
	Zahlungskategorie:
	<select name="frm_paycat2" id="frm_paycat2" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_thepaycat eq "-1"%>selected<%/if%>>alle</option>
	<%section name="paycat" loop="$tpl_paycat%>
		<option value="<%$tpl_paycat[paycat].catid%>" <%if $tpl_thepaycat eq $tpl_paycat[paycat].catid%>selected<%/if%>><%$tpl_paycat[paycat].cat%></option>
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
	&nbsp;
	Zahlungskategorie:
	<select name="frm_paycat3" id="frm_paycat3" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_thepaycat eq "-1"%>selected<%/if%>>alle</option>
	<%section name="paycat" loop="$tpl_paycat%>
		<option value="<%$tpl_paycat[paycat].catid%>" <%if $tpl_thepaycat eq $tpl_paycat[paycat].catid%>selected<%/if%>><%$tpl_paycat[paycat].cat%></option>
	<%/section%>
	</select>		
	</div>	

<br>
	<table border="0" cellspacing="0" cellpadding="3" width="550">
		<tr>
				<td class="ListL1">
		  			<strong>Datum</strong>
		  		</td>
				<td class="ListL1">
		  			<strong>Zahlungskategorie</strong>
		  		</td>				
				<td class="ListL1">
		  			<strong>Beschreibung</strong>
		  		</td>	
				<td class="ListL1">
		  			<strong>Betrag</strong>
		  		</td>					
				<td class="ListL1">
		  			<strong>Name</strong>
		  		</td>	
				<td class="ListL1">
		  			<strong>Rechnungsnummer</strong>
		  		</td>	
				<td class="ListL1">
		  			<strong>Rechnungsdatum</strong>
		  		</td>	
		   </tr>				   
			<%section name=i loop=$tpl_income%>
				<tr>
					<td class="ListL<%$tpl_income[i].color%>"><%$tpl_income[i].date_payment%>&nbsp;</td>
					<td class="ListL<%$tpl_income[i].color%>"><%$tpl_income[i].paycat%>&nbsp;</td>
					<td class="ListL<%$tpl_income[i].color%>"><%$tpl_income[i].description%>&nbsp;</td>					
					<td class="ListL<%$tpl_income[i].color%>" align="right"><%$tpl_income[i].amount%>&nbsp;EUR&nbsp;</td>
					<td class="ListL<%$tpl_income[i].color%>"><%$tpl_income[i].lastname%><%if $tpl_income[i].lastname neq "" && $tpl_income[i].firstname neq ""%>,&nbsp;<%/if%><%$tpl_income[i].firstname%>&nbsp;</td>
					<td class="ListL<%$tpl_income[i].color%>"><%$tpl_income[i].receipt_reference_id%>&nbsp;</td>
					<td class="ListL<%$tpl_income[i].color%>"><%$tpl_income[i].receipt_date%>&nbsp;</td>
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

