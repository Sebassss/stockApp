/**
 * Created by Ivan on 26/09/2017.
 */
/**
 * Created by Ivan on 25/09/2017.
 */

var myApp = new Framework7();

var $$ = Dom7;

var articulos;

var usuario_id;

function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}


$(function(){

    usuario_id = GetURLParameter('usuario_id');

    myApp.showPreloader('Espere...');

    var mySearchbar = $$('.searchbar')[0].f7Searchbar;

    $.ajax({
        url: 'http://10.64.65.200:84/stockapp/public/abm_getArticulos',
        type: "GET",
        dataType: "json",
        success: function(data)
        {
            //console.dir(data);

            fillTable(data);
            articulos = data;

            myApp.hidePreloader();
        },
        error: function(error)
        {
            console.log(error);
            myApp.hidePreloader();
        }

    });


});

function fillTable(data){


    console.dir(data);

    for ( var index in data){

        var html =
            '<li class="item-content"  data-id="'+ data[index].articulo_id +'">'+
                '<div class="item-inner">'+
                    colorBadge(data[index].articulo_cantidad) +
                    '<div class="item-title">'+ data[index].articulo_nombre +
                        '<br>'+
                        '<div class="chip">' +
                            '<div class="chip-label">'+
                                data[index].deposito_nombre +
                            '</div>' +
                        '</div>' +
                        '<div class="rubro" >'+ data[index].rubro_nombre+'</div>'+
                        '<div style="display: none">'+ data[index].marca_nombre+'</div>'+
                        '<div style="display: none">'+ decodeEntities(data[index].articulo_detalle) +'</div>'+
                    '</div>'+
                '</div>'+
            '</li>';


        $("#listContent").append(html);

    }

    fillActions();
}


function fillActions(){


    $(".item-content").click(function(){

        //console.log($(this).data('id'))
        detailPopUp($(this).data('id'));
    });
}

/*https://stackoverflow.com/questions/1147359/how-to-decode-html-entities-using-jquery*/
function decodeEntities(encodedString) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
}




function detailPopUp(id){


    var encontrado;


    for(var index in articulos){

        if(articulos[index].articulo_id == id){

            //console.log(articulos[index])

            encontrado = articulos[index];
        }

    }
    //lo separo en 2 porque sino el IDE no me lo resalta

    var popupHTML =

        '<div class="popup">'+
            '<div class="navbar">'+
                '<div class="navbar-inner navbarMenu">'+
                    '<div class="left">'+
                        '<a href="#" class="link back close-popup">'+
                        '<i class="icon icon-back"></i>'+
                        '<span>Volver</span>'+
                        '</a>'+
                    '</div>'+
                    '<div class="center">En stock:' + colorBadge( encontrado.articulo_cantidad) +'</span></div>'+
                '</div>'+
            '</div>'+
                '<div class="list-block cards-list">'+
                    '<ul>'+
                        '<li class="card">'+
                            '<div class="card-header">Información del artículo</div>'+
                            '<div class="card-content">'+
                                '<div class="card-content-inner">' +
                                    '<div class="content-block">'+
                                        '<div class="row">' +
                                            '<div class="col-auto">' +
                                                '<div class="chip">' +
                                                    '<div class="chip-label">'+
                                                        encontrado.deposito_nombre +
                                                    '</div>' +
                                                '</div>' +
                                                '<h4> Marca: ' + encontrado.marca_nombre +'</h4>' +
                                                '<h4> Modelo: ' + encontrado.articulo_nombre +'</h4>' +
                                                '<h4> Rubro: ' + encontrado.rubro_nombre +'</h4>' +
                                                '<h4> Proveedor: ' + encontrado.proveedor_nombre +'</h4>' +
                                            '</div>'+
                                        '</div>'+
                                        '<div class="row">' +
                                            '<h4>Detalle:</h4>' +
                                            '<div class="col-100 detalle">' +
                                                '<p>'+ decodeEntities(encontrado.articulo_detalle) + '</p>' +
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</li>';



    popupHTML = popupHTML +

                '<li class="card">'+
                    '<div class="card-header">Ingrese cantidad a retirar</div>'+
                    '<div class="card-content">'+
                        '<div class="card-content-inner">' +
                            '<div class="row no-gutter">' +
                                '<div class="col-33">' +
                                    '<a href="#" class="button button-fill color-deeporange" id="btnMenos">menos</a>'+
                                '</div>' +
                                '<div class="col-33">' +
                                    '<input id="elInput" class="inputs" type="number">'+
                                '</div>' +
                                '<div class="col-33">' +
                                    '<a href="#" class="button button-fill color-green" id="btnMas">mas</a>'+
                                '</div>'+
                            '</div>'+
                            '<br>'+
                            '<div class="row no-gutter">' +
                                '<h4>Puede ingresar un comentario</h4>'+
                                '<input id="elComentario" type="text" class="inputs">'+
                            '</div>' +
                        '</div>'+
                    '</div>'+
                    '<div class="card-footer botonera">' +
                        '<a href="#" class="button button-fill color-red" id="btnRetirar">Retirar</a>'+
                    '</div>'+
                '</li>'+
           '</ul>'+
       '</div>'+
   '</div>';




    myApp.popup(popupHTML);

    $("#elInput").val(0);

    $("#btnMenos").click(function(){

        if(parseInt($("#elInput").val()) > 0){

            $("#elInput").val(parseInt( $("#elInput").val() )-1);
        }

    });

    $("#btnMas").click(function(){

        if(parseInt($("#elInput").val()) < encontrado.articulo_cantidad){

            $("#elInput").val(parseInt( $("#elInput").val() )+1);
        }

    });




    $("#btnRetirar").click(function(){


        if($("#elInput").val() == 0){

            myApp.alert("No se ingresó una cantidad mayor a 0");
        }else if($("#elComentario").val() != ''){

            var modal = myApp.modal({
                title: 'Está seguro de retirar ' + $("#elInput").val() + ' ' + encontrado.articulo_nombre + ' ?' + msgComentario,
                buttons: [
                    {
                        text: 'Cancelar'
                    },
                    {
                        text: 'Retirar',
                        bold: true,
                        onClick: function () {
                            $.ajax({
                                url: 'http://10.64.65.200:84/stockapp/public/abm_descArticulos',
                                method: "PUT",
                                data: {
                                    'articulo_id': encontrado.articulo_id,
                                    'articulo_cantidad': $("#elInput").val(),
                                    'usuario_id': usuario_id,
                                    'articulo_comentario': $("#elComentario").val()
                                },
                                dataType: "json",
                                success: function (data) {
                                    myApp.alert("El artículo se descontó correctamente");
                                    location.reload();

                                },
                                error: function (error) {

                                    myApp.alert("CUIDADO, no se actualizó el stock chango!!\n" + error);
                                }

                            });
                        }
                    }
                ]
            });

        }else{
            myApp.alert("No puede retirar artículos sin un comentario");
        }


    });

}




function colorBadge(cant){

    var htmlBadge;

    if(cant == 0){
        htmlBadge = '<span class="badge  bg-red">'+ cant +'</span>';
    }else if(cant <= 1){
        htmlBadge = '<span class="badge  bg-orange">'+ cant +'</span>';
    }else{
        htmlBadge = '<span class="badge  bg-green">'+ cant+'</span>';
    }

    return htmlBadge;
}