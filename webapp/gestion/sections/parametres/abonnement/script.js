$(function(){

	$("#formAbonnement input").keyup(function(event) {
		if ($(this).val().length == 5) {
			$(this).parent("div").next("div").find("input").focus();
		}
	});



	$(".formAbonnement").submit(function(event) {
		Loader.start();
		var url = "../../webapp/gestion/modules/abonnement/index/ajax.php";
		var formdata = new FormData($(this)[0]);
		formdata.append('action', "abonnement");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			if (data.status) {
				window.location.reload();
			}else{
				Alerter.error('Erreur !', data.message);
			}
		}, 'json')
		return false;
	});

})