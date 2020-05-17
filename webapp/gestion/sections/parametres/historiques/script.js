
$(function(){

	$("input[type=date]").change(function(){
		Loader.start()
		var url = "../../webapp/gestion/modules/parametres/historiques/ajax.php";
		var formData = new FormData();
		formData.append("date1", $("input[name=date1]").val());
		formData.append("date2", $("input[name=date2]").val());
		formData.append("action", "historiques");
		$.post({url:url, data:formData, processData:false, contentType:false}, function(data) {
			$("div.affichage").html(data);
			Loader.stop();
		}, "html");
	})


	$("input[name=date1]").change()
})