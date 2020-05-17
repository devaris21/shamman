$(function(){

    var total = 0;
    $("tr.fini").hide()

    $("input[type=checkbox].onoffswitch-checkbox").change(function(event) {
        if($(this).is(":checked")){
            Loader.start()
            setTimeout(function(){
                Loader.stop()
                $("tr.fini").fadeIn(400)
            }, 500);
        }else{
            $("tr.fini").fadeOut(400)
        }
    });

    $("#top-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table.table-approvisionnement tr:not(.no)").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });



    //nouvel approvisionnement
    $(".newressource").click(function(event) {
        var url = "../../webapp/gestion/modules/production/approvisionnements/ajax.php";
        var id = $(this).attr("data-id");
        $.post(url, {action:"newressource", id:id}, (data)=>{
            $("tbody.approvisionnement").append(data);
            $("button[data-id ="+id+"]").hide(200);
            calcul()
        },"html");
    });


    supprimeRessource = function(id){
        var url = "../../webapp/gestion/modules/production/approvisionnements/ajax.php";
        $.post(url, {action:"supprimeRessource", id:id}, (data)=>{
            $("tbody.approvisionnement tr#ligne"+id).hide(400).remove();
            $("button[data-id ="+id+"]").show(200);
            calcul()
        },"html");
    }


    calcul = function(){
        var url = "../../webapp/gestion/modules/production/approvisionnements/ajax.php";
        var formdata = new FormData($("#formApprovisionnement")[0]);
        var tableau = new Array();
        $("#modal-approvisionnement .approvisionnement tr, #modal-approvisionnement_ .approvisionnement tr").each(function(index, el) {
            var id = $(this).attr('data-id');
            var qte = $(this).find('input[name=quantite]').val();
            var prix = $(this).find('input[name=prix]').val();
            var item = id+"-"+qte+"-"+prix;
            tableau.push(item);
        });
        formdata.append('tableau', tableau);
        formdata.append('action', "calcul");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            $("#modal-approvisionnement tbody.approvisionnement, #modal-approvisionnement_ tbody.approvisionnement").html(data);

            formdata.append('action', "total");
            $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                $(".total").html(data.total);
                total = data.total;
            }, 'json')
        }, 'html')
        return formdata;
    }


    $("body").on("change", "tbody.approvisionnement input.prix", function() {
        calcul()
    })


    validerApprovisionnement = function(){
        formdata = calcul();
        alerty.confirm("Voulez-vous vraiment confirmer cet approvisionnement ?", {
            title: "Validation de l'approvisionnement",
            cancelLabel : "Non",
            okLabel : "OUI, confirmer",
        }, function(){
            if (parseInt(total) == 0) {
                alerty.confirm("Le montant total de cet approvisionnement est de 0F ! Est-il vraiment exact?", {
                    title: "Attention",
                    cancelLabel : "Non",
                    okLabel : "OUI, confirmer",
                }, function(){
                    Loader.start();
                    var url = "../../webapp/gestion/modules/production/approvisionnements/ajax.php";
                    formdata.append('action', "validerApprovisionnement");
                    $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                        if (data.status) {
                            window.open(data.url, "_blank");
                            window.location.reload();
                        }else{
                            Alerter.error('Erreur !', data.message);
                        }
                    }, 'json')
                })
            }else{
                Loader.start();
                var url = "../../webapp/gestion/modules/production/approvisionnements/ajax.php";
                formdata.append('action', "validerApprovisionnement");
                $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                    if (data.status) {
                        window.open(data.url, "_blank");
                        window.location.reload();
                    }else{
                        Alerter.error('Erreur !', data.message);
                    }
                }, 'json')
            }

        })
    }


    annuler = function(id){
        alerty.confirm("Voulez-vous vraiment annuler cet approvisionnement ?", {
            title: "Annuler l'approvisionnement",
            cancelLabel : "Non",
            okLabel : "OUI, annuler",
        }, function(){
            var url = "../../webapp/gestion/modules/production/approvisionnements/ajax.php";
            alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
                title: 'Récupération du mot de passe !',
                inputType : "password",
                cancelLabel : "Annuler",
                okLabel : "Valider"
            }, function(password){
                Loader.start();
                $.post(url, {action:"annuler", id:id, password:password}, (data)=>{
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
        alerty.confirm("Cet approvisionnement est-il vraiment terminé ?", {
            title: "Approvisionnement terminé",
            cancelLabel : "Non",
            okLabel : "OUI, terminer",
        }, function(){
            session("approvisionnement_id", id);
            modal("#modal-approvisionnement"+id);
        })
    }


    $(".formValiderApprovisionnement").submit(function(event) {
        var url = "../../webapp/gestion/modules/production/approvisionnements/ajax.php";
        var formdata = new FormData($(this)[0]);
        var tableau = new Array();
        $(this).find("table tr").each(function(index, el) {
            var id = $(this).attr('data-id');
            var val = $(this).find('input').val();
            var item = id+"-"+val;
            tableau.push(item);
        });
        formdata.append('tableau', tableau);
        formdata.append('action', "validerAppro");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            if (data.status) {
                window.location.reload()
            }else{
                Alerter.error('Erreur !', data.message);
            }
        }, 'json');
        return false;
    });


})