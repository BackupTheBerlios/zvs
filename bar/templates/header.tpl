<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML> 
<HEAD>
<title>zvs: <%$tpl_title%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<%if $tpl_logout eq "true"%>
<meta http-equiv="refresh" content="3; URL=<%$wwwroot%>index.php/login.<%$tpl_login%>/index.php">
<%/if%> 
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript">
<!--
    function openWindow(){
    F1 = window.open('<%$wwwroot%>addbarguest.php','addbarguest','width=270,height=190,left=0,top=0');
    F1.focus();
    }
//-->
</script>

<%if $tpl_nav eq "statistics" || $tpl_nav eq "archive" || $tpl_subnav eq "archive"%>
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
<%/if%>
<%if $tpl_nav eq "sell"%>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/reloadtimer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/numtimer.js"></script>
<%/if%>
</HEAD>
<%strip%>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" <%if $tpl_nav eq "sell" %>onLoad="InitializeTimer();"<%/if%>>
<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
<tr>
<td valign="top">
<table border="0" class="Box" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td rowspan="2"><%if $tpl_sum neq ""%>Tagesumsatz: <%$tpl_sum%>&nbsp;EUR<%/if%><img src="<%$wwwroot%>img/spacer.gif" boder="0" width="100" height="1"></td>
        <td align="right"><%$smarty.now|date_format:"%A, %d. %B %Y"%>&nbsp;</td>
	</tr>
	</tr>
        <td align="right" valign="bottom">
           <table border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td class="<%if $tpl_nav eq "sell"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>index.php" class="<%if $tpl_nav eq "sell"%>NavActive<%else%>NavInactive<%/if%>">Verkauf</a></td>
			   <!--<td class="<%if $tpl_nav eq "kassa"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>kassa.php" class="<%if $tpl_nav eq "kassa"%>NavActive<%else%>NavInactive<%/if%>">Kassa</a></td>-->
			   <td class="<%if $tpl_nav eq "archive"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>archive.php" class="<%if $tpl_nav eq "archive"%>NavActive<%else%>NavInactive<%/if%>">Archiv</a></td>			   
               <td class="<%if $tpl_nav eq "settings"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>settings.php" class="<%if $tpl_nav eq "settings"%>NavActive<%else%>NavInactive<%/if%>">Einstellungen</a></td>
			   <td class="<%if $tpl_nav eq "statistics"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>statistics.php" class="<%if $tpl_nav eq "statistics"%>NavActive<%else%>NavInactive<%/if%>">Statistiken</a></td>
			   <td class="<%if $tpl_nav eq "logout"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>logout.php" class="<%if $tpl_nav eq "logout"%>NavActive<%else%>NavInactive<%/if%>">Abmelden</a></td>
			 </tr>
           </table>
        </td>
    </tr>
    <tr>
        <td class="BoxTop" colspan="2"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    </tr>
    <tr>
        <td align="right" valign="top" colspan="2" class="White" width="100%">
  		  <%if $tpl_nav eq "kassa"%>
           <table border="0" cellspacing="0" cellpadding="0" valign="top" width="100%">
             <tr>
			   <%section name=guest loop=$tpl_barguests%>
			   <%if $tpl_barguests[guest].newline eq "true"%>
			    </tr>
			    <tr>
				<%/if%>
			 	<td class="<%if $tpl_barguests[guest].guestid eq $tpl_theguestid%>NavActive<%else%>NavInactive<%/if%>" nowrap="nowrap" align="center">
				 <%if $tpl_barguests[guest].guestid eq '0'%>
				 	&nbsp;
				 <%else%>
				  	<a href="<%$wwwroot%><%if $tpl_nav eq "sell"%>index.php<%else%>kassa.php<%/if%>/guestid.<%$tpl_barguests[guest].guestid%>/index.php" class="<%if $tpl_barguests[guest].guestid eq $tpl_theguestid%>NavActive<%else%>NavInactive<%/if%>"><%$tpl_barguests[guest].firstname%>&nbsp;<%$tpl_barguests[guest].lastname%></a>
				<%/if%>
			   	</td>
			   <%/section%>
			   </tr>
           </table>		
  		  <%elseif $tpl_nav eq "sell2"%>
           <table border="0" cellspacing="0" cellpadding="0" valign="top" width="100%">
             <tr>
			 <td valign="top" class="NavInactive"><a href="javascript:openWindow();" class="NavInactive">neu</a></td>
			 <td>
			   <%section name=guest loop=$tpl_barguests%>
				 <a href="<%$wwwroot%>index.php/guestid.<%$tpl_barguests[guest].guestid%>/index.php" class="BarNavInactive"><%$tpl_barguests[guest].firstname%>&nbsp;<%$tpl_barguests[guest].lastname%></a>
			   <%/section%>
			   </td>
			   </tr>
           </table>		  
          <%elseif $tpl_nav eq "settings"%>
           <table border="0" cellspacing="0" cellpadding="0" valign="top">
             <tr>
               <td valign="top" class="<%if $tpl_subnav eq "editarticle"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>editarticle.php" class="<%if $tpl_subnav eq "editarticle"%>NavActive<%else%>NavInactive<%/if%>">Artikel verwalten</a></td>
			   <td valign="top" class="<%if $tpl_subnav eq "editarticlecat"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>editarticlecat.php" class="<%if $tpl_subnav eq "editarticlecat"%>NavActive<%else%>NavInactive<%/if%>">Artikelkategorien verwalten</a></td>
               <td valign="top" class="<%if $tpl_subnav eq "edituser"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>edituser.php" class="<%if $tpl_subnav eq "edituser"%>NavActive<%else%>NavInactive<%/if%>">Benutzer verwalten</a></td>
			   <td valign="top" class="<%if $tpl_subnav eq "backup"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>database.php" class="<%if $tpl_subnav eq "backup"%>NavActive<%else%>NavInactive<%/if%>">Datensicherung</a></td>
			   <td valign="top" class="<%if $tpl_subnav eq "archive"%>NavActive<%else%>NavInactive<%/if%>"><a href="<%$wwwroot%>archivedb.php" class="<%if $tpl_subnav eq "archive"%>NavActive<%else%>NavInactive<%/if%>">Archivieren</a></td>			   
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
