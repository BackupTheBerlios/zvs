<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML> 
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: <%$tpl_title%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<%if $tpl_type eq "editgast" || $tpl_type eq "season" || $tpl_type eq "price" || $tpl_type eq "lists" || $tpl_subnav eq "account" || $tpl_type eq "newsletter" || $tpl_type eq "listemployeetime"%>
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/confirmleave.js"></script>
<%/if%>
<%if $tpl_type eq "calendar" || $tpl_type eq "editgast" || $tpl_type eq "showgast" || $tpl_type eq "roomcat"%>
<script src="<%$wwwroot%>global/tooltip.js" type="text/javascript" language="Javascript"></script>
<%/if%>
<%if ($tpl_type eq "editgast" || $tpl_type eq "showgast") && $tpl_subnav eq "hauptgast"%>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/addressselect.js"></script>
<%/if%>
<%if $tpl_logout eq "true"%>
<meta http-equiv="refresh" content="3; URL=<%$wwwroot%>index.php/login.<%$tpl_login%>/index.php">
<%/if%> 
</HEAD>
<%strip%>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" <%if ($tpl_type eq "editgast" || $tpl_type eq "showgast") || $tpl_type eq "price" || $tpl_type eq "newsletter"%>onLoad="<%if $tpl_subnav eq "hauptgast"%>switchLayer('add_private');<%/if%><%if $tpl_type eq "editgast" || $tpl_type eq "price" || $tpl_type eq "newsletter" || $tpl_type eq "listemployeetime" %>addonchangeevents();<%/if%>"<%/if%> <%if $tpl_type eq "editgast" || $tpl_type eq "price" || $tpl_type eq "newsletter"%> onbeforeunload="javascript:returnvalue();"<%/if%>>
<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
<tr>
<td valign="top">
<table border="0" class="Box" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td rowspan="2"><img src="<%$wwwroot%>logo/logo.gif" boder="0" width="100" height="70"></td>
        <td align="right"><%$smarty.now|date_format:"%A, %d. %B %Y"%>&nbsp;</td>
	</tr>
	<tr>
        <td align="right" valign="bottom">
           <table border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td class="<%if $tpl_nav eq "calendar"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>index.php" class="<%if $tpl_nav eq "calendar"%>NavActive<%else%>NavInactive<%/if%>"><img src="<%$wwwroot%>img/room.png" border="0" width="14" height="14">&nbsp;##ROOM_ADMINISTRATION##</a></td>
               <td class="<%if $tpl_nav eq "gast" or $tpl_nav eq "showgast"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>guest.php" class="<%if $tpl_nav eq "gast" or $tpl_nav eq "showgast"%>NavActive<%else%>NavInactive<%/if%>"><img src="<%$wwwroot%>img/guests.png" border="0" width="23" height="14">&nbsp;##GUEST_ADMINISTRATION##</a></td>
			   <td class="<%if $tpl_nav eq "newsletter"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>newsletter.php" class="<%if $tpl_nav eq "newsletter"%>NavActive<%else%>NavInactive<%/if%>"><img src="<%$wwwroot%>img/email.png" border="0" width="14" height="14">&nbsp;##NEWSLETTER##</a></td>			   			   
               <td class="<%if $tpl_nav eq "lists"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>lists.php" class="<%if $tpl_nav eq "lists"%>NavActive<%else%>NavInactive<%/if%>"><img src="<%$wwwroot%>img/lists.png" border="0" width="14" height="14">&nbsp;##LISTS##</a></td>			   
               <td class="<%if $tpl_nav eq "settings"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>settings.php" class="<%if $tpl_nav eq "settings"%>NavActive<%else%>NavInactive<%/if%>"><img src="<%$wwwroot%>img/editnav.png" border="0" width="14" height="14">&nbsp;##SETTINGS##</a></td>
               <td class="<%if $tpl_nav eq "logout"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>logout.php" class="<%if $tpl_nav eq "logout"%>NavActive<%else%>NavInactive<%/if%>"><img src="<%$wwwroot%>img/logout.png" border="0" width="14" height="14">&nbsp;##LOGOUT##</a></td>			   
			 </tr>
           </table>
        </td>
    </tr>
    <tr>
        <td class="BoxTop" colspan="2"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    </tr>
    <tr>
        <td align="right" valign="top" colspan="2" class="White">
          <%if $tpl_nav eq "gast"%>
           <table border="0" cellspacing="0" cellpadding="0" valign="top">
             <tr>
               <td valign="top" class="<%if $tpl_subnav eq "hauptgast"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>editgast.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>" class="<%if $tpl_subnav eq "hauptgast"%>NavActive<%else%>NavInactive<%/if%>">##MAIN_GUEST##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "escort"%>NavActive<%else%>NavInactive<%/if%>"><%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>showescort.php/guestid.<%$tpl_gast.guestid%>/type.edit" class="<%if $tpl_subnav eq "escort"%>NavActive<%else%>NavInactive<%/if%>">##ESCORTS##</a><%else%>##ESCORTS##<%/if%></td>
               <td valign="top" class="<%if $tpl_subnav eq "editinfo"%>NavActive<%else%>NavInactive<%/if%>"><%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>editinfo.php/guestid.<%$tpl_gast.guestid%>" class="<%if $tpl_subnav eq "editinfo"%>NavActive<%else%>NavInactive<%/if%>">Notizen</a><%else%>##NOTICE##<%/if%></td>
               <td valign="top" class="<%if $tpl_subnav eq "cat"%>NavActive<%else%>NavInactive<%/if%>"><%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>editcat.php/guestid.<%$tpl_gast.guestid%>" class="<%if $tpl_subnav eq "cat"%>NavActive<%else%>NavInactive<%/if%>">Kategorien</a><%else%>##CATEGORIES##<%/if%></td>
               <td valign="top" class="<%if $tpl_subnav eq "documents"%>NavActive<%else%>NavInactive<%/if%>"><%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>showguestdocuments.php/guestid.<%$tpl_gast.guestid%>/type.edit" class="<%if $tpl_subnav eq "documents"%>NavActive<%else%>NavInactive<%/if%>">Dokumente</a><%else%>##DOCUMENTS##<%/if%></td>
			   <td valign="top" class="<%if $tpl_subnav eq "account"%>NavActive<%else%>NavInactive<%/if%>"><%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>account.php/guestid.<%$tpl_gast.guestid%>/type.edit" class="<%if $tpl_subnav eq "account"%>NavActive<%else%>NavInactive<%/if%>">##PAYMENT_ENTRY##</a><%else%>##PAYMENT_ENTRY##<%/if%></td>			   
             </tr>
           </table>
          <%elseif $tpl_nav eq "showgast"%>
           <table border="0" cellspacing="0" cellpadding="0" valign="top">
             <tr>
               <td valign="top" class="<%if $tpl_subnav eq "hauptgast"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>showgast.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>" class="<%if $tpl_subnav eq "hauptgast"%>NavActive<%else%>NavInactive<%/if%>">Hauptgast</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "escort"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>showescort.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show" class="<%if $tpl_subnav eq "escort"%>NavActive<%else%>NavInactive<%/if%>">##ESCORTS##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "showinfo"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>showinfo.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>" class="<%if $tpl_subnav eq "showinfo"%>NavActive<%else%>NavInactive<%/if%>">##NOTICE##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "cat"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>showcat.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>" class="<%if $tpl_subnav eq "cat"%>NavActive<%else%>NavInactive<%/if%>">##CATEGORIES##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "documents"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>showguestdocuments.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show" class="<%if $tpl_subnav eq "documents"%>NavActive<%else%>NavInactive<%/if%>">##DOCUMENTS##</a></td>
			   <td valign="top" class="<%if $tpl_subnav eq "account"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>account.php<%if $tpl_gast.guestid neq ""%>/guestid.<%$tpl_gast.guestid%><%/if%>/type.show" class="<%if $tpl_subnav eq "account"%>NavActive<%else%>NavInactive<%/if%>">##PAYMENT_ENTRY##</a></td>			   
             </tr>
           </table>
		  <%elseif $tpl_nav eq "lists"%>
           <table border="0" cellspacing="0" cellpadding="0" valign="top">
             <tr>
               <td valign="top" class="<%if $tpl_subnav eq "receipt"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_receipt.php" class="<%if $tpl_subnav eq "receipt"%>NavActive<%else%>NavInactive<%/if%>">##BILLS##</a></td>
			   <td valign="top" class="<%if $tpl_subnav eq "receiptitems"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_receiptitems.php" class="<%if $tpl_subnav eq "receiptitems"%>NavActive<%else%>NavInactive<%/if%>">##INVOICE_ITEM##</a></td>			   
			   <td valign="top" class="<%if $tpl_subnav eq "income"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_income.php" class="<%if $tpl_subnav eq "income"%>NavActive<%else%>NavInactive<%/if%>">##REVENUES##</a></td>			   			   
			   <td valign="top" class="<%if $tpl_subnav eq "checkout"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_guest.php" class="<%if $tpl_subnav eq "checkout"%>NavActive<%else%>NavInactive<%/if%>">##ATTENDANCE_LIST##</a></td>
			   <td valign="top" class="<%if $tpl_subnav eq "guestlist2"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_guest2.php" class="<%if $tpl_subnav eq "guestlist2"%>NavActive<%else%>NavInactive<%/if%>">##ATTENDANCE_LIST## 2</a></td>			   
			   <td valign="top" class="<%if $tpl_subnav eq "roomchange"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_roomchange.php" class="<%if $tpl_subnav eq "roomchange"%>NavActive<%else%>NavInactive<%/if%>">##CHANGE_OF_ROOM##</a></td>			   			   
			   <td valign="top" class="<%if $tpl_subnav eq "birthday"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_birthday.php" class="<%if $tpl_subnav eq "birthday"%>NavActive<%else%>NavInactive<%/if%>">##BIRTHDAY_LIST##</a></td>			   			   			   
			   <td valign="top" class="<%if $tpl_subnav eq "employeetime"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_employeetime.php" class="<%if $tpl_subnav eq "employeetime"%>NavActive<%else%>NavInactive<%/if%>">##EMPLOYEES_TIMES=Mitarbeiterzeiten##</a></td>			   			   			   			   
			   <td valign="top" class="<%if $tpl_subnav eq "employee"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>list_employee.php" class="<%if $tpl_subnav eq "employee"%>NavActive<%else%>NavInactive<%/if%>">##EMPLOYEES##</a></td>			   			   			   			   			   
             </tr>
           </table>		  
          <%elseif $tpl_nav eq "settings"%>
           <table border="0" cellspacing="0" cellpadding="0" valign="top">
             <tr>
               <td valign="top" class="<%if $tpl_subnav eq "category"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>category.php" class="<%if $tpl_subnav eq "category"%>NavActive<%else%>NavInactive<%/if%>">##GUEST_CATEGORIES##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "roomcat"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>roomcategory.php" class="<%if $tpl_subnav eq "roomcat"%>NavActive<%else%>NavInactive<%/if%>">##ROOM_CATEGORIES##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "rooms"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>rooms.php" class="<%if $tpl_subnav eq "rooms"%>NavActive<%else%>NavInactive<%/if%>">##ROOM##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "bookingcat"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>bookingcat.php" class="<%if $tpl_subnav eq "bookingcat"%>NavActive<%else%>NavInactive<%/if%>">##CATEGORIES_OF_BOOKING##</a></td>
			   <td valign="top" class="<%if $tpl_subnav eq "season"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>season.php" class="<%if $tpl_subnav eq "season"%>NavActive<%else%>NavInactive<%/if%>">##SEASON##</a></td>			   
			   <td valign="top" class="<%if $tpl_subnav eq "price"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>price.php" class="<%if $tpl_subnav eq "price"%>NavActive<%else%>NavInactive<%/if%>">##ROOM_PRICES##</a></td>			   			   
			   <td valign="top" class="<%if $tpl_subnav eq "article"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>article.php" class="<%if $tpl_subnav eq "article"%>NavActive<%else%>NavInactive<%/if%>">##ARTICLE##</a></td>	
			   <td valign="top" class="<%if $tpl_subnav eq "paycategory"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>paytypes.php" class="<%if $tpl_subnav eq "paycategory"%>NavActive<%else%>NavInactive<%/if%>">##PAYMENT_CATEGORIES##</a></td>		   
               <td valign="top" class="<%if $tpl_subnav eq "user"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>edituser.php" class="<%if $tpl_subnav eq "user"%>NavActive<%else%>NavInactive<%/if%>">##USER##</a></td>
			 </tr>
           </table>
		   <table border="0" cellspacing="0" cellpadding="0" valign="top">
		   	 <tr>
  			   <td valign="top" class="<%if $tpl_subnav eq "employee"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>editemployee.php" class="<%if $tpl_subnav eq "employee"%>NavActive<%else%>NavInactive<%/if%>">##EMPLOYEES##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "systemsettings"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>systemsettings.php" class="<%if $tpl_subnav eq "systemsettings"%>NavActive<%else%>NavInactive<%/if%>">##SYSTEM_SETTINGS##</a></td>
			   <td valign="top" class="<%if $tpl_subnav eq "database"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>database.php" class="<%if $tpl_subnav eq "database"%>NavActive<%else%>NavInactive<%/if%>">##DATABASE##</a></td>
			 </tr>
			</table>
          <%elseif $tpl_nav eq "calendar"%>
           <table border="0" cellspacing="0" cellpadding="0" valign="top">
             <tr>
               <td valign="top" class="<%if $tpl_subnav eq "type"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>index.php/view.type<%if $tpl_navmonth neq ""%>/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%/if%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>" class="<%if $tpl_subnav eq "type"%>NavActive<%else%>NavInactive<%/if%>">##TYPE_OF_ALLOCATION_PLURAL##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "cat"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>index.php/view.cat<%if $tpl_navmonth neq ""%>/month.<%$tpl_navmonth%>/year.<%$tpl_navyear%><%/if%><%if $tpl_navstep neq ""%>/step.<%$tpl_navstep%><%/if%>" class="<%if $tpl_subnav eq "cat"%>NavActive<%else%>NavInactive<%/if%>">##CATEGORIES_OF_BOOKING##</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "checkin"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>checkinlist.php" class="<%if $tpl_subnav eq "checkin"%>NavActive<%else%>NavInactive<%/if%>">Checkin</a></td>
			  <td valign="top" class="<%if $tpl_subnav eq "checkout"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>checkoutlist.php" class="<%if $tpl_subnav eq "checkout"%>NavActive<%else%>NavInactive<%/if%>">##CHECKOUT##</a></td>			   
             </tr>
           </table>
          <%/if%>
        </td>
    </tr>
</table>
<table width="100%" height="80%" border="0">
<tr>
  <td valign="top">
<%/strip%>
