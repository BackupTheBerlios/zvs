<%strip%>
<%include file=header.tpl%>
<div class="boxdyn">
		<h2><span>##ATTENDANCE_LIST## <a href="<%$wwwroot%>list_guest2_csv.php/what.<%$tpl_what%>/thedate.<%$tpl_theotherdate%>/start1.<%$tpl_theotherstart1%>/start.<%$tpl_theotherstart%>/end1.<%$tpl_theotherend1%>/end.<%$tpl_theotherend%>/bcat.<%$tpl_thebookcat%>/list_guest2_csv.php"><img src="<%$wwwroot%>img/export.png" width="16" height="16" border="0" alt="##EXPORT_CSV##"></a>
	<a href="<%$wwwroot%>list_guest2_rtf.php/what.<%$tpl_what%>/thedate.<%$tpl_theotherdate%>/start1.<%$tpl_theotherstart1%>/start.<%$tpl_theotherstart%>/end1.<%$tpl_theotherend1%>/end.<%$tpl_theotherend%>/bcat.<%$tpl_thebookcat%>/list_guest2_rtf.php"><img src="<%$wwwroot%>img/rtf.png" hight="16" width="16" alt="##EXPORT_RTF##" border="0"></a>
</span></h2>
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
	&nbsp; ##CATEGORY_OF_BOOKING##: 
	<select name="frm_bookcat1" id="frm_bookcat1" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_thebookcat eq "-1"%>selected<%/if%>>##ALL##</option>
	<%section name="bookcat" loop="$tpl_bookcat%>
		<option value="<%$tpl_bookcat[bookcat].bcatid%>" <%if $tpl_thebookcat eq $tpl_bookcat[bookcat].bcatid%>selected<%/if%>><%$tpl_bookcat[bookcat].name%></option>
	<%/section%>
	</select>	
	</div>
	<div id="timeline" name="timeline" style="visibility:visible">
	##FROM##: 
	<input name="frm_start1" type="text" id="frm_start1" size="10" value="<%$tpl_start1%>" class="nomargin"/><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
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
	&nbsp; ##CATEGORY_OF_BOOKING##: 
	<select name="frm_bookcat2" id="frm_bookcat2" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_thebookcat eq "-1"%>selected<%/if%>>##ALL##</option>
	<%section name="bookcat" loop="$tpl_bookcat%>
		<option value="<%$tpl_bookcat[bookcat].bcatid%>" <%if $tpl_thebookcat eq $tpl_bookcat[bookcat].bcatid%>selected<%/if%>><%$tpl_bookcat[bookcat].name%></option>
	<%/section%>
	</select>		
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
	&nbsp; ##CATEGORY_OF_BOOKING##: 
	<select name="frm_bookcat3" id="frm_bookcat3" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_thebookcat eq "-1"%>selected<%/if%>>alle</option>
	<%section name="bookcat" loop="$tpl_bookcat%>
		<option value="<%$tpl_bookcat[bookcat].bcatid%>" <%if $tpl_thebookcat eq $tpl_bookcat[bookcat].bcatid%>selected<%/if%>><%$tpl_bookcat[bookcat].name%></option>
	<%/section%>
	</select>		
	</div>	
	<br/>
    	<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr class="ListHeader">
			  <th>##ROOM##</th>
				<th>##LASTNAME##</th>
				<th>##FIRSTNAME##</th>
				<th>##EMAIL##</th>
				<th>##FROM##</th>
				<th>##UNTIL##</th>
				<th>##CATEGORY_OF_BOOKING##</th>
				<th>##STATUS_OF_BOOKING##</th>
				<th>##ADULT##</th>
				<th><%$tpl_children0_field%></th>
				<th><%$tpl_children1_field%></th>
				<th><%$tpl_children2_field%></th>
				<th><%$tpl_children3_field%></th>								
			</tr>    	
			<%section name=guest loop=$tpl_guests%>
			<tr class="ListL<%$tpl_guests[guest].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_guests[guest].color%>'">			
			<%if $smarty.section.guest.last%>
				<td colspan="8" align="right"><b>Summe: </b></td>			
				<td><%$tpl_guests[guest].person%></td>		
				<td><%$tpl_guests[guest].children0%></td>						
				<td><%$tpl_guests[guest].children1%></td>
				<td><%$tpl_guests[guest].children2%></td>
				<td><%$tpl_guests[guest].children3%></td>															
			<%else%>
				<td><%$tpl_guests[guest].room%></td>			
				<td><%$tpl_guests[guest].lastname%></td>
				<td><%$tpl_guests[guest].firstname%></td>
				<td><a href="mailto:<%$tpl_guests[guest].email%>"><%$tpl_guests[guest].email%></a></td>				
				<td><%$tpl_guests[guest].startdate%></td>
				<td><%$tpl_guests[guest].enddate%></td>
				<td><%$tpl_guests[guest].bookingcat%></td>	
				<td><%$tpl_guests[guest].bookingtype%></td>					
				<td><%$tpl_guests[guest].person%></td>				
				<td><%$tpl_guests[guest].children0%></td>
				<td><%$tpl_guests[guest].children1%></td>
				<td><%$tpl_guests[guest].children2%></td>
				<td><%$tpl_guests[guest].children3%></td>															
			<%/if%>
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="13">keine Eintr&auml;ge</td>
			</tr>
			<%/section%>
		</table>
</form>
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
