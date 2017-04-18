jQuery(document).ready(function($)
{

    var Options = [
        {refresh: "true"},
        {add: "true"},
        {edit: "true"},
        {delete: "true"}];

    var colheaders = [
        {index : "deposito_id", name: "id", editable: "false",  visible: "false", type: "text",placeholder:"", maxlength: "10", required: "true" },
        {index : "deposito_nombre", name: "Nombre del depósito",editable: "true", visible: "true", type: "text", maxlength: "50",placeholder:"", required: "true" },
        {index : "deposito_detalle", name: "Detalles",editable: "true", visible: "true", type: "textarea",  required: "true"}];


    var edit_options ={	url: "abm_getDepositos",titulo: "Editar",method : "PUT" };
    var add_options ={ url: "abm_getDepositos",titulo: "Agregar",method : "POST" };
    var del_options ={ url: "abm_getDepositos",titulo: "Eliminar",method : "DELETE"};

    var datasource ={
        url: "abm_getDepositos",
        method : "GET",
        datatype: "json",
        pagesize: 10,
        paginate: "false",
        fixedrows: "12"
    };


    var x = $('#table').Grid({  // calls the init method

        Titulo : 'Depósitos',
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
