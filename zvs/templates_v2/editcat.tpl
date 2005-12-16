<%strip%>
<%include file=header.tpl%>

<DIV ID="dek"></DIV>
<div class="boxdyn">
	<h2><span>##CATEGORIES## <%if $tpl_gast.lastname neq ""%>##FROM## <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></span></h2>
 <div class="table">  
<%/strip%>

<script type="text/javascript" language="Javascript">
<!--
function add(catid)
{
  document.save.frm_changeAction.value='add';
  document.save.frm_catid.value = catid;
  document.save.submit();
}

function del(catid)
{
  document.save.frm_changeAction.value='del';
  document.save.frm_catid.value = catid;
  document.save.submit();
}

function save()
{
  document.save.frm_changeAction.value='save';
  document.save.submit();
}

	var offsetxpoint=-60; //Customize x offset of tooltip
	var offsetypoint=20; //Customize y offset of tooltip
	var ie=document.all;
	var ns6=document.getElementById && !document.all;
	var enabletip=false;
	if (ie||ns6)
	var tipobj=document.all? document.all["dek"] : document.getElementById? document.getElementById("dek") : "";
	
	document.onmousemove=positiontip;


//-->
</script>
<%strip%>
<form id="save" name="save" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_gastid" id="frm_gastid" value="<%if $tpl_gast.guestid neq ""%><%$tpl_gast.guestid%><%else%>0<%/if%>"/>
<input type="hidden" name="frm_changeAction" id="frm_changeAction" value=""/>
<input type="hidden" name="frm_catid" id="frm_catid" value=""/>
			<table boder="0" cellspacing="0" cellpadding="3">
			<colgroup>
      	<col width="15">
      	<col width="200">
      	<col width="100">
     	</colgroup>					
              <%section name=cat loop=$tpl_category%>
               <tr class="ListL<%$tpl_category[cat].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_category[cat].color%>'" onClick="<%if $tpl_category[cat].subscribed eq "yes"%>del(<%$tpl_category[cat].catid%>);<%else%>add(<%$tpl_category[cat].catid%>);<%/if%>">
                 <td><%if $tpl_category[cat].subscribed eq "yes"%><img src="<%$wwwroot%>img/icon_ok.gif" border="0" width="15" height="13"><%else%>&nbsp;<%/if%></td>
                 <td><%if $tpl_category[cat].description neq ""%><a ONMOUSEOVER=" popup('<%$tpl_category[cat].description|strip%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><%/if%><%$tpl_category[cat].cat%><%if $tpl_category[cat].description neq ""%></a><%/if%><td>
                 <td>
                 <%if $tpl_category[cat].subscribed eq "yes"%>
                   <a href="javascript:del(<%$tpl_category[cat].catid%>);" class="dotted">##DELETE##</a>
                 <%else%>
                   <a href="javascript:add(<%$tpl_category[cat].catid%>);" class="dotted">##ADD##</a>
                 <%/if%>
                 </td>
              <tr>
              <%/section%>
            </table>
<input type="hidden" name="frm_max" value="<%$smarty.section.cat.total%>"/>
</form>
</div>
</div>
<%include file=footer.tpl%>
<%/strip%>

