$(function(){


    $("tr.fini").hide()

    $("input[type=checkbox].onoffswitch-checkbox").change(function(event) {
        if($(this).is(":checked")){
            Loader.start()
            setTimeout(function(){
                Loader.stop()
                $("tr.fini").fadeIn(400)
                $(".aucun").hide()
            }, 500);
        }else{
            $("tr.fini").fadeOut(400)
            $(".aucun").show()
        }
    });

    $("#top-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table.table-livraison tr:not(.no)").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    
    annulerLivraison = function(id){
        alerty.confirm("Voulez-vous vraiment annuler cette livraison ?", {
            title: "Annuler la livraison",
            cancelLabel : "Non",
            okLabel : "OUI, annuler",
        }, function(){
            var url = "../../webapp/gestion/modules/production/livraisons/ajax.php";
            alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
                title: 'Récupération du mot de passe !',
                inputType : "password",
                cancelLabel : "Annuler",
                okLabel : "Valider"
            }, function(password){
                Loader.start();
                $.post(url, {action:"annulerLivraison", id:id, password:password}, (data)=>{
                    if (data.status) {
                        window.location.reload()
                    }else{
                        Alerter.error('Erreur !', data.message);
                    }
                },"json");
            })
        })
    }


    terminer = function(id){
        alerty.confirm("Cette livraison est-elle vraiment terminée ?", {
            title: "Livraison terminée",
            cancelLabel : "Non",
            okLabel : "OUI, terminer",
        }, function(){
            session("livraison_id", id);
            modal("#modal-livraison"+id);
        })
    }



    $(".formValiderLivraison").submit(function(event) {
        Loader.start();
        var url = "../../webapp/gestion/modules/production/livraisons/ajax.php";
        var formdata = new FormData($(this)[0]);
        var tableau = new Array();
        $(this).find("table tr").each(function(index, el) {
            var id = $(this).attr('data-id');
            var val = $(this).find('input').val();
            var item = id+"-"+val;
            tableau.push(item);
        });
        formdata.append('tableau', tableau);
        formdata.append('action', "validerLivraison");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            if (data.status) {
                window.location.reload()
            }else{
                Alerter.error('Erreur !', data.message);
            }
        }, 'json');
        return false;
    });


    $(".formPayeTricycle").submit(function(event) {
        var url = "../../webapp/gestion/modules/production/tricycle/ajax.php";
        var formdata = new FormData($(this)[0]);
        alerty.confirm("Voulez-vous effectuer la paye de cet tricycle ?", {
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