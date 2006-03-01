        <table class="calendar">
          <tr>
            <td class="CalendarL1HeaderLeft">&nbsp;</td>
            <%section name=cal loop=$tpl_cal%>
            <td colspan="2" class="CalendarL1Header"><%$tpl_cal[cal].weekday%><br><%$tpl_cal[cal].date%></td>
            <%/section%>
          </tr>
        <%section name=room loop=$tpl_room%>
        <tr>
           <td class="CalendarL<%$tpl_room[room].color%>Left" onmouseover="popup('<%$tpl_room[room].infotxt|strip|escape:"quotes"|replace:'"':'&#34;'%>','<%$wwwroot%>');" onmouseout="kill()"><%$tpl_room[room].name%></td>
            <%section name=cal loop=$tpl_roomcal[room]%>
            <%if $tpl_roomcal[room][cal].firstday neq 'true' and $tpl_roomcal[room][cal].lastday neq 'true'%>
                 <td colspan="2" class="<%if $tpl_roomcal[room][cal].color neq ""%>CalendarRoom<%$tpl_room[room].color%><%else%>CalendarL<%$tpl_room[room].color%><%/if%>" style="background-color:<%if $tpl_view eq 'type'%><%$tpl_roomcal[room][cal].bookingtypecolor%><%else%><%$tpl_roomcal[room][cal].color%><%/if%>;" onclick="openWindow('<%$wwwroot%><%if $tpl_roomcal[room][cal].bookid neq ""%>editbook.php/bookid.<%$tpl_roomcal[room][cal].bookid%>/bookingdetailid.<%$tpl_roomcal[room][cal].bookingdetailid%><%else%>book.php/start.<%$tpl_roomcal[room][cal].linkDate%>/room.<%$tpl_room[room].roomid%><%/if%>');" <%if $tpl_roomcal[room][cal].infotxt neq ""%>onmouseover="popup('<%$tpl_roomcal[room][cal].infotxt|strip|escape:"quotes"|replace:'"':'&#34;'%>','<%$wwwroot%>');" onmouseout="kill();"<%/if%> <%if $tpl_roomcal[room][cal].infotxt eq ""%><%/if%>>&nbsp;</td>
            <%else%>
                <%if $tpl_roomcal[room][cal].lastday eq 'true'%>
                     <td class="CalendarRoom<%$tpl_room[room].color%>" style="background-color:<%if $tpl_view eq 'type'%><%$tpl_roomcal[room][cal].lastdaydata.bookingtypecolor%><%else%><%$tpl_roomcal[room][cal].lastdaydata.color%><%/if%>;" onclick="openWindow('<%$wwwroot%><%if $tpl_roomcal[room][cal].lastdaydata.bookid neq ""%>editbook.php/bookid.<%$tpl_roomcal[room][cal].lastdaydata.bookid%>/bookingdetailid.<%$tpl_roomcal[room][cal].lastdaydata.bookingdetailid%><%else%>book.php/start.<%$tpl_roomcal[room][cal].linkDate%>/room.<%$tpl_room[room].roomid%><%/if%>');" onmouseover="popup('<%$tpl_roomcal[room][cal].lastdaydata.infotxt|strip|escape:"quotes"|replace:'"':'&#34;'%>','<%$wwwroot%>');" onmouseout="kill();">&nbsp;</td>
                <%else%>
                      <td class="CalendarL<%$tpl_room[room].color%>">&nbsp;</td>
                <%/if%>
                <%if $tpl_roomcal[room][cal].firstday eq 'true'%>
                     <td class="CalendarRoom<%$tpl_room[room].color%>" style="background-color:<%if $tpl_view eq 'type'%><%$tpl_roomcal[room][cal].bookingtypecolor%><%else%><%$tpl_roomcal[room][cal].color%><%/if%>;" onclick="openWindow('<%$wwwroot%><%if $tpl_roomcal[room][cal].bookid neq ""%>editbook.php/bookid.<%$tpl_roomcal[room][cal].bookid%>/bookingdetailid.<%$tpl_roomcal[room][cal].bookingdetailid%><%else%>book.php/start.<%$tpl_roomcal[room][cal].linkDate%>/room.<%$tpl_room[room].roomid%><%/if%>');" onmouseover="popup('<%$tpl_roomcal[room][cal].infotxt|strip|escape:"quotes"|replace:'"':'&#34;'%>','<%$wwwroot%>');" onmouseout="kill();">&nbsp;</td>
                <%else%>
                     <td class="CalendarL<%$tpl_room[room].color%>" onclick="openWindow('<%$wwwroot%>book.php/start.<%$tpl_roomcal[room][cal].linkDate%>/room.<%$tpl_room[room].roomid%>');">&nbsp;</td>
                <%/if%>
            <%/if%>
            <%/section%>
        </tr>
        <%/section%>
        </table>
		<!--
        <br/>
        <table style="border:0px;">
        <tr>
        <%if $tpl_view eq "type"%>
            <td class="colorchooser" style="background-color:<%$tpl_colorP%>;">&nbsp;</td>
            <td>##CLEARED##</td>
            <td>&nbsp;</td>
            <td class="colorchooser" style="background-color:<%$tpl_colorB%>;">&nbsp;</td>
            <td>##BOOKING##</td>
            <td>&nbsp;</td>
            <td class="colorchooser" style="background-color:<%$tpl_colorR%>;">&nbsp;</td>
            <td>##ADVANCE_BOOKING##</td>
            <td>&nbsp;</td>
        <%else%>
            <%section name=bcat loop=$tpl_bcat%>
            <td class="colorchooser" style="background-color:<%$tpl_bcat[bcat].catcolor%>;" onmouseover="popup('<%$tpl_bcat[bcat].description|strip|escape:"quotes"|replace:'"':'&#34;'%>','<%$wwwroot%>');" onmouseout="kill()">&nbsp;</a></td>
            <td <%if $tpl_bcat[bcat].description neq ""%> onmouseover="popup('<%$tpl_bcat[bcat].description|strip|escape:"quotes"|replace:'"':'&#34;'%>','<%$wwwroot%>');" onmouseout="kill()"<%/if%>><%$tpl_bcat[bcat].name%></td>
            <td>&nbsp;</td>
            <%/section%>
        <%/if%>
      	</tr>
		</table>
		//-->
