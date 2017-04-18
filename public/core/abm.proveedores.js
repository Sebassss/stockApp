jQuery(document).ready(function($)
{

    var Options = [
        {refresh: "true"},
        {add: "true"},
        {edit: "true"},
        {delete: "true"}];

    var colheaders = [
        {index : "proveedor_id", name: "id", editable: "false",  visible: "false", type: "text",placeholder:"", maxlength: "10", required: "true" },
        {index : "proveedor_nombre", name: "Nombre",editable: "true", visible: "true", type: "text", maxlength: "10",placeholder:"", required: "true" },
        {index : "proveedor_apellido", name: "Apellido",editable: "true", visible: "true", type: "text", maxlength: "10", required: "true"},
        {index : "proveedor_tel", name: "Teléfono",editable: "true", visible: "true", type: "text", maxlength: "10", required: "true"},
        {index : "proveedor_cel", name: "Celular",editable: "true", visible: "true", type: "text", maxlength: "10", required: "true"},
        {index : "proveedor_empresa", name: "Empresa",editable: "true", visible: "true", type: "text", maxlength: "50", required: "true"},
        {index : "proveedor_domicilio", name: "Domicilio",editable: "true", visible: "true", type: "textarea",  required: "true"},
        {index : "proveedor_cuit", name: "CUIT",editable: "true", visible: "true", type: "text", maxlength: "10", required: "true"},
        {index : "proveedor_cuil", name: "CUIL",editable: "true", visible: "true", type: "text", maxlength: "10", required: "true"}];


    var edit_options ={	url: "abm_getProveedores",titulo: "Editar",method : "PUT" };
    var add_options ={ url: "abm_getProveedores",titulo: "Agregar",method : "POST" };
    var del_options ={ url: "abm_getProveedores",titulo: "Eliminar",method : "DELETE"};

    var datasource ={
        url: "abm_getProveedores",
        method : "GET",
        datatype: "json",
        pagesize: 10,
        paginate: "false",
        fixedrows: "12"
    };


    var x = $('#table').Grid({  // calls the init method

        Titulo : 'Proveedores',
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
