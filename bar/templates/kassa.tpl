<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
function checkout(setinactive)
{
	document.pay.frm_checkout.value = "true";
	document.pay.frm_setinactive.value = setinactive;
	document.pay.submit();
}
//-->
</script>
<%strip%>
<table border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td>
	<%if $tpl_theguestid eq "-1"%>
		<p class="SubheadlineYellow">Bitte einen Gast ausw&auml;hlen!</p>
	<%else%>
        <p class="SubheadlineYellow">Abrechnung f&uuml;r <%$tpl_theguest%></p>
		<%if $tpl_articles[0].articleid eq "0"%>
		Es liegen keine Ums&auml;tze vor!
		<%else%>
		<form name="pay" id="pay" action="<%$wwwroot%>kassa.php/guestid.<%$tpl_theguestid%>/index.php" method="post">
		<input type="hidden" name="frm_checkout" id="frm_checkout" value="false">
		<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%$tpl_theguestid%>">
		<input type="hidden" name="frm_setinactive" id="frm_setinactive" value="false">
		<table border="0" cellpadding="3" cellspacing="0">
		   <tr>
		      <td class="ListL1Header"><b>Anzahl</b></td>
		   	  <td class="ListL1Header"><b>Artikel</b></td>
			  <td class="ListL1Header"><b>Datum</b></td>
			  <td class="ListL1Header"><b>Preis</b></td>
			  <td class="ListL1Header"><b>Total</b></td>
		   </tr>
		  <%section name=article loop=$tpl_articles%>
		  <%if $smarty.section.article.last%>
		   <tr>
		   	<td colspan="4" align="right" class="ListL<%$tpl_articles[article].color%>Footer"><b>Summe:</b></td>
			<td class="ListL<%$tpl_articles[article].color%>Footer"><b><%$tpl_articles[article].total%>&nbsp;EUR</b></td>
		   </tr>		  
		  <%else%>
			<tr>
			  <td class="ListL<%$tpl_articles[article].color%>"><%$tpl_articles[article].num%></td>
			  <td class="ListL<%$tpl_articles[article].color%>"><%$tpl_articles[article].description%></td>
			  <td class="ListL<%$tpl_articles[article].color%>"><%$tpl_articles[article].timestamp%></td>
			  <td class="ListL<%$tpl_articles[article].color%>" align="right"><%$tpl_articles[article].price%>&nbsp;EUR</td>			  
			  <td class="ListL<%$tpl_articles[article].color%>" align="right"><%$tpl_articles[article].total%>&nbsp;EUR</td>			  
			</tr>
		  <%/if%>
		  <%/section%>
		</table>
		<button onclick="checkout(false);">bezahlt</button>&nbsp;<button onclick="checkout(true);">bezahlt und weg</button>
		</form>
		<%/if%>
	<%/if%>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>

<%include file=footer.tpl%>
<%/strip%>
