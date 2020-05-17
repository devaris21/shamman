$(function(){
	// $(this).masonry({
	// 	itemSelector: '.bloc',
	// });


	$(".formPrix").submit(function(event) {
		Loader.start();
		var url = "../../webapp/gestion/modules/parametres/configuration/ajax.php";
		var formdata = new FormData($(this)[0]);
		var tableau = new Array();
		$(this).find("input[data-id]").each(function(configuration, el) {
			var id = $(this).attr('data-id');
			var val = $(this).val();
			var item = id+"-"+val;
			tableau.push(item);
		});
		formdata.append('tableau', tableau);
		formdata.append('action', "prix");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			if (data.status) {
				window.location.reload();
			}else{
				Alerter.error('Erreur !', data.message);
			}
		}, 'json')
		return false;
	});



	$(".formExigence").submit(function(event) {
		Loader.start();
		var url = "../../webapp/gestion/modules/parametres/configuration/ajax.php";
		var formdata = new FormData($(this)[0]);
		var tableau = new Array();
		$(this).find("div.input").each(function(configuration, el) {
			var id = $(this).find("input[data-id]").attr('data-id');
			var prod = $(this).find("input[data-id]").val();
			var res = $(this).find("input[name=quantite_ressource]").val();
			var item = id+"-"+prod+"-"+res;
			tableau.push(item);
		});
		formdata.append('tableau', tableau);
		formdata.append('action', "exigence");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			if (data.status) {
				window.location.reload();
			}else{
				Alerter.error('Erreur !', data.message);
			}
		}, 'json')
		return false;
	});



	$("form.formPayeProduit").submit(function(event) {
		Loader.start();
		var url = "../../webapp/gestion/modules/parametres/configuration/ajax.php";
		var formdata = new FormData($(this)[0]);
		var tableau = new Array();
		$(this).find("input[data-id][name=price]").each(function(configuration, el) {
			var id = $(this).attr('data-id');
			var val = $(this).val();
			var item = id+"-"+val;
			tableau.push(item);
		});

		var tableau1= new Array();
		$(this).find("input[data-id][name=price_rangement]").each(function(configuration, el) {
			var id = $(this).attr('data-id');
			var val = $(this).val();
			var item = id+"-"+val;
			tableau1.push(item);
		});


		var tableau2= new Array();
		$(this).find("input[data-id][name=price_livraison]").each(function(configuration, el) {
			var id = $(this).attr('data-id');
			var val = $(this).val();
			var item = id+"-"+val;
			tableau2.push(item);
		});

		formdata.append('tableau', tableau);
		formdata.append('tableau1', tableau1);
		formdata.append('tableau2', tableau2);
		formdata.append('action', "formPayeProduit");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			if (data.status) {
				window.location.reload();
			}else{
				Alerter.error('Erreur !', data.message);
			}
		}, 'json')
		return false;
	});



	$("form.formPayeProduitFerie").submit(function(event) {
		Loader.start();
		var url = "../../webapp/gestion/modules/parametres/configuration/ajax.php";
		var formdata = new FormData($(this)[0]);
		var tableau = new Array();
		$(this).find("input[data-id][name=price]").each(function(configuration, el) {
			var id = $(this).attr('data-id');
			var val = $(this).val();
			var item = id+"-"+val;
			tableau.push(item);
		});

		var tableau1= new Array();
		$(this).find("input[data-id][name=price_rangement]").each(function(configuration, el) {
			var id = $(this).attr('data-id');
			var val = $(this).val();
			var item = id+"-"+val;
			tableau1.push(item);
		});


		var tableau2= new Array();
		$(this).find("input[data-id][name=price_livraison]").each(function(configuration, el) {
			var id = $(this).attr('data-id');
			var val = $(this).val();
			var item = id+"-"+val;
			tableau2.push(item);
		});

		formdata.append('tableau', tableau);
		formdata.append('tableau1', tableau1);
		formdata.append('tableau2', tableau2);
		formdata.append('action', "formPayeProduitFerie");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			if (data.status) {
				window.location.reload();
			}else{
				Alerter.error('Erreur !', data.message);
			}
		}, 'json')
		return false;
	});



	$("button.autoriser").click(function(event) {
		var url = "../../webapp/gestion/modules/parametres/configuration/ajax.php";
		button = $(this);
		employe_id = $(this).attr("employe");
		role_id = $(this).attr("role");

		alerty.confirm("Vous êtes sur le point d'autoriser cet accès à cet employe, voulez-vous continuer ?", {
			title: "Autoriser l'acces",
			cancelLabel : "Non",
			okLabel : "OUI, autoriser",
		}, function(){
			$.post(url, {action:"autoriser", employe_id:employe_id, role_id:role_id}, (data)=>{
				if (data.status) {
					Alerter.success('Reussite !', "L'employé a maintenant cet acces !");
					button.addClass('btn-primary');
					button.removeClass('btn-white');
				}else{
					Alerter.error('Erreur !', data.message);
				}
			},"json");
		})
	});


		$("button.refuser").click(function(event) {
		var url = "../../webapp/gestion/modules/parametres/configuration/ajax.php";
		button = $(this);
		employe_id = $(this).attr("employe");
		role_id = $(this).attr("role");

		alerty.confirm("Vous êtes sur le point de refuser cet accès à cet employe, voulez-vous continuer ?", {
			title: "Bloquage d'accès",
			cancelLabel : "Non",
			okLabel : "OUI, refuser",
		}, function(){
			$.post(url, {action:"refuser", employe_id:employe_id, role_id:role_id}, (data)=>{
				if (data.status) {
					Alerter.success('Reussite !', "L'employé a maintenant cet acces !");
					button.removeClass('btn-primary');
					button.addClass('btn-white');
				}else{
					Alerter.error('Erreur !', data.message);
				}
			},"json");
		})
	});



})