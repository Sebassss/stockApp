/**
 * Created by Ivan on 26/09/2017.
 */
/**
 * Created by Ivan on 25/09/2017.
 */

var myApp = new Framework7();

var $$ = Dom7;

var articulos;

$(function(){

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
            '<a href="#" class="floating-button floating-button-to-popover open-popover color-purple">'+
                '<i class="icon icon-plus"></i>'+
            '</a>'+
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
        '</div>';


    myApp.popup(popupHTML);

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