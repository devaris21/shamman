$(function(){

    //nouvelle ressource
    $(".newressource").click(function(event) {
        var url = "../../webapp/gestion/modules/master/ressources/ajax.php";
        var id = $(this).attr("data-id");
        $.post(url, {action:"newressource", id:id}, (data)=>{
            $("tbody.approvisionnement").append(data);
            $("button[data-id ="+id+"]").hide(200);
        },"html");
    });


    supprimeRessource = function(id){
        var url = "../../webapp/gestion/modules/master/ressources/ajax.php";
        $.post(url, {action:"supprimeRessource", id:id}, (data)=>{
            $("tbody.approvisionnement tr#ligne"+id).hide(400).remove();
            $("button[data-id ="+id+"]").show(200);
        },"html");
    }



    enregistrerApprovisionnement = function(){
        var url = "../../webapp/gestion/modules/master/ressources/ajax.php";
        var tableau = new Array();
        $("#modal-approvisionnement .approvisionnement tr").each(function(index, el) {
            var id = $(this).attr('data-id');
            var val = $(this).find('input').val();
            var item = id+"-"+val;
            tableau.push(item);
        });
        var formdata = new FormData($("#formApprovisionnement")[0]);
        formdata.append('tableau', tableau);

        alerty.confirm("Voulez-vous vraiment valider l'approvisionnement ?", {
            title: "Validation de l'approvisionnement",
            cancelLabel : "Non",
            okLabel : "OUI, valider",
        }, function(){
            Loader.start();
            var url = "../../webapp/gestion/modules/master/ressources/ajax.php";
            // val = $("input[name=datelivraison]").data('datepicker');
            // console.log(val)
            // let debut =val.format('YYYY-MM-DD');
            // console.log(debut)
            formdata.append('action', "enregistrerApprovisionnement");
            $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                if (data.status) {
                    window.location.reload();
                }else{
                    Alerter.error('Erreur !', data.message);
                }
            }, 'json')
        })
    }


    $('.input-group.date').datepicker({
        autoclose: true,
        format: "dd MM yyyy",
        language: "fr"
    });

})