<?php
//guardo posición de menú en la variable session
 $_SESSION['menu'] = "abm_salida";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>
<script type="text/javascript">
	var tmp = "";
	var datos = "";
	
	var articulo_id=0;
	var articulo_cantidad=0;


function mySubmitFunction()
{
  return false;
}

function decodeEntities(encodedString) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
}

	$(document).ready(function(){

		//console.log("listo");
		$.ajax({
	        url: 'http://otrsminsalud.sanjuan.gob.ar/stockapp/public/abm_getArticulos',
	        type: "GET",
	        dataType: "json",
	        success: function(data)
	        {
	            datos = data;
	        },
	        error: function(error)
	        {
	            console.log(error);
	            //myApp.hidePreloader();
	        }

    	});
	});


	function check_stock(val)
	{

		//alert(articulo_cantidad);
		if(articulo_cantidad < val)
		{
			alert("No puedes registrar una salida de stock inexistente.");
		}
	}

	function openModal(id,cant)
	{
		$('#myModal').modal({
			backdrop: 'static',   // This disable for click outside event
    		keyboard: true        // This for keyboard event
		});

		
		articulo_id = id;
		articulo_cantidad = cant;
		$("#cantidaddb").val(cant);
	}

	function continuar()
	{
		if($("#comment").val().trim() == "")
		{
			alert("ingrese un comentario");
			return false;
		}

		if(parseInt(articulo_cantidad) <= 0 )
		{
			alert("La cantidad debe ser mayor a 0");
			return false;
		}

		if(articulo_cantidad < $("#cantidaddb").val())
		{
			alert("No puedes registrar una salida de stock inexistente.");
			return false;
		}

		descontar(articulo_id,articulo_cantidad);

	}

	function descontar(id, cant)
	{
		
		/*
		console.log(id);
		console.log(cant);
		console.log($("#usrid").val());
		console.log($("#comment").val());
		*/

		$.ajax({
        	url: 'http://otrsminsalud.sanjuan.gob.ar/stockapp/public/abm_descArticulos',
            method: "PUT",
            data: {
            	'articulo_id': id,
                'articulo_cantidad': $("#cantidad").val(),
                'usuario_id': $("#usrid").val(),
                'articulo_comentario': $("#comment").val()
                },
                dataType: "json",
                success: function (data) {
                alert("El artículo se descontó correctamente");
                location.reload();
                },
				error: function (error) {
					alert("CUIDADO, no se actualizó el stock chango!!\n" + error);
                }
		});
		
	}

	function buscar(val)
	{
		$("#resultado").empty();	
		tmp = "";
            for(var i=0; i<datos.length;i++)
            {
            	if(datos[i].articulo_nombre.trim().toLowerCase().indexOf(val.toLowerCase())>=0)
            	{
	            	 tmp +=   "<center><br>"+
	            			  "Código Artículo: "+ datos[i].articulo_codigo+
	            			  "</br>"+
							  "<br>"+
	            			  "Nombre: "+ datos[i].articulo_nombre+
	            			  "</br>"+
	            			  "<br>"+
	            			  "Cantidad: "+ datos[i].articulo_cantidad+ " <button type='button' class='btn btn-danger btn-sm' onclick='javascript:openModal("+datos[i].articulo_id+","+datos[i].articulo_cantidad+");'>Registrar salida</button>"+ 
	            			  "</br>"+
	            			  "<br>"+
	            			  "Detalle: "+ decodeEntities(datos[i].articulo_detalle)+
	            			  "</br>"+
	            			  "<br>"+
	            			  "Marca: "+ datos[i].marca_nombre+
	            			  "</br>"+
	            			  "<br>"+
	            			  "Rubro: "+ datos[i].rubro_nombre+
	            			  "</br>"+
							  "<br>"+
	            			  "Depósito: "+ datos[i].deposito_nombre+
	            			  "</br>"+
	            			  "<hr><center>";
					$("#resultado").html(tmp);			            		
					//console.dir(tmp);
				}
            }		 
	}
</script>
<body>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Registrar Salida</h4>
      </div>
      <div class="modal-body">
        <form >

			
			
			<input type="hidden" name="usrid" id="usrid" value="<?php echo $_SESSION['userCredentials']['usuario_id']; ?>" readonly></input> 

        	<div class="form-group">
			    <label for="cantidad">Cantidad en stock</label>
			    <input type="number" class="form-control" name="cantidaddb" id="cantidaddb" placeholder="cantidad..." readonly></input> 
			  </div>

        	<div class="form-group">
			    <label for="cantidad">Cantidad a retirar</label>
				    	<input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="cantidad..." onchange="javascript:check_stock(this.value);"></input> 
			  </div>

			  <div class="form-group">
			    <label for="comment">Comentarios</label>
			    <textarea class="form-control" name="comment" id="comment" placeholder="Comentario..."></textarea> 
			  </div>
			</form>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-success" onclick="javascript:continuar();" >Continuar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>


<div class="box box-primary">
    <section class="content-header">
        <h1>Salida de Stock</h1>
    </section>

    <section class="content">
        <div id="table" style="margin-bottom: 50px">
        	<form onsubmit="return mySubmitFunction()">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Artículo</label>
			    <input type="text" class="form-control" id="articulo" placeholder="ingrese el articulo" onkeyup="javascript:buscar(this.value);">
			  </div>
			</form>
        </div>
        <div id="resultado" name="resultado">
        	Resultado...
        </div>
    </section>
</div>
</body>

</html>


