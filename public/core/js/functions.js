/**
 * Created by Calopsia on 24/01/2017.
 */
function loadPage(routes){

    $.ajax({
        url: routes,
        type: "POST",
        global: true,
        cache:false

    }).done(function(data) {

        $("#main").html(data);
    });
}


function login(form)
{
    $.ajax({
        url: 'checkUserCredentials',
        type: "GET",
        global: true,
        cache:false,
        dataType: "json",
        data: form.serialize(),
    success: function(data)
    {
        console.dir(data);

        $(".modal-body").html(data.mensaje);
        $('#mensajeModal').modal({ keyboard: false,show: true});

        if(data.alias != "NONE")
        {
            //window.location.href = "../indexa.php";
            setTimeout(function(){window.location.href = "system"},1000);
        }
        else
        {
            //location.reload();
        }
    },
    error: function(error)
    {
        console.log("Error");
    }

    });
}