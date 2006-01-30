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
function changecat()
{
	document.pay.frm_changecat.value = "true";
	document.pay.submit();
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
function openSpecial(catid){
    F2 = window.open('<%$wwwroot%>addspecial.php/guestid.<%$tpl_theguestid%>/catid.'+catid+'/addspecial.php','addbarguest','width=400,height=240,left=0,top=0');
    F2.focus();
}
function openedit(guestid){
    F3 = window.open('<%$wwwroot%>editbarguest.php/guestid.'+guestid+'/editbarguest.php','editbarguest','width=400,height=210,left=0,top=0');
    F3.focus();
}
function openbon(){
	F4 = window.open('<%$wwwroot%>selectreceipt.php/guestid.<%$tpl_theguestid%>/cats.<%section name=thecat loop=$tpl_selectedcat%><%$tpl_selectedcat[thecat]%><%if not $smarty.section.thecat.last%>,<%/if%><%/section%>/receipt.php','bon','width=400,height=280,left=0,top=0');
	F4.focus();
}

function printbon(){
  //F8 = window.open('<%$wwwroot%>receipt_html.php/guestid.<%$tpl_theguestid%>/cats.<%section name=thecat loop=$tpl_selectedcat%><%$tpl_selectedcat[thecat]%><%if not $smarty.section.thecat.last%>,<%/if%><%/section%>/receipt_html.php', "Bon", "width=300,height=600,left=100,top=200,toolbar=no,status=no,scrollbars=yes");
  //F8.focus();
  F8 = window.open('', "Bon", "width=300,height=600,left=100,top=200,toolbar=no,status=no,scrollbars=yes");
  var temp = document.pay.action;
  document.pay.action = '<%$wwwroot%>receipt_html.php/guestid.<%$tpl_theguestid%>/cats.<%section name=thecat loop=$tpl_selectedcat%><%$tpl_selectedcat[thecat]%><%if not $smarty.section.thecat.last%>,<%/if%><%/section%>/receipt_html.php';
  document.pay.target = 'Bon';
  document.pay.submit();
  document.pay.target = '_top';
  document.pay.action = temp;
  F8.focus();
}

    function openImport(){
    F5 = window.open('<%$wwwroot%>importuser.php','importuser','width=270,height=190,left=0,top=0');
    F5.focus();
    }

function calculate(){ 
	<%section name=guestarticle loop=$tpl_guestarticles%>	
	<%/section%>
	num = <%$smarty.section.guestarticle.total%>-1;
	id = 'payid';
	total = 'total';
	sum = 0.00;
  for (i=0;i<num;i++) {
     cb = document.getElementById(id+[i+1]);
     if (cb.checked) {
     	fieldtotal = document.getElementById(total+[i+1]);
     	sum += parseFloat(fieldtotal.value);
     }
  }
  document.all.subtotal1.innerHTML = sum.toFixed(2);
  document.all.subtotal2.innerHTML = sum.toFixed(2);
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
			 	<td valign="top" class="NavInactive" colspan="6"><a href="javascript:openWindow();" class="NavInactive">neuer Gast</a><%if $tpl_import%>&nbsp;&nbsp;<a href="javascript:openImport();" class="NavInactive">ZVS Import</a><%/if%></td>
			 </tr>
			   <%section name=guest loop=$tpl_barguests%>
	
				 <%if $tpl_barguests[guest].newline eq 'true'%>		   
			    	<tr>
				 <%/if%>
				 <%if $tpl_barguests[guest].guestid neq '0'%>
  			 	<td class="colorchooser" bgcolor="<%$tpl_barguests[guest].bccolor%>"><img src="<%$wwwroot%>img/spacer.gif" width="10" height="10" border="0" alt="<%$tpl_barguests[guest].bookingcat%>"></td>
			 	<td class="<%if $tpl_barguests[guest].guestid eq $tpl_theguestid%>NavActive<%else%><%if $tpl_barguests[guest].sum eq '0.00'%>zero<%else%>NavInactive<%/if%><%/if%>" nowrap="nowrap" width="250">
					<a href="javascript:openedit(<%$tpl_barguests[guest].guestid%>);"><img src="<%$wwwroot%>img/editnav.png" width="14" height="14" border="0" alt="Bearbeiten"></a>&nbsp;
				  	<a href="<%$wwwroot%><%if $tpl_nav eq "sell"%>index.php<%else%>kassa.php<%/if%>/guestid.<%$tpl_barguests[guest].guestid%>/index.php" class="<%if $tpl_barguests[guest].guestid eq $tpl_theguestid%>NavActive<%else%>NavInactive<%/if%>"><%$tpl_barguests[guest].firstname%>&nbsp;<%$tpl_barguests[guest].lastname%>&nbsp;(<%$tpl_barguests[guest].sum%>&nbsp;EUR)</a>

			   	</td>
				<%else%>
				<td class="NavInactive" colspan="2">&nbsp;</td>
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
		        <table border="0" cellpadding="0" cellspacing="0"><tr><td class="colorchooser" bgcolor="<%$tpl_thebookingcat.color%>"><img src="<%$wwwroot%>img/spacer.gif" width="15" height="10" boder="0" alt="<%$tpl_thebookingcat.name%>"></td><td class="SubheadlineYellow">Verkauf an <%$tpl_theguest%> &nbsp;&nbsp;<a href="javascript:openedit(<%$tpl_theguestid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a></td></tr></table><br>
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
				<table border="0" align="center">
					<tr>
					<%section name=article loop=$tpl_cat[divcat].articles%>
						<%if $tpl_cat[divcat].articles[article].newline eq "true"%>
						</tr><tr>
						<%/if%>			
						<td><button class="BarButton" <%if $tpl_cat[divcat].articles[article].hotkey neq ""%>accesskey="<%$tpl_cat[divcat].articles[article].hotkey%>"<%/if%> <%if $tpl_cat[divcat].articles[article].articleid eq "0"%>onclick="openSpecial(<%$tpl_cat[divcat].articlecatid%>);"<%else%>onfocus="submitform<%$tpl_cat[divcat].articlecatid%>(<%$tpl_cat[divcat].articles[article].articleid%>);"<%/if%>><%$tpl_cat[divcat].articles[article].description%><br><%$tpl_cat[divcat].articles[article].price%><%if $tpl_cat[divcat].articles[article].price neq ""%>&nbsp;EUR<%/if%><br><%if $tpl_cat[divcat].articles[article].hotkey neq ""%>ALT+<%$tpl_cat[divcat].articles[article].hotkey%><%else%>&nbsp;<%/if%></button></td>
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
		        <table border="0" cellpadding="0" cellspacing="0"><tr><td class="colorchooser" bgcolor="<%$tpl_thebookingcat.color%>"><img src="<%$wwwroot%>img/spacer.gif" width="15" height="10" boder="0" alt="<%$tpl_thebookingcat.name%>"></td><td class="SubheadlineYellow">Abrechnung f&uuml;r <%$tpl_theguest%> &nbsp;&nbsp;<a href="javascript:openedit(<%$tpl_theguestid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a></td></tr></table><br>
				<form name="pay" id="pay" action="<%$wwwroot%>index.php/guestid.<%$tpl_theguestid%>/index.php" method="post">
				<input type="hidden" name="frm_checkout" id="frm_checkout" value="false">
				<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%$tpl_theguestid%>">
				<input type="hidden" name="frm_setinactive" id="frm_setinactive" value="false">
				<input type="hidden" name="frm_boughtid" id="frm_boughtid" value="">
				<input type="hidden" name="frm_storno" id="frm_storno" value="false">
				<input type="hidden" name="frm_pay" id="frm_pay" value="false">
				<input type="hidden" name="frm_changecat" id="frm_changecat" value="false">
				<%if $tpl_guestarticles[0].articleid eq "0"%>
				<%section name=cat loop=$tpl_cat%>
				<input type="checkbox" name="frm_selectedcat[]" id="frm_selectedcat[]" value="<%$tpl_cat[cat].articlecatid%>" <%section name=thecat loop=$tpl_selectedcat%><%if $tpl_selectedcat[thecat] eq $tpl_cat[cat].articlecatid%>checked="checked"<%/if%><%/section%> onClick="changecat();"><%$tpl_cat[cat].articlecat%>&nbsp;
				<%/section%>
				<br>					
				Es liegen keine Ums&auml;tze vor!
				<br>
				<%if $tpl_level ge 10%>
				<button onclick="checkout(true);">weg</button>
				<%/if%>
				<%else%>	
				<%section name=cat loop=$tpl_cat%>
				<input type="checkbox" name="frm_selectedcat[]" id="frm_selectedcat[]" value="<%$tpl_cat[cat].articlecatid%>" <%section name=thecat loop=$tpl_selectedcat%><%if $tpl_selectedcat[thecat] eq $tpl_cat[cat].articlecatid%>checked="checked"<%/if%><%/section%> onClick="changecat();"><%$tpl_cat[cat].articlecat%>&nbsp;
				<%/section%>			
				<table border="0" cellpadding="3" cellspacing="0">
				   <tr>
				      <td class="ListL1Header">&nbsp;</td>
				      <td class="ListL1Header"><b>Anzahl</b></td>
				   	  <td class="ListL1Header"><b>Artikel</b></td>
					  <td class="ListL1Header"><b>Datum</b></td>
					  <td class="ListL1Header"><b>Preis</b></td>
					  <td class="ListL1Header"><b>Total</b></td>
					  <td class="ListL1Header" colspan="2">&nbsp;</td>
					  <%if $tpl_level ge 10%>
					  <td class="ListL1Header" colspan="2"><b>Erstellt</b></td>					  
					  <td class="ListL1Header" colspan="2"><b>Letzte &Auml;nderung</b></td>					  
					  <%/if%>
				   </tr>
				  <%section name=guestarticle loop=$tpl_guestarticles%>		
				  <%if $smarty.section.guestarticle.last%>		   
				   <tr>
				   	<td colspan="4" align="right" class="ListL1Footer"><b>Summe:</b></td>
					<td class="ListL1Footer" align="right"><b><span id="subtotal1"><%$tpl_guestarticles[guestarticle].total%></span>&nbsp;EUR</b></td>
					<td class="ListL1Footer" colspan="3">&nbsp;</td>
 				  	<%if $tpl_level ge 10%>
					<td class="ListL1Footer">von</td>
					<td class="ListL1Footer">am</td>
					<td class="ListL1Footer">von</td>
					<td class="ListL1Footer">am</td>
					<%/if%>
				   </tr>	
				  <%/if%>	
				  <%/section%>	
				  <%section name=guestarticle loop=$tpl_guestarticles%>				   
				  <%if $smarty.section.guestarticle.last%>
				   <tr>
				   	<td colspan="4" align="right" class="ListL<%$tpl_guestarticles[guestarticle].color%>Footer"><b>Summe:</b></td>
					<td class="ListL<%$tpl_guestarticles[guestarticle].color%>Footer" align="right"><b><span id="subtotal2"><%$tpl_guestarticles[guestarticle].total%></span>&nbsp;EUR</b></td>
					<td class="ListL<%$tpl_guestarticles[guestarticle].color%>Footer" colspan="3">&nbsp;</td>
					<%if $tpl_level ge 10%>
					<td class="ListL<%$tpl_guestarticles[guestarticle].color%>Footer" colspan="4">&nbsp;</td>
					<%/if%>
				   </tr>		  
				  <%else%>
					<tr>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><input type="checkbox" name="payid[]" id="payid<%$smarty.section.guestarticle.iteration%>" checked="checked" value="<%$tpl_guestarticles[guestarticle].boughtid%>" onclick="calculate(); InitializeTimer();"></td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].num%></td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].description%></td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].timestamp%>&nbsp;Uhr</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>" align="right"><%$tpl_guestarticles[guestarticle].price%>&nbsp;EUR</td>			  
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>" align="right"><input type="hidden" name="total<%$smarty.section.guestarticle.iteration%>" id="total<%$smarty.section.guestarticle.iteration%>" value="<%$tpl_guestarticles[guestarticle].total%>"><%$tpl_guestarticles[guestarticle].total%>&nbsp;EUR</td>	
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><a href="javascript:pay(<%$tpl_guestarticles[guestarticle].boughtid%>, <%$tpl_guestarticles[guestarticle].num%>, '<%$tpl_guestarticles[guestarticle].description%>')"><img src="<%$wwwroot%>img/icon_ok.gif" border="0" width="15" height="13" alt="bezahlt"></a></td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%if $tpl_level ge 10%><a href="javascript:storno(<%$tpl_guestarticles[guestarticle].boughtid%>, <%$tpl_guestarticles[guestarticle].num%>, '<%$tpl_guestarticles[guestarticle].description%>');"><img src="<%$wwwroot%>img/shutter_minus.gif" border="0" width="13" height="13" alt="Storno"></a><%/if%>&nbsp;</td>		  
					  <%if $tpl_level ge 10%>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].inserted%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%if $tpl_guestarticles[guestarticle].inserteddate neq ""%><%$tpl_guestarticles[guestarticle].inserteddate%>&nbsp;Uhr<%/if%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%$tpl_guestarticles[guestarticle].updated%>&nbsp;</td>
					  <td class="ListL<%$tpl_guestarticles[guestarticle].color%>"><%if $tpl_guestarticles[guestarticle].updateddate neq ""%><%$tpl_guestarticles[guestarticle].updateddate%>&nbsp;Uhr<%/if%>&nbsp;</td>
					  <%/if%>
					</tr>
				  <%/if%>
				  <%/section%>
				</table>
				<br>
				<button onclick="checkout(false);">bezahlt</button>&nbsp;<%if $tpl_level ge 10%><button onclick="checkout(true);">bezahlt und weg</button>&nbsp;<%/if%><%if $tpl_level ge 10%><button onclick="printbon();">Bon drucken</button>&nbsp;<button onclick="window.open('<%$wwwroot%>receipt.php/guestid.<%$tpl_theguestid%>/cats.<%section name=thecat loop=$tpl_selectedcat%><%$tpl_selectedcat[thecat]%><%if not $smarty.section.thecat.last%>,<%/if%><%/section%>/receipt.php')">Bon</button>&nbsp;<%/if%><%if $tpl_level ge 10%><button onclick="openbon();">Bon &uuml;ber Zeitraum</button><%/if%>
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
