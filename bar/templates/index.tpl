<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
<%section name=divcat loop=$tpl_cat%>
function submitform<%$tpl_cat[divcat].articlecatid%>(id)
{
	document.order<%$tpl_cat[divcat].articlecatid%>.frm_articleid.value = id;
	document.order<%$tpl_cat[divcat].articlecatid%>.submit();
}


function addNumber<%$tpl_cat[divcat].articlecatid%>(number){
	if (num_clear) {
		document.order<%$tpl_cat[divcat].articlecatid%>.frm_num.value = number;
	} else {
		document.order<%$tpl_cat[divcat].articlecatid%>.frm_num.value = document.order<%$tpl_cat[divcat].articlecatid%>.frm_num.value + number;	
	}
	num_InitializeTimer();
	InitializeTimer();
}



function resetNumber<%$tpl_cat[divcat].articlecatid%>(){
	document.order<%$tpl_cat[divcat].articlecatid%>.frm_num.value = "";
}

<%/section%>

function storno(id, num, desc)
{
	if (confirm("Wirklich \""+num + "x "+desc+"\" stornieren?") )
	{
		document.pay.frm_boughtid.value = id;
		document.pay.frm_storno.value = "true";
		document.pay.submit();
	}
}
function pay(id, num, desc)
{
	if (confirm("Wirklich \""+num + "x "+desc+"\" als bezahlt markieren?") )
	{
		document.pay.frm_boughtid.value = id;
		document.pay.frm_pay.value = "true";
		document.pay.submit();
	}
}
function checkout(setinactive)
{
	var message;
	message = "Wirklich ausgewählte Artikel als bezahlt markieren ";
	if (setinactive == true) {
		message += "und auschecken";
	}
	message += "?";
	if (confirm(message))
	{
		document.pay.frm_checkout.value = "true";
		document.pay.frm_setinactive.value = setinactive;
		document.pay.submit();
	}
}
function openSpecial(){
    F2 = window.open('<%$wwwroot%>addspecial.php/guestid.<%$tpl_theguestid%>/addspecial.php','addbarguest','width=400,height=240,left=0,top=0');
    F2.focus();
}
function openedit(guestid){
    F3 = window.open('<%$wwwroot%>editbarguest.php/guestid.'+guestid+'/editbarguest.php','editbarguest','width=400,height=210,left=0,top=0');
    F3.focus();
}
function openbon(){
	F4 = window.open('<%$wwwroot%>selectreceipt.php/guestid.<%$tpl_theguestid%>/receipt.php','bon','width=400,height=280,left=0,top=0');
	F4.focus();
}



var isIE, isDOM;
isIE = (document.all ? true : false);
isDOM = (document.getElementById ? true : false);


function switchLayer(layername)
{

	if (isIE)
	{
		element0 = document.all.list;
		<%section name=cat loop=$tpl_cat%>
	    element<%$smarty.section.cat.rownum%> = document.all.verkauf<%$tpl_cat[cat].articlecatid%>;
		<%/section%>
		element<%$tpl_nextnum%>  = document.all.abrechnung;
		myelement = eval('document.all.'+layername);
	} else {
		element0 = document.getElementById("list");		
		<%section name=cat loop=$tpl_cat%>
		element<%$smarty.section.cat.rownum%> = document.getElementById("verkauf<%$tpl_cat[cat].articlecatid%>");
		<%/section%>
		element<%$tpl_nextnum%> = document.getElementById("abrechnung");
		myelement = document.getElementById(layername);
	}	

	element0.style.display = 'none';
	<%section name=cat loop=$tpl_cat%>
	element<%$smarty.section.cat.rownum%>.style.display = 'none';
	<%/section%>
	element<%$tpl_nextnum%>.style.display = 'none';
	myelement.style.display = '';
}
//-->
</script>
<%strip%>
<table width="98%" border="0" cellspacing="2" cellpadding="0" align="center">
<tr>
	<td valign="top">
	
