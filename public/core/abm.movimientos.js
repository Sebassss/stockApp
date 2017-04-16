jQuery(document).ready(function($)
{

    var Options = [
        {refresh: "true"},
        {add: "true"},
        {edit: "true"},
        {delete: "true"}];

    var colheaders = [
        {index : "movimiento_id", name: "id", editable: "false",  visible: "false", type: "text",placeholder:"", maxlength: "10", required: "true" },
        {index : "deposito_id", name: "Depósito",editable: "true", visible: "true", type: "dropdown", url: 'abm_getMovimientosDeposito', maxlength: "10", required: "true"},
        {index : "proveedor_id", name: "Proveedor",editable: "true", visible: "true", type: "dropdown", url: 'abm_getMovimientosProveedor', maxlength: "10", required: "true"},
        {index : "articulo_id", name: "Artículo",editable: "true", visible: "true", type: "dropdown", url: 'abm_getMovimientosArticulos', maxlength: "10", required: "true"},
        {index : "operacion", name: "Operación",editable: "true", visible: "true", type: "dropdown", url: 'abm_getMovimientosOperacion', maxlength: "10", required: "true"},
        {index : "cantidad", name: "Cantidad",editable: "true", visible: "true", type: "text", maxlength: "10", required: "true"}];


    var edit_options ={	url: "abm_getMovimientos",titulo: "Editar",method : "PUT" };
    var add_options ={ url: "abm_getMovimientos",titulo: "Agregar",method : "POST" };
    var del_options ={ url: "abm_getMovimientos",titulo: "Eliminar",method : "DELETE"};

    var datasource ={
        url: "abm_getMovimientos",
        method : "GET",
        datatype: "json",
        pagesize: 10,
        paginate: "false",
        fixedrows: "12"
    };


    var x = $('#table').Grid({  // calls the init method

        Titulo : 'Movimientos',
        ABM: Options,
        Columnas: colheaders,
        edit_options : edit_options,
        add_options : add_options,
        del_options : del_options,
        timeout: 6000, /*Segundos de espera para llamados ajax edit, update, delete*/
        animate: 1,
        datasource: datasource,
        export2XLS: "true"
    });



});/**
 * Created by Ivan on 23/01/2017.
 */
