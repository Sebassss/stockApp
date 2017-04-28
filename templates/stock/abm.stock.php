<?php
//guardo posición de menú en la variable session
 $_SESSION['menu'] = "abm_stock";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo</title>


    <script src="core/Grid/Grid.js"></script>

</head>

<body>

<div class="box box-primary">
    <section class="content-header">
        <h1>Stock</h1>
    </section>

    <section class="content" style="margin-bottom: 100px">
        <div id="table">
            <form action="" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-4">
                        <span class="input-group-addon">Ingrese la cantidad</span>
                        <input id="txt_cant" type="text" class="form-control text-center" value="1" readonly placeholder="Cantidad">
                        <span id="btn_min" class="input-group-addon btn-success">-</span>
                        <span id="btn_max" class="input-group-addon btn-success">+</span>
                    </div>
                    <div class="col-sm-8">
                        <span class="input-group-addon">Ingrese el artículo</span>
                        <input id="txt_articulo" type="text" class="form-control text-center" placeholder="Código de barra del artículo">
                        <span id="btn_add_articulo" class="input-group-addon btn-success">Agregar</span>
                    </div>
                </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Marca</th>
                    <th>Rubro</th>
                    <th>Cantidad</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody id="tbody">
            </table>
        </div>
    </section>
</div>
</body>

</html>

<script>

    var global_cant = [];


    $(document).ready(function(){

        $("#txt_articulo").focus();
    })

    $("#btn_min").click(function(){
        $("#txt_cant").val(parseInt($("#txt_cant").val())-1);
    })

    $("#btn_max").click(function(){
        $("#txt_cant").val(parseInt($("#txt_cant").val())+1);
    })

    $("#btn_add_articulo").click(function(){

        $.ajax({
            url: "getArticuloCodigo?txt_articulo="+$("#txt_articulo").val()+"&txt_cant="+$("#txt_cant").val(),
            dataType: "json",
            method: "get",
            //async:false,
            success: function(response)
            {
                if(response.datos[0][4] < $("#txt_cant").val())
                {
                    alert("La cantidad ingresada supera el stock declarado. Stock Actual: " + response.datos[0][4]);
                }
                else {
                    $("#tbody").append("<tr>" +
                        "<td>" + response.datos[0][1] + "</td>" +
                        "<td>" + response.datos[0][2] + "</td>" +
                        "<td>" + response.datos[0][3] + "</td>" +
                        "<td>" + $("#txt_cant").val() + "</td>" +
                        "<td><span id='btn_add_articulo' class='input-group-addon btn-danger'>Quitar</span></td>" +
                        "</tr>")
                }
            },
            error: function(error)
            {
                alert("El código ingresado no existe.");
            }
        });
    })
</script>
<!--<script src="core/abm.stock.js"></script>-->
