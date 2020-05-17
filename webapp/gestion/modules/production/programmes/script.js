$(function(){


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
        $("table.table-commande tr:not(no)").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".clients").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });


    modifier = function(id){    
        Loader.start();    
        var url = "../../webapp/gestion/modules/production/programmes/ajax.php";
        $.post(url, {action:"modifier", id:id}, (data)=>{
            $("body #modal-programmation-modifier").remove();
            $("body").append(data);
            $("body #modal-programmation-modifier").modal("show");
            $("select.select2").select2();
            Loader.stop();    
        },"html");
    }

    modifierProgrammation = function(){
        var formdata = new FormData($("#formProgrammation")[0]);
        var tableau = new Array();
        $("#modal-programmation-modifier .commande tr").each(function(index, el) {
            var id = $(this).attr('data-id');
            var val = $(this).find('input').val();
            var item = id+"-"+val;
            tableau.push(item);
        });
        formdata.append('tableau', tableau);

        alerty.confirm("Voulez-vous vraiment modifier la programmation de cette ivraison ?", {
            title: "Programmation de la livraison",
            cancelLabel : "Non",
            okLabel : "OUI, modifier",
        }, function(){
            Loader.start();
            var url = "../../webapp/gestion/modules/production/programmes/ajax.php";
            formdata.append('action', "modifierProgrammation");
            $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                if (data.status) {
                    window.location.reload();
                }else{
                    Alerter.error('Erreur !', data.message);
                }
            }, 'json')
        })
    }



    validerProg = function(id){    
        Loader.start();    
        var url = "../../webapp/gestion/modules/production/programmes/ajax.php";
        $.post(url, {action:"valider", id:id}, (data)=>{
            $("body #modal-programmation-valider").remove();
            $("body").append(data);
            $("body #modal-programmation-valider").modal("show");
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


    ValiderLivraisonProgrammee = function(){
        var formdata = new FormData($("#formValiderLivraisonProgrammee")[0]);
        var tableau = new Array();
        $("#modal-programmation-valider .commande tr").each(function(index, el) {
            var id = $(this).attr('data-id');
            var val = $(this).find('input').val();
            var item = id+"-"+val;
            tableau.push(item);
        });
        formdata.append('tableau', tableau);

        alerty.confirm("Voulez-vous vraiment valider cette ivraison ?", {
            title: "Validation de la livraison",
            cancelLabel : "Non",
            okLabel : "OUI, valider",
        }, function(){
            Loader.start();
            var url = "../../webapp/gestion/modules/production/programmes/ajax.php";
            formdata.append('action', "ValiderLivraisonProgrammee");
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


})