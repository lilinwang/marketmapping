<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<title >MarketMapping</title>
	<link rel="stylesheet" href="http://apps.bdimg.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/css.css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.boutique_min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>	
	<script type="text/javascript" src="js/html2canvas.js" type="text/javascript"></script>
	
\
<script type="text/javascript">	
	var company_id=-1;		
	var urlimg="";
	var axisnum=0;
	$(document).ready(function() {
		var $logos=$("#logos"),
			$transfer=$("#squares");
			
		$transfer.droppable({
			accept: "#logos > a",
			//activeClass: "custom-state-active",
			activeClass: "ui-state-highlight",
			drop: function( event, ui ) {
				$('.myImage').append(ui);
				alert(ui.position.top);
				//recycleImage( ui.draggable );
			}
		});
		$('body').on('click','#save_image',function(){
      	        html2canvas($('.myImage'), {
      	            onrendered: function(canvas) {
      		            //$('.imageHolder').html(canvas);
      		                var dataURL = canvas.toDataURL("image/png");
      		
      		                $('.imageHolder').append('<img src="'+dataURL+'" />');
      		               /* $('.imageHolder').html('Generating..');
      		                $.post('image.php',{image: dataURL},function(data){
      		                	$('.imageHolder').html(data);
      		                });*/
      		        }
      	        });
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
	
	function get_metrics(){
			//document.getElementById("focus").className="btn btn-default";
			//ok.className ="btn btn-success";			
			$.post("ajax/get_metrics", 
			{
				
            },			
            function(data,status){
				console.log(data);
				data = eval("(" + data + ")");
				var innerHTML3="<p>Choose x metrics:</p>";	
				console.log(data);		
				var ndata=new Array('Complexity','Price','Quality','Customer Segment','Security','Research Style','Risk','Value','Reputation','Customization');
				for(var i = 0; i < ndata.length; i++)
	            {
					innerHTML3 += "<input class=\"btn btn-default\" name=\"metric1\" onclick=\"drawChart(this,"+i+",1)\" type=\"button\" value=\""+ndata[i]+"\" />";
				}
				document.getElementById("metrics1").innerHTML = innerHTML3;	
				innerHTML2="<p>Choose y metrics:</p>";
				for(var i = 0; i < ndata.length; i++)
	            {
					innerHTML2 += "<input class=\"btn btn-default\" name=\"metric0\" onclick=\"drawChart(this,"+i+",0)\" type=\"button\" value=\""+ndata[i]+"\" />";
				}
				/*for(var i = 0; i < data.metrics.length; i++)
	            {
	            	innerHTML2 += "<input class=\"btn\" onclick=\"drawChart(this,value,"+i+",1)\" type=\"button\" value=\""+data.metrics[i].metric+"\" />";					
				}	
				for(var i = 0; i < data.metrics.length; i++)
	            {
					innerHTML2 += "<input class=\"btn\" onclick=\"drawChart(this,value,"+i+",0)\" type=\"button\" value=\""+ndata[i]+"\" />";
	            }*/
				document.getElementById("metrics2").innerHTML = innerHTML2;				
			});
	};	
     google.load("visualization", "1", {packages:["corechart"]});
    // google.setOnLoadCallback(drawChart);
	var columnx=0;
	var columny=1;
	var valuex='Complexity';
	var valuey='Price';
     function drawChart(value,column,isx) {						
		//alert(value+valuex+valuey);		
		if (isx==1){
			columnx=column;valuex=value.value;	
			var m1=document.getElementsByName("metric1");
			for (var i=0;i<m1.length;i++){
				m1[i].className ="btn btn-default";				
			};			
		}else {
			columny=column;valuey=value.value;
			var m0=document.getElementsByName("metric0");
			for (var i=0;i<m0.length;i++){
				m0[i].className ="btn btn-default";
			};	
		}
		value.className ="btn btn-success";	
		
		//=document.getElementById("columnx").value;
		//=document.getElementById("columny").value;
		//alert(value+valuex+valuey);
        var data = new google.visualization.DataTable();		
		data.addColumn('number','Complexity');
		data.addColumn('number','Price');
		data.addColumn('number','Quality');
		data.addColumn('number','Customer Segment');
		data.addColumn('number','Security');
		data.addColumn('number','Research Style');
		data.addColumn('number','Rist');
		data.addColumn('number','Value');
		data.addColumn('number','Reputation');
		data.addColumn('number','Customization');
		data.addColumn('string','Company');
		data.addColumn({type: 'string', role: 'tooltip', p: {'html': true}});
		
		data.addRows([
			[7,1,3,2,1,4,5,4,10,9,'Intercom.io','<img width=100px src="image/intercom.png">'],
			[3,4,9,9,1,4,4,8,4,3,'Mixpanel.com','<img width=100px src="image/mixpanel.png">'],
			[3,5,4,4,1,4,4,7,5,2,'getvero.com','<img width=100px src="image/getvero.png">'],
			[1,1,7,4,3,4,5,5,5,6,'segment.io','<img width=100px src="image/segment.png">'],
			[9,9,9,6,8,7,7,6,5,8,'mailchimp.com','<img width=100px src="image/mailchimp.png">']        
        ]);
		var options = {
		  tooltip: {isHtml: true},
          title: valuex+' vs. '+ valuey +' comparison',
          hAxis: {title: valuex, gridlines:{count:2},minValue: 0,maxvalue: 10, baseline:5 },
          vAxis: {title: valuey, gridlines:{count:2},baseline:5, minValue: 0, maxValue:10 },
          legend: 'none',
		  pointSize: 15,
		  series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'triangle' },
                2: { pointShape: 'square' },
                3: { pointShape: 'diamond' },
                4: { pointShape: 'star' }
            },
		  animation: {
			duration: 5000,
			easing: 'In',
		  }		 
        };			  
  // Create and draw the visualization.
		var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
		function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            //var topping = data.getValue(selectedItem.row, 1);
			window.open('http://'+data.getValue(selectedItem.row, 10));
            //alert('The user selected ' + topping);
          }
        }	
		var view = new google.visualization.DataView(data);
		view.setColumns([columnx,columny,11]);
		google.visualization.events.addListener(chart, 'select', selectHandler);          				      						
		chart.draw(view, options);
		
    } 		  
