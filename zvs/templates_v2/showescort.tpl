<%strip%>
<%include file=header.tpl%>

<div class="boxdyn">
	<h2><span>##ESCORTS_OF## <%if $tpl_gast.firstname neq ""%> <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></span></h2>
		<br/>
  <div class="table">
    <table boder="0" cellspacing="0" cellpadding="3">
		<tr class="ListHeader">
			<th>##LASTNAME##</th>
			<th>##FIRSTNAME##</th>
		</tr>
     <%section name=escort loop=$tpl_escort%>
    <tr class="ListL<%$tpl_escort[escort].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_escort[escort].color%>'">
     <td><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_escort[escort].guestid%>" class="dotted" title="##SHOW##"><%$tpl_escort[escort].lastname%></a></td>
		 <td><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_escort[escort].guestid%>" class="dotted" title="##SHOW##"><%$tpl_escort[escort].firstname%></a></td>
    </tr>
     <%sectionelse%>
       <tr>
          <td colspan="3">bisher keine Buchungen mit Begleitpersonen</td>
       </tr>
     <%/section%>
     </table>
     </div>
</div>
<%include file=footer.tpl%>
<%/strip%>

