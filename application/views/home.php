<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title >MarketMapping</title>
	
	<link rel="stylesheet" href="http://apps.bdimg.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/css.css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">		
    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">	
	
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.boutique_min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>	
	<script type="text/javascript" src="js/html2canvas.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/script.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>    
    <script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
<script type="text/javascript">	
	var company_id=-1;		
	var urlimg="";
	var axisnum=0;
	var logo_show=0;
	
	$(document).ready(function() {
		var $logos=$("#logos"),
			$transfer=$("#squares");
		
		$transfer.droppable({
			accept: "#logos > a",
			//activeClass: "custom-state-active",
			activeClass: "ui-state-highlight",
			drop: function( event, ui ) {
				
				var dropElem = ui.draggable;				
				dropElem.css('position', 'absolute');
				dropElem.css('top', ui.position.top+$(this).offset().top+111);
				dropElem.css('left', ui.position.left+$(this).offset().left-370);

				$(this).append(dropElem);
				//$(this).append(ui.draggable.css({position: 'static'});
				alert(ui.position.top);
				//recycleImage( ui.draggable );
			}
		});
		$('body').on('click','#save_image',function(){
      	    html2canvas($('.myImage'), {
      	            onrendered: function(canvas) {
      		            //$('.imageHolder').html(canvas);
      		                var dataURL = canvas.toDataURL("image/png");
							//window.open(dataURL);
							var link = document.createElement('a');
							link.href = dataURL;
							link.download = 'Marketmap.jpg';
							document.body.appendChild(link);
							link.click();      		                
      		        }
      	    });
			$.post("ajax/save_axis", 
			{								
				axis_top:$('#axis_top').val(),
				axis_bottom:$('#axis_bottom').val(),
				axis_left:$('#axis_left').val(),
				axis_right:$('#axis_right').val()
            },function(data,status){															
			});   
				
      	});
		$('body').on('click','#view_logo',function(){
			if (logo_show){
				$("#sidebar").hide();
				logo_show=0;
			}else{
				$("#sidebar").show();
				logo_show=1;
			}			
		});
		//$("a",$logos).draggable();
		/*$("#draggable1").draggable({			
			stop: function( event, ui ) {
				//alert("wll");
				//alert(ui.position.top);//ui.y;
				//console.log(ui.x);
			}
		});*/
	});

	function search_name(){	
	     	$.post("ajax/get_img", 
			{								
				crunchbase_url:"http://api.crunchbase.com/v/2/organization/"+document.getElementById("company_name").value+"?user_key=7ac52c190afddbbdc5a9227779b7064c",
				anglelist_url:"http://api.angel.co/1/search/slugs?query="+document.getElementById("company_name").value
            },
			function(data,status){
				data = eval("(" + data + ")");
				//console.log(data);
				for (i=0;i<data.length;i++){					
					$("<a class=\"pull-left\" href=\"#\"> <img src=\""+data[i]+"\" ></a>").appendTo("#logos").draggable();
				}													
			});            
	};
	function upload(){		
		var file_data = $("#userfile").prop("files")[0];   
		var form_data = new FormData();                  
		form_data.append("file", file_data);                         
		$.ajax({
                url: "ajax/upload",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
				async:false,
				enctype: 'multipart/form-data',
                complete: function(data){				
					console.log(data['responseText']);							
					$("<a class=\"pull-left\" href=\"#\"> <img src=\""+data['responseText']+"\" ></a>").appendTo("#logos").draggable();					                   
                }
		});				            			     	
	};			
	
</script>		
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" id="view_logo">
					<i class="fa fa-align-justify"></i>
					Logos
				</a>				
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown<button class="btn btn-default" id="save_image" name="submit" type="button">Export Image</button>
                     -->				
                <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" >
                        Save <i class="fa fa-cloud-download"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li id="canvas-style" style="margin-left:10px">							                             
                            <p>
                                <strong>Style:</strong>
                            </p>							
							<button class="btn" id="canvas-white"><img  src="img/style138.png" /></button>
							<button class="btn" id="canvas-gray"><img  src="img/style139.png" /></button>
							<button class="btn" id="canvas-ivory"><img  src="img/style140.png" /> </button>
													
                        </li>
                        <li class="divider"></li>
						<li>
                            <a href="#" id="save_image" >
								Save as PNG  
                            </a>
                        </li>                        
                                                
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation" id="sidebar">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">								
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search..." id="company_name">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" onclick="search_name()" name="submit" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
							<div  class="input-group" style="width:260px;margin-left:15px;height:50px;">
							<span class="input-group-btn">
								<span class="input-group-btn">
								<input type="file" class="filestyle" id="userfile" name='userfile' >
								</span>
                                <span class="input-group-btn">
									
                                    <button class="btn btn-default" onclick="upload()" name="submit" type="button" >
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </span>
							</span>
                            </div>						
                        </li>                        
						<li>
							<div class="logos-class">
								<div id="logos">		
								</div>
							</div>
						</li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
				<div class="myImage">
					<div class="map-title">
						<p contenteditable="true" style="text-align:center">xx vs. competitors</p>     
					</div>
					
					<div id="squares">   
						<div id="upper" style="border-bottom:1px solid;height:450px;width:898px;">   
							<div id="square1" style="border-right: 1px solid;height:450px;width:450px;"></div>	
						</div>		
						<div id="lower" style="height:450px;width:900px;">   
							<div id="square4" style="border-right: 1px solid;height:448px;width:450px;"></div>
						</div>
					</div>	
					<div class="label-top">						   			         		      	  				  
						<input type="text" id="axis_top" onkeyup="autocomplet(this)" placeholder="axis.." style="border: 0px solid;background-color: transparent;">
						<ul id="axis_top_list"></ul>
					</div>
					<div class="label-bottom">
						<input type="text" id="axis_bottom" onkeyup="autocomplet(this)" placeholder="axis.." style="border: 0px solid;background-color: transparent;">
						<ul id="axis_bottom_list"></ul> 			         		      	  				  
					</div>
					<div class="label-left">     			        
						<input type="text" id="axis_left" onkeyup="autocomplet(this)" placeholder="axis.." style="border: 0px solid;background-color: transparent;">
						<ul id="axis_left_list"></ul>
					</div>
					<div class="label-right">   	
						<input type="text" id="axis_right" onkeyup="autocomplet(this)" placeholder="axis.." style="border: 0px solid;background-color: transparent;">
						<ul id="axis_right_list"></ul>
					</div>
				</div>               
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    
<script type="text/javascript">
	$('#canvas-white').click(function(e) {
		e.stopPropagation();
		$('#squares').css('background','#FFFFFF');
	});
	$('#canvas-gray').click(function(e) {
		e.stopPropagation();
		$('#squares').css('background','#C0C0C0');
	});
	$('#canvas-ivory').click(function(e) {
		e.stopPropagation();
		$('#squares').css('background','#FFFFF0');
	});
</script>
</body>

</html>
