<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2005 of Christian Ehret
-->
	<title>zvs: <%$tpl_title%></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<meta name="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css" media="screen">@import "<%$wwwroot%>css/global_v2.css";</style>
	<%if $tpl_type eq "editgast" || $tpl_type eq "season" || $tpl_type eq "price" || $tpl_type eq "lists" || $tpl_subnav eq "account" || $tpl_type eq "newsletter" || $tpl_type eq "listemployeetime" || $tpl_type eq "roomcat"%>
		<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
	<%/if%>
	<%if $tpl_type eq "editgast" || $tpl_type eq "season" || $tpl_type eq "price" || $tpl_type eq "lists" || $tpl_subnav eq "account" || $tpl_type eq "newsletter" || $tpl_type eq "listemployeetime"%>
		<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
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

	<div id="body">
	  <div id="header">
		  <div id="loginname"><span><%if $tpl_title neq "Login"%>Hallo, <%$tpl_loggedin%><%/if%></span></div>
		  <img src="<%$wwwroot%>/img_v2/teaser.jpg" alt="Zimmerverwaltungsystem">
		  <div id="logo">
		    <div id="servicenav">
   		      <%if $tpl_title neq "Login"%>
			  <ul>
				  <li><a href="<%$wwwroot%>settings.php">##SETTINGS##</a> | </li>
				  <li><a href="<%$wwwroot%>logout.php">##LOGOUT##</a></li>
			  </ul>	
			  <%/if%>		
  		      </div>				
		      <img src="<%$wwwroot%>/img_v2/logo.gif" alt="Zimmerverwaltungsystem">
			</div>
		   </div>
		   <div id="date"><%$smarty.now|date_format:"%A, %d. %B %Y"%></div>
		   <div id="toplevelnav">
		    <%if $tpl_title neq "Login"%>	
		    <ul>
				<li <%if $tpl_nav eq "calendar"%>class="current"<%/if%>><a href="<%$wwwroot%>index.php">##ROOM_ADMINISTRATION##</a></li>
				<li <%if $tpl_nav eq "gast" or $tpl_nav eq "showgast"%>class="current"<%/if%>><a href="<%$wwwroot%>guest.php">##GUEST_ADMINISTRATION##</a></li>
				<li <%if $tpl_nav eq "newsletter"%>class="current"<%/if%>><a href="<%$wwwroot%>newsletter.php">##NEWSLETTER##</a></li>
				<li <%if $tpl_nav eq "lists"%>class="current"<%/if%>><a href="<%$wwwroot%>lists.php">##LISTS##</a></li>
		    </ul>
			<%/if%>			
		  </div>
		  <div id="secondlevelnav">
          <%if $tpl_nav eq "gast"%>
			<%if $tpl_gast.guestid neq ""%>
			<ul>
				<li <%if $tpl_subnav eq "hauptgast"%>class="current"<%/if%>><a href="<%$wwwroot%>editgast.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>">##MAIN_GUEST##</a><%if $tpl_gast.guestid neq ""%><span>|</span><%/if%></li>
				<li <%if $tpl_subnav eq "escort"%>class="current"<%/if%>><a href="<%$wwwroot%>showescort.php/guestid.<%$tpl_gast.guestid%>/type.edit">##ESCORTS##</a><span>|</span></li>
				<li <%if $tpl_subnav eq "editinfo"%>class="current"<%/if%>><a href="<%$wwwroot%>editinfo.php/guestid.<%$tpl_gast.guestid%>">##NOTICE##</a><span>|</span></li>
			    <li <%if $tpl_subnav eq "cat"%>class="current"<%/if%>><a href="<%$wwwroot%>editcat.php/guestid.<%$tpl_gast.guestid%>">##CATEGORIES##</a><span>|</span></li>
				<li <%if $tpl_subnav eq "documents"%>class="current"<%/if%>><a href="<%$wwwroot%>showguestdocuments.php/guestid.<%$tpl_gast.guestid%>/type.edit">##DOCUMENTS##</a><span>|</span></li>
			    <li <%if $tpl_subnav eq "account"%>class="current"<%/if%>><a href="<%$wwwroot%>account.php/guestid.<%$tpl_gast.guestid%>/type.edit">##PAYMENT_ENTRY##</a></li>
			</ul>
			<%else%>
			<ul>
				<li>##MAIN_GUEST##</a><span>|</span></li>
				<li>##ESCORTS##</a><span>|</span></li>
				<li>##NOTICE##</a><span>|</span></li>
			    <li>##CATEGORIES##</a><span>|</span></li>
				<li>##DOCUMENTS##</a><span>|</span></li>
			    <li>##PAYMENT_ENTRY##</a></li>
			</ul>			
			<%/if%>
		  <%elseif $tpl_nav eq "showgast"%>
			<ul>
              <li <%if $tpl_subnav eq "hauptgast"%>class="current"<%/if%>><a href="<%$wwwroot%>showgast.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>">##MAIN_GUEST##</a><span>|</span></li>
            <li <%if $tpl_subnav eq "escort"%>class="current"<%/if%>><a href="<%$wwwroot%>showescort.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show">##ESCORTS##</a><span>|</span></li>
            <li <%if $tpl_subnav eq "showinfo"%>class="current"<%/if%>><a href="<%$wwwroot%>showinfo.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>">##NOTICE##</a><span>|</span></li>
            <li <%if $tpl_subnav eq "cat"%>class="current"<%/if%>><a href="<%$wwwroot%>showcat.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>">##CATEGORIES##</a><span>|</span></li>
            <li <%if $tpl_subnav eq "documents"%>class="current"<%/if%>><a href="<%$wwwroot%>showguestdocuments.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show">##DOCUMENTS##</a><span>|</span></li>
	    	<li <%if $tpl_subnav eq "account"%>class="current"<%/if%>><a href="<%$wwwroot%>account.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show">##PAYMENT_ENTRY##</a></li>			   
			</ul>	
		  <%elseif $tpl_nav eq "lists"%>
		    <ul>
	         <li <%if $tpl_subnav eq "receipt"%>class="current"<%/if%>><a href="<%$wwwroot%>list_receipt.php">##BILLS##</a><span>|</span></li>
			 <li <%if $tpl_subnav eq "receiptitems"%>class="current"<%/if%>><a href="<%$wwwroot%>list_receiptitems.php">##INVOICE_ITEM##</a><span>|</span></li>			   
			 <li <%if $tpl_subnav eq "income"%>class="current"<%/if%>><a href="<%$wwwroot%>list_income.php">##REVENUES##</a><span>|</span></li>
  		     <li <%if $tpl_subnav eq "checkout"%>class="current"<%/if%>><a href="<%$wwwroot%>list_guest.php">##ATTENDANCE_LIST##</a><span>|</span></li>
		     <li <%if $tpl_subnav eq "guestlist2"%>class="current"<%/if%>><a href="<%$wwwroot%>list_guest2.php">##ATTENDANCE_LIST## (##TIMEPERIOD##)</a><span>|</span></li>			   
  		     <li <%if $tpl_subnav eq "roomchange"%>class="current"<%/if%>><a href="<%$wwwroot%>list_roomchange.php">##CHANGE_OF_ROOM##</a><span>|</span></li>			   			   
			 <li <%if $tpl_subnav eq "birthday"%>class="current"<%/if%>><a href="<%$wwwroot%>list_birthday.php">##BIRTHDAY_LIST##</a><span>|</span></li>			   			   			   
		     <li <%if $tpl_subnav eq "employeetime"%>class="current"<%/if%>><a href="<%$wwwroot%>list_employeetime.php">##EMPLOYEES_TIMES##</a><span>|</span></li>			   			   			   			   
			 <li <%if $tpl_subnav eq "employee"%>id="current"<%/if%>><a href="<%$wwwroot%>list_employee.php">##EMPLOYEES##</a></li>					      		</ul>
          <%elseif $tpl_subnav eq "catsettings"%>
          	<ul>
			  <li <%if $tpl_subnav2 eq "category"%>class="current"<%/if%>><a href="<%$wwwroot%>category.php">##GUEST_CATEGORIES##</a><span>|</span></li>
			  <li <%if $tpl_subnav2 eq "roomcat"%>class="current"<%/if%>><a href="<%$wwwroot%>roomcategory.php">##ROOM_CATEGORIES##</a><span>|</span></li>
			  <li <%if $tpl_subnav2 eq "bookingcat"%>class="current"<%/if%>><a href="<%$wwwroot%>bookingcat.php">##CATEGORIES_OF_BOOKING##</a><span>|</span></li>
			  <li <%if $tpl_subnav2 eq "paycategory"%>class="current"<%/if%>><a href="<%$wwwroot%>paytypes.php">##PAYMENT_CATEGORIES##</a></li>		   
            </ul>		      
          <%elseif $tpl_subnav eq "syssettings"%>
            <ul>
			  <li <%if $tpl_subnav2 eq "rooms"%>class="current"<%/if%>><a href="<%$wwwroot%>rooms.php">##ROOM##</a><span>|</span></li>
  			  <li <%if $tpl_subnav2 eq "season"%>class="current"<%/if%>><a href="<%$wwwroot%>season.php">##SEASON##</a><span>|</span></li>
			  <li <%if $tpl_subnav2 eq "price"%>class="current"<%/if%>><a href="<%$wwwroot%>price.php">##ROOM_PRICES##</a><span>|</span></li>  
			  <li <%if $tpl_subnav2 eq "article"%>class="current"<%/if%>><a href="<%$wwwroot%>article.php">##ARTICLE##</a><span>|</span></li>							
			  <li <%if $tpl_subnav2 eq "user"%>class="current"<%/if%>><a href="<%$wwwroot%>edituser.php">##USER##</a><span>|</span></li>
			  <li <%if $tpl_subnav2 eq "employee"%>class="current"<%/if%>><a href="<%$wwwroot%>editemployee.php">##EMPLOYEES##</a><span>|</span></li>
			  <li <%if $tpl_subnav2 eq "systemsettings"%>class="current"<%/if%>><a href="<%$wwwroot%>systemsettings.php">##SYSTEM_SETTINGS##</a><span>|</span></li>
			  <li <%if $tpl_subnav2 eq "database"%>class="current"<%/if%>><a href="<%$wwwroot%>database.php">##DATABASE##</a></li>
          	</ul>		                	
          <%elseif $tpl_nav eq "calendar"%>
            <ul>
			  <li <%if $tpl_subnav eq "type"%>class="current"<%/if%>><a href="<%$wwwroot%>index.php/view.type<%if $tpl_navmonth neq ""%>/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%/if%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>">##TYPE_OF_ALLOCATION_PLURAL##</a><span>|</span></li>
			  <li <%if $tpl_subnav eq "cat"%>class="current"<%/if%>><a href="<%$wwwroot%>index.php/view.cat<%if $tpl_navmonth neq ""%>/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%/if%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>">##CATEGORIES_OF_BOOKING##</a><span>|</span></li>
			  <li <%if $tpl_subnav eq "checkin"%>class="current"<%/if%>><a href="<%$wwwroot%>checkinlist.php">##CHECK_IN##</a><span>|</span></li>
			  <li <%if $tpl_subnav eq "checkout"%>class="current"<%/if%>><a href="<%$wwwroot%>checkoutlist.php">##CHECKOUT##</a></li>			            </ul>          
		  <%/if%>
		</div>
		<div id="main">
<%/strip%>