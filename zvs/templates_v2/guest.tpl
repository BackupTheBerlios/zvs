<%strip%>
<%include file=header.tpl%>
<form accept-charset="utf-8" id="search" name="search" action="<%$SCRIPT_NAME%>" method="post">
<h1>##SEARCH_GUEST##</h1>
<div class="toolbar"><a href="<%$wwwroot%>guestdetail.php/edit.true/guestdetail.php" class="toolbar">##ADD_NEW_GUEST##</a></div>
<div class="searchbox">	
  	<label for="frm_lastname">##LASTNAME##</label>
	<input name="frm_lastname" type="text" id="frm_lastname" value="<%$tpl_lastname%>" class="text" autocomplete="off" tabindex="1"/>
	<br/>
	<div id="search-results" name="search-results"></div>
	<label for="frm_firstname">##FIRSTNAME##</label>
	<input name="frm_firstname" type="text" id="frm_firstname"  value="<%$tpl_firstname%>" class="text" autocomplete="off" tabindex="2"/>
	<br/>

	<label for="submitbutton1"></label>
	<input type="submit" name="submitbutton1" id="submitbutton1" value="##SEARCH## &raquo;" class="button_right" onmouseover="document.search.submitbutton1.className='button_right_hover'" onmouseout="document.search.submitbutton1.className='button_right'"/></p>
</div>	<script language="javascript" type="text/javascript">autocomplete_guestsearch_lastname(); autocomplete_guestsearch_firstname();</script> 
	<%if $tpl_isresult eq 'true'%>
    <p><%$tpl_numresult%>&nbsp;<%if $tpl_numresult eq 1%>Eintrag<%else%>Eintr&auml;ge<%/if%>&nbsp;gefunden</p>
   		<table class="list">
             <tr class="ListHeader">
               <th>##LASTNAME##</th>
               <th>##FIRSTNAME##</th>
               <th>##GENDER##</th>
               <th>##ADRESS##</th>
               <th>##POSTAL_CODE_SHORT##</th>
               <th>##CITY##</th>
               <th>##COUNTRY##</th>
               <th>##LAST1##<br/>##BOOKING##</th>
               <th>##LAST2##<br/>##STAY##</th>
               <th>&nbsp;</th>
             </tr>
             <%section name=res loop=$tpl_result%>
             <tr class="ListL<%$tpl_result[res].color%>"  onmouseover="this.className='ListHighlight'" onmouseout="this.className='ListL<%$tpl_result[res].color%>'" onclick="window.location.href='<%$wwwroot%>guestdetail.php/guestid.<%$tpl_result[res].guestid%>/guestdetail.php';">
               <td><%$tpl_result[res].lastname%>&nbsp;</td>
               <td><%$tpl_result[res].firstname%>&nbsp;</td>
               <td><%$tpl_result[res].gender%>&nbsp;</td>
               <td><%$tpl_result[res].address%>&nbsp;</td>
               <td><%$tpl_result[res].postalcode%>&nbsp;</td>
               <td><%$tpl_result[res].city%>&nbsp;</td>
               <td><%$tpl_result[res].country_name%>&nbsp;</td>
               <td><%$tpl_result[res].last_booking%>&nbsp;</td>
               <td><%$tpl_result[res].last_stay%>&nbsp;</td>
				<td><a href="<%$wwwroot%>guestdetail.php/guestid.<%$tpl_result[res].guestid%>/guestdetail.php" class="dotted">##SHOW##</a>&nbsp;&raquo;</td>
             </tr>
             <%sectionelse%>
             <tr>
               <td class="DefText" colspan="11">##NO_ENTRYS##</td>
             </tr>
             <%/section%>
        </table>
		<%/if%>	
</form>
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

