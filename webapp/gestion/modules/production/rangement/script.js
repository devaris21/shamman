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
        $("table.table-commande tr:not(.no)").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".clients").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });



    $(".formRangement").submit(function(event) {
        Loader.start();
        var url = "../../webapp/gestion/modules/production/rangement/ajax.php";
        var formdata = new FormData($(this)[0]);
        var val = $(this).find("select[name=manoeuvre_id]").val();
        formdata.append('manoeuvres', val);
        formdata.append('action', "rangement");
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