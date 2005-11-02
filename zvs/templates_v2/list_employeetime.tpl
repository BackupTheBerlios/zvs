<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--

	function edit(id) {
		document.selectfrm.frm_timetrackerid.value = id;
		document.selectfrm.frm_action.value = "edit";
		document.selectfrm.submit();	
	}
	
	function del(id) {
		var check;
		check = confirm("Zeit wirklich löschen?");
		if (check) {
			document.selectfrm.frm_timetrackerid.value = id;
			document.selectfrm.frm_action.value = "del";
			document.selectfrm.submit();	
		}
	}	
	
	function save(id){
	   document.selectfrm.frm_timetrackerid.value=id;	
		document.selectfrm.submit();
	}
	
	function neu(){
		document.selectfrm.frm_timetrackerid.value = 0;
		document.selectfrm.frm_action.value = "addnew";
		document.selectfrm.submit();
	}
	
	function cleartimes() {
		document.selectfrm.frm_action.value= "clear";
		document.selectfrm.submit();
	}

	function checkAll()
	{
	if (document.selectfrm.frm_selector.checked == true) {
		checked = true;
	} else {
		checked = false;
	}
	var f = document.selectfrm;
	for(i=0;i<f.elements.length;i++) {
		if(f.elements[i].type=="checkbox"){
			f.elements[i].checked = checked;
		}
	}	
	}
	
//-->
</script>
<%strip%>
<div class="boxdyn">
		<h2><span>##EMPLOYEES_TIMES##</span></h2>
		<br/>
  <div class="table">
<form name="selectfrm" id="selectfrm" action="<%$SCRIPT_NAME%>" method="post">
<input name="frm_newstart" id="frm_newstart" type="hidden" value="false"/>
<input name="frm_timetrackerid" id="frm_timetrackerid" type="hidden" value=""/>
<input name="frm_action" id="frm_action" type="hidden" value=""/>
	##EMPLOYEES##:&nbsp;
	<select name="frm_employee" id="frm_employee" onChange="javascript:document.selectfrm.submit();">
		<option value="-1">##SELECT_EMPLOYEE##</option>
		<%section name="emp" loop=$tpl_employee%>
		<option value="<%$tpl_employee[emp].userid%>" <%if $tpl_employee[emp].userid eq $tpl_theemployeeid%>selected<%/if%>><%$tpl_employee[emp].lastname%>, <%$tpl_employee[emp].firstname%></option>
		<%/section%>
	</select>
	&nbsp;
	##FROM##: 
	<select name="frm_start" id="frm_start" onChange="javascript:document.selectfrm.frm_newstart.value='true';document.selectfrm.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_thestart%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	&nbsp;
	##UNTIL##: 
	<select name="frm_end" id="frm_end" onChange="javascript:document.selectfrm.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_theend%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	&nbsp;&nbsp;
	<select name="frm_type" id="frm_type" onChange="javascript:document.selectfrm.submit();">
	<option value="all" <%if $tpl_thetype eq "all"%>selected="selected"<%/if%>>##ALL##</option>
	<option value="cleared" <%if $tpl_thetype eq "cleared"%>selected="selected"<%/if%>>##CLEARED##</option>
	<option value="open" <%if $tpl_thetype eq "open"%>selected="selected"<%/if%>>##OPEN##</option>
	</select>
	<br/><br/>
