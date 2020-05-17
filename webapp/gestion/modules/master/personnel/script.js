$(function(){

	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $("#parcs div.tab-pane:first").addClass('active')
	
	$("#top-search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tableUser tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	


	$(".formPayeManoeuvre").submit(function(event) {
		var url = "../../webapp/gestion/modules/master/personnel/ajax.php";
		var formdata = new FormData($(this)[0]);
		alerty.confirm("Voulez-vous effectuer la paye de cet manoeuvre ?", {
			title: "Nouvelle Paye",
			cancelLabel : "Non",
			okLabel : "OUI,payer",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				Loader.start();
				formdata.append('password', password);
				formdata.append('action', "payer");
				$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
					if (data.status) {
						window.location.reload()
					}else{
						Alerter.error('Erreur !', data.message);
					}
				}, 'json');
			})
		})
		return false;
	});

})


