<%strip%>
<%include file=header.tpl%>
<form accept-charset="utf-8" id="search" name="search" action="<%$SCRIPT_NAME%>" method="post">


<div class="boxdyn">
<h2><span>##SEARCH_GUEST##</span></h2>
&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="<%$wwwroot%>editgast.php" class="dotted">##ADD_NEW_GUEST##</a></div>
<div class="table">	
  	<label for="frm_lastname">##LASTNAME##</label>
		<input name="frm_lastname" type="text" id="frm_lastname" value="<%$tpl_lastname%>" class="textlong" autocomplete="off" tabindex="1"/><br/>
		<div id="search-results" name="search-results"></div> 
	<label for="frm_firstname">##FIRSTNAME##</label><input name="frm_firstname" type="text" id="frm_firstname"  value="<%$tpl_firstname%>" class="textlong" autocomplete="off" tabindex="2"/><br/> 
	<p class="rightlong"><input type="submit" value="##SEARCH## &raquo;" class="right"/></p>
 	<%$tpl_widgets%>
	<%$tpl_loadapp%>
	<%if $tpl_isresult eq 'true'%>
    <p><%$tpl_numresult%>&nbsp;<%if $tpl_numresult eq 1%>Eintrag<%else%>Eintr&auml;ge<%/if%>&nbsp;gefunden</p>
   		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr class="ListHeader">
               <th>##LASTNAME##</th>
               <th>##FIRSTNAME##</th>
               <th>##GENDER##</th>
               <th>##COMPANY##</th>
               <th>##ADRESS##</th>
               <th>##POSTAL_CODE_SHORT##</th>
               <th>##CITY##</th>
               <th>##COUNTRY##</th>
               <th>##LAST1##<br>##BOOKING##</th>
               <th>##LAST2##<br>##STAY##</th>
               <th>&nbsp;</td>
							 <th>&nbsp;</th>
             </tr>
             <%section name=res loop=$tpl_result%>
             <tr class="ListL<%$tpl_result[res].color%>"  onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_result[res].color%>'">
               <td><%$tpl_result[res].lastname%>&nbsp;</td>
               <td><%$tpl_result[res].firstname%>&nbsp;</td>
               <td><%$tpl_result[res].gender%>&nbsp;</td>
               <td><%$tpl_result[res].company%>&nbsp;</td>
               <td><%$tpl_result[res].address%>&nbsp;</td>
               <td><%$tpl_result[res].postalcode%>&nbsp;</td>
               <td><%$tpl_result[res].city%>&nbsp;</td>
               <td><%$tpl_result[res].country_name%>&nbsp;</td>
               <td><%$tpl_result[res].last_booking%>&nbsp;</td>
               <td><%$tpl_result[res].last_stay%>&nbsp;</td>
							 <td><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_result[res].guestid%>" class="dotted">##SHOW##</a>&nbsp;&raquo;</td>
               <td><a href="<%$wwwroot%>editgast.php/guestid.<%$tpl_result[res].guestid%>" class="dotted">##EDIT##</a>&nbsp;&raquo;</td>
             </tr>
             <%sectionelse%>
             <tr>
               <td class="DefText" colspan="4">##NO_ENTRYS##</td>
             </tr>
             <%/section%>

        </table>
		<%/if%>
		</div>
</div>
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