<%/strip%>
	<%if $tpl_theemployeeid eq -1%>
		Bitte einen Mitarbeiter ausw&auml;hlen
	<%else%>

	<%if $tpl_addnew neq 'true'%>
	<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:neu();" class="dotted">##ADD##</a></div>	
	<%/if%>
		<%strip%>
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr class="ListHeader">
				<th><%if $tpl_noresult || $tpl_thetype eq "cleared"%>&nbsp;<%else%><input type="checkbox" name="frm_selector" id="frm_selector" value="" onClick="checkAll();" class="nomargin"/><%/if%>##CLEARED##</th>			
				<th>##COME##</th>
				<th>##GO##</th>					
				<th>##TIME##</th>	
				<th>&nbsp;</th>
		   </tr>
		   <%/strip%>				   
		   <%if $tpl_addnew eq 'true'%>
		   <%strip%>
			<tr class="ListHighlight">
			    <td>&nbsp;</td>
					<td><input type="text" name="frm_thestart" id="frm_thestart" size="10" maxlength="10"  value="" class="nomargin"/>
		<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar1Callback(date, month, year)
        {
            document.forms['selectfrm'].frm_thestart.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['selectfrm'].frm_thestart.value;
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
	&nbsp;<input type="text" name="frm_starttime" id="frm_starttime" value="" size="5" class="nomargin"/>
		  		</td>
		  		<td><input type="text" name="frm_theend" id="frm_theend" size="10" maxlength="10"  value="" class="nomargin"/>
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar2Callback(date, month, year)
        {
            document.forms['selectfrm'].frm_theend.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['selectfrm'].frm_theend.value;
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
	&nbsp;<input type="text" name="frm_endtime" id="frm_endtime" value="" size="5" class="nomargin"/>
		  		</td>
				<td>&nbsp;</td>
				<td><a href="javascript:save(0);"><span class="button">##SAVE##</span></a></td>
		   </tr>
		   <%/strip%>

		   <%/if%>		   
			<%section name=list loop=$tpl_list%>
		   <%strip%>
				<tr  class="ListL<%$tpl_list[list].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_list[list].color%>'">
				    <td><%if not $smarty.section.list.last%><%if $tpl_list[list].cleared neq ""%><%$tpl_list[list].cleared%><%else%><input type="checkbox" id="frm_cleared[]" name="frm_cleared[]" value="<%$tpl_list[list].timetracker_id%>" class="nomargin"/><%/if%><%else%><%if $tpl_thetype neq "cleared"%><a href="javascript:cleartimes();" class="dotted">##CLEAR##</a>&nbsp;&raquo;<%/if%><%/if%>&nbsp;</td>
				    <td>
					<%/strip%>
					<%if $tpl_editid eq $tpl_list[list].timetracker_id%>
					<%strip%>
<input type="text" name="frm_thestart" id="frm_thestart" size="10" maxlength="10"  value="<%if $tpl_list[list].start_date_only neq "00.00.0000"%><%$tpl_list[list].start_date_only%><%/if%>" class="nomargin"/>
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar1Callback(date, month, year)
        {
            document.forms['selectfrm'].frm_thestart.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['selectfrm'].frm_thestart.value;
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
	&nbsp;<input type="text" name="frm_starttime" id="frm_starttime" value="<%$tpl_list[list].start_time%>" size="5" class="nomargin"/>
					<%/strip%>
					<%else%>
					<%strip%>
					<%$tpl_list[list].start_date%>&nbsp;
					<%/strip%>
					<%/if%>
					<%strip%>
					</td>	

					<td>
	<%/strip%>
	<%if $tpl_editid eq $tpl_list[list].timetracker_id%>
	<%strip%>
<input type="text" name="frm_theend" id="frm_theend" size="10" maxlength="10"  value="<%if $tpl_list[list].end_date_only neq "00.00.0000"%><%$tpl_list[list].end_date_only%><%/if%>" class="nomargin"/>
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar2Callback(date, month, year)
        {
            document.forms['selectfrm'].frm_theend.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['selectfrm'].frm_theend.value;
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
	&nbsp;<input type="text" name="frm_endtime" id="frm_endtime" value="<%$tpl_list[list].end_time%>" size="5" class="nomargin"/>
	<%/strip%>
					<%else%>
					<%strip%>
					<%$tpl_list[list].end_date%>&nbsp;
					<%/strip%>
					<%/if%>
					<%strip%>
					</td>
					<%if $smarty.section.list.last%>
					<td colspan="2">
					##TOTAL##: <%$tpl_list[list].diff%>
					<%if $tpl_thetype neq "cleared"%><br>##OPEN##: <%$tpl_list[list].diff2%><%/if%>
					</td>	
					<%else%>
					<td><%$tpl_list[list].diff%>&nbsp;</td>	
					<td>
					<%if $tpl_editid eq $tpl_list[list].timetracker_id%>
					  <a href="javascript:save(<%$tpl_list[list].timetracker_id%>);"><span class="button">##SAVE##</span></a>
				    <%else%>
				      <a href="javascript:edit(<%$tpl_list[list].timetracker_id%>);" class="dotted">##EDIT##</a>&nbsp;&raquo;&nbsp;&nbsp;
					  <a href="javascript:del(<%$tpl_list[list].timetracker_id%>);" class="dotted">##DELETE##</a>&nbsp;&raquo;
					<%/if%>  
					</td>				
					<%/if%>
				</tr>
		   <%/strip%>
			<%/section%>
			<%strip%>
		</table>
		<%/strip%>
	<%/if%>	
	<%strip%>
</div>
</div>
</form>
<%include file=footer.tpl%>
<%/strip%>

