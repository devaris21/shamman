

$(function(){


    $("form#resetForm").submit(function(event) {
        Loader.start();
        var url = "../../webapp/gestion/modules/access/reset/ajax.php";
        var formData = new FormData($(this)[0]);
        formData.append('action', 'resetPassword');
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