<%strip%>
<%include file=header.tpl%>
<div class="boxdyn">
		<h2><span>##ROOM_CHANGE_LIST## <a href="<%$wwwroot%>list_roomchange_csv.php/what.<%$tpl_what%>/thedate.<%$tpl_theotherdate%>/start1.<%$tpl_theotherstart1%>/start.<%$tpl_theotherstart%>/end1.<%$tpl_theotherend1%>/end.<%$tpl_theotherend%>/list_roomchange_csv.php"><img src="<%$wwwroot%>img/export.png" width="16" height="16" border="0" alt="##EXPORT_CSV##"></a>
	<a href="<%$wwwroot%>list_roomchange_rtf.php/what.<%$tpl_what%>/thedate.<%$tpl_theotherdate%>/start1.<%$tpl_theotherstart1%>/start.<%$tpl_theotherstart%>/end1.<%$tpl_theotherend1%>/end.<%$tpl_theotherend%>/list_roomchange_rtf.php"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="##EXPORT_RTF##" border="0"></a></span></h2>
		<br/>
  <div class="table">
<form name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_newstart" id="frm_newstart" value="false"/>
<input type="hidden" name="frm_what" id="frm_what" value="<%$tpl_what%>"/>

  
    <a href="javascript:switchLayer('thedate');document.select.frm_what.value='thedate';document.select.submit();" class="dotted">##DATE##</a>
	&nbsp;<a href="javascript:switchLayer('timeline');document.select.frm_what.value='timeline';document.select.submit();" class="dotted">##TIMEFRAME## (##DATE##)</a>
	&nbsp;<a href="javascript:switchLayer('timeline2');document.select.frm_what.value='timeline2';document.select.submit();" class="dotted">##TIMEFRAME## (##MONTH##)</a>
	<br/><br/>
	<div id="thedate" name="thedate" style="visibility:visible">
	##DATE##: 
	<input name="frm_thedate" type="text" id="frm_thedate" size="10" value="<%$tpl_thedate%>"  onChange="javascript:document.select.frm_what.value='thedate';document.select.submit();" class="nomargin"/><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
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
	</div>
	<div id="timeline" name="timeline" style="visibility:visible">
	##FROM##: 
	<input name="frm_start1" type="text" id="frm_start1" size="10" value="<%$tpl_start1%>" class="nomargin"/><%/strip%>
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

	&nbsp;##UNTIL##: 
	<input name="frm_end1" type="text" id="frm_end1" size="10" value="<%$tpl_end1%>" class="nomargin"/><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
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
	</div>
	<div id="timeline2" name="timeline2" style="visibility:visible">
	##FROM##: 
	<select name="frm_start" id="frm_start" onChange="javascript:document.select.frm_newstart.value='true';document.select.frm_what.value='timeline2';document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_thestart%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	&nbsp;
	##UNTIL##: 
	<select name="frm_end" id="frm_end" onChange="javascript:document.select.frm_what.value='timeline2';document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_theend%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	</div>	
	<br/>
    	<table class="list" width="100%">
			<tr class="ListHeader">
			  <th>##ROOM##</th>
				<th>##DEPARTURE##</th>
				<th>##NAME##</th>
				<th>##ARRIVAL##</th>
				<th>##DEPARTURE##</th>
				<th>##CATEGORY_OF_BOOKING##</th>
				<th>##ADULT##</th>
				<th><%$tpl_children0_field%></th>
				<th><%$tpl_children1_field%></th>
				<th><%$tpl_children2_field%></th>
				<th><%$tpl_children3_field%></th>	
				<th>##COMMENT##</th>							
			</tr>      	
			<%section name=guest loop=$tpl_booking%>
			<tr class="ListL<%$tpl_booking[guest].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_booking[guest].color%>'">
				<td valign="top"><%$tpl_booking[guest].room%></td>			
				<td valign="top"><%$tpl_booking[guest].enddate%></td>			
				<td valign="top"><%$tpl_booking[guest].lastname%><%if $tpl_booking[guest].firstname neq ""%>,&nbsp;<%/if%><%$tpl_booking[guest].firstname%></td>					
				<td valign="top"><%$tpl_booking[guest].startdate%></td>
				<td valign="top"><%$tpl_booking[guest].enddate2%></td>						
				<td valign="top"><%$tpl_booking[guest].bookingcat%></td>	
				<td valign="top"><%$tpl_booking[guest].person%></td>			
				<td valign="top"><%$tpl_booking[guest].children0%></td>	
				<td valign="top"><%$tpl_booking[guest].children1%></td>
				<td valign="top"><%$tpl_booking[guest].children2%></td>
				<td valign="top"><%$tpl_booking[guest].children3%></td>		
				<td valign="top"><%$tpl_booking[guest].addinfo|nl2br%></td>																		
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="12">keine Eintr&auml;ge</td>
			</tr>
			<%/section%>
		</table>
</div>
</div>
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
