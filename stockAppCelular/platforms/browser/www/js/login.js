/**
 * Created by Ivan on 22/09/2017.
 */

/*
$$(document).on('DOMContentLoaded', function(){
   
    
});
*/
var myApp = new Framework7();


$("#loginButton").click(function(){

    login();

});

function login()
{

    myApp.showPreloader('Espere...');

    $.ajax({
        url: 'http://10.64.65.200:84/stockapp/public/checkUserCredentials',
        type: "GET",
        global: true,
        cache:false,
        dataType: "json",
        data: {
            txt_usr: $("#username").val(),
            txt_pwd: $("#password").val()
        },
        success: function(data)
        {
            console.log(data)
            myApp.hidePreloader();

            if(data.estado === 'NONE'){

                myApp.alert(data.mensaje,"error de acceso")
            }else if(data.estado === 'HABILITADO'){

                //console.log("se logea")
                window.location.replace("a_index.html");
            }


        },
        error: function(error)
        {
            console.log(error);
            myApp.hidePreloader();
        }

    });
}