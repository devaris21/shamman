
$(function(){

    $("form#formConnexion").submit(function(event) {
        Loader.start();
        var url = "../../webapp/gestion/modules/access/login/ajax.php";
        var formData = new FormData($(this)[0]);
        formData.append('action', 'connexion');
        $.post({url:url, data:formData, processData:false, contentType:false}, function(data) {
            if (data.status) {
                if (data.new) {
                     Loader.stop();
                    $("#modal-newUser").modal();
                }else{
                    window.location.href = data.url;
                }
            }else{
               Alerter.error('Erreur !', data.message);
            }
        }, 'json');
        return false;
    });



    $("form#formNewUser").submit(function(event) {
         Loader.start();
        var url = "../../webapp/gestion/modules/access/login/ajax.php";
        var formData = new FormData($(this)[0]);
        formData.append('action', 'newUser');
        $.post({url:url, data:formData, processData:false, contentType:false}, function(data) {
            if (data.status) {
                window.location.href = data.url;
            }else{
               Alerter.error('Erreur !', data.message);
            }
        }, 'json');
        return false;
    });


})