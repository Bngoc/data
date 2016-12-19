// JavaScript Document

var mouse_is_inside = false;

$(document).ready(function()
{
    $('.box_login, .pao').hover(
	function(){ 
        mouse_is_inside=true; 
    }, function(){ 
        mouse_is_inside=false; 
    });
	
	
    $("body").mouseup(function(){ 
        if(! mouse_is_inside)
		{
			$('.box_login').hide();
	    	$("i.down").removeClass("downup");
	    	$("i.down").addClass("down");
		}
    });
});

//Dang nhap even click
$(document).ready(function () {
    $('.pao').click(function () {
        if ($('.box_login').is(":hidden")){
            $('.box_login').slideDown('slow');
	    	$("i.down").toggleClass("downup");
		}
         else {
            $('.box_login').slideUp('slow');
	    	$("i.down").toggleClass("downup");
		 }
    });
});
//hover hop thong so luong
