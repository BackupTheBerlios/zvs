<%strip%>
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
<%if $tpl_type eq "editgast"%>
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>
<%/if%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
   function setcolor(color)
   {
     opener.<%$tpl_form%>.<%$tpl_field%>.value = color;
     self.close();
   }
//-->
</script>
<%strip%>
</HEAD>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=0>
<TR>
<TD BGCOLOR="#FF0066"><A HREF="javascript:setcolor('#FF0066');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC0066"><A HREF="javascript:setcolor('#CC0066');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#990066"><A HREF="javascript:setcolor('#990066');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#660066"><A HREF="javascript:setcolor('#660066');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#330066"><A HREF="javascript:setcolor('#330066');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#000066"><A HREF="javascript:setcolor('#000066');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#000033"><A HREF="javascript:setcolor('#000033');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#330033"><A HREF="javascript:setcolor('#330033');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#660033"><A HREF="javascript:setcolor('#660033');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#990033"><A HREF="javascript:setcolor('#990033');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC0033"><A HREF="javascript:setcolor('#CC0033');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF0033"><A HREF="javascript:setcolor('#FF0033');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF0000"><A HREF="javascript:setcolor('#FF0000');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC0000"><A HREF="javascript:setcolor('#CC0000');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#990000"><A HREF="javascript:setcolor('#990000');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#660000"><A HREF="javascript:setcolor('#660000');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#330000"><A HREF="javascript:setcolor('#330000');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#000000"><A HREF="javascript:setcolor('#000000');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FF3366"><A HREF="javascript:setcolor('#FF3366');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC3366"><A HREF="javascript:setcolor('#CC3366');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#993366"><A HREF="javascript:setcolor('#993366');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#663366"><A HREF="javascript:setcolor('#663366');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#333366"><A HREF="javascript:setcolor('#333366');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#003366"><A HREF="javascript:setcolor('#003366');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#003333"><A HREF="javascript:setcolor('#003333');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#333333"><A HREF="javascript:setcolor('#333333');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#663333"><A HREF="javascript:setcolor('#663333');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#993333"><A HREF="javascript:setcolor('#993333');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC3333"><A HREF="javascript:setcolor('#CC3333');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF3333"><A HREF="javascript:setcolor('#FF3333');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF3300"><A HREF="javascript:setcolor('#FF3300');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC3300"><A HREF="javascript:setcolor('#CC3300');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#993300"><A HREF="javascript:setcolor('#993300');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#663300"><A HREF="javascript:setcolor('#663300');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#333300"><A HREF="javascript:setcolor('#333300');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#003300"><A HREF="javascript:setcolor('#003300');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FF6666"><A HREF="javascript:setcolor('#FF6666');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC6666"><A HREF="javascript:setcolor('#CC6666');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#996666"><A HREF="javascript:setcolor('#996666');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#666666"><A HREF="javascript:setcolor('#666666');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#336666"><A HREF="javascript:setcolor('#336666');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#006666"><A HREF="javascript:setcolor('#006666');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#006633"><A HREF="javascript:setcolor('#006633');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#336633"><A HREF="javascript:setcolor('#336633');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#666633"><A HREF="javascript:setcolor('#666633');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#996633"><A HREF="javascript:setcolor('#996633');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC6633"><A HREF="javascript:setcolor('#CC6633');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF6633"><A HREF="javascript:setcolor('#FF6633');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF6600"><A HREF="javascript:setcolor('#FF6600');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC6600"><A HREF="javascript:setcolor('#CC6600');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#996600"><A HREF="javascript:setcolor('#996600');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#666600"><A HREF="javascript:setcolor('#666600');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#336600"><A HREF="javascript:setcolor('#336600');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#006600"><A HREF="javascript:setcolor('#006600');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FF9966"><A HREF="javascript:setcolor('#FF9966');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC9966"><A HREF="javascript:setcolor('#CC9966');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#999966"><A HREF="javascript:setcolor('#999966');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#669966"><A HREF="javascript:setcolor('#669966');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#339966"><A HREF="javascript:setcolor('#339966');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#009966"><A HREF="javascript:setcolor('#009966');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#009933"><A HREF="javascript:setcolor('#009933');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#339933"><A HREF="javascript:setcolor('#339933');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#669933"><A HREF="javascript:setcolor('#669933');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#999933"><A HREF="javascript:setcolor('#999933');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC9933"><A HREF="javascript:setcolor('#CC9933');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF9933"><A HREF="javascript:setcolor('#FF9933');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF9900"><A HREF="javascript:setcolor('#FF9900');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC9900"><A HREF="javascript:setcolor('#CC9900');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#999900"><A HREF="javascript:setcolor('#999900');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#669900"><A HREF="javascript:setcolor('#669900');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#339900"><A HREF="javascript:setcolor('#339900');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#009900"><A HREF="javascript:setcolor('#009900');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FFCC66"><A HREF="javascript:setcolor('#FFCC66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCCC66"><A HREF="javascript:setcolor('#CCCC66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99CC66"><A HREF="javascript:setcolor('#99CC66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66CC66"><A HREF="javascript:setcolor('#66CC66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33CC66"><A HREF="javascript:setcolor('#33CC66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00CC66"><A HREF="javascript:setcolor('#00CC66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00CC33"><A HREF="javascript:setcolor('#00CC33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33CC33"><A HREF="javascript:setcolor('#33CC33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66CC33"><A HREF="javascript:setcolor('#66CC33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99CC33"><A HREF="javascript:setcolor('#99CC33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCCC33"><A HREF="javascript:setcolor('#CCCC33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FFCC33"><A HREF="javascript:setcolor('#FFCC33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FFCC00"><A HREF="javascript:setcolor('#FFCC00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCCC00"><A HREF="javascript:setcolor('#CCCC00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99CC00"><A HREF="javascript:setcolor('#99CC00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66CC00"><A HREF="javascript:setcolor('#66CC00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33CC00"><A HREF="javascript:setcolor('#33CC00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00CC00"><A HREF="javascript:setcolor('#00CC00');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FFFF66"><A HREF="javascript:setcolor('#FFFF66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCFF66"><A HREF="javascript:setcolor('#CCFF66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99FF66"><A HREF="javascript:setcolor('#99FF66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66FF66"><A HREF="javascript:setcolor('#66FF66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33FF66"><A HREF="javascript:setcolor('#33FF66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00FF66"><A HREF="javascript:setcolor('#00FF66');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00FF33"><A HREF="javascript:setcolor('#00FF33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33FF33"><A HREF="javascript:setcolor('#33FF33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66FF33"><A HREF="javascript:setcolor('#66FF33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99FF33"><A HREF="javascript:setcolor('#99FF33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCFF33"><A HREF="javascript:setcolor('#CCFF33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FFFF33"><A HREF="javascript:setcolor('#FFFF33');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FFFF00"><A HREF="javascript:setcolor('#FFFF00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCFF00"><A HREF="javascript:setcolor('#CCFF00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99FF00"><A HREF="javascript:setcolor('#99FF00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66FF00"><A HREF="javascript:setcolor('#66FF00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33FF00"><A HREF="javascript:setcolor('#33FF00');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00FF00"><A HREF="javascript:setcolor('#00FF00');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FFFFFF"><A HREF="javascript:setcolor('#FFFFFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCFFFF"><A HREF="javascript:setcolor('#CCFFFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99FFFF"><A HREF="javascript:setcolor('#99FFFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66FFFF"><A HREF="javascript:setcolor('#66FFFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33FFFF"><A HREF="javascript:setcolor('#33FFFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00FFFF"><A HREF="javascript:setcolor('#00FFFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00FFCC"><A HREF="javascript:setcolor('#00FFCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33FFCC"><A HREF="javascript:setcolor('#33FFCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66FFCC"><A HREF="javascript:setcolor('#66FFCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99FFCC"><A HREF="javascript:setcolor('#99FFCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCFFCC"><A HREF="javascript:setcolor('#CCFFCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FFFFCC"><A HREF="javascript:setcolor('#FFFFCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FFFF99"><A HREF="javascript:setcolor('#FFFF99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCFF99"><A HREF="javascript:setcolor('#CCFF99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99FF99"><A HREF="javascript:setcolor('#99FF99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66FF99"><A HREF="javascript:setcolor('#66FF99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33FF99"><A HREF="javascript:setcolor('#33FF99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00FF99"><A HREF="javascript:setcolor('#00FF99');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FFCCFF"><A HREF="javascript:setcolor('#FFCCFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCCCFF"><A HREF="javascript:setcolor('#CCCCFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99CCFF"><A HREF="javascript:setcolor('#99CCFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66CCFF"><A HREF="javascript:setcolor('#66CCFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33CCFF"><A HREF="javascript:setcolor('#33CCFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00CCFF"><A HREF="javascript:setcolor('#00CCFF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00CCCC"><A HREF="javascript:setcolor('#00CCCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33CCCC"><A HREF="javascript:setcolor('#33CCCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66CCCC"><A HREF="javascript:setcolor('#66CCCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99CCCC"><A HREF="javascript:setcolor('#99CCCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCCCCC"><A HREF="javascript:setcolor('#CCCCCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FFCCCC"><A HREF="javascript:setcolor('#FFCCCC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FFCC99"><A HREF="javascript:setcolor('#FFCC99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CCCC99"><A HREF="javascript:setcolor('#CCCC99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#99CC99"><A HREF="javascript:setcolor('#99CC99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#66CC99"><A HREF="javascript:setcolor('#66CC99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#33CC99"><A HREF="javascript:setcolor('#33CC99');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#00CC99"><A HREF="javascript:setcolor('#00CC99');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FF99FF"><A HREF="javascript:setcolor('#FF99FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC99FF"><A HREF="javascript:setcolor('#CC99FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#9999FF"><A HREF="javascript:setcolor('#9999FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#6699FF"><A HREF="javascript:setcolor('#6699FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#3399FF"><A HREF="javascript:setcolor('#3399FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#0099FF"><A HREF="javascript:setcolor('#0099FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#0099CC"><A HREF="javascript:setcolor('#0099CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#3399CC"><A HREF="javascript:setcolor('#3399CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#6699CC"><A HREF="javascript:setcolor('#6699CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#9999CC"><A HREF="javascript:setcolor('#9999CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC99CC"><A HREF="javascript:setcolor('#CC99CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF99CC"><A HREF="javascript:setcolor('#FF99CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF9999"><A HREF="javascript:setcolor('#FF9999');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC9999"><A HREF="javascript:setcolor('#CC9999');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#999999"><A HREF="javascript:setcolor('#999999');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#669999"><A HREF="javascript:setcolor('#669999');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#339999"><A HREF="javascript:setcolor('#339999');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#009999"><A HREF="javascript:setcolor('#009999');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FF66FF"><A HREF="javascript:setcolor('#FF66FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC66FF"><A HREF="javascript:setcolor('#CC66FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#9966FF"><A HREF="javascript:setcolor('#9966FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#6666FF"><A HREF="javascript:setcolor('#6666FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#3366FF"><A HREF="javascript:setcolor('#3366FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#0066FF"><A HREF="javascript:setcolor('#0066FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#0066CC"><A HREF="javascript:setcolor('#0066CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#3366CC"><A HREF="javascript:setcolor('#3366CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#6666CC"><A HREF="javascript:setcolor('#6666CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#9966CC"><A HREF="javascript:setcolor('#9966CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC66CC"><A HREF="javascript:setcolor('#CC66CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF66CC"><A HREF="javascript:setcolor('#FF66CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF6699"><A HREF="javascript:setcolor('#FF6699');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC6699"><A HREF="javascript:setcolor('#CC6699');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#996699"><A HREF="javascript:setcolor('#996699');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#666699"><A HREF="javascript:setcolor('#666699');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#336699"><A HREF="javascript:setcolor('#336699');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#006699"><A HREF="javascript:setcolor('#006699');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FF33FF"><A HREF="javascript:setcolor('#FF33FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC33FF"><A HREF="javascript:setcolor('#CC33FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#9933FF"><A HREF="javascript:setcolor('#9933FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#6633FF"><A HREF="javascript:setcolor('#6633FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#3333FF"><A HREF="javascript:setcolor('#3333FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#0033FF"><A HREF="javascript:setcolor('#0033FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#0033CC"><A HREF="javascript:setcolor('#0033CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#3333CC"><A HREF="javascript:setcolor('#3333CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#6633CC"><A HREF="javascript:setcolor('#6633CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#9933CC"><A HREF="javascript:setcolor('#9933CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC33CC"><A HREF="javascript:setcolor('#CC33CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF33CC"><A HREF="javascript:setcolor('#FF33CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF3399"><A HREF="javascript:setcolor('#FF3399');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC3399"><A HREF="javascript:setcolor('#CC3399');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#993399"><A HREF="javascript:setcolor('#993399');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#663399"><A HREF="javascript:setcolor('#663399');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#333399"><A HREF="javascript:setcolor('#333399');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#003399"><A HREF="javascript:setcolor('#003399');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR><TR>
<TD BGCOLOR="#FF00FF"><A HREF="javascript:setcolor('#FF00FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC00FF"><A HREF="javascript:setcolor('#CC00FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#9900FF"><A HREF="javascript:setcolor('#9900FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#6600FF"><A HREF="javascript:setcolor('#6600FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#3300FF"><A HREF="javascript:setcolor('#3300FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#0000FF"><A HREF="javascript:setcolor('#0000FF');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#0000CC"><A HREF="javascript:setcolor('#0000CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#3300CC"><A HREF="javascript:setcolor('#3300CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#6600CC"><A HREF="javascript:setcolor('#6600CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#9900CC"><A HREF="javascript:setcolor('#9900CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC00CC"><A HREF="javascript:setcolor('#CC00CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF00CC"><A HREF="javascript:setcolor('#FF00CC');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#FF0099"><A HREF="javascript:setcolor('#FF0099');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#CC0099"><A HREF="javascript:setcolor('#CC0099');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#990099"><A HREF="javascript:setcolor('#990099');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#660099"><A HREF="javascript:setcolor('#660099');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#330099"><A HREF="javascript:setcolor('#330099');"><TT>&nbsp;&nbsp;</TT></A></TD>
<TD BGCOLOR="#000099"><A HREF="javascript:setcolor('#000099');"><TT>&nbsp;&nbsp;</TT></A></TD>
</TR></TABLE>

</body>
</html>
<%/strip%>