<img id="placeholder" name="placeholder" src="<%$wwwroot%>img/spacer.gif" width="1" height="1">
<div id="list" name="list" style="visibility:visible">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
		 <tr>
		   <td class="White">&nbsp;</td>
		   <td align="right" class="White">
		       <table border="0" cellspacing="0" cellpadding="0">
		         <tr>
		           <td class="NavActive"><a href="javascript:switchLayer('list');" class="NavActive">Gastliste</a></td>
				   <%section name=cat loop=$tpl_cat%>
		           <td class="NavInactive"><a href="javascript:switchLayer('verkauf<%$tpl_cat[cat].articlecatid%>');InitializeTimer();" class="NavInactive"><%$tpl_cat[cat].articlecat%></a></td>
				   <%/section%>
		           <td class="NavInactive"><a href="javascript:switchLayer('abrechnung');InitializeTimer();" class="NavInactive">Abrechnung</a></td>
		   	 	 </tr>
		       </table>
	   		</td>
			<td class="White">&nbsp;</td>
  		  </tr>
		  <tr>
		    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
		    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
		  </tr>
		  <tr>
		    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td width="100%">	
			<p class="SubheadlineYellow">Gastliste</p>	
           <table border="0" cellspacing="0" cellpadding="0" valign="top" width="500" align="center">
             <tr>
			 	<td valign="top" class="NavInactive" colspan="3"><a href="javascript:openWindow();" class="NavInactive">neuer Gast</a></td>
			 </tr>
			   <%section name=guest loop=$tpl_barguests%>
	
				 <%if $tpl_barguests[guest].newline eq 'true'%>		   
			    	<tr>
				 <%/if%>
				 <%if $tpl_barguests[guest].guestid neq '0'%>
			 	<td class="<%if $tpl_barguests[guest].guestid eq $tpl_theguestid%>NavActive<%else%>NavInactive<%/if%>" nowrap="nowrap" width="250">
					<a href="javascript:openedit(<%$tpl_barguests[guest].guestid%>);"><img src="<%$wwwroot%>img/editnav.png" width="14" height="14" border="0" alt="Bearbeiten"></a>&nbsp;
				  	<a href="<%$wwwroot%><%if $tpl_nav eq "sell"%>index.php<%else%>kassa.php<%/if%>/guestid.<%$tpl_barguests[guest].guestid%>/index.php" class="<%if $tpl_barguests[guest].guestid eq $tpl_theguestid%>NavActive<%else%>NavInactive<%/if%>"><%$tpl_barguests[guest].firstname%>&nbsp;<%$tpl_barguests[guest].lastname%>&nbsp;(<%$tpl_barguests[guest].sum%>&nbsp;EUR)</a>

			   	</td>
				<%else%>
				<td class="NavInactive">&nbsp;</td>
				<%/if%>
				<%if $tpl_barguests[guest].endline eq 'true'%>		   
			    	</tr>
				 <%/if%>
			
								
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
</div>
 <%section name=divcat loop=$tpl_cat%>
