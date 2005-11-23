<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<!-- 
		This website is brought to you by ZVS
		ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
		ZVS is copyright 2003-2004 of Christian Ehret
	-->
	<title>zvs: ##EXPIRED_RESERVATIONS##</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<meta name="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css" media="screen">@import "<%$wwwroot%>css/global.css";</style>
	<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
	<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
	<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
	<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/confirmleave.js"></script>
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
			alert('##ENTER_DATE##');
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
			alert('##ENTER_DATE##');
		}
	}
	function del_all()
	{
		var check;
		check = confirm("##REALLY_DELETE_ALL RESERVATIONS##");
		if (check) {
			document.reservation.frm_del_all.value = 'true';
			document.reservation.submit();
		}			
	}
	
	function del(name)
	{
		var check;
		check = confirm("##REALLY_DELETE_RESERVATION_FOR## "+name+"?");
		if (!check) {
			return false;
		}	else {
			return true;
		}		
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
	
	function CheckAll()
	{	
		var TotalBoxes = 0;
		var TotalOn = 0;
		for (var i=0;i<document.forms['reservation'].elements.length;i++)
		{
			var e = document.forms['reservation'].elements[i];
			if ((e.name != 'dummy') && (e.type=='checkbox'))
			{
				TotalBoxes++;
				if (e.checked)
				{
					TotalOn++;
				}
			}
		}
		if (TotalBoxes==TotalOn)
		{
			setCheckboxes('reservation', false);
		}
		else
		{
			setCheckboxes('reservation', true);
		}
	}	
	
	function CheckOnClick(i) {
		if (document.forms['reservation'].elements['frm_ids[]'][i].checked ) {
			document.forms['reservation'].elements['frm_ids[]'][i].checked = false;
		}else{
			document.forms['reservation'].elements['frm_ids[]'][i].checked = true;
		}
	}
	//-->
</script>
<%strip%>
</head>
<body onLoad="addonchangeevents();">
<br/>
<div class="boxdyn">
	<h2><span>##EXPIRED_RESERVATIONS##</span></h2>
	<div class="table">
	<form accept-charset="utf-8" name="reservation" id="reservation" action="<%$wwwroot%>oldreservations.php" method="post">
	<input type="hidden" id="frm_id" name="frm_id" value=""/>
	<input type="hidden" id="frm_date" name="frm_date" value=""/>
	<input type="hidden" name="frm_navmonth" id="frm_navmonth" value="<%$tpl_navmonth%>"/>
	<input type="hidden" name="frm_navyear" id="frm_navyear" value="<%$tpl_navyear%>"/>
	<input type="hidden" name="frm_navstep" id="frm_navstep" value="<%$tpl_navstep%>"/>
	<input type="hidden" name="frm_res_all" id="frm_res_all" value="false"/>
	<input type="hidden" name="frm_del_all" id="frm_del_all" value="false"/>

		<%section name=page loop=$tpl_pages%>
		<%if $tpl_pages[page].number eq $tpl_thispageno%>&lt;<%/if%><a href="<%$tpl_wwwroot%>oldreservations.php/start.<%$tpl_pages[page].start%>/oldreservations.php">Seite <%$tpl_pages[page].number%></a><%if $tpl_pages[page].number eq $tpl_thispageno%>&gt;<%/if%>&nbsp;
		<%/section%>
		<br/>
		&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span>
			<a href="javascript:del_all();" class="dotted">##DELETE##</a>&nbsp;|&nbsp;
			<input name="frm_reservationduration" type="text" id="frm_reservationduration" size="10" value="" class="nomargin"/>
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
        calendar.setOffsetX(0);
        calendar.setOffsetY(0);
    //-->
    </script>
	<%strip%>
				&nbsp;<a href="#" onclick="res_all();" class="dotted">##EXTEND##</a>
				&nbsp;|&nbsp;
				<a href="javascript:window.opener.location.replace('<%$wwwroot%>index.php/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>');self.close();" class="dotted">##CLOSE##</a>

		</div>
		<table class="list" width="100%">
			<tr class="ListHeader">		
			  <th><input type="checkbox" name="dummy" id="dummy" onclick="CheckAll();"/></th>
				<th>##GUEST##</th>
				<th>##FROM##</th>
				<th>##UNTIL##</th>
				<th>##DELETE##</th>
				<th>##EXTEND##</th>
			</tr>
      <%/strip%>
      <%section name=res loop=$tpl_oldreservations%>
      <tr class="ListL<%$tpl_oldreservations[res].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_oldreservations[res].color%>'" onClick="CheckOnClick(<%$smarty.section.res.index%>);">
	     <td><input type="checkbox" name="frm_ids[]" id="frm_ids[]" value="<%$tpl_oldreservations[res].bookingid%>"/></td>
       <td><%if $tpl_oldreservations[res].salutation neq "n/a"%><%$tpl_oldreservations[res].salutation%>&nbsp;<%/if%><%if $tpl_oldreservations[res].academictitle neq ""%><%$tpl_oldreservations[res].academictitle %>&nbsp;<%/if%><%$tpl_oldreservations[res].firstname %>&nbsp;<%$tpl_oldreservations[res].lastname %></td>
       <td><%$tpl_oldreservations[res].startdate%></td>
  		 <td><%$tpl_oldreservations[res].enddate%></td>
			 <td><a href="<%$wwwroot%>oldreservations.php/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%if $tpl_navstep neq ""%>/navstep.<%$tpl_navstep%><%/if%>/del.<%$tpl_oldreservations[res].bookingid%>/oldreservations.php" class="dotted" onclick="return del('<%$tpl_oldreservations[res].firstname %> <%$tpl_oldreservations[res].lastname %>');">##DELETE##</a><strong>&nbsp;&raquo;</strong></td>
			 <td><input name="frm_reservationduration<%$tpl_oldreservations[res].bookingid%>" type="text" id="frm_reservationduration<%$tpl_oldreservations[res].bookingid%>" size="10" value="<%$tpl_reservationduration%>" class="nomargin"/>

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
			   &nbsp;<a href="#" onclick="submitform('<%$tpl_oldreservations[res].bookingid%>');" class="dotted">##EXTEND##</a><strong>&nbsp;&raquo;</strong></td>
        </tr>
			  <%sectionelse%>
			  <tr class="ListL0" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL0'">
			  	<td colspan="6">##NO_EXPIRED_RESERVATION##</td>
			  </tr>
        <%/section%>
		    <%strip%>
      </table>      
</form>
</div>
</div>
</body>
</html>
<%/strip%>