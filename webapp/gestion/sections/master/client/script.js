$(function(){

	newcommande = function(){
		alerty.confirm("Une ou plusieurs commandes sont déjà en cours, voulez-vous continuer avec l'une d'entre elles ?", {
			title: "Nouvelle commande",
			cancelLabel : "Non, une nouvelle commande",
			okLabel : "OUI, continuer avec elles",
		}, function(){			
			modal("#modal-listecommande");
		}, function(){
			session("commande-encours", null);
			modal("#modal-newcommande");
		})
	}

	chosir = function(id){
		session('commande-encours', id);
		$("#modal-listecommande").modal("hide")
		modal("#modal-newcommande");
	}

	fichecommande = function(id){	
		Loader.start();	
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		$.post(url, {action:"fichecommande", id:id}, (data)=>{
			$("body #modal-groupecommande").remove();
			$("body").append(data);
			$("body #modal-groupecommande").modal("show");
			$("select.select2").select2();
			Loader.stop();	
		},"html");
	}

	newlivraison = function(id){	
		Loader.start();	
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		$.post(url, {action:"newlivraison", id:id}, (data)=>{
			$("body #modal-newlivraison").remove();
			$("body").append(data);
			$("body #modal-newlivraison").modal("show");
			$("select.select2").select2();
			$('.i-checks').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});
			$("div.tricycle").hide()
			$("div.location").hide()
			$("div.chauffeur").hide()
			$("div.montant_location").hide()
			Loader.stop();	
		},"html");
	}


	newProgrammation = function(id){	
		Loader.start();	
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		$.post(url, {action:"newProgrammation", id:id}, (data)=>{
			$("body #modal-programmation").remove();
			$("body").append(data);
			$("body #modal-programmation").modal("show");
			$("select.select2").select2();
			Loader.stop();	
		},"html");
	}



	fairenewcommande = function(id){	
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		$.post(url, {action:"modalcommande", id:id}, (data)=>{
			$("body #modal-newcommande").remove();
			$("body").append(data);
			$("body #modal-newcommande").modal("show");
			$("select.select2").select2();
			$("div.modepayement_facultatif").hide();
			Loader.stop();	
		},"html");
	}

	//nouvelle commande
	$("body").on("click", ".newproduit", function(event) {
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		var id = $(this).attr("data-id");
		var zone = $("select[name=zonelivraison_id]").val();
		$.post(url, {action:"newproduit", id:id, zone:zone}, (data)=>{
			$("tbody.commande").append(data);
			$("button[data-id ="+id+"]").hide(200);
			calcul()
		},"html");
	});


	$("body").on("change", "tbody.commande input", function() {
		calcul()
	})


	supprimeProduit = function(id){
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		$.post(url, {action:"supprimeProduit", id:id}, (data)=>{
			$("tbody.commande tr#ligne"+id).hide(400).remove();
			$("button[data-id ="+id+"]").show(200);
			calcul()
		},"html");
	}


	$("body").on("change", "select[name=zonelivraison_id]", function(){
		calcul()
	})


	calcul = function(){
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		var formdata = new FormData($("#formCommande")[0]);
		var tableau = new Array();
		$("#modal-newcommande .commande tr").each(function(index, el) {
			var id = $(this).attr('data-id');
			var val = $(this).find('input').val();
			var item = id+"-"+val;
			tableau.push(item);
		});
		formdata.append('tableau', tableau);
		formdata.append('action', "calcul");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			$("#modal-newcommande tbody.commande").html(data);

			formdata.append('action', "total");
			$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
				$(".tva").html(data.tva);
				$(".montant").html(data.montant);
				$(".total").html(data.total);
			}, 'json')
		}, 'html')
		
		$("#actualise").hide(200);
		return formdata;
	}


	validerCommande = function(){
		formdata = calcul();
		alerty.confirm("Voulez-vous vraiment valider la commande ?", {
			title: "Validation de la commande",
			cancelLabel : "Non",
			okLabel : "OUI, valider",
		}, function(){
			Loader.start();
			var url = "../../webapp/gestion/modules/master/client/ajax.php";

			// val = $("input[name=datelivraison]").data('datepicker');
			// console.log(val)
			// let debut =val.format('YYYY-MM-DD');
			// console.log(debut)
			formdata.append('action', "validerCommande");
			$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
				if (data.status) {
					window.open(data.url, "_blank");
					window.location.reload();
					window.open(data.url1, "_blank");
				}else{
					Alerter.error('Erreur !', data.message);
				}
			}, 'json')
		})
	}


	annulerCommande = function(id){
		alerty.confirm("Voulez-vous vraiment annuler cette commande. \n Elle implique la suppression de la facture associé, et l'annulation de la dette si il y a! \n Voulez-vous vraiment continuer ?", {
			title: "Annuler la commande",
			cancelLabel : "Non",
			okLabel : "OUI, annuler",
		}, function(){
			var url = "../../webapp/gestion/modules/master/client/ajax.php";
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				Loader.start();
				$.post(url, {action:"annulerCommande", id:id, password:password}, (data)=>{
					if (data.status) {
						window.location.reload()
					}else{
						Alerter.error('Erreur !', data.message);
					}
				},"json");
			})
		})
	}



	validerLivraison = function(){
		// val = $('.date').data("datepicker").viewDate;
		// console.log(val);
		// return false;
		var formdata = new FormData($("#formLivraison")[0]);
		var tableau = new Array();
		$("#modal-newlivraison .commande tr").each(function(index, el) {
			var id = $(this).attr('data-id');
			var val = $(this).find('input').val();
			var item = id+"-"+val;
			tableau.push(item);
		});
		formdata.append('tableau', tableau);

		alerty.confirm("Voulez-vous vraiment confirmer la livraison de ces produits ?", {
			title: "livraison de la commande",
			cancelLabel : "Non",
			okLabel : "OUI, livrer",
		}, function(){
			Loader.start();
			var url = "../../webapp/gestion/modules/master/client/ajax.php";
			formdata.append('action', "livraisonCommande");
			$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
				if (data.status) {
					window.open(data.url, "_blank");
					window.location.reload();
				}else{
					Alerter.error('Erreur !', data.message);
				}
			}, 'json')
		})
	}


	validerProgrammation = function(){
		var formdata = new FormData($("#formLivraison")[0]);
		var tableau = new Array();
		$("#modal-programmation .commande tr").each(function(index, el) {
			var id = $(this).attr('data-id');
			var val = $(this).find('input').val();
			var item = id+"-"+val;
			tableau.push(item);
		});
		formdata.append('tableau', tableau);
		formdata.append('datelivraison', $("#modal-programmation input[name=datelivraison]").val());

		alerty.confirm("Voulez-vous vraiment confirmer la programmation de cette ivraison ?", {
			title: "Programmation de la livraison",
			cancelLabel : "Non",
			okLabel : "OUI, programmer",
		}, function(){
			Loader.start();
			var url = "../../webapp/gestion/modules/master/client/ajax.php";
			formdata.append('action', "validerProgrammation");
			$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
				if (data.status) {
					window.location.reload();
				}else{
					Alerter.error('Erreur !', data.message);
				}
			}, 'json')
		})
	}


	$("#formAcompte").submit(function(event) {
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		alerty.confirm("Voulez-vous vraiment créditer ce montant sur ce compte ?", {
			title: "Créditer l'acompte",
			cancelLabel : "Non",
			okLabel : "OUI, créditer",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				var formdata = new FormData($("#formAcompte")[0]);
				formdata.append('password', password);
				formdata.append('action', "acompte");
				Loader.start();
				$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
					if (data.status) {
						window.open(data.url, "_blank");
						window.location.reload();
					}else{
						Alerter.error('Erreur !', data.message);
					}
				}, 'json')
			})
		})
		return false;
	});


	$("#formDette").submit(function(event) {
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		alerty.confirm("Voulez-vous vraiment faire le réglement de ce montant ?", {
			title: "Reglement de dette",
			cancelLabel : "Non",
			okLabel : "OUI, régler la dette",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				var formdata = new FormData($("#formDette")[0]);
				formdata.append('password', password);
				formdata.append('action', "dette");
				Loader.start();
				$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
					if (data.status) {
						if (data.url != null) {
							window.open(data.url, "_blank");
						}
						window.location.reload();
					}else{
						Alerter.error('Erreur !', data.message);
					}
				}, 'json')
			})
		})
		return false;
	});


	$("#formRembourser").submit(function(event) {
		var url = "../../webapp/gestion/modules/master/client/ajax.php";
		alerty.confirm("Voulez-vous vraiment rembourser ce montant à ce client ?", {
			title: "rembourser l'acompte",
			cancelLabel : "Non",
			okLabel : "OUI, créditer",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				var formdata = new FormData($("#formRembourser")[0]);
				formdata.append('password', password);
				formdata.append('action', "rembourser");
				Loader.start();
				$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
					if (data.status) {
						window.open(data.url, "_blank");
						window.location.reload();
					}else{
						Alerter.error('Erreur !', data.message);
					}
				}, 'json')
			})
		})
		return false;
	});


	$('.input-group.date').datepicker({
		autoclose: true,
		format: "dd MM yyyy",
		language: "fr"
	});

})