<div id="verkauf<%$tpl_cat[divcat].articlecatid%>" name="verkauf<%$tpl_cat[divcat].articlecatid%>" style="visibility:visible">	

		<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
		 <tr>
		   <td class="White">&nbsp;</td>
		   <td align="right" class="White">
		       <table border="0" cellspacing="0" cellpadding="0">
		         <tr>
		           <td class="NavInactive"><a href="javascript:switchLayer('list');" class="NavInactive">Gastliste</a></td>
		           <%section name=cat loop=$tpl_cat%>
		           <td class="<%if $tpl_cat[divcat].articlecatid eq $tpl_cat[cat].articlecatid%>NavActive<%else%>NavInactive<%/if%>"><a href="javascript:switchLayer('verkauf<%$tpl_cat[cat].articlecatid%>');InitializeTimer();" class="<%if $tpl_cat[divcat].articlecatid eq $tpl_cat[cat].articlecatid%>NavActive<%else%>NavInactive<%/if%>"><%$tpl_cat[cat].articlecat%></a></td>
				   <%/section%>
		           <td class="NavInactive"><a href="javascript:switchLayer('abrechnung');InitializeTimer();" class="NavInactive">Abrechnung</a></td>
		   	 	 </tr>
		       </table>
	   		</td>
			<td class="White">&nbsp;</td>
  		  </tr>
		  <tr>
		    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
		    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
		  </tr>
		  <tr>
		    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td width="100%">
		<%if $tpl_theguestid neq "-1"%>	
		        <p class="SubheadlineYellow">Verkauf an <%$tpl_theguest%> &nbsp;&nbsp;<a href="javascript:openedit(<%$tpl_theguestid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a></p>
  					<%if $tpl_showlast eq "true"%>
					<%$tpl_guestarticles[0].timestamp%>&nbsp;Uhr:&nbsp;
					<b><%$tpl_guestarticles[0].num%>x</b>&nbsp;
					<b><%$tpl_guestarticles[0].description%></b> &nbsp;
					(<%$tpl_guestarticles[0].price%>&nbsp;EUR /&nbsp;
					<b><%$tpl_guestarticles[0].total%>&nbsp;EUR</b>)	
					<%/if%>				
				<form name="order<%$tpl_cat[divcat].articlecatid%>" id="order<%$tpl_cat[divcat].articlecatid%>" action="<%$wwwroot%>index.php/guestid.<%$tpl_theguestid%>/index.php" method="post">
				<input type="hidden" name="frm_articleid" id="frm_articleid" value="">
				<input type="hidden" name="frm_action" id="frm_action" value="">
				<input type="hidden" name="frm_cat" id="frm_cat" value="<%$tpl_cat[divcat].articlecatid%>">
				Anzahl: <input type="text" name="frm_num" id="frm_num" value="1" size="3" maxlength="3">&nbsp;&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(1);">1</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(2);">2</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(3);">3</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(4);">4</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(5);">5</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(6);">6</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(7);">7</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(8);">8</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(9);">9</button>&nbsp;
				<button class="CalcButton" onClick="addNumber<%$tpl_cat[divcat].articlecatid%>(0);">0</button>&nbsp;
				<button class="CalcButton" onClick="resetNumber<%$tpl_cat[divcat].articlecatid%>();">L</button>&nbsp;
				<table border="0">
					<tr>
					<%section name=article loop=$tpl_cat[divcat].articles%>
						<%if $tpl_cat[divcat].articles[article].newline eq "true"%>
						</tr><tr>
						<%/if%>			
						<td><button class="BarButton" <%if $tpl_cat[divcat].articles[article].hotkey neq ""%>accesskey="<%$tpl_cat[divcat].articles[article].hotkey%>"<%/if%> <%if $tpl_cat[divcat].articles[article].articleid eq "0"%>onclick="openSpecial();"<%else%>onfocus="submitform<%$tpl_cat[divcat].articlecatid%>(<%$tpl_cat[divcat].articles[article].articleid%>);"<%/if%>><%$tpl_cat[divcat].articles[article].description%><br><%$tpl_cat[divcat].articles[article].price%><%if $tpl_cat[divcat].articles[article].price neq ""%>&nbsp;EUR<%/if%><br><%if $tpl_cat[divcat].articles[article].hotkey neq ""%>ALT+<%$tpl_cat[divcat].articles[article].hotkey%><%else%>&nbsp;<%/if%></button></td>
					<%/section%>
					</tr>
				</table>
				</form>
			<%else%>
			<p class="SubheadlineYellow">Bitte einen Gast ausw&auml;hlen!</p>
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
	</div>
