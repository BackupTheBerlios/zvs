<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2005 of Christian Ehret
-->
	<title>zvs: <%$tpl_title%></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<meta name="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css" media="screen">@import "<%$wwwroot%>css/global.css";</style>
	<%if $tpl_type eq "editgast" || $tpl_type eq "season" || $tpl_type eq "price" || $tpl_type eq "lists" || $tpl_subnav eq "account" || $tpl_type eq "newsletter" || $tpl_type eq "listemployeetime"%>
		<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
		<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
		<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
		<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/confirmleave.js"></script>
	<%/if%>
	<%if $tpl_type eq "calendar" || $tpl_type eq "editgast" || $tpl_type eq "showgast" || $tpl_type eq "roomcat"%>
		<script src="<%$wwwroot%>global/tooltip2.js" type="text/javascript" language="Javascript"></script>
	<%/if%>
	<%if ($tpl_type eq "editgast" || $tpl_type eq "showgast") && $tpl_subnav eq "hauptgast"%>
		<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/addressselect.js"></script>
	<%/if%>
	<%if $tpl_logout eq "true"%>
		<meta http-equiv="refresh" content="3; URL=<%$wwwroot%>index.php/login.<%$tpl_login%>/index.php">
	<%/if%>
	<%if $tpl_title eq "Login"%>
		<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/md5.js"></script> 
	<%/if%>
	<%$tpl_ajaxjs%>
</head>
<%strip%>
<body <%if ($tpl_type eq "editgast" || $tpl_type eq "showgast") || $tpl_type eq "price" || $tpl_type eq "newsletter"%>onLoad="<%if $tpl_subnav eq "hauptgast"%>switchLayer('add_private');<%/if%><%if $tpl_type eq "editgast" || $tpl_type eq "price" || $tpl_type eq "newsletter" || $tpl_type eq "listemployeetime" %>addonchangeevents();<%/if%>"<%/if%> <%if $tpl_type eq "editgast" || $tpl_type eq "price" || $tpl_type eq "newsletter"%> onbeforeunload="javascript:returnvalue();"<%/if%>>

