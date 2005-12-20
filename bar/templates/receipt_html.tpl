<html>
<head>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2005 of Christian Ehret
-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/bon.css" rel="stylesheet" type="text/css">
<title>Bon: <%$tpl_name%></title>
</head>
<body onload="javascript:window.print();">
<div id="head">
<img src="<%$wwwroot%>global/<%$tpl_logo%>" width="150" height="105" border="0"/>
<br/>
Petra & Mike
<br/>
Wiesenhof 204
<br/>
A-6351 Scheffau am Wilden Kaiser
<br/>
<br/>
Telefon: 0043-5358-8398 
<br/>
E-mail: wiesenhof@tirol.com 
<br/>
<br/>
</div>
<b>Rechnung von <%$tpl_name%></b>
<br/>
<table id="head">
 <tr>
  <td class="left"><%$tpl_date%></td>
  <td class="right"><%$tpl_loggedin%></td>
 </tr>
  <tr>
  <td class="left border">&nbsp;</td>
  <td class="right border">&nbsp;</td>
 </tr>
 <%section name="art" loop=$tpl_receipt%>
<%if $smarty.section.art.last%>
  <tr>
  <td class="left sum"><b>Summe:</b></td>
  <td class="right sum"><b><%$tpl_receipt[art].total%> &euro;</b></td>
 </tr>
<%else%>  
  <tr>
  <td class="left"><%$tpl_receipt[art].num%> x <%$tpl_receipt[art].price%> &euro;</td>
  <td class="right">*<%$tpl_receipt[art].total%> &euro;</td>
 </tr>
  <tr>
  <td class="left <%if $tpl_receipt[art.index_next].articleid eq 0%>secondlast<%else%>border<%/if%>" colspan="2"><%$tpl_receipt[art].description%></td>
 </tr> 
 <%/if%>
 <%/section%>
</table>
<br/>
<div id="footer">
Vielen Dank f&uuml;r Ihren Besuch
<br/>
Auf Wiedersehen
<br/><br/>
http://www.saustall.info
</div>
</body>
</html>