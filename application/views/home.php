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
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">		
    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">	
	<!-- Custom Fonts -->
    <link href="font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/css.css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
	
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
			$trashcan=$("#trash-can");
		
		$transfer.droppable({
			accept: "#logos > a",
			//activeClass: "custom-state-active",
			activeClass: "ui-state-highlight",
			drop: function( event, ui ) {				
				$.ui.ddmanager.current.cancelHelperRemoval = true;
				var dropElem = ui.helper;//ui.draggable;				
				dropElem.css('position', 'absolute');
				var pos=ui.helper.position();
				alert($(this).offset().left+","+$(this).offset().top+","+pos.left+","+pos.top+","+event.pageX+","+event.pageY+","+event.offsetX+","+event.offsetY);
				if ((event.pageX-event.offsetX)<pos.left){
					dropElem.css('top', pos.top+event.pageY-58);
					dropElem.css('left', pos.left);
				}else{
					dropElem.css('top', event.pageY-event.offsetY);
					dropElem.css('left', event.pageX-event.offsetX);
				}
				//dropElem.css('z-index', 100000);
				dropElem.addClass('canvas-image');
				dropElem.draggable();
				$(this).append(dropElem);
				ui.draggable.remove();
			}
		});
		
		$trashcan.droppable({
			//accept: "#logos > a",
			//activeClass: "custom-state-active",
			activeClass: "ui-state-highlight",
			drop: function( event, ui ) {				
				var dropElem = ui.draggable;
				dropElem.remove();				
			}
		});
		$trashcan.click(function() {
			$("#logos > a").remove();
		});
		$("#company_name").keyup(function(event){
			if(event.keyCode == 13){
				$("#search-icon").click();
			}
		});
		$('body').on('click','#save_image',function(){
      	    html2canvas($('#myImage'), {
      	            onrendered: function(canvas) {
      		            //$('.imageHolder').html(canvas);
      		                var dataURL = canvas.toDataURL("image/png");
							//window.open(dataURL);
							var link = document.createElement('a');
							link.href = dataURL;
							link.download = 'Marketmap.png';
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
	});
	
	function clear_all(){		
		if (confirm("Are you sure you want to clear the map?") == true) {
			$(".canvas-image").remove();
			$('#axis_top').val('');
			$('#axis_bottom').val('');
			$('#axis_left').val('');
			$('#axis_right').val('');
			$('#canvas_title').val('');
		} 			
	}
	function search_name(){	
			//$('#logos').html('<img src="http://preloaders.net/preloaders/287/Filling%20broken%20ring.gif"> loading...');
			//$('#search-icon').toggleClass('fa-search fa-spinner');
			if (document.getElementById("company_name").value==''){
				alert("Please input company name!");
				return;
			}
			
			if (document.getElementsByName(document.getElementById("company_name").value).length>0){
				alert("Oops! You already searched this company!");
				return;
			}
			$('#search-icon').html('<i class="fa fa-spin fa-spinner"></i>');
	     	$.post("ajax/get_img", 
			{								
				crunchbase_url:"http://api.crunchbase.com/v/2/organization/"+document.getElementById("company_name").value+"?user_key=7ac52c190afddbbdc5a9227779b7064c",
				anglelist_url:"http://api.angel.co/1/search/slugs?query="+document.getElementById("company_name").value
            },
			function(data,status){
				data = eval("(" + data + ")");
				//console.log(data);
				for (i=0;i<data.length;i++){
					if (data[i]==0){
						alert("Company not found! Try another one!");
						break;						
					};
					$("<a class=\"pull-front\" name=\""+document.getElementById("company_name").value+"\" href=\"#\"> <img src=\""+data[i]+"\" ></a>").appendTo("#logos").draggable({
						//revert: 'invalid',
						helper: function(){
							$copy = $(this).clone();
							return $copy;
						},
						start: function(event, ui) {
							dropped = false;
							$(this).addClass("hide");
						},
						stop: function(event, ui) {
							if (dropped==true) {
								$(this).remove();
							} else {
								$(this).removeClass("hide");
							}
							//$('#'+$(this).attr('id')).draggable({revert: 'invalid'});
						}       
					});					                
				}													
				$('#search-icon').html('<i class="fa fa-search"></i>');
			});            
	};
	function upload(){						
		var file_data = $("#userfile").prop("files")[0];   		
		var fileName = $("#userfile").val();
		
		if(fileName.lastIndexOf("png")===fileName.length-3 || fileName.lastIndexOf("jpg")===fileName.length-3){								
			$('#upload-icon').html('<i class="fa fa-spin fa-spinner"></i>');
			var form_data = new FormData();                  
			form_data.append("file", file_data);                         
			$.ajax({
                url: "ajax/upload",               
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
				enctype: 'multipart/form-data',

                complete: function(data){				
					console.log(data['responseText']);							
					$("<a class=\"pull-front\" href=\"#\"> <img src=\""+data['responseText']+"\" ></a>").appendTo("#logos").draggable({
						//revert: 'invalid',
						helper: function(){
							$copy = $(this).clone();
							return $copy;
						},
						start: function(event, ui) {
							dropped = false;
							$(this).addClass("hide");
						},
						stop: function(event, ui) {
							if (dropped==true) {
								$(this).remove();
							} else {
								$(this).removeClass("hide");
							}
							//$('#'+$(this).attr('id')).draggable({revert: 'invalid'});
						}       
					});					                   					
					$('#upload-icon').html('<i class="fa fa-upload"></i>');					
                }
			});				            			     	
		}else{
			alert("Not file choosen!");
		}
	};			
	
</script>		
</head>

<body>

    <div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="welcome">MarketMap</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="about">About</a>
                    </li>
                    <li class="page-scroll">
                        <a href="links">Links</a>
                    </li>
                    <li class="page-scroll">
                        <a href="blog">Why Market Maps?</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

            <div class="navbar-default sidebar" role="navigation" id="sidebar">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">								
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search for Logo" id="company_name">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" onclick="search_name()" name="submit" type="button" id="search-icon">
                                        <i class="fa fa-search" ></i>
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
									
                                    <button class="btn btn-default" onclick="upload()" name="submit" type="button" id="upload-icon">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </span>
							</span>
                            </div>						
                        </li>                        
						<li>
							<div class="logos-class" style="height:400px">
								<div id="logos">		
								</div>
							</div>
						</li>
						<ul>

						</ul>
						<li style="text-align:right" >
							<li class="dropup same-line"style="width:85px;">
							<a id="paint" type="button" class="dropdown-toggle" data-toggle="dropup" href="#" >
								 <i class="fa fa-paint-brush fa-4x"></i>
							</a>
							<ul class="dropdown-menu dropdown-tasks" style="width:200px">
								<li id="canvas-style" style="margin-left:10px">							                             
									<p><strong>Style:</strong></p>							
									<button class="btn" id="canvas-white" style="padding:0;background:transparent;"><img  src="img/style138.png" /></button>
									<button class="btn" id="canvas-gray" style="padding:0;background:transparent;"><img  src="img/style139.png" /></button>
									<button class="btn" id="canvas-ivory" style="padding:0;background:transparent;"><img src="img/style140.png" /> </button>
									<button class="btn" id="canvas-blue" style="padding:0;background:transparent;"><img  src="img/style141.png" /> </button>
													
								</li>
								<li class="divider"></li>								                       							           
							</ul>
							</li>
							
							<li class="dropup same-line" style="width:85px;">
							<a id="download" type="button" class="dropdown-toggle" data-toggle="dropup" href="#" >
								<i class="fa fa-cloud-download fa-4x"></i>  
							</a>
							
							<ul class="dropdown-menu dropdown-tasks">
								<li>
									<a href="#" id="save_image" >
										Save as PDF  
									</a>
								</li>    
								<li>
									<a href="#" id="save_image" >
										Save as PNG  
									</a>
								</li>                        							            
							</ul>
							</li>
							<li class="dropup same-line" >
							<button id="trash-can" class="btn btn-default" style="height:77px;width:80px;">
								<i class="fa fa-trash-o fa-4x"></i>  
							</button>
																				
							</li>							
							
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
				<button class="btn btn-default" onclick="clear_all()">
                    Clear canvas
                </button>
				<div id="myImage" style="margin-top:40px">
					<div class="map-title">
						<input type="text" id="canvas_title" placeholder="Tittle of Map"  class="canvas-title">											
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
						<input type="text" id="axis_top" onkeyup="autocomplet(this)" placeholder="Y Axis" class="axis-label">
						<ul id="axis_top_list"></ul>
					</div>
					<div class="label-bottom">
						<input type="text" id="axis_bottom" onkeyup="autocomplet(this)" placeholder="Y Axis" class="axis-label">
						<ul id="axis_bottom_list"></ul> 			         		      	  				  
					</div>
					<div class="label-left">     			        
						<input type="text" id="axis_left" onkeyup="autocomplet(this)" placeholder="X Axis" class="axis-label">
						<ul id="axis_left_list"></ul>
					</div>
					<div class="label-right">   	
						<input type="text" id="axis_right" onkeyup="autocomplet(this)" placeholder="X Axis" style="text-align:center;"class="axis-label">
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
	$('#canvas-blue').click(function(e) {
		e.stopPropagation();
		$('#squares').css('background','#ECFFFF');
	});
</script>
</body>

</html>
