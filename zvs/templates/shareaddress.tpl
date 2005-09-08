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
<%if $tpl_finish%>
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
        <p  class="SubheadlineYellow">Adresse verkn&uuml;pfen (<%$tpl_gast.firstname%> <%$tpl_gast.lastname%>, <%if $tpl_type eq 'private'%>##PRIVATE##<%elseif $tpl_type eq 'business'%>##BUSINESS##<%elseif $tpl_type eq 'other'%>##OTHER##<%/if%>)</p>
        Adresse wurde erfolgreich verkn&uuml;pft.  <a href="<%$tpl_wwwroot%>editgast.php/guestid.<%$tpl_gast.guestid%>"><img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" alt="##NEXT##" border="0" id="loginfrm"></a>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
<%else%>
<form id="search" name="search" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%$tpl_gast.guestid%>">
<input type="hidden" name="frm_type" id="frm_type" value="<%$tpl_type%>">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
        <p  class="SubheadlineYellow">Adresse verkn&uuml;pfen (<%$tpl_gast.firstname%> <%$tpl_gast.lastname%>, <%if $tpl_type eq 'private'%>##PRIVATE##<%elseif $tpl_type eq 'business'%>##BUSINESS##<%elseif $tpl_type eq 'other'%>##OTHER##<%/if%>)</p>
   		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td><strong>##FIRSTNAME##</strong></td>
               <td><input name="frm_firstname" type="text" id="frm_firstname" size="30" value="<%$tpl_firstname%>" onKeyPress="submit_onkeypress();"></td>
             </tr>
             <tr>
               <td><strong>##LASTNAME##</strong></td>
               <td><input name="frm_lastname" type="text" id="frm_lastname" size="30" value="<%$tpl_lastname%>" onKeyPress="submit_onkeypress();"></td>
             </tr>
			 <tr>
			  <td class="DefText">&nbsp;</td>
			  <td align=right>
			  <a href="javascript:document.search.submit();"><img src="<%$wwwroot%>img/button_search.png" width="73" height="24" alt="##SEARCH##" border="0" id="loginfrm"></a>
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

<%if $tpl_isresult eq 'true'%>
<form id="select" name="select" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%$tpl_gast.guestid%>">
<input type="hidden" name="frm_type" id="frm_type" value="<%$tpl_type%>">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
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
               <td class="ListL1Header"><strong>##LASTNAME##</strong></td>
               <td class="ListL1Header"><strong>##FIRSTNAME##</strong></td>
               <td class="ListL1Header"><strong>##COMPANY##</strong></td>
			   <td class="ListL1Header">&nbsp;</td>
             </tr>
             <%section name=res loop=$tpl_result%>
             <tr>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].lastname%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].firstname%>&nbsp;</td>
               <td class="ListL<%$tpl_result[res].color%>"><%$tpl_result[res].company%>&nbsp;</td>
			   <td class="ListL<%$tpl_result[res].color%>">
			   <table border="0" cellspacing="0">
			    <%section name="ad" loop=$tpl_result[res].addresses%>
				<tr>
				 <td><%if $tpl_result[res].addresses[ad].defaultaddress eq "P"%><input type="radio" name="frm_newaddress" id="frm_newaddress" value="P_<%$tpl_result[res].guestid%>"><%elseif $tpl_result[res].addresses[ad].defaultaddress eq 'B'%><input type="radio" name="frm_newaddress" id="frm_newaddress" value="B_<%$tpl_result[res].guestid%>"><%elseif $tpl_result[res].addresses[ad].defaultaddress eq 'O'%><input type="radio" name="frm_newaddress" id="frm_newaddress" value="O_<%$tpl_result[res].guestid%>"><%/if%></td>
				 <td><%$tpl_result[res].addresses[ad].address%>, <%$tpl_result[res].addresses[ad].postalcode%> <%$tpl_result[res].addresses[ad].city%>, <%$tpl_result[res].addresses[ad].country_Name%></td>
				</tr>
				<%/section%>
			   </table>
			   </td>
             </tr>
             <%sectionelse%>
             <tr>
               <td class="DefText" colspan="10">##NO_ENTRYS##</td>
			 </tr>
             <%/section%>
        </table>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
      <td width="100%" align="right"><br/><a href="javascript:document.select.submit();"><img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" border="0" alt="weiter"></a></td>   
	   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>  
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</form>
<%/if%>
<%/if%>
<%include file=footer.tpl%>
<%/strip%>

