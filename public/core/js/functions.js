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
        type: "POST",
        global: true,
        cache:false,
        dataType: "json",
        data: form.serialize(),
    success: function(data)
    {
        console.dir(data);
        if(data.login == "OK")
        {
            //window.location.href = "../../indexa.php";
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