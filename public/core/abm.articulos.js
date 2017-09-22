jQuery(document).ready(function($)
{

    var Options = [
        {refresh: "true"},
        {add: "true"},
        {edit: "true"},
        {delete: "true"}];

    var colheaders = [
        {index : "articulo_id", name: "id", editable: "false",  visible: "false", type: "text",placeholder:"", maxlength: "10", required: "true" },
        {index : "proveedor_id", name: "Proveedor",editable: "true", visible: "false", type: "dropdown", url: 'abm_getArticulosProveedor', maxlength: "10", required: "true"},
        {index : "proveedor_nombre", name: "Proveedor",editable: "false", visible: "true", type: "text",  maxlength: "10", required: "true"},
        {index : "marca_id", name: "Marca",editable: "true", visible: "false", type: "dropdown", url: 'abm_getArticulosMarcas', maxlength: "10", required: "true"},
        {index : "marca_nombre", name: "Marca",editable: "false", visible: "true", type: "text",  maxlength: "20", required: "true"},
        {index : "rubro_id", name: "Rubro",editable: "true", visible: "false", type: "dropdown", url: 'abm_getArticulosRubros', maxlength: "10", required: "true"},
        {index : "rubro_nombre", name: "Rubro",editable: "false", visible: "true", type: "text",  maxlength: "10", required: "true"},
        {index : "articulo_codigo", name: "Código de barra",editable: "true", visible: "true", type: "text", maxlength: "50",placeholder:"", required: "true" },
        {index : "articulo_nombre", name: "Nombre del artículo",editable: "true", visible: "true", type: "text", maxlength: "50",placeholder:"", required: "true" },
        {index : "articulo_cantidad", name: "Cantidad",editable: "true", visible: "true", type: "text", maxlength: "20",placeholder:"Cantidad de artículos", required: "true" },
        {index : "articulo_detalle", name: "Detalles",editable: "true", visible: "true", type: "textarea", maxlength: "100", required: "true"}];


    var edit_options ={	url: "abm_getArticulos",titulo: "Editar",method : "PUT" };
    var add_options ={ url: "abm_getArticulos",titulo: "Agregar",method : "POST" };
    var del_options ={ url: "abm_getArticulos",titulo: "Eliminar",method : "DELETE"};

    var datasource ={
        url: "abm_getArticulos",
        method : "GET",
        datatype: "json",
        pagesize: 10,
        paginate: "false",
        fixedrows: "12"
    };


    var x = $('#table').Grid({  // calls the init method

        Titulo : 'Artículos',
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