</script>
		
	<script type="text/javascript">		

	function exportimg(fileName) {
    // for non-IE
	var fileURL='http://localhost/marketmapping/servlet?img=' + urlimg;
    if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = fileURL;
        save.target = '_blank';
        save.download = fileName || 'unknown';

        var event = document.createEvent('Event');
        event.initEvent('click', true, true);
        save.dispatchEvent(event);
        (window.URL || window.webkitURL).revokeObjectURL(save.href);
    }

    // for IE
    else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
	}

    function exportimg(value){
		var img = '/flower.png';
		//file_put_contents(img, file_get_contents(urlimg));
		jQuery.ajax({

			url: 'http://localhost:8080/marketmapping/servlet?img=' + urlimg,
			//data: myData,
			type: 'GET',
			crossDomain: true,
			dataType: 'jsonp',
		// success: function() { alert("Success"); },
		// error: function() { alert('Failed!'); },
		// beforeSend: setHeader
		});
	}
	</script>
</head>
<body>

<div id="container">
	<img width=200px src="image/Logo-V1-Gaps.png"/> <h1></h1>
	
	<div id="body">
	<div id="search">
		<p>Search company name:</p>
		<div class="col-lg-6">
		<div class="input-group">
			<input type="text" class="form-control" id="company_name" />
			<span class="input-group-btn">
				<button class="btn btn-default" onclick="search_name()" name="submit" type="button">Search</button>
			</span>
		</div>
		<!-- /input-group <input type="text" class="input"  /> <input type="submit" class="btn"  value="search"/>chart_div	-->		
		</div>	
		<div class="col-lg-6">
		<div class="input-group">
		
			<input type="file" class="form-control" id="userfile" name='userfile' />
			<span class="input-group-btn">
				<button class="btn btn-default" onclick="upload()" name="submit" type="button">Upload</button>
			</span>
		</div>		
		</div>
		<button class="btn btn-default" onclick="get_metrics()" name="submit" type="button">Show axis</button>
	</div>
	
	<div class="logos-class">
		<div id="logos">		
		</div>
	</div>
	</br></br>
	<div id="metrics" >	
		<div id="metrics1" class="btn-group">
		</div>
		<div id="metrics2" class="btn-group">
		</div>
	</div>

	
	<div class="myImage">
		          			         		      	  				  
	<div id="squares">   
		<div id="upper" style="border-bottom:1px solid;height:450px;width:898px;">   
			<div id="square1" style="border-right: 1px solid;height:450px;width:450px;"></div>	
		</div>		
		<div id="lower" style="height:450px;width:900px;">   
			<div id="square4" style="border-right: 1px solid;height:448px;width:450px;"></div>
		</div>
	</div>	
	 </div>
     <a id="save_image" href="#">3 Generate Image</a>
		<div class="result">
			          <h1>4 Preview:</h1>
		<div class="imageHolder"></div>
	</div>					
	<div id="custom_html_content_div"></div>
		<div id="chartContainer" style="width: 900px; height: 500px;"></div>	
	</div>
	
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>	
	
</div>
</body>
</html>