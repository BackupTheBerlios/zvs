<%strip%>
<%include file=header.tpl%>
<fieldset class="w400">
	<legend>##LISTS##</legend>
	<ul class="buttonlist">
		<li><a href="<%$wwwroot%>list_receipt.php">##BILLS##</a></li>
		<li><a href="<%$wwwroot%>list_receiptitems.php">##INVOICE_ITEM##</a></li>
		<li><a href="<%$wwwroot%>list_income.php">##REVENUES##</a></li>		
		<li><a href="<%$wwwroot%>list_guest.php">##ATTENDANCE_LIST##</a></li>
		<li><a href="<%$wwwroot%>list_guest2.php">##ATTENDANCE_LIST## (##TIMEPERIOD##)</a></li>
		<li><a href="<%$wwwroot%>list_roomchange.php">##CHANGE_OF_ROOM##</a></li>
		<li><a href="<%$wwwroot%>list_birthday.php">##BIRTHDAY_LIST##</a></li>
		<li><a href="<%$wwwroot%>list_employeetime.php">##EMPLOYEES_TIMES##</a></li>
		<li><a href="<%$wwwroot%>list_employee.php">##EMPLOYEES##</a></li>
	</ul>
</fieldset>
 
<%include file=footer.tpl%>
<%/strip%>

