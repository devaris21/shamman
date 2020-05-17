
$(function(){
	$(document).idleTimer(13 * 60 * 1000);
	$(document).on("idle.idleTimer", function(event, elem, obj){
        window.location.href = "../../gestion/access/locked";
    });
})