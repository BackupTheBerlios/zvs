<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="javascript"  type="text/javascript">

<!--

  function submit_onkeypress()
  {
    if(window.event.keyCode==13)
    {
   	  document.search.submit();
    }
  }

// -->

</script>
<%strip%>

<table border="0" cellpadding="4" cellspacing="0" align="center" height="95%">
<tr>
<td valign="top" width="400">
<form id="search" name="search" action="<%$SCRIPT_NAME%>" method="post">
<table width="40%" border="0" cellspacing="0" cellpadding="0" class="Box" align="left">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
        <p  class="SubheadlineYellow">Gast suchen</p>
   		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td><strong>Vorname</strong></td>
               <td><input name="frm_firstname" type="text" id="frm_firstname" size="30" value="<%$tpl_firstname%>" onKeyPress="submit_onkeypress();"></td>
             </tr>
             <tr>
               <td><strong>Nachname</strong></td>
               <td><input name="frm_lastname" type="text" id="frm_lastname" size="30" value="<%$tpl_lastname%>" onKeyPress="submit_onkeypress();"></td>
             </tr>
			 <tr>
			  <td class="DefText">&nbsp;</td>
			  <td align=right>
			  <a href="javascript:document.search.submit();"><img src="<%$wwwroot%>img/button_search.png" width="73" height="24" alt="Suchen" border="0" id="loginfrm"></a>
			  </td>
			 </tr>
        </table>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</form>
</td>
<td valign="top" width="250">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Box" align="left">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
		<p class="SubheadlineYellow">neuen Gast erfassen</p>
        <a href="<%$wwwroot%>editgast.php"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" alt="Suchen" border="0" id="loginfrm"></a>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</td>
</tr>
<%if $tpl_isresult eq 'true'%>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Box" align="left">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow"><%$tpl_numresult%>&nbsp;<%if $tpl_numresult eq 1%>Eintrag<%else%>Eintr&auml;ge<%/if%>&nbsp;gefunden</p>
   		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td class="ListL1Header">&nbsp;</td>
               <td class="ListL1Header"><strong>Nachname</strong></td>
               <td class="ListL1Header"><strong>Vorname</strong></td>
               <td class="ListL1Header"><strong>Geschlecht</strong></td>
               <td class="ListL1Header"><strong>Firma</strong></td>
               <td class="ListL1Header"><strong>Addresse</strong></td>
               <td class="ListL1Header"><strong>PLZ</strong></td>
               <td class="ListL1Header"><strong>Ort</strong></td>
               <td class="ListL1Header"><strong>Land</strong></td>
               <td class="ListL1Header"><strong>letzte<br>Buchung</strong></td>
               <td class="ListL1Header"><strong>letzter<br>Aufenthalt</strong></td>
               <td class="ListL1Header">&nbsp;</td>
             </tr>
             <%section name=res loop=$tpl_result%>
             <tr>
               <td class="ListL<%$tpl_result[res].color%>"><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_result[res].guestid%>"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a></td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].lastname%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].firstname%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].gender%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].company%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].address%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].postalcode%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].city%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].country_name%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].last_booking%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].last_stay%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><a href="<%$wwwroot%>editgast.php/guestid.<%$tpl_result[res].guestid%>"><img src="<%$wwwroot%>img/icon_antwort.gif" width="19" height="16" border="0" alt="Editieren"></a></td>
             </tr>
             <%sectionelse%>
             <tr>
               <td class="DefText" colspan="4">keine Eintr&auml;ge gefunden</td>
             <%/section%>

        </table>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</td>
</tr>
<%/if%>
</table>

<%include file=footer.tpl%>
<%/strip%>

