<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--

	function edit(id) {
		document.select.frm_timetrackerid.value = id;
		document.select.frm_action.value = "edit";
		document.select.submit();	
	}
	
	function del(id, name) {
		var check;
		check = confirm("Zimmer \""+ name +"\" wirklich löschen?");
		if (check) {
			document.select.frm_timetrackerid.value = id;
			document.select.frm_action.value = "del";
			document.select.submit();	
		}
	}	
	
	function save(id){
	   document.select.frm_timetrackerid.value=id;	
		document.select.submit();
	}
	
	function neu(){
		document.select.frm_timetrackerid.value = 0;
		document.select.frm_action.value = "addnew";
		document.select.submit();
	}

//-->
</script>
<%strip%>
<form name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
<input name="frm_newstart" id="frm_newstart" type="hidden" value="false">
<input name="frm_timetrackerid" id="frm_timetrackerid" type="hidden" value="">
<input name="frm_action" id="frm_action" type="hidden" value="">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Mitarbeiterzeiten</p>
	Mitarbeiter:&nbsp;
	<select name="frm_employee" id="frm_employee" onChange="javascript:document.select.submit();">
		<option value="-1">Mitarbeiter ausw&auml;hlen</option>
		<%section name="emp" loop=$tpl_employee%>
		<option value="<%$tpl_employee[emp].userid%>" <%if $tpl_employee[emp].userid eq $tpl_theemployeeid%>selected<%/if%>><%$tpl_employee[emp].lastname%>, <%$tpl_employee[emp].firstname%></option>
		<%/section%>
	</select>
	&nbsp;
	von: 
	<select name="frm_start" id="frm_start" onChange="javascript:document.select.frm_newstart.value='true';document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_thestart%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	&nbsp;
	bis: 
	<select name="frm_end" id="frm_end" onChange="javascript:document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_theend%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	<br><br>
	<%if $tpl_theemployeeid eq -1%>
		Bitte einen Mitarbeiter ausw&auml;hlen
	<%else%>
	<table border="0" cellspacing="0" cellpadding="3" width="650">
		<tr>
				<td class="ListL1">
		  			<strong>Kommen</strong>
		  		</td>	
				<td class="ListL1">
		  			<strong>Gehen</strong>
		  		</td>					
				<td class="ListL1">
		  			<strong>Zeit</strong>
		  		</td>	
				<td class="ListL1">
					<strong>&nbsp;</strong>
				</td>
		   </tr>				   
		   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL0">
<input type="text" name="frm_thestart" id="frm_thestart" size="10" maxlength="10"  value="">
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar1Callback(date, month, year)
        {
            document.forms['select'].frm_thestart.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_thestart.value;
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
	&nbsp;<input type="text" name="frm_starttime" id="frm_starttime" value="" size="5">
		  		</td>
		  		<td class="ListL0">
<input type="text" name="frm_theend" id="frm_theend" size="10" maxlength="10"  value="">
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar2Callback(date, month, year)
        {
            document.forms['select'].frm_theend.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_theend.value;
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
	&nbsp;<input type="text" name="frm_endtime" id="frm_endtime" value="" size="5">
		  		</td>
				<td class="ListL0">&nbsp;</td>
				<td class="ListL0">
					<a href="javascript:save(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
		   </tr>
		   <%else%>
			<tr>
				<td class="ListL0" colspan="3">
					<strong>&nbsp;</strong>
				</td>			
				<td class="ListL0">
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		   
		   <%/if%>		   
			<%section name=list loop=$tpl_list%>
				<tr>
				    <td class="ListL<%$tpl_list[list].color%>">
					<%if $tpl_editid eq $tpl_list[list].timetracker_id%>
<input type="text" name="frm_thestart" id="frm_thestart" size="10" maxlength="10"  value="<%if $tpl_list[list].start_date_only neq "00.00.0000"%><%$tpl_list[list].start_date_only%><%/if%>">
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar1Callback(date, month, year)
        {
            document.forms['select'].frm_thestart.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_thestart.value;
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
	&nbsp;<input type="text" name="frm_starttime" id="frm_starttime" value="<%$tpl_list[list].start_time%>" size="5">
					<%else%>
					<%$tpl_list[list].start_date%>&nbsp;
					<%/if%>
					</td>	

					<td class="ListL<%$tpl_list[list].color%>">
	
	<%if $tpl_editid eq $tpl_list[list].timetracker_id%>
<input type="text" name="frm_theend" id="frm_theend" size="10" maxlength="10"  value="<%if $tpl_list[list].end_date_only neq "00.00.0000"%><%$tpl_list[list].end_date_only%><%/if%>">
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar2Callback(date, month, year)
        {
            document.forms['select'].frm_theend.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_theend.value;
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
	&nbsp;<input type="text" name="frm_endtime" id="frm_endtime" value="<%$tpl_list[list].end_time%>" size="5">

					<%else%>
					<%$tpl_list[list].end_date%>&nbsp;
					<%/if%>
					</td>
					<td class="ListL<%$tpl_list[list].color%>"><%$tpl_list[list].diff%>&nbsp;</td>	
					<%if $smarty.section.list.last%>
					<td class="ListL<%$tpl_list[list].color%>">&nbsp;</td>	
					<%else%>
					<td class="ListL<%$tpl_list[list].color%>">
					<%if $tpl_editid eq $tpl_list[list].timetracker_id%>
					  <a href="javascript:save(<%$tpl_list[list].timetracker_id%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				    <%else%>
				      <a href="javascript:edit(<%$tpl_list[list].timetracker_id%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
					<%/if%>  
					</td>				
					<%/if%>
				</tr>
			<%/section%>
		</table>
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
</form>
<%include file=footer.tpl%>
<%/strip%>

