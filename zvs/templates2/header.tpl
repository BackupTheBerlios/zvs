<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML> 
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs Mitarbeiter Zeitverwaltung: <%$tpl_title%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<%if $tpl_logout eq "true"%>
<meta http-equiv="refresh" content="3; URL=<%$wwwroot%>index.php/login.<%$tpl_login%>/index.php">
<%elseif $tpl_title eq "login"%>
<%else%>
<meta http-equiv="refresh" content="120; URL=<%$wwwroot%>logout.php">
<%/if%> 
</HEAD>
<%strip%>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" >
<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
<tr>
<td valign="top">
<table border="0" class="Box" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td rowspan="2">&nbsp;</td>
        <td align="right"><%$smarty.now|date_format:"%A, %d. %B %Y"%>&nbsp;</td>
	</tr>
	<tr>
        <td align="right" valign="bottom">
           <table border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td class="<%if $tpl_nav eq "index"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>index.php" class="<%if $tpl_nav eq "index"%>NavActive<%else%>NavInactive<%/if%>">Kommen/Gehen</a></td>
               <td class="<%if $tpl_nav eq "list"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>list_employeetime.php" class="<%if $tpl_nav eq "list"%>NavActive<%else%>NavInactive<%/if%>">Zeiten</a></td>
               <td class="<%if $tpl_nav eq "logout"%>NavActive<%else%>NavInactive<%/if%>" valign="baseline"><a href="<%$wwwroot%>logout.php" class="<%if $tpl_nav eq "logout"%>NavActive<%else%>NavInactive<%/if%>"><img src="<%$wwwroot%>img/logout.png" border="0" width="14" height="14">&nbsp;Abmelden</a></td>			   
			 </tr>
           </table>
        </td>
    </tr>
</table>
<table width="100%" height="80%" border="0">
<tr>
  <td valign="top">
<%/strip%>
