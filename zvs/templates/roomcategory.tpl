<%strip%>
<%include file=header.tpl%>
<%/strip%>
<DIV ID="dek"></DIV>
<script language="JavaScript" type="text/javascript">
<!--

//Pop up information box II (Mike McGrath (mike_mcgrath@lineone.net,  http://website.lineone.net/~mike_mcgrath))
//Permission granted to Dynamicdrive.com to include script in archive
//For this and 100's more DHTML scripts, visit http://dynamicdrive.com

Xoffset=  0;    // 60 modify these values to ...
Yoffset= 25;    // 20 change the popup position.

var old,skn,iex=(document.all),yyy=-1000;

var ns4=document.layers
var ns6=document.getElementById&&!document.all
var ie4=document.all

if (ns4)
{
	skn=document.dek
}else if (ns6)
{
	skn=document.getElementById("dek").style
} else if (ie4)
{
	skn=document.all.dek.style
}

if(ns4)
{
	document.captureEvents(Event.MOUSEMOVE);
}else{
	skn.visibility="visible"
	skn.display="none"
}
document.onmousemove=get_mouse;

    function openWindow(url){
    F1 = window.open(url,'articlechooser','width=400,height=300,left=0,top=0');
    F1.focus();
    }
	
	function editcat(id) {
		document.cat.frm_catid.value = id;
		document.cat.frm_action.value = "edit";
		document.cat.submit();	
	}
	
	function delcat(id, name) {
		var check;
		check = confirm("Kategorie \""+ name +"\" wirklich löschen?\n");
		if (check) {
			document.cat.frm_catid.value = id;
			document.cat.frm_action.value = "del";
			document.cat.submit();	
		}
	}	
	
	function savecat(id){
	   document.cat.frm_catid.value=id;	
		document.cat.submit();
	}
	
	function neu(){
		document.cat.frm_catid.value = 0;
		document.cat.frm_action.value = "addnew";
		document.cat.submit();
	}

//-->
</script>
<%strip%>
<table width="750" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Zimmerkategorien verwalten</p>
		<form id="cat" name="cat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_catid" id="frm_catid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<table border="0" cellspacing="0" cellpadding="3" width="750">
		   <%if $tpl_addnew neq 'true'%>
			<tr>
				<td colspan="5">		  		
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		   
		   <%/if%>
			<tr>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Bezeichnung</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Artikel</strong>
		  		</td>	
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Preisschema</strong>
		  		</td>					
				<td colspan=3" class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
					&nbsp;
				</td>
			   </tr>	
		   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL1">
		  			<input type="text" name="frm_cat" id="frm_cat" maxlength="128" size="50">&nbsp;
		  		</td>
				<td class="ListL1">&nbsp;</td>
				<td class="ListL1">
		  			<select name="frm_price_type" id="frm_price_type">
						<option value="N">Pro Person</option>
						<option value="A">gestaffelt</option>
					</select>
					&nbsp;
		  		</td>					
				<td class="ListL1">
					<a href="javascript:savecat(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
				<td class="ListL1" colspan="2">&nbsp;</td>
		   </tr>
		   <%/if%>		   			   
			<%section name=cat loop=$tpl_category%>
			<tr>
				<td class="ListL<%$tpl_category[cat].color%>">
					<%if $tpl_editid eq $tpl_category[cat].catid%>
					  <input type="text" name="frm_cat" id="frm_cat" maxlength="128" size="50" value="<%$tpl_category[cat].name%>">
					<%else%>
					  <%$tpl_category[cat].name%>
					<%/if%>
				</td>
				<td class="ListL<%$tpl_category[cat].color%>"><%$tpl_category[cat].articles%>&nbsp;</td>
				<td class="ListL<%$tpl_category[cat].color%>">
					<%if $tpl_editid eq $tpl_category[cat].catid%>
			  			<select name="frm_price_type" id="frm_price_type">
							<option value="N" <%if $tpl_category[cat].price_type eq 'N'%>selected="selected"<%/if%>>Pro Person</option>
							<option value="A" <%if $tpl_category[cat].price_type eq 'A'%>selected="selected"<%/if%>>gestaffelt</option>
						</select>					
					<%else%>
					  <%if $tpl_category[cat].price_type eq 'N'%>Pro Person<%else%>gestaffelt<%/if%>
					<%/if%>
				</td>		
				<td class="ListL<%$tpl_category[cat].color%>">
				<%if $tpl_editid eq $tpl_category[cat].catid%>
					<a href="javascript:savecat(<%$tpl_category[cat].catid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				<%else%>
					<a href="javascript:editcat(<%$tpl_category[cat].catid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
				<%/if%>
				</td>
				<td class="ListL<%$tpl_category[cat].color%>">
					<%if $tpl_editid neq $tpl_category[cat].catid%>
						<a href="javascript:delcat(<%$tpl_category[cat].catid%>,'<%$tpl_category[cat].name%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
					<%/if%>&nbsp;
				</td>
				<td class="ListL<%$tpl_category[cat].color%>">
					<a href="javascript:openWindow('<%$wwwroot%>articlechooser.php/id.<%$tpl_category[cat].catid%>/type.rcat/articlechooser.php');">Artikelzuordnung &auml;ndern</a>
				</td>
			</tr>
			<%/section%>
		</table>
		</form>
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

