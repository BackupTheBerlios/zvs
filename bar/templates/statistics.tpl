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
	<br>
	von:&nbsp;
	<select name="frm_from_clock1" id="frm_from_clock1" onChange="javascript:document.select.frm_what.value='thedate';document.select.submit();">
		<option value="0" <%if $tpl_from_clock1 eq "0"%>selected="selected"<%/if%>>00:00</option>
		<option value="1" <%if $tpl_from_clock1 eq "1"%>selected="selected"<%/if%>>01:00</option>
		<option value="2" <%if $tpl_from_clock1 eq "2"%>selected="selected"<%/if%>>02:00</option>
		<option value="3" <%if $tpl_from_clock1 eq "3"%>selected="selected"<%/if%>>03:00</option>
		<option value="4" <%if $tpl_from_clock1 eq "4"%>selected="selected"<%/if%>>04:00</option>
		<option value="5" <%if $tpl_from_clock1 eq "5"%>selected="selected"<%/if%>>05:00</option>	
		<option value="6" <%if $tpl_from_clock1 eq "6"%>selected="selected"<%/if%>>06:00</option>
		<option value="7" <%if $tpl_from_clock1 eq "7"%>selected="selected"<%/if%>>07:00</option>
		<option value="8" <%if $tpl_from_clock1 eq "8"%>selected="selected"<%/if%>>08:00</option>
		<option value="9" <%if $tpl_from_clock1 eq "9"%>selected="selected"<%/if%>>09:00</option>
		<option value="10" <%if $tpl_from_clock1 eq "10"%>selected="selected"<%/if%>>10:00</option>
		<option value="11" <%if $tpl_from_clock1 eq "11"%>selected="selected"<%/if%>>11:00</option>
		<option value="12" <%if $tpl_from_clock1 eq "12"%>selected="selected"<%/if%>>12:00</option>
		<option value="13" <%if $tpl_from_clock1 eq "13"%>selected="selected"<%/if%>>13:00</option>
		<option value="14" <%if $tpl_from_clock1 eq "14"%>selected="selected"<%/if%>>14:00</option>
		<option value="15" <%if $tpl_from_clock1 eq "15"%>selected="selected"<%/if%>>15:00</option>
		<option value="16" <%if $tpl_from_clock1 eq "16"%>selected="selected"<%/if%>>16:00</option>
		<option value="17" <%if $tpl_from_clock1 eq "17"%>selected="selected"<%/if%>>17:00</option>
		<option value="18" <%if $tpl_from_clock1 eq "18"%>selected="selected"<%/if%>>18:00</option>
		<option value="19" <%if $tpl_from_clock1 eq "19"%>selected="selected"<%/if%>>19:00</option>
		<option value="20" <%if $tpl_from_clock1 eq "20"%>selected="selected"<%/if%>>20:00</option>
		<option value="21" <%if $tpl_from_clock1 eq "21"%>selected="selected"<%/if%>>21:00</option>
		<option value="22" <%if $tpl_from_clock1 eq "22"%>selected="selected"<%/if%>>22:00</option>
		<option value="23" <%if $tpl_from_clock1 eq "23"%>selected="selected"<%/if%>>23:00</option>							
	</select>	
	Uhr
	&nbsp;&nbsp;
	bis:&nbsp;
	<select name="frm_till_clock1" id="frm_till_clock1" onChange="javascript:document.select.frm_what.value='thedate';document.select.submit();">
		<option value="0" <%if $tpl_till_clock1 eq "0"%>selected="selected"<%/if%>>00:59/option>
		<option value="1" <%if $tpl_till_clock1 eq "1"%>selected="selected"<%/if%>>01:59</option>
		<option value="2" <%if $tpl_till_clock1 eq "2"%>selected="selected"<%/if%>>02:59</option>
		<option value="3" <%if $tpl_till_clock1 eq "3"%>selected="selected"<%/if%>>03:59</option>
		<option value="4" <%if $tpl_till_clock1 eq "4"%>selected="selected"<%/if%>>04:59</option>
		<option value="5" <%if $tpl_till_clock1 eq "5"%>selected="selected"<%/if%>>05:59</option>	
		<option value="6" <%if $tpl_till_clock1 eq "6"%>selected="selected"<%/if%>>06:59</option>
		<option value="7" <%if $tpl_till_clock1 eq "7"%>selected="selected"<%/if%>>07:59</option>
		<option value="8" <%if $tpl_till_clock1 eq "8"%>selected="selected"<%/if%>>08:59</option>
		<option value="9" <%if $tpl_till_clock1 eq "9"%>selected="selected"<%/if%>>09:59</option>
		<option value="10" <%if $tpl_till_clock1 eq "10"%>selected="selected"<%/if%>>10:59</option>
		<option value="11" <%if $tpl_till_clock1 eq "11"%>selected="selected"<%/if%>>11:59</option>
		<option value="12" <%if $tpl_till_clock1 eq "12"%>selected="selected"<%/if%>>12:59</option>
		<option value="13" <%if $tpl_till_clock1 eq "13"%>selected="selected"<%/if%>>13:59</option>
		<option value="14" <%if $tpl_till_clock1 eq "14"%>selected="selected"<%/if%>>14:59</option>
		<option value="15" <%if $tpl_till_clock1 eq "15"%>selected="selected"<%/if%>>15:59</option>
		<option value="16" <%if $tpl_till_clock1 eq "16"%>selected="selected"<%/if%>>16:59</option>
		<option value="17" <%if $tpl_till_clock1 eq "17"%>selected="selected"<%/if%>>17:59</option>
		<option value="18" <%if $tpl_till_clock1 eq "18"%>selected="selected"<%/if%>>18:59</option>
		<option value="19" <%if $tpl_till_clock1 eq "19"%>selected="selected"<%/if%>>19:59</option>
		<option value="20" <%if $tpl_till_clock1 eq "20"%>selected="selected"<%/if%>>20:59</option>
		<option value="21" <%if $tpl_till_clock1 eq "21"%>selected="selected"<%/if%>>21:59</option>
		<option value="22" <%if $tpl_till_clock1 eq "22"%>selected="selected"<%/if%>>22:59</option>
		<option value="23" <%if $tpl_till_clock1 eq "23"%>selected="selected"<%/if%>>23:59</option>							
	</select>	
	Uhr	
	<br>
	
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
	<br>	
	von:&nbsp;
	<select name="frm_from_clock2" id="frm_from_clock2" onChange="javascript:document.select.frm_what.value='timeline';document.select.submit();">
		<option value="0" <%if $tpl_from_clock2 eq "0"%>selected="selected"<%/if%>>00:00</option>
		<option value="1" <%if $tpl_from_clock2 eq "1"%>selected="selected"<%/if%>>01:00</option>
		<option value="2" <%if $tpl_from_clock2 eq "2"%>selected="selected"<%/if%>>02:00</option>
		<option value="3" <%if $tpl_from_clock2 eq "3"%>selected="selected"<%/if%>>03:00</option>
		<option value="4" <%if $tpl_from_clock2 eq "4"%>selected="selected"<%/if%>>04:00</option>
		<option value="5" <%if $tpl_from_clock2 eq "5"%>selected="selected"<%/if%>>05:00</option>	
		<option value="6" <%if $tpl_from_clock2 eq "6"%>selected="selected"<%/if%>>06:00</option>
		<option value="7" <%if $tpl_from_clock2 eq "7"%>selected="selected"<%/if%>>07:00</option>
		<option value="8" <%if $tpl_from_clock2 eq "8"%>selected="selected"<%/if%>>08:00</option>
		<option value="9" <%if $tpl_from_clock2 eq "9"%>selected="selected"<%/if%>>09:00</option>
		<option value="10" <%if $tpl_from_clock2 eq "10"%>selected="selected"<%/if%>>10:00</option>
		<option value="11" <%if $tpl_from_clock2 eq "11"%>selected="selected"<%/if%>>11:00</option>
		<option value="12" <%if $tpl_from_clock2 eq "12"%>selected="selected"<%/if%>>12:00</option>
		<option value="13" <%if $tpl_from_clock2 eq "13"%>selected="selected"<%/if%>>13:00</option>
		<option value="14" <%if $tpl_from_clock2 eq "14"%>selected="selected"<%/if%>>14:00</option>
		<option value="15" <%if $tpl_from_clock2 eq "15"%>selected="selected"<%/if%>>15:00</option>
		<option value="16" <%if $tpl_from_clock2 eq "16"%>selected="selected"<%/if%>>16:00</option>
		<option value="17" <%if $tpl_from_clock2 eq "17"%>selected="selected"<%/if%>>17:00</option>
		<option value="18" <%if $tpl_from_clock2 eq "18"%>selected="selected"<%/if%>>18:00</option>
		<option value="19" <%if $tpl_from_clock2 eq "19"%>selected="selected"<%/if%>>19:00</option>
		<option value="20" <%if $tpl_from_clock2 eq "20"%>selected="selected"<%/if%>>20:00</option>
		<option value="21" <%if $tpl_from_clock2 eq "21"%>selected="selected"<%/if%>>21:00</option>
		<option value="22" <%if $tpl_from_clock2 eq "22"%>selected="selected"<%/if%>>22:00</option>
		<option value="23" <%if $tpl_from_clock2 eq "23"%>selected="selected"<%/if%>>23:00</option>							
	</select>	
	Uhr
	&nbsp;&nbsp;
	bis:&nbsp;
	<select name="frm_till_clock2" id="frm_till_clock2" onChange="javascript:document.select.frm_what.value='timeline';document.select.submit();">
		<option value="0" <%if $tpl_till_clock2 eq "0"%>selected="selected"<%/if%>>00:59</option>
		<option value="1" <%if $tpl_till_clock2 eq "1"%>selected="selected"<%/if%>>01:59</option>
		<option value="2" <%if $tpl_till_clock2 eq "2"%>selected="selected"<%/if%>>02:59</option>
		<option value="3" <%if $tpl_till_clock2 eq "3"%>selected="selected"<%/if%>>03:59</option>
		<option value="4" <%if $tpl_till_clock2 eq "4"%>selected="selected"<%/if%>>04:59</option>
		<option value="5" <%if $tpl_till_clock2 eq "5"%>selected="selected"<%/if%>>05:59</option>	
		<option value="6" <%if $tpl_till_clock2 eq "6"%>selected="selected"<%/if%>>06:59</option>
		<option value="7" <%if $tpl_till_clock2 eq "7"%>selected="selected"<%/if%>>07:59</option>
		<option value="8" <%if $tpl_till_clock2 eq "8"%>selected="selected"<%/if%>>08:59</option>
		<option value="9" <%if $tpl_till_clock2 eq "9"%>selected="selected"<%/if%>>09:59</option>
		<option value="10" <%if $tpl_till_clock2 eq "10"%>selected="selected"<%/if%>>10:59</option>
		<option value="11" <%if $tpl_till_clock2 eq "11"%>selected="selected"<%/if%>>11:59</option>
		<option value="12" <%if $tpl_till_clock2 eq "12"%>selected="selected"<%/if%>>12:59</option>
		<option value="13" <%if $tpl_till_clock2 eq "13"%>selected="selected"<%/if%>>13:59</option>
		<option value="14" <%if $tpl_till_clock2 eq "14"%>selected="selected"<%/if%>>14:59</option>
		<option value="15" <%if $tpl_till_clock2 eq "15"%>selected="selected"<%/if%>>15:59</option>
		<option value="16" <%if $tpl_till_clock2 eq "16"%>selected="selected"<%/if%>>16:59</option>
		<option value="17" <%if $tpl_till_clock2 eq "17"%>selected="selected"<%/if%>>17:59</option>
		<option value="18" <%if $tpl_till_clock2 eq "18"%>selected="selected"<%/if%>>18:59</option>
		<option value="19" <%if $tpl_till_clock2 eq "19"%>selected="selected"<%/if%>>19:59</option>
		<option value="20" <%if $tpl_till_clock2 eq "20"%>selected="selected"<%/if%>>20:59</option>
		<option value="21" <%if $tpl_till_clock2 eq "21"%>selected="selected"<%/if%>>21:59</option>
		<option value="22" <%if $tpl_till_clock2 eq "22"%>selected="selected"<%/if%>>22:59</option>
		<option value="23" <%if $tpl_till_clock2 eq "23"%>selected="selected"<%/if%>>23:59</option>							
	</select>	
	Uhr	
	<br>
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
	<br>	
	von:&nbsp;
	<select name="frm_from_clock3" id="frm_from_clock3" onChange="javascript:document.select.frm_what.value='timeline2';document.select.submit();">
		<option value="0" <%if $tpl_from_clock3 eq "0"%>selected="selected"<%/if%>>00:00</option>
		<option value="1" <%if $tpl_from_clock3 eq "1"%>selected="selected"<%/if%>>01:00</option>
		<option value="2" <%if $tpl_from_clock3 eq "2"%>selected="selected"<%/if%>>02:00</option>
		<option value="3" <%if $tpl_from_clock3 eq "3"%>selected="selected"<%/if%>>03:00</option>
		<option value="4" <%if $tpl_from_clock3 eq "4"%>selected="selected"<%/if%>>04:00</option>
		<option value="5" <%if $tpl_from_clock3 eq "5"%>selected="selected"<%/if%>>05:00</option>	
		<option value="6" <%if $tpl_from_clock3 eq "6"%>selected="selected"<%/if%>>06:00</option>
		<option value="7" <%if $tpl_from_clock3 eq "7"%>selected="selected"<%/if%>>07:00</option>
		<option value="8" <%if $tpl_from_clock3 eq "8"%>selected="selected"<%/if%>>08:00</option>
		<option value="9" <%if $tpl_from_clock3 eq "9"%>selected="selected"<%/if%>>09:00</option>
		<option value="10" <%if $tpl_from_clock3 eq "10"%>selected="selected"<%/if%>>10:00</option>
		<option value="11" <%if $tpl_from_clock3 eq "11"%>selected="selected"<%/if%>>11:00</option>
		<option value="12" <%if $tpl_from_clock3 eq "12"%>selected="selected"<%/if%>>12:00</option>
		<option value="13" <%if $tpl_from_clock3 eq "13"%>selected="selected"<%/if%>>13:00</option>
		<option value="14" <%if $tpl_from_clock3 eq "14"%>selected="selected"<%/if%>>14:00</option>
		<option value="15" <%if $tpl_from_clock3 eq "15"%>selected="selected"<%/if%>>15:00</option>
		<option value="16" <%if $tpl_from_clock3 eq "16"%>selected="selected"<%/if%>>16:00</option>
		<option value="17" <%if $tpl_from_clock3 eq "17"%>selected="selected"<%/if%>>17:00</option>
		<option value="18" <%if $tpl_from_clock3 eq "18"%>selected="selected"<%/if%>>18:00</option>
		<option value="19" <%if $tpl_from_clock3 eq "19"%>selected="selected"<%/if%>>19:00</option>
		<option value="20" <%if $tpl_from_clock3 eq "20"%>selected="selected"<%/if%>>20:00</option>
		<option value="21" <%if $tpl_from_clock3 eq "21"%>selected="selected"<%/if%>>21:00</option>
		<option value="22" <%if $tpl_from_clock3 eq "22"%>selected="selected"<%/if%>>22:00</option>
		<option value="23" <%if $tpl_from_clock3 eq "23"%>selected="selected"<%/if%>>23:00</option>							
	</select>	
	Uhr
	&nbsp;&nbsp;
	bis:&nbsp;
	<select name="frm_till_clock3" id="frm_till_clock3" onChange="javascript:document.select.frm_what.value='timeline2';document.select.submit();">
		<option value="0" <%if $tpl_till_clock3 eq "0"%>selected="selected"<%/if%>>00:59</option>
		<option value="1" <%if $tpl_till_clock3 eq "1"%>selected="selected"<%/if%>>01:59</option>
		<option value="2" <%if $tpl_till_clock3 eq "2"%>selected="selected"<%/if%>>02:59</option>
		<option value="3" <%if $tpl_till_clock3 eq "3"%>selected="selected"<%/if%>>03:59</option>
		<option value="4" <%if $tpl_till_clock3 eq "4"%>selected="selected"<%/if%>>04:59</option>
		<option value="5" <%if $tpl_till_clock3 eq "5"%>selected="selected"<%/if%>>05:59</option>	
		<option value="6" <%if $tpl_till_clock3 eq "6"%>selected="selected"<%/if%>>06:59</option>
		<option value="7" <%if $tpl_till_clock3 eq "7"%>selected="selected"<%/if%>>07:59</option>
		<option value="8" <%if $tpl_till_clock3 eq "8"%>selected="selected"<%/if%>>08:59</option>
		<option value="9" <%if $tpl_till_clock3 eq "9"%>selected="selected"<%/if%>>09:59</option>
		<option value="10" <%if $tpl_till_clock3 eq "10"%>selected="selected"<%/if%>>10:59</option>
		<option value="11" <%if $tpl_till_clock3 eq "11"%>selected="selected"<%/if%>>11:59</option>
		<option value="12" <%if $tpl_till_clock3 eq "12"%>selected="selected"<%/if%>>12:59</option>
		<option value="13" <%if $tpl_till_clock3 eq "13"%>selected="selected"<%/if%>>13:59</option>
		<option value="14" <%if $tpl_till_clock3 eq "14"%>selected="selected"<%/if%>>14:59</option>
		<option value="15" <%if $tpl_till_clock3 eq "15"%>selected="selected"<%/if%>>15:59</option>
		<option value="16" <%if $tpl_till_clock3 eq "16"%>selected="selected"<%/if%>>16:59</option>
		<option value="17" <%if $tpl_till_clock3 eq "17"%>selected="selected"<%/if%>>17:59</option>
		<option value="18" <%if $tpl_till_clock3 eq "18"%>selected="selected"<%/if%>>18:59</option>
		<option value="19" <%if $tpl_till_clock3 eq "19"%>selected="selected"<%/if%>>19:59</option>
		<option value="20" <%if $tpl_till_clock3 eq "20"%>selected="selected"<%/if%>>20:59</option>
		<option value="21" <%if $tpl_till_clock3 eq "21"%>selected="selected"<%/if%>>21:59</option>
		<option value="22" <%if $tpl_till_clock3 eq "22"%>selected="selected"<%/if%>>22:59</option>
		<option value="23" <%if $tpl_till_clock3 eq "23"%>selected="selected"<%/if%>>23:59</option>							
	</select>	
	Uhr
	<br>
	</div>
	<br>
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
		<br>
		<img src="<%$wwwroot%>statisticsgraph.php/what.<%$tpl_what%>/thedate.<%$tpl_thedate%>/theend.<%$tpl_theend%>/thestart.<%$tpl_thestart%>/theend1.<%$tpl_end1%>/thestart1.<%$tpl_start1%>/statisticsgraph.php">
		<br>
		<img src="<%$wwwroot%>statisticsgraph2.php/what.<%$tpl_what%>/thedate.<%$tpl_thedate%>/theend.<%$tpl_theend%>/thestart.<%$tpl_thestart%>/theend1.<%$tpl_end1%>/thestart1.<%$tpl_start1%>/statisticsgraph2.php">		
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