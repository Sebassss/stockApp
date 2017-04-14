jQuery(document).ready(function($)
{

    var Options = [
        {refresh: "true"},
        {add: "true"},
        {edit: "true"},
        {delete: "true"}];

    var colheaders = [
        {index : "rubro_id", name: "id", editable: "false",  visible: "false", type: "text",placeholder:"", maxlength: "10", required: "true" },
        {index : "rubro_nombre", name: "Nombre del rubro",editable: "true", visible: "true", type: "text", maxlength: "10", required: "false" }];


    var edit_options ={	url: "edit.php",titulo: "Editar",method : "UPDATE" };
    var add_options ={ url: "abm_getUsuarios",titulo: "Agregar",method : "POST" };
    var del_options ={ url: "abm_getUsuarios",titulo: "Eliminar",method : "DELETE"};

    var datasource ={
        url: "abm_getRubros",
        method : "POST",
        datatype: "json",
        pagesize: 10,
        paginate: "false",
        fixedrows: "12"
    };


    var x = $('#table').Grid({  // calls the init method

        Titulo : 'Usuarios',
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
