<%strip%>
<%include file=header.tpl%>
<form id="search" name="search" action="<%$SCRIPT_NAME%>" method="post">


<fieldset class="w750">
	<legend>##SEARCH_GUEST##</legend>
  	<label for="frm_lastname">##LASTNAME##</label>
		<input name="frm_lastname" type="text" id="frm_lastname" value="<%$tpl_lastname%>" class="textlong" autocomplete="off" tabindex="1"/><br/>
		<div id="search-results" name="search-results"></div> 
	<label for="frm_firstname">##FIRSTNAME##</label><input name="frm_firstname" type="text" id="frm_firstname"  value="<%$tpl_firstname%>" class="textlong" autocomplete="off" tabindex="2"/><br/> 
	<p class="rightlong"><input type="submit" value="##SEARCH## &raquo;" class="right"></p>
	<%$tpl_widgets%>
	<%$tpl_loadapp%>
	<%if $tpl_isresult eq 'true'%>
    <p class="SubheadlineYellow"><%$tpl_numresult%>&nbsp;<%if $tpl_numresult eq 1%>Eintrag<%else%>Eintr&auml;ge<%/if%>&nbsp;gefunden</p>
   		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td class="ListL1Header">&nbsp;</td>
               <td class="ListL1Header"><strong>##LASTNAME##</strong></td>
               <td class="ListL1Header"><strong>##FIRSTNAME##</strong></td>
               <td class="ListL1Header"><strong>##GENDER##</strong></td>
               <td class="ListL1Header"><strong>##COMPANY##</strong></td>
               <td class="ListL1Header"><strong>##ADRESS##</strong></td>
               <td class="ListL1Header"><strong>##POSTAL_CODE_SHORT##</strong></td>
               <td class="ListL1Header"><strong>##CITY##</strong></td>
               <td class="ListL1Header"><strong>##COUNTRY##</strong></td>
               <td class="ListL1Header"><strong>##LAST1##<br>##BOOKING##</strong></td>
               <td class="ListL1Header"><strong>##LAST2##<br>##STAY##</strong></td>
               <td class="ListL1Header">&nbsp;</td>
             </tr>
             <%section name=res loop=$tpl_result%>
             <tr>
               <td class="ListL<%$tpl_result[res].color%>"><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_result[res].guestid%>"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="##SHOW##"></a></td>
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
               <td class="ListL<%$tpl_result[res].color%>"><a href="<%$wwwroot%>editgast.php/guestid.<%$tpl_result[res].guestid%>"><img src="<%$wwwroot%>img/icon_antwort.gif" width="19" height="16" border="0" alt="##EDIT##"></a></td>
             </tr>
             <%sectionelse%>
             <tr>
               <td class="DefText" colspan="4">##NO_ENTRYS##</td>
             <%/section%>

        </table>
		<%/if%>
</fieldset>
</form>
<br/>
<fieldset class="w750">
	<legend>##ADD_NEW_GUEST##</legend>
	<p>
	<a href="<%$wwwroot%>editgast.php"><span class="button">##ADD_NEW_GUEST##</span></a>
	</p>
</fieldset>
<%/strip%>
<script language="javascript"  type="text/javascript">
<!--
  // Activate the appropriate input form field.
  var firstname = document.search.frm_firstname;
  var lastname = document.search.frm_lastname;
  if (lastname.value == '') {
    lastname.focus();
  } else {
    firstname.focus();
  }
// -->
</script>
<%strip%>
<%include file=footer.tpl%>
<%/strip%>

