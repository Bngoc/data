function stshow(){if(!st_cm) return;var m=st_cm;if(!m.typ&&st_nav.typ!=4){if(!st_nav.typ&&(st_nav.ver<5||st_nav.os=="mac")&&staddP(m.ps[0]))st_ld.push(new Function("stsPop(st_ms["+m.id+"].ps[0]);stshP(st_ms["+m.id+"].ps[0]);st_ms["+m.id+"].ps[0].lock=1"));else if(staddP(m.ps[0]))document.write("<script type='text/javascript' language='javascript1.2'>stsPop(st_ms["+m.id+"].ps[0]);stshP(st_ms["+m.id+"].ps[0]);st_ms["+m.id+"].ps[0].lock=1</script>");}else if(m.typ==1&&st_nav.typ!=4){if(!st_nav.typ&&(st_nav.ver<5||st_nav.os=="mac"))st_ld.push(new Function("stshP(st_ms["+m.id+"].ps[0]);st_ms["+m.id+"].ps[0].lock=1"));else{stshP(m.ps[0]);m.ps[0].lock=1;}}else if(m.typ==3&&st_nav.typ!=4){var es;if(st_nav.typ)es="var m=st_ms["+m.id+"];m.x=e.pageX;m.y=e.pageY;stshP(m.ps[0]);clearTimeout(m.ps[0].tid);m.ps[0].tid=setTimeout(\"sthdP(st_ms["+m.id+"].ps[0])\",m.deHd)";else es="var m=st_ms["+m.id+"];m.x=stgcl()+event.x;m.y=stgct()+event.y;stshP(m.ps[0]);clearTimeout(m.ps[0].tid);m.ps[0].tid=setTimeout(\"sthdP(st_ms["+m.id+"].ps[0])\",m.deHd)";es+=";return false;";document.oncontextmenu=new Function("e",es);}stsetld();}
function hideMenu(n){if((m=stgMe(n))&&st_nav.typ!=4)sthdPX(m.ps[0],4)}
function showFloatMenuAt(n,x,y){	var m;if((m=stgMe(n))&&st_nav.typ!=4){m.x=x;m.y=y;stshP(m.ps[0]);if(!STM_AHCM)m.ps[0].lock=1;}}stshow();
