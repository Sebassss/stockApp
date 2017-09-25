

function loadCssFile(filename, filetype)
{
    if (filetype=="js"){ //if filename is a external JavaScript file
        var fileref=document.createElement('script')
        fileref.setAttribute("type","text/javascript")
        fileref.setAttribute("src", filename)
    }
    else if (filetype=="css"){ //if filename is an external CSS file
        var fileref=document.createElement("link")
        fileref.setAttribute("rel", "stylesheet")
        fileref.setAttribute("type", "text/css")
        fileref.setAttribute("href", filename)
    }
    if (typeof fileref!="undefined")
        document.getElementsByTagName("head")[0].appendChild(fileref)
}



function loadScript(url, callback)
{

    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                    script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function(){
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}


(function( $ ){

    var criteria,criteria_flag=false;

    var methods = {

                    Serialize: function(el)
                    {
                        var serialized = $(el).serialize();
                        if (!serialized) // not a form
                            serialized = $(el).find('input[name],select[name],textarea[name]').serialize();
                        return serialized;
                    },

                    DropDownFill :  function (id,campo,dato,url,accion)
                    {
                        $.ajax({
                            url: url,
                            dataType: "json",
                            method: "get",
                            //async:false,
                            success: function(response)
                            {
                                //console.dir(campo)
                                for(var  k in response)
                                {
                                    if(dato == response[k].value)
                                    {
                                            $("#" + id + "_field_" + campo).append("<option selected value='" + response[k].value + "'>" + response[k].text + "</option>")
                                    }
                                    else
                                    {
                                        if (accion != 2)
                                        {
                                            $("#" + id + "_field_" + campo).append("<option value='" + response[k].value + "'>" + response[k].text + "</option>")
                                        }
                                    }
                                }


                            },
                            error: function(error)
                            {
                                $("#" + id + "_field_" + campo).append("<option>Error</option>")
                            }
                        });

                    },
    				export2XLS : function(obj)
    				{
						var id = $(obj).attr("id");
						$('#'+id).tableExport({type:'excel',headings: 'true',escape:'false'});
    				},

    				ajaxFnc : function (form,obj, accion)
    				{
    					var ret;
                        var id = $(obj).attr("id");
    					switch(accion)
    					{
    						case 0: /*Agregar*/
    						{
                                tinyMCE.triggerSave();
    							$.ajax({
	                        		type: obj.add_options.method,
			                        data: methods.Serialize($("#"+form)),//$("#"+form).serialize(),
			                        url: obj.add_options.url,
									global:true,
                                    cache:false,
			                        timeout: obj.timeout,
                                    dataType: "json",
			                        success: function(data) 
			                        {
                                        if(data.estado == "true")
                                        {
                                            $("#"+id+"_CrudModal").find("#resulttxt").addClass("alert alert-success");
                                            $("#"+id+"_CrudModal").find("#resulttxt").html("<strong>"+data.mensaje+"</strong>");
                                            $("#"+id+"_CrudModal").find("#resulttxt").show();
                                            setTimeout(function() {
                                            $("#"+id+"_CrudModal .close").click();
                                            methods.getDatos(obj,1,methods.doTable);},1000);
                                            obj.add_options.callback(data);
                                        }
                                        else
                                        {
                                            $("#"+id+"_CrudModal").find("#resulttxt").addClass("alert alert-danger");
                                            $("#"+id+"_CrudModal").find("#resulttxt").html("<strong>"+data.mensaje+"</strong>");
                                            $("#"+id+"_CrudModal").find("#resulttxt").show();
                                        }
										ret = data;
										
	                        		},
	                        		error: function(xhr, resp, text) 
	                        		{
              
						              if(resp === "timeout")
						              {
						                alert("Se ha superado el tiempo de peticion");
						              }
						              else
						              {
						              	alert("Error");
						              }
						              //console.log(xhr, resp, text);
						          }
                    			});
    						}break; 

							case 1: /*Editar*/
    						{
                                tinyMCE.triggerSave();
    							$.ajax({
	                        		type: obj.edit_options.method,
			                        data: methods.Serialize($("#"+form)),//$("#"+form).serialize(),
			                        url: obj.edit_options.url,
									global:true,
                                    cache:false,
			                        timeout: obj.timeout,
                                    dataType: "json",
			                        success: function(data) 
			                        {
										ret = data;
                                        if(data.estado == "true")
                                        {

                                            $("#"+id+"_CrudModal").find("#resulttxt").addClass("alert alert-success");
                                            $("#"+id+"_CrudModal").find("#resulttxt").html("<strong>"+data.mensaje+"</strong>");
                                            $("#"+id+"_CrudModal").find("#resulttxt").show();
                                            setTimeout(function() {
                                                $("#"+id+"_CrudModal .close").click();
                                                methods.getDatos(obj,1,methods.doTable);},1000);
                                        }
                                        else
                                        {
                                            $("#"+id+"_CrudModal").find("#resulttxt").addClass("alert alert-danger");
                                            $("#"+id+"_CrudModal").find("#resulttxt").html("<strong>"+data.mensaje+"</strong>");
                                            $("#"+id+"_CrudModal").find("#resulttxt").show();
                                        }
	                        		},
	                        		error: function(xhr, resp, text) 
	                        		{
						              if(resp === "timeout")
						              {
						                alert("Se ha superado el tiempo de peticion");
						              }
						              else
						              {
						              	alert("Error");
						              }
						              //console.log(xhr, resp, text);
						          }
                    			});
    						}break;    						

							case 2: /*Eliminar*/
    						{
                                tinyMCE.triggerSave();
								$.ajax({
									type: obj.del_options.method,
									data: methods.Serialize($("#"+form)),//$("#"+form).serialize(),
									url: obj.del_options.url,
									global:true,
									cache:false,
									timeout: obj.timeout,
									dataType: "json",
			                        success: function(data) 
			                        {
                                        if(data.estado == "true")
                                        {

                                            $("#"+id+"_CrudModal").find("#resulttxt").addClass("alert alert-success");
                                            $("#"+id+"_CrudModal").find("#resulttxt").html("<strong>"+data.mensaje+"</strong>");
                                            $("#"+id+"_CrudModal").find("#resulttxt").show();
                                            setTimeout(function() {
                                                $("#"+id+"_CrudModal .close").click();
                                                methods.getDatos(obj,1,methods.doTable);},1000);
                                        }
                                        else
                                        {
                                            $("#"+id+"_CrudModal").find("#resulttxt").addClass("alert alert-danger");
                                            $("#"+id+"_CrudModal").find("#resulttxt").html("<strong>"+data.mensaje+"</strong>");
                                            $("#"+id+"_CrudModal").find("#resulttxt").show();
                                        }
                                        ret = data;
	                        		},
	                        		error: function(xhr, resp, text) 
	                        		{
						              if(resp === "timeout")
						              {
						                alert("Se ha superado el tiempo de peticion");
						              }
						              else
						              {
						              	alert("Error");
						              }
						              //console.log(xhr, resp, text);
						          }
                    			});
    						}break; 
    					}
    					return ret;
    				},

    				Sort: function (field, reverse, primer)
    				{
    					var key = primer ? function(x) {return primer(x[field])} :  function(x) {return x[field]};
					   	reverse = !reverse ? 1 : -1;

					   return function (a, b) {
					       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
					     } 
    				},

					getDatos : function (obj,page,callback)
    				{
						$body = $("body");
    					var id = $(obj).attr("id");
    					
	                    //$body.addClass("loading");

    					return $.ajax({
	                        		type: obj.datasource.method,
									global:true,
                                    cache:false,
			                        data: { 
			                        		pagesize: obj.datasource.pagesize, 
			                        	    page: page,
			                        	  },
			                        url: obj.datasource.url,
			                        timeout: obj.timeout,
			                        dataType: "json",
			                        success: function(data)
			                        {

			                        	$("#"+id).empty();
			                        	var params = $.extend ($(this),obj);
			                        	//$body.removeClass("loading");
										callback(obj,data)
			                        },
	                        		error: function(xhr, resp, text) 
	                        		{
						              if(resp === "timeout")
						              {
						                alert("Se ha superado el tiempo de peticion");
						              }
						              else
						              {
						              	alert("Errorrrr");
						              }
						              //console.log(xhr, resp, text);
						          }
                    			});
    				},
    				wanimate : function (div)
    				{
					    var open = $("#"+div).attr('data-easein');
					    if (open == 'shake') {
					      $("#"+div).find('.modal-dialog').velocity('callout.' + open);
					    } else if (open == 'pulse') {
					      $("#"+div).find('.modal-dialog').velocity('callout.' + open);
					    } else if (open == 'tada') {
					      $("#"+div).find('.modal-dialog').velocity('callout.' + open);
					    } else if (open == 'flash') {
					      $("#"+div).find('.modal-dialog').velocity('callout.' + open);
					    } else if (open == 'bounce') {
					      $("#"+div).find('.modal-dialog').velocity('callout.' + open);
					    } else if (open == 'swing') {
					      $("#"+div).find('.modal-dialog').velocity('callout.' + open);
					    } else {
					      $("#"+div).find('.modal-dialog').velocity('transition.' + open);
					    }
					},
    				rowClick: function (id, Columnas)
    				{
    						var tmp = [];
    						for (i=0; i<$("#"+id).find('.highlight td').length; i++)
    						{
    							tmp[i] = $("#"+id).find( ".highlight").find('td').eq(i).html();
    						}
    						return tmp;
    				},
                    doTable : function(obj,dataset)
                              {
                                  console.dir(dataset);
                                  //console.dir(obj);
                                    var id = $(obj).attr("id");
									var display;
                                    var visible = (obj.Visible=="false") ? 'display:none' : '';
                                    var html = "<table id='"+id+"_table' class='table table-striped' style='"+visible+"'><thead>"
                                        html +="<div id="+id+"_buttons></div> <hr>"
                                        html +="<tr>"
                              			
                                        for(i=0;i<obj.Columnas.length; i++)
                                        {
                                        	//if(obj.Columnas[i].visible == "true")
                                        	//{
                                            if(obj.Columnas[i].visible !="true")
                                            {
                                                display = "display:none";
                                            }
                                            else
                                            {
                                                display = "";
                                            }

                                        		if(obj.Columnas[i].index == criteria && criteria_flag==true)
                                        		{
													html += "<th style='"+display+"' id="+id+"_header_"+obj.Columnas[i].index+"><img src='core/Grid/inc/img/sort_desc.png'>"+obj.Columnas[i].name+"</th>";
                                        		}
                                        		else
                                        		{
                                            		html += "<th style='"+display+"' id="+id+"_header_"+obj.Columnas[i].index+"><img src='core/Grid/inc/img/sort_asc.png'>"+obj.Columnas[i].name+"</th>";
                                            	}
                                        	//}
                                        	//else
                                        	////	html += "<th style=\"display:none\" >"+obj.Columnas[i].name+"</th>";
                                        	//}
                                        }

										html +="</tr>"
                                        html +="</thead>"
                                        html +="<tbody>"
                                        html +="<tr class='clickable-row' data-href='url://#'></tr>"

                                        dataset.values.sort(methods.Sort(criteria, criteria_flag, function(a){return a}));
                                        
                                        var fixed_rows = parseInt(obj.datasource.fixedrows) - parseInt(dataset.values.length)  ;

                                        for(var k in dataset.values  )
                                        {
                                        	var cant_columns=0, cant_columns_query=0
                                        	html+="<tr>"
											for(i=0;i<obj.Columnas.length;i++)
	                                        {
	                                        	cant_columns=i+1
	                                        	var t = obj.Columnas[i].index

	                                        		if(dataset.values[k].hasOwnProperty(t)==true)
	                                        		{
	                                        			cant_columns_query++;
                                                        if(obj.Columnas[i].visible !="true")
                                                        {
                                                            display = "display:none";
                                                        }
                                                        else
                                                        {
                                                            display = "";
                                                        }

                                                        var data = dataset.values[k][t].replace("&lt;","")

														data = data.replace("p&gt;","");
                                                        data = data.replace("&lt;","<");
                                                        data = data.replace("p&gt;",">");
                                                        data = data.replace("&quot;","'");

                                                        data = data.replace("p&gt;","");
                                                        data = data.replace("&lt;","<");
                                                        data = data.replace("p&gt;",">");
                                                        data = data.replace("&quot;","'");




					                                    	html+="<td id="+t+"_"+k+" style='"+display+"'>"+data+"</td>"
																//$("#"+t+"_"+k).html(dataset.values[k][t]);

				                                    }
											}
											html+="</tr>"
                                        }

                                        if(fixed_rows > 0)
                                        {
	                                        for(p=0; p<fixed_rows;p++ )
	                                        {
	                                        	html+="<tr class='empty_td'>"
	                                        	for(i=0;i<obj.Columnas.length;i++)
		                                        {
                                                    if(obj.Columnas[i].visible == "true")
                                                    {
                                                        html += "<td>&nbsp;</td>"
                                                    }
	                                        	}
	                                        	html+="</tr>"		
	                                        }
                                    	}


                                        if(cant_columns !=cant_columns_query)
                                        {
                                        	alert("Las columnas no concuerdan con los resultados devueltos")
                                        }
                                        else
                                        {

	                                        html +="</tbody></table>"
		                                    html +="<ul class='pagination' style='"+visible+"' > <span class='pagination-info'>Mostrando "+dataset.info[0].rows+" resultados de "+dataset.info[0].total_rows+" en un total de "+dataset.info[0].page_count+" páginas.</span>"
	                                        for(t=0; t<dataset.info[0].page_count;t++)
	                                        {
	                                        	if(parseInt(t+1) == dataset.info[0].page)
	                                        	{
													html +="<li id='"+id+"_page-"+t+"' class='active'><a href='javascript:;'>"+parseInt(t+1)+"</a></li>"
												}
												else
												{
													html +="<li id='"+id+"_page-"+t+"'><a href='javascript:;'>"+parseInt(t+1)+"</a></li>"
												}
											}


											html +="</ul>"


	                                        $("#"+id).append(html);


                                            for(var k in dataset.values  )
                                            {
                                                var cant_columns=0, cant_columns_query=0

                                                for(i=0;i<obj.Columnas.length;i++)
                                                {
                                                    cant_columns=i+1
                                                    var t = obj.Columnas[i].index




                                                        //$("#"+t+"_"+k).append(dataset.values[k][t]);

                                                }

                                            }

											for(t=0; t<dataset.info[0].page_count;t++)
	                                        {
	                                        	
	                                        	$("#"+ id + "_page-"+t+"").click(function () 
	                                        	{
	                                        		page = $(this).attr("id").split('-');
	                                        		methods.getDatos(obj,parseInt(page[1])+1,methods.doTable); 
	                                        	});
	                                    	}


	                                        $("#"+id).prepend("<h4>"+obj.Titulo+"</h4>");
	                       
	                                        var btn_options = "<hr>";    
	                                        for(i=0; i<obj.ABM.length;i++)
	                                        {
												obj.ABM[i].text = typeof(obj.ABM[i].text) == 'undefined' ? "" : obj.ABM[i].text;
	                                            if(obj.ABM[i].refresh == "true")
	                                                btn_options += "<button id='"+id+"_refresh' class='btn btn-primary margin3' data-toggle='tooltip' data-placement='top' title='Refrescar'><i class='grid-icon icon-refresh'>&#xe800;</i>"+obj.ABM[i].text+"</button> ";

	                                            if(obj.ABM[i].add == "true")
	                                                btn_options += "<button id='"+id+"_add' class='btn btn-success margin3' data-toggle='tooltip' data-placement='top' title='Agregar'><i class='grid-icon icon-add'>&#xe806;</i> "+obj.ABM[i].text+"</button> ";
	                                        
	                                             if(obj.ABM[i].edit == "true")
	                                                btn_options += "<button id='"+id+"_edit' class='btn btn-warning margin3' data-toggle='tooltip' data-placement='top' title='Editar'><i class='grid-icon icon-edit'>&#xe804;</i>"+obj.ABM[i].text+"</button> ";

	                                             if(obj.ABM[i].delete == "true")
	                                                btn_options += "<button id='"+id+"_del'  class='btn btn-danger margin3' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='grid-icon icon-del'>&#xe803;</i>"+obj.ABM[i].text+"</button> ";
	                                        }

	                                        if(obj.export2XLS == "true")
	                                        {
	                                        	btn_options += "<button id='"+id+"_XLSX' class='btn btn-primary margin3' data-toggle='tooltip' data-placement='top' title='Exportar a excel'><i class='grid-icon icon-xls'>&#xe805;</i> </button>";
	                                        }
	                                        $("#"+id+"_buttons").append(btn_options);    

	                                        $("#"+ id + "_refresh").click(function () { methods.getDatos(obj,1,methods.doTable); });
	                                        $("#"+ id + "_add").click(function () { methods.doModal(params,0); });
	                                        $("#"+ id + "_edit").click(function () { methods.doModal(params,1); });
	                                        $("#"+ id + "_del").click(function () { methods.doModal(params,2); });
	                                        $("#"+ id + "_XLSX").click(function () { methods.export2XLS(obj); });

	                                        for(i=0;i<obj.Columnas.length;i++)
	                                        {
                                        		$("#"+id+"_header_"+obj.Columnas[i].index).click(function()
                                        		{

                                        			var res = $(this).attr("id").split("_", 3);
                                        			criteria = res[2];
                                        			if(criteria_flag == false)
                                        			{
                                        				criteria_flag=true;
                                        			}
                                        			else
                                        			{
                                        				criteria_flag=false;
                                        			}
                                        			//$("#"+id).empty();   
                                        			methods.getDatos(obj,dataset.info[0].page,methods.doTable);
                                        			
                                       			})
	                                        }
											var params = $.extend ($(this),obj);
	                                        
	                                        $("#"+id).on('click', 'tbody tr', function(event) 
	                                        {
	                                        	if($(this).attr("class") !='empty_td')
	                                        	{
	                                            	$(this).addClass('highlight').siblings().removeClass('highlight');
	                                        	}
	                                        });
	                                    }
                              },
                    doModal : function(obj,accion) 
                              {    		var wnd = false;
                              			var id = $(obj).attr("id");
                              			switch(accion)
										{
											case 0: /*Agregar*/
											{
												wnd=true;

												var html =  '<div id="'+id+'_CrudModal" class="modal"  data-easein="flipBounceYIn" tabindex="-1" data-keyboard="false" data-backdrop="static"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">';
                                                var rdm = Math.floor((Math.random() * 100) + 1);
		                                        html += '<div class="modal-dialog">';
		                                        html += '<div class="modal-content">';
		                                        html += '<div class="modal-header">';
		                                        html += '<a class="close" data-dismiss="modal">×</a>';
		                                        html += '<h4>'+obj.add_options.titulo+'</h4>'
												html += '<div id="resulttxt" name="resulttxt"  style="display:none;text-align:center"></div>'
		                                        html += '</div>';
		                                        html += '<div class="modal-body" style="height:400px; overflow:auto">';
		                                        html += '<div id="'+id+'_form" action="#" method="post" >';

		                                        /****/
                                                var display;


		                                        for(i=0;i<obj.Columnas.length;i++)
		                                        {

		                                            switch(obj.Columnas[i].type)
		                                            {
		                                                case "text":
		                                                {
                                                            if(obj.Columnas[i].editable !="true")
                                                            {
                                                                display = "display:none";
                                                            }
                                                            else
                                                            {
                                                                display = "";
                                                            }

                                                                var required = (obj.Columnas[i].required == "true") ? 'required' : '';
                                                                if (typeof(obj.Columnas[i].placeholder) == 'undefined') {
                                                                    placeholder = "";
                                                                }
                                                                else {
                                                                    placeholder = obj.Columnas[i].placeholder;
                                                                }
                                                                html += "<div class='form-group' style='"+display+"'>"
                                                                html += "  <label for='" + id + "_field_" + obj.Columnas[i].index + "'>" + obj.Columnas[i].name + ":</label>"
                                                                html += "  <input type='" + obj.Columnas[i].type + "' class='form-control' value='' name='" + id + "_field_" + obj.Columnas[i].index + "' id='" + id + "_field_" + obj.Columnas[i].index + "' placeholder='" + placeholder + "' style='" + obj.Columnas[i].style + "' maxlength='" + obj.Columnas[i].maxlength + "' " + required + " >"
                                                                html += "</div>"

		                                                }break;

                                                        case "dropdown":
                                                        {
															console.log("dentra")
                                                            if(obj.Columnas[i].editable !="true")
                                                            {
                                                                display = "display:none";
                                                            }
                                                            else
                                                            {
                                                                display = "";
                                                            }

                                                            var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                            html += "<div class='form-group' style='"+display+"'>"
                                                            html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                            html += "  <select onchange=''  class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" />"
                                                            html += "</div>"


                                                        }break;

                                                        case "password":
                                                        {
                                                            if(obj.Columnas[i].editable !="true")
                                                            {
                                                                display = "display:none";
                                                            }
                                                            else
                                                            {
                                                                display = "";
                                                            }

                                                            var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                            html += "<div class='form-group' style='"+display+"'>"
                                                            html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                            html += "  <input value='' type='"+obj.Columnas[i].type[0]+"' class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" >"
                                                            html += "</div>"
                                                        }break;

                                                        case "textarea":
                                                        {
                                                            var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                            html += "<div class='form-group' style='"+display+"'>"
                                                            html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                            html += "  <textarea  class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" ></textarea>"
                                                            html += "</div>"
                                                        }break;
		                                            }
		                                        }
		                                        /****/
		                                        //html += content;
		                                        html += '</div>';
		                                        html += '</div>';
		                                        html += '<div class="modal-footer">';
		                                        html += '<span class="btn btn-primary" data-dismiss="modal">Cerrar</span>';
		                                        html += '<span id="btnGuardar" class="btn btn-success" >Guardar</span>';
		                                        html += '</div>';  // content
		                                        html += '</div>';  // dialog
		                                        html += '</div>';  // footer
		                                        html += '</div>';  // modalWindow

												console.dir(html);
		                                        $('body').append(html);

                                                for(i=0;i<obj.Columnas.length;i++)
                                                {
                                                    $("#" + id + "_field_" + obj.Columnas[i].index).attr('autocomplete','new-password')



                                                        switch($("#" + id + "_field_" + obj.Columnas[i].index).prop('nodeName'))
                                                        {
                                                            case "SELECT":
                                                            {
                                                                var campo = obj.Columnas[i].index;
                                                                var dato = "";//; data[i];
                                                                var url = obj.Columnas[i].url;
																console.log("hola");
                                                                methods.DropDownFill(id, campo, dato, url, accion);
                                                            }break;

                                                            case "TEXTAREA":
                                                            {
                                                                var oldEditor = tinyMCE.get(id + "_field_" + obj.Columnas[i].index);
                                                                if (oldEditor != undefined) {
                                                                    tinymce.remove(oldEditor);
                                                                }

                                                                tinymce.init({
                                                                    selector: "textarea#"+ id + "_field_" + obj.Columnas[i].index,
                                                                    height: obj.Columnas[i].type[1],
                                                                    language: 'es',
                                                                    entity_encoding: "raw",
                                                                    relative_urls : false,
                                                                    convert_urls : false,

                                                                    menubar: false,
                                                                    plugins: [
                                                                        'advlist autolink lists link image charmap print preview anchor',
                                                                        'searchreplace visualblocks code fullscreen',
                                                                        'insertdatetime media table contextmenu paste code'
                                                                    ],
                                                                    toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                                                                });

                                                                $(document).on('focusin', function(e) {
                                                                    if ($(e.target).closest(".mce-window").length) {
                                                                        e.stopImmediatePropagation();
                                                                    }
                                                                });
                                                            }break;
                                                        }


                                                }

                                        		$("#btnGuardar").click(function(){

                                        			var params = $.extend ($(this),obj);

                                        			methods.ajaxFnc(id+"_form",params, accion)
                                        		})

											}break;

											case 1: /*Editar*/
											{
                                                console.dir(obj);
												var data = methods.rowClick(id);
												if(data.length > 0 )
												{
													wnd=true;
													var html =  '<div id="'+id+'_CrudModal" class="modal"  data-easein="flipBounceYIn" tabindex="-1" data-keyboard="false" data-backdrop="static"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">';

			                                        html += '<div class="modal-dialog">';
			                                        html += '<div class="modal-content">';
			                                        html += '<div class="modal-header">';
			                                        html += '<a class="close" data-dismiss="modal">×</a>';
			                                        html += '<h4>'+obj.edit_options.titulo+'</h4>'
                                                    html += '<div id="resulttxt" name="resulttxt"  style="display:none;text-align:center"></div>'
			                                        html += '</div>';
			                                        html += '<div class="modal-body" style="height:400px; overflow:auto">';
			                                        html += '<div id="'+id+'_form" >';
			                                        /****/

                                                    var display;
			                                        for(i=0;i<obj.Columnas.length;i++)
			                                        {
			                                            switch(obj.Columnas[i].type)
			                                            {
			                                                case "text":
			                                                {

                                                                if(obj.Columnas[i].editable !="true")
                                                                {
                                                                    display = "display:none";
                                                                }
                                                                else
                                                                {
                                                                    display = "";
                                                                }

				                                                 	var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
				                                                 	html += "<div class='form-group' style='"+display+"'>"
				                                                 	html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
				                                                 	html += "  <input type='"+obj.Columnas[i].type[0]+"' class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" >"
				                                                 	html += "</div>"

			                                                }break;

                                                            case "dropdown":
                                                            {

                                                                if(obj.Columnas[i].editable !="true")
                                                                {
                                                                    display = "display:none";
                                                                }
                                                                else
                                                                {
                                                                    display = "";
                                                                }

                                                                var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                                html += "<div class='form-group' style='"+display+"'>"
                                                                html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                                html += "  <select  class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" />"
                                                                html += "</div>"


                                                            }break;

                                                            case "password":
                                                            {
                                                                if(obj.Columnas[i].editable !="true")
                                                                {
                                                                    display = "display:none";
                                                                }
                                                                else
                                                                {
                                                                    display = "";
                                                                }

                                                                var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                                html += "<div class='form-group' style='"+display+"'>"
                                                                html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                                html += "  <input type='"+obj.Columnas[i].type[0]+"' class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" >"
                                                                html += "</div>"
                                                            }break;

                                                            case "textarea":
                                                            {
                                                                var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                                html += "<div class='form-group' style='"+display+"'>"
                                                                html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                                html += "  <textarea  class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" ></textarea>"
                                                                html += "</div>"
                                                            }break;
			                                            }
			                                        }
			                                        /****/
			                                        //html += content;
			                                        html += '</div>';
			                                        html += '</div>';
			                                        html += '<div class="modal-footer">';
			                                        html += '<span class="btn btn-primary" data-dismiss="modal">Cerrar</span>';
			                                        html += '<span id="btnGuardar" class="btn btn-success" >Guardar</span>';
			                                        html += '</div>';  // content
			                                        html += '</div>';  // dialog
			                                        html += '</div>';  // footer
			                                        html += '</div>';  // modalWindow
			                                        $('body').append(html);



	                                        		for(i=0; i<data.length;i++)
	                                        		{
                                                        //console.log($("#" + id + "_field_" + obj.Columnas[i].index).val(data[i]))
                                                        switch($("#" + id + "_field_" + obj.Columnas[i].index).prop('nodeName'))
                                                        {

                                                            case "INPUT":
                                                            {
                                                                $("#" + id + "_field_" + obj.Columnas[i].index).val(data[i]);
                                                                console.log(data[i]);
                                                            }break;

                                                            case "SELECT":
                                                            {
                                                                var campo = obj.Columnas[i].index;
                                                                var dato =  data[i];
                                                                var url = obj.Columnas[i].url;
                                                                methods.DropDownFill(id, campo, dato, url, accion);
                                                            }break;

                                                            case "TEXTAREA":
                                                            {

                                                                $("#" + id + "_field_" + obj.Columnas[i].index).html(data[i]);
                                                                var oldEditor = tinyMCE.get(id + "_field_" + obj.Columnas[i].index);
                                                                if (oldEditor != undefined) {
                                                                    tinymce.remove(oldEditor);
                                                                }

                                                                tinymce.init({
                                                                    selector: "textarea#"+ id + "_field_" + obj.Columnas[i].index,
                                                                    height: obj.Columnas[i].type[1],
                                                                    language: 'es',
                                                                    entity_encoding: "raw",
                                                                    relative_urls : false,
                                                                    convert_urls : false,

                                                                    menubar: false,
                                                                    plugins: [
                                                                        'advlist autolink lists link image charmap print preview anchor',
                                                                        'searchreplace visualblocks code fullscreen',
                                                                        'insertdatetime media table contextmenu paste code'
                                                                    ],
                                                                    toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                                                                });

                                                                $(document).on('focusin', function(e) {
                                                                    if ($(e.target).closest(".mce-window").length) {
                                                                        e.stopImmediatePropagation();
                                                                    }
                                                                });
                                                            }break;
                                                        }


                                                    }

	                                        		$("#btnGuardar").click(function(){
	                                        			var params = $.extend ($(this),obj);
	                                        			methods.ajaxFnc(id+"_form",params, accion)
	                                        		})
	                                        	}
	                                        	else
	                                        	{
	                                        		alert("Seleccione una fila.")
	                                        	}

											}break;

											case 2: /*Eliminar*/
											{
												var data = methods.rowClick(id);
												if(data.length > 0 )
												{
													wnd=true;
													var html =  '<div id="'+id+'_CrudModal" class="modal"  data-easein="flipBounceYIn" tabindex="-1" data-keyboard="false" data-backdrop="static"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">';

			                                        html += '<div class="modal-dialog">';
			                                        html += '<div class="modal-content">';
			                                        html += '<div class="modal-header">';
			                                        html += '<a class="close" data-dismiss="modal">×</a>';
			                                        html += '<h4>'+obj.del_options.titulo+'</h4>'
                                                    html += '<div id="resulttxt" name="resulttxt"  style="display:none;text-align:center"></div>'
			                                        html += '</div>';
			                                        html += '<div class="modal-body" style="height:400px; overflow:auto">';
			                                        html += '<div id="'+id+'_form" action="#" method="post" autocomplete="off">';
			                                        /****/

			                                        var display;
			                                        for(i=0;i<obj.Columnas.length;i++)
			                                        {
			                                            switch(obj.Columnas[i].type)
			                                            {
			                                                case "text":
			                                                {
			                                                	if(obj.Columnas[i].editable !="true")
			                                                	{
			                                                		display = "display:none";
																}
																else
                                                                {
                                                                    display = "";
                                                                }
				                                                    var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                                    html += "<div class='form-group' style='"+display+"'>"
                                                                    html += "  <label for='" + id + "_field_" + obj.Columnas[i].index + "'>" + obj.Columnas[i].name + ":</label>"
                                                                    html += "  <input readonly type='" + obj.Columnas[i].type[0] + "' class='form-control' value='' name='" + id + "_field_" + obj.Columnas[i].index + "' id='" + id + "_field_" + obj.Columnas[i].index + "'  style='" + obj.Columnas[i].style + "' maxlength='" + obj.Columnas[i].maxlength + "' " + required + " >"
                                                                    html += "</div>"

			                                                }break;

                                                            case "dropdown":
                                                            {

                                                                if(obj.Columnas[i].editable !="true")
                                                                {
                                                                    display = "display:none";
                                                                }
                                                                else
                                                                {
                                                                    display = "";
                                                                }

                                                                var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                                html += "<div class='form-group' style='"+display+"'>"
                                                                html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                                html += "  <select class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" />"
                                                                html += "</div>"


                                                            }break;

                                                            case "password":
                                                            {
                                                                if(obj.Columnas[i].editable !="true")
                                                                {
                                                                    display = "display:none";
                                                                }
                                                                else
                                                                {
                                                                    display = "";
                                                                }

                                                                var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                                html += "<div class='form-group' style='"+display+"'>"
                                                                html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                                html += "  <input readonly type='"+obj.Columnas[i].type[0]+"' class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" >"
                                                                html += "</div>"
                                                            }break;

                                                            case "textarea":
                                                            {
                                                                var required =  (obj.Columnas[i].required == "true") ? 'required' : '';
                                                                html += "<div class='form-group' style='"+display+"'>"
                                                                html += "  <label for='"+id+"_field_"+obj.Columnas[i].index+"'>"+obj.Columnas[i].name+":</label>"
                                                                html += "  <textarea   class='form-control' name='" + id + "_field_" + obj.Columnas[i].index + "'  id='"+id+"_field_"+obj.Columnas[i].index+"' style='"+obj.Columnas[i].style+"' maxlength='"+obj.Columnas[i].maxlength+"' " + required +" ></textarea>"
                                                                html += "</div>"
                                                            }break;
			                                            }
			                                        }
			                                        /****/
			                                        //html += content;
			                                        html += '</div>';
			                                        html += '</div>';
			                                        html += '<div class="modal-footer">';
			                                        html += '<span class="btn btn-primary" data-dismiss="modal">Cerrar</span>';
			                                        html += '<span id="btnGuardar" class="btn btn-danger" >Eliminar</span>';
			                                        html += '</div>';  // content
			                                        html += '</div>';  // dialog
			                                        html += '</div>';  // footer
			                                        html += '</div>';  // modalWindow
			                                        $('body').prepend(html);

                                                    for(i=0;i<data.length;i++)
                                                    {

                                                        switch($("#" + id + "_field_" + obj.Columnas[i].index).prop('nodeName'))
                                                        {
                                                            case "INPUT":
                                                            {
                                                                $("#" + id + "_field_" + obj.Columnas[i].index).val(data[i]);
                                                            }break;

                                                            case "SELECT":
                                                            {
                                                                var campo = obj.Columnas[i].index;
                                                                var dato =  data[i];
                                                                var url = obj.Columnas[i].url;
                                                                methods.DropDownFill(id, campo, dato, url, accion);
                                                            }break;

                                                            case "TEXTAREA":
                                                            {
                                                                $("#" + id + "_field_" + obj.Columnas[i].index).val(data[i]);
                                                                var oldEditor = tinyMCE.get(id + "_field_" + obj.Columnas[i].index);
                                                                if (oldEditor != undefined) {
                                                                    tinymce.remove(oldEditor);
                                                                }

                                                                tinymce.init({
                                                                    selector: "textarea#"+ id + "_field_" + obj.Columnas[i].index,
                                                                    height: obj.Columnas[i].type[1],
                                                                    language: 'es',
                                                                    entity_encoding: "raw",
                                                                    relative_urls : false,
                                                                    convert_urls : false,

                                                                    menubar: false,
                                                                    readonly:1,
                                                                    plugins: [
                                                                        'advlist autolink lists link image charmap print preview anchor',
                                                                        'searchreplace visualblocks code fullscreen',
                                                                        'insertdatetime media table contextmenu paste code'
                                                                    ],
                                                                    toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                                                                });

                                                                $(document).on('focusin', function(e) {
                                                                    if ($(e.target).closest(".mce-window").length) {
                                                                        e.stopImmediatePropagation();
                                                                    }
                                                                });
                                                            }break;
                                                        }


                                                        // if($("#"+id+"_field_"+obj.Columnas[i].index).prop('nodeName') == 'INPUT')
                                                        // {
                                                        //     $("#" + id + "_field_" + obj.Columnas[i].index).val(data[i]);
                                                        // }
                                                        // else
                                                        // {
                                                        //
                                                        //     var campo =obj.Columnas[i].index;
                                                        //     var dato = data[i];
                                                        //     var url = obj.Columnas[i].type[1];
                                                        //     methods.DropDownFill(id, campo,dato,url,accion);
                                                        //
                                                        // }

                                                    }

	                                        		$("#btnGuardar").click(function(){
	                                        			var params = $.extend ($(this),obj);
	                                        			methods.ajaxFnc(id+"_form",params, accion)
	                                        		})
	                                        	}
	                                        	else
	                                        	{
	                                        		alert("Seleccione una fila.")
	                                        	}												
											}break;
										}
                                      	
                                        /*Animacion aleatoria*/
                                        //var rdm = 7;//Math.floor(Math.random() * 11) + 1;
                                        if(wnd == true) //si se va a mostrar el modal flag
                                        {
								            switch(obj.animate)
								            {
								                case 1:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','slideDownIn');
								                }break;

								                case 2:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','flipXIn');
								                }break;

								                case 3:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','flipYIn');
								                }break;

								                case 4:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','flipBounceXIn');                  
								                }break;

								                case 5:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','swoopIn');                  
								                }break;

								                case 6:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','whirlIn');                  
								                }break;

								                case 7:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','bounceLeftIn');                  
								                }break;                

								                case 8:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','perspectiveUpIn');                  
								                }break;                

								                case 9:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','perspectiveRightIn');                  
								                }break;

								                case 10:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','swing');                  
								                }break;                                

								                case 11:
								                {
								                  $("#"+id+"_CrudModal" ).attr('data-easein','tada');                  
								                }break;                                
								            }         
								            methods.wanimate(id+"_CrudModal");
	                                        /*fin animacion aleatoria*/
                                            $("#"+id+"_CrudModal").find('.modal-dialog').css({width:'80%', height:'auto','max-height':'100%'});
	                                        $("#"+id+"_CrudModal").modal();
	                                        $("#"+id+"_CrudModal").modal('show');
	                                        $("#"+id+"_CrudModal").on('hidden.bs.modal', function (e)
	                                        {
	                                            $(this).remove();
	                                        });
	                                    }
                              },
                  };


            $.fn.Grid = function(config) 
            {
            	
            	/*Carga dependencias en orden*/
            	loadCssFile("core/Grid/inc/tableexport.css", "css") //dynamically load and add this .js file
				loadCssFile("core/Grid/inc/Grid.css", "css") //dynamically load and add this .js file

				loadScript("core/Grid/inc/velocity.min.js", function()
				{
				    loadScript("core/Grid/inc/velocity.ui.min.js",function()
				    {
						loadScript("core/Grid/inc/FileSaver.js",function()
						{
							loadScript("core/Grid/inc/tableexport.js",function()
							{
								loadScript("core/Grid/inc/jquery.base64.js",function()
								{
                                    loadScript("core/Grid/inc/tinymce.min.js",function()
                                    {

                                    })

				    			})

				    		})

				    	})
				    })
				});



                var obj = $.extend ($(this),config);
                methods.getDatos(obj,1,methods.doTable);
				//methods.fillTable(obj);
                return $.extend ($(this),config);
            };

})(jQuery);


