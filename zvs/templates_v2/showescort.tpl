<%strip%>
<%include file=header.tpl%>
  <h1>##ESCORTS_OF## <%if $tpl_gast.firstname neq ""%> <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></h1>
  <table class="list">
     <colgroup>
        <col width="200">
        <col width="200">
     </colgroup>  
	 <tr class="ListHeader">
			<th>##LASTNAME##</th>
			<th>##FIRSTNAME##</th>
		</tr>
     <%section name=escort loop=$tpl_escort%>
    <tr class="ListL<%$tpl_escort[escort].color%>" onmouseover="this.className='ListHighlight'" onmouseout="this.className='ListL<%$tpl_escort[escort].color%>'" onclick="window.location.href('<%$wwwroot%>guestdetail.php/guestid.<%$tpl_escort[escort].guestid%>')">
     <td><a href="<%$wwwroot%>guestdetail.php/guestid.<%$tpl_escort[escort].guestid%>" class="dotted" title="##SHOW##"><%$tpl_escort[escort].lastname%></a></td>
		 <td><a href="<%$wwwroot%>guestdetail.php/guestid.<%$tpl_escort[escort].guestid%>" class="dotted" title="##SHOW##"><%$tpl_escort[escort].firstname%></a></td>
    </tr>
     <%sectionelse%>
       <tr class="ListL0" onmouseover="this.className='ListHighlight'" onmouseout="this.className='ListL0'">
          <td colspan="2">bisher keine Buchungen mit Begleitpersonen</td>
       </tr>
     <%/section%>
  </table>
<%include file=footer.tpl%>
<%/strip%>