<div id="container">
		<div id="header">
		  <%if $tpl_title neq "Login"%>
	  	<div id="servicenav">
	  		<a href="<%$wwwroot%>settings.php">##SETTINGS##</a> | <a href="<%$wwwroot%>logout.php">##LOGOUT##</a>
	  	</div>
	  	<%/if%>
	  	<div id="date">
	  		<%$smarty.now|date_format:"%A, %d. %B %Y"%>
	  	</div>
			<img src="<%$wwwroot%>logo/logo.gif" class="logo" alt="Zimmerverwaltungsystem" border="0" height="70">		
		  <%if $tpl_title neq "Login"%>		
		  <ul>
		    <li <%if $tpl_nav eq "calendar"%>id="current"<%/if%>><a href="<%$wwwroot%>index.php">##ROOM_ADMINISTRATION##</a></li>
		    <li <%if $tpl_nav eq "gast" or $tpl_nav eq "showgast"%>id="current"<%/if%>><a href="<%$wwwroot%>guest.php">##GUEST_ADMINISTRATION##</a></li>
		    <li <%if $tpl_nav eq "newsletter"%>id="current"<%/if%>><a href="<%$wwwroot%>newsletter.php">##NEWSLETTER##</a></li>
		    <li <%if $tpl_nav eq "lists"%>id="current"<%/if%>><a href="<%$wwwroot%>lists.php">##LISTS##</a></li>
		   </ul>
		   <%/if%>
		</div>
		<%/strip%>
		<div id="tab">
				<div id="subnav">
          <%if $tpl_nav eq "gast"%>
						<%if $tpl_gast.guestid neq ""%>
					<ul>
						<li <%if $tpl_subnav eq "hauptgast"%>id="current"<%/if%>><a href="<%$wwwroot%>editgast.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>">##MAIN_GUEST##</a><%if $tpl_gast.guestid neq ""%>|<%/if%></li>
						<li <%if $tpl_subnav eq "escort"%>id="current"<%/if%>><a href="<%$wwwroot%>showescort.php/guestid.<%$tpl_gast.guestid%>/type.edit">##ESCORTS##</a>|</li>
					  <li <%if $tpl_subnav eq "editinfo"%>id="current"<%/if%>><a href="<%$wwwroot%>editinfo.php/guestid.<%$tpl_gast.guestid%>">##NOTICE##</a>|</li>
					  <li <%if $tpl_subnav eq "cat"%>id="current"<%/if%>><a href="<%$wwwroot%>editcat.php/guestid.<%$tpl_gast.guestid%>">##CATEGORIES##</a>|</li>
					  <li <%if $tpl_subnav eq "documents"%>id="current"<%/if%>><a href="<%$wwwroot%>showguestdocuments.php/guestid.<%$tpl_gast.guestid%>/type.edit">##DOCUMENTS##</a>|</li>
					  <li <%if $tpl_subnav eq "account"%>id="current"<%/if%>><a href="<%$wwwroot%>account.php/guestid.<%$tpl_gast.guestid%>/type.edit">##PAYMENT_ENTRY##</a></li>
					</ul>
					  <%/if%>
					<%elseif $tpl_nav eq "showgast"%>
					<ul>
            <li <%if $tpl_subnav eq "hauptgast"%>id="current"<%/if%>><a href="<%$wwwroot%>showgast.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>">##MAIN_GUEST##</a>|</li>
            <li <%if $tpl_subnav eq "escort"%>id="current"<%/if%>><a href="<%$wwwroot%>showescort.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show">##ESCORTS##</a>|</li>
            <li <%if $tpl_subnav eq "showinfo"%>id="current"<%/if%>><a href="<%$wwwroot%>showinfo.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>">##NOTICE##</a>|</li>
            <li <%if $tpl_subnav eq "cat"%>id="current"<%/if%>><a href="<%$wwwroot%>showcat.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>">##CATEGORIES##</a>|</li>
            <li <%if $tpl_subnav eq "documents"%>id="current"<%/if%>><a href="<%$wwwroot%>showguestdocuments.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show">##DOCUMENTS##</a>|</li>
	    	    <li <%if $tpl_subnav eq "account"%>id="current"<%/if%>><a href="<%$wwwroot%>account.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show">##PAYMENT_ENTRY##</a></li>			   
					</ul>	
		      <%elseif $tpl_nav eq "lists"%>
		      <ul>
	         <li <%if $tpl_subnav eq "receipt"%>id="current"<%/if%>><a href="<%$wwwroot%>list_receipt.php">##BILLS##</a>|</li>
				   <li <%if $tpl_subnav eq "receiptitems"%>id="current"<%/if%>><a href="<%$wwwroot%>list_receiptitems.php">##INVOICE_ITEM##</a>|</li>			   
				   <li <%if $tpl_subnav eq "income"%>id="current"<%/if%>><a href="<%$wwwroot%>list_income.php">##REVENUES##</a>|</li>			   			   
				   <li <%if $tpl_subnav eq "checkout"%>id="current"<%/if%>><a href="<%$wwwroot%>list_guest.php">##ATTENDANCE_LIST##</a>|</li>
				   <li <%if $tpl_subnav eq "guestlist2"%>id="current"<%/if%>><a href="<%$wwwroot%>list_guest2.php">##ATTENDANCE_LIST## (##TIMEPERIOD##)</a>|</li>			   
				   <li <%if $tpl_subnav eq "roomchange"%>id="current"<%/if%>><a href="<%$wwwroot%>list_roomchange.php">##CHANGE_OF_ROOM##</a>|</li>			   			   
				   <li <%if $tpl_subnav eq "birthday"%>id="current"<%/if%>><a href="<%$wwwroot%>list_birthday.php">##BIRTHDAY_LIST##</a>|</li>			   			   			   
				   <li <%if $tpl_subnav eq "employeetime"%>id="current"<%/if%>><a href="<%$wwwroot%>list_employeetime.php">##EMPLOYEES_TIMES##</a>|</li>			   			   			   			   
				   <li <%if $tpl_subnav eq "employee"%>id="current"<%/if%>><a href="<%$wwwroot%>list_employee.php">##EMPLOYEES##</a></li>			   			   			   			   			   
		      </ul>
          <%elseif $tpl_subnav eq "catsettings"%>
          <ul>
						<li <%if $tpl_subnav eq "category"%>id="current"<%/if%>><a href="<%$wwwroot%>category.php">##GUEST_CATEGORIES##</a>|</li>
						<li <%if $tpl_subnav eq "roomcat"%>id="current"<%/if%>><a href="<%$wwwroot%>roomcategory.php">##ROOM_CATEGORIES##</a>|</li>
						<li <%if $tpl_subnav eq "bookingcat"%>id="current"<%/if%>><a href="<%$wwwroot%>bookingcat.php">##CATEGORIES_OF_BOOKING##</a>|</li>
						<li <%if $tpl_subnav eq "paycategory"%>id="current"<%/if%>><a href="<%$wwwroot%>paytypes.php">##PAYMENT_CATEGORIES##</a></li>		   
          </ul>		      
          <%elseif $tpl_subnav eq "syssettings"%>
          <ul>
						<li <%if $tpl_subnav eq "rooms"%>id="current"<%/if%>><a href="<%$wwwroot%>rooms.php">##ROOM##</a>|</li>
						<li <%if $tpl_subnav eq "season"%>id="current"<%/if%>><a href="<%$wwwroot%>season.php">##SEASON##</a>|</li>			   
						<li <%if $tpl_subnav eq "price"%>id="current"<%/if%>><a href="<%$wwwroot%>price.php">##ROOM_PRICES##</a>|</li>			   			   
						<li <%if $tpl_subnav eq "article"%>id="current"<%/if%>><a href="<%$wwwroot%>article.php">##ARTICLE##</a>|</li>							
						<li <%if $tpl_subnav eq "user"%>id="current"<%/if%>><a href="<%$wwwroot%>edituser.php">##USER##</a>|</li>
						<li <%if $tpl_subnav eq "employee"%>id="current"<%/if%>><a href="<%$wwwroot%>editemployee.php">##EMPLOYEES##</a>|</li>
						<li <%if $tpl_subnav eq "systemsettings"%>id="current"<%/if%>><a href="<%$wwwroot%>systemsettings.php">##SYSTEM_SETTINGS##</a>|</li>
						<li <%if $tpl_subnav eq "database"%>id="current"<%/if%>><a href="<%$wwwroot%>database.php">##DATABASE##</a></li>
          </ul>		                	
          <%elseif $tpl_nav eq "calendar"%>
          <ul>
						<li <%if $tpl_subnav eq "type"%>id="current"<%/if%>><a href="<%$wwwroot%>index.php/view.type<%if $tpl_navmonth neq ""%>/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%/if%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>">##TYPE_OF_ALLOCATION_PLURAL##</a>|</li>
						<li <%if $tpl_subnav eq "cat"%>id="current"<%/if%>><a href="<%$wwwroot%>index.php/view.cat<%if $tpl_navmonth neq ""%>/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%/if%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>">##CATEGORIES_OF_BOOKING##</a>|</li>
						<li <%if $tpl_subnav eq "checkin"%>id="current"<%/if%>><a href="<%$wwwroot%>checkinlist.php">##CHECK_IN##</a>|</li>
						<li <%if $tpl_subnav eq "checkout"%>id="current"<%/if%>><a href="<%$wwwroot%>checkoutlist.php">##CHECKOUT##</a></li>			   
          </ul>          
					<%/if%>
				</div>
			<%strip%>
			<div id="main">
<%/strip%>
