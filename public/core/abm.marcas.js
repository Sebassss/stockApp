jQuery(document).ready(function($)
{

    var Options = [
        {refresh: "true"},
        {add: "true"},
        {edit: "true"},
        {delete: "true"}];

    var colheaders = [
        {index : "marca_id", name: "id", editable: "false",  visible: "false", type: "text",placeholder:"", maxlength: "10", required: "true" },
        {index : "rubro_id", name: "Rubro",editable: "true", visible: "false", type: "dropdown", url: 'abm_getMarcasRubros', maxlength: "10", required: "true"},
        {index : "rubro_nombre", name: "Rubro",editable: "false", visible: "true", type: "text", maxlength: "10",placeholder:"", required: "true" },
        {index : "marca_nombre", name: "Nombre de la marca",editable: "true", visible: "true", type: "text", maxlength: "10",placeholder:"", required: "true" },
        {index : "marca_detalle", name: "Detalles",editable: "true", visible: "true", type: "textarea", maxlength: "10", required: "true"}];


    var edit_options ={	url: "abm_getMarcas",titulo: "Editar",method : "PUT" };
    var add_options ={ url: "abm_getMarcas",titulo: "Agregar",method : "POST" };
    var del_options ={ url: "abm_getMarcas",titulo: "Eliminar",method : "DELETE"};

    var datasource ={
        url: "abm_getMarcas",
        method : "GET",
        datatype: "json",
        pagesize: 10,
        paginate: "false",
        fixedrows: "12"
    };


    var x = $('#table').Grid({  // calls the init method

        Titulo : 'Marcas',
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
