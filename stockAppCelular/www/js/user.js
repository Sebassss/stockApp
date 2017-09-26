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

        var htmlBadge;

        if(data[index].articulo_cantidad <= 1){
            htmlBadge = '<span class="badge  bg-red">'+ data[index].articulo_cantidad +'</span>';
        }else{
            htmlBadge = '<span class="badge  bg-green">'+ data[index].articulo_cantidad +'</span>';
        }

        var html =
            '<li class="item-content"  data-id="'+ data[index].articulo_id +'">'+
                '<div class="item-inner">'+
                    htmlBadge +
                    '<div class="item-title">'+ data[index].articulo_nombre +
                        '<br>'+
                        '<div class="chip">' +
                            '<div class="chip-label">'+
                        data[index].deposito_nombre + '</div></div>' +
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

        console.log($(this).data('id'))
    });
}

function decodeEntities(encodedString) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
}