<%/section%>
	<div id="abrechnung" name="abrechnung" style="visibility:visible">
		<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
		 <tr>
		   <td class="White">&nbsp;</td>
		   <td align="right" class="White">
		       <table border="0" cellspacing="0" cellpadding="0">
		         <tr>
		           <td class="NavInactive"><a href="javascript:switchLayer('list');" class="NavInactive">Gastliste</a></td>
		           <%section name=cat loop=$tpl_cat%>
		           <td class="NavInactive"><a href="javascript:switchLayer('verkauf<%$tpl_cat[cat].articlecatid%>');InitializeTimer();" class="NavInactive"><%$tpl_cat[cat].articlecat%></a></td>
				   <%/section%>
		           <td class="NavActive"><a href="javascript:switchLayer('abrechnung');InitializeTimer();" class="NavActive">Abrechnung</a></td>
		   	 	 </tr>
		       </table>
	   		</td>
			<td class="White">&nbsp;</td>
  		  </tr>		
		  <tr>
		    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
		    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
		  </tr>
		  <tr>
		    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td width="100%">
			<%if $tpl_theguestid eq "-1"%>
				<p class="SubheadlineYellow">Bitte einen Gast ausw&auml;hlen!</p>
			<%else%>
		        <p class="SubheadlineYellow">Abrechnung f&uuml;r <%$tpl_theguest%> &nbsp;&nbsp;<a href="javascript:openedit(<%$tpl_theguestid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a></p>
				<form name="pay" id="pay" action="<%$wwwroot%>index.php/guestid.<%$tpl_theguestid%>/index.php" method="post">
				<input type="hidden" name="frm_checkout" id="frm_checkout" value="false">
				<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%$tpl_theguestid%>">
				<input type="hidden" name="frm_setinactive" id="frm_setinactive" value="false">
				<input type="hidden" name="frm_boughtid" id="frm_boughtid" value="">
				<input type="hidden" name="frm_storno" id="frm_storno" value="false">
				<input type="hidden" name="frm_pay" id="frm_pay" value="false">
				<%if $tpl_guestarticles[0].articleid eq "0"%>
				Es liegen keine Ums&auml;tze vor!
				<br>
				<%if $tpl_level ge 10%>
				<button onclick="checkout(true);">weg</button>
				<%/if%>
				<%else%>				
				<table border="0" cellpadding="3" cellspacing="0">
				   <tr>
				      <td class="ListL1Header">&nbsp;</td>
				      <td class="ListL1Header"><b>Anzahl</b></td>
				   	  <td class="ListL1Header"><b>Artikel</b></td>
					  <td class="ListL1Header"><b>Datum</b></td>
					  <td class="ListL1Header"><b>Preis</b></td>
					  <td class="ListL1Header"><b>Total</b></td>
					  <td class="ListL1Header" colspan="2">&nbsp;</td>
				   </tr>
				  <%section name=guestarticle loop=$tpl_guestarticles%>		
				  <%if $smarty.section.guestarticle.last%>		   
				   <tr>
				   	<td colspan="4" align="right" class="ListL1Footer"><b>Summe:</b></td>
					<td class="ListL1Footer" align="right"><b><%$tpl_guestarticles[guestarticle].total%>&nbsp;EUR</b></td>
					<td class="ListL1Footer" colspan="3">&nbsp;</td>
				   </tr>	
				  <%/if%>	
				  <%/section%>	
				  <%section name=guestarticle loop=$tpl_guestarticles%>				   
				  <%if $smarty.section.guestarticle.last%>
				   <tr>
				   	<td colspan="4" align="right" class="ListL<%$tpl_guestarticles[guestarticle].color%>Footer"><b>Summe:</b></td>
					<td class="ListL<%$tpl_guestarticles[guestarticle].color%>Footer" align="right"><b><%$tpl_guestarticles[guestarticle].total%>&nbsp;EUR</b></td>
					<td class="ListL<%$tpl_guestarticles[guestarticle].color%>Footer" colspan="3">&nbsp;</td>
				   </tr>		  
				  <%else%>
					<tr>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><input type="checkbox" name="payid[]" id="payid[]" checked="checked" value="<%$tpl_guestarticles[guestarticle].boughtid%>" onclick="InitializeTimer();"></td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].num%></td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].description%></td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].timestamp%>&nbsp;Uhr</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>" align="right"><%$tpl_guestarticles[guestarticle].price%>&nbsp;EUR</td>			  
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>" align="right"><%$tpl_guestarticles[guestarticle].total%>&nbsp;EUR</td>	
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><a href="javascript:pay(<%$tpl_guestarticles[guestarticle].boughtid%>, <%$tpl_guestarticles[guestarticle].num%>, '<%$tpl_guestarticles[guestarticle].description%>')"><img src="<%$wwwroot%>img/icon_ok.gif" border="0" width="15" height="13" alt="bezahlt"></a></td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%if $tpl_level ge 10%><a href="javascript:storno(<%$tpl_guestarticles[guestarticle].boughtid%>, <%$tpl_guestarticles[guestarticle].num%>, '<%$tpl_guestarticles[guestarticle].description%>');"><img src="<%$wwwroot%>img/shutter_minus.gif" border="0" width="13" height="13" alt="Storno"></a><%/if%>&nbsp;</td>		  
					</tr>
				  <%/if%>
				  <%/section%>
				</table>
				<br>
				<button onclick="checkout(false);">bezahlt</button>&nbsp;<%if $tpl_level ge 10%><button onclick="checkout(true);">bezahlt und weg</button>&nbsp;<%/if%><%if $tpl_level ge 10%><button onclick="window.open('<%$wwwroot%>receipt.php/guestid.<%$tpl_theguestid%>/receipt.php')">Bon</button>&nbsp;<%/if%><%if $tpl_level ge 10%><button onclick="openbon();">Bon &uuml;ber Zeitraum</button><%/if%>
				<%/if%>
				</form>
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
	</div>		
	</td>	
</tr>
</table>
<%/strip%>
<script language="JavaScript">
<%if $tpl_theguestid neq "-1"%>switchLayer('<%$tpl_thecat%>');<%else%>switchLayer('list');<%/if%>
<%strip%>
</script>
<%include file=footer.tpl%>
<%/strip%>
