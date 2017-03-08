<!-- # GO Visualizer is  released under the terms of the GNU Lesser General Public License Ver.2.1. 
# https://www.gnu.org/licenses/old-licenses/lgpl-2.1.en.html
-->
<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
 <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
   		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">-->
        <script language="javascript" type="text/javascript" src="../js/rainbow.js"></script>
		

    <script type="text/javascript" src="./js/chroma.min.js"></script>
    
    <script src="http://d3js.org/d3.v3.min.js"></script>
	<!--<script src="http://cpettitt.github.io/project/dagre-d3/latest/dagre-d3.min.js"></script>-->
	<script language="javascript" type="text/javascript" src="./js/dagre-d3.js"></script>
	<script language="javascript" type="text/javascript" src="./js/saveSvgAsPng.js"></script>
    <script language="javascript" type="text/javascript" src="./js/FileSaver.js"></script>
    
    <script language="javascript" type="text/javascript" src="./js/svg_todataurl.js"></script>
	<script src="./js/rgbcolor.js"></script>
    <script src="./js/canvg.js"></script>
    <script src="./js/svgenie.js"></script>
    
    <script type="text/javascript">
    
    
    //Show UCLA CS class dependencies (not complete)

    </script>
    
    <style type="text/css">
      body {
      overflow: auto;
      }
      #header {
		background: #333;
		height: 35px;
		-webkit-box-shadow: 0 2px 3px rgba(0,0,0,.25);
		-moz-box-shadow: 0 2px 3px rgba(0,0,0,.25);
		box-shadow: 0 2px 3px rgba(0,0,0,.25);
		text-align: center;
		position: absolute;
		left: 0;
		width: 100%;
		
		color: white;
		}
		#search-txt{
		border-radius:5px;
		height:25px;
		margin-top:5px;
		}
		#settings {
		display:block;
		position: absolute;
		height:100%;
		width:20%;
		right: 20px;
		top: 0px;
		overflow-y: auto;
		
		}
		#check-box {
		display:block;
		position: fixed;
		left:0px;
		top: 00px;
		overflow-y: auto;
		
		}
		#settings > label {
		clear: both;
		float: left;
		margin-top: 6px;
		margin-right: 10px;
		width: 107px;
		}
		.settings-box {
		
		width: 100%;
		float: left;
		}
		svg {
	  		overflow: scroll;
	  		width:100%;
	  		height:100%;
		}

		text {
		  font-weight: 300;
		  font-family: "Helvetica Neue", Helvetica, Arial, sans-serf;
		  font-size: 14px;
		  cursor:pointer;
		}

		.node{
		  stroke: #222;
		  stroke-width: 2px;
		  fill: #fff;
		  cursor:pointer;
		}

		.edgeLabel rect {
			  fill: #fff;
		}

		.edgePath path {
		  stroke: #222;
		  stroke-width: 1px;
		  fill: none;
		}
		.status{
			color:#333;
			display:block;
			position: fixed;
			right:10px;
			top: 00px;
			overflow-y: auto;
		}
		#go-id{
			color:#333;
			display:block;
			position: fixed;
			right:10px;
			top: 15px;
			overflow-y: auto;
		}
		#go-name{
			color:#333;
			display:block;
			position: fixed;
			right:10px;
			top: 30px;
			overflow-y: auto;
		}
		.edge-info{
			display:block;
			position: fixed;
			right:10px;
			top: 50px;
			overflow-y: auto;
		}
		#overlay-back {
		    position   : absolute;
		    top        : 0;
		    left       : 0;
		    width      : 100%;
		    height     : 100%;
		    background : #000;
		    opacity    : 0.6;
		    filter     : alpha(opacity=60);
		    z-index    : 5;
		    display    : none;
		}
		
		#overlay {
		    position : absolute;
		    top      : 200px;
		    left:0;
	        right:0;
	        margin-left:auto;
	        margin-right:auto;
		    width    : 300px;
		    height   : 100px;
		    z-index  : 10;
		    display  : none;
		} 

    </style>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-22567380-1', 'auto');
  ga('send', 'pageview');

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-22567380-2', 'auto');
  ga('send', 'pageview');

</script>
</head>

<body>
<?php 
	
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
   echo 'Your Web Browser is not supported, please use Chrome or Firefox!';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
    echo 'Your Web Browser is not supported, please use Chrome or Firefox!';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
   echo '';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
   echo '';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
   echo 'Your Web Browser is not supported, please use Chrome or Firefox!';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
   echo 'Your Web Browser is not supported, please use Chrome or Firefox!';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
   echo "";
 else
   echo 'Your Web Browser is not supported, please use Chrome or Firefox!';
   
   
?>

<div id="overlay-back"></div>
<div id="overlay"><div class="panel panel-default">
  <div class="panel-body">
    	Rendering Graph Please Wait...	</div>
  </div>
</div> 

<div>
	<svg id="diagram">
	    <g transform="translate(20,20) scale(0.2)"/>
	</svg>
</div>


  <span class="status" style="display:none">
  </span>
   <span id="go-id" ></span>
   <span id="go-name" ></span>
   
  <div class="edge-info"></div>
  <div class="indicator" style="display:none"></div>
  <br>
  <div id="check-box" ><input type="checkbox" class="simple-relationship" name="" value=""> No parent recomputation <br> when expanded (Faster)<br></div>
  
  <textarea style="margin-top:10px; display:none" class="form-control" id="submit-txt"></textarea>
  
  <button style="margin-top:10px; display:none" class="btn btn-default btn-primary form-control" id="match-path-btn" data-toggle="tooltip" data-animation="false" data-placement="top" title="Colors are based on number of predicted child nodes in the path">Submit</button>
 



<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="../js/slim.js"></script>
<script>
// Create a new directed graph

var g = new dagreD3.Digraph();
var expandedNodes = {};
var branch = "";
// Add nodes to the graph. The first argument is the node id. The second is
// metadata about the node. In this case we're going to add labels to each of
// our nodes.
g.addNode("all",    { label: "<div class='term' style='padding: 10px; font-size:14px'>all</div>" });
g.addNode("GO:0008150", {label: "<div class='term' style='padding: 10px; font-size:14px'>biological_process</div>"});
g.addNode("GO:0005575", {label: "<div class='term' style='padding: 10px; font-size:14px'>cellular_component</div>"});
g.addNode("GO:0003674", {label: "<div class='term' style='padding: 10px; font-size:14px'>molecular_function</div>"});

// Add edges to the graph. The first argument is the edge id. Here we use null
// to indicate that an arbitrary edge id can be assigned automatically. The
// second argument is the source of the edge. The third argument is the target
// of the edge. The last argument is the edge metadata.

//g.addEdge(null, "kspacey",   "swilliams", { label: "K-PAX" });
g.addEdge(null, "all","GO:0008150");
g.addEdge(null, "all","GO:0005575");
g.addEdge(null, "all","GO:0003674");

var layout = dagreD3.layout()
                    .nodeSep(10)
                    .rankDir("TD");
var job_id;
var max_raw_score = 0;

var navigo_api_verision = "alpha";
//initialize the graph by get predicted terms from the api...

		//initialize the graph library api
		//set the initial scale and translate rate
		//should set both below and the svg dom in html
		var renderer = new dagreD3.Renderer();
		
		renderer.layout(layout).run(g, d3.select("svg g"));
		var svg = d3.select("svg");
		var zoom = d3.behavior.zoom().translate([20,20]).scale(.2);
		//console.log(svg);
 		d3.select("svg")
        .call(zoom.on("zoom", function() {
          var ev = d3.event;
          var scale = ev.scale;
          svg.select("g")
            .attr("transform", "translate(" + ev.translate + ") scale(" + scale + ")");
        }));


         $.get("../server/get_relationship.php?"+navigo_api_verision + "&html", function(o){
             $(".edge-info").html(o);
         });
		
 		$("svg").on('mouseover', '.node g', function (event){
	 		var cur = $(this).children();
			//console.log(cur);
			var name = cur.text();
// 			console.log(name);
			g.eachNode(function(u, value) {
			    var tmp_value = value.label;
			    tmp_value = tmp_value.replace(/<(?:.|\n)*?>/gm, '');
			    var tmp_name = value.label.replace(/<br>/g,' ');
			    tmp_name = tmp_name.replace(/<(?:.|\n)*?>/gm, '');
			    tmp_name = tmp_name.replace(/[0-9]*\.[0-9]*%/gm, '');
			    tmp_name = tmp_name.replace(/GO:[0-9]* /gm, '');
				//console.log(tmp_value);
    			if(name === tmp_value){
    			$("#go-id").text(u);
                $("#go-name").text(tmp_name);
    			
    			}
			});
 		});
 		
 		//The event that click on a node on the graph, should expand the node to show the children of that node...
 		$("svg").on('click', '.node', function (event){
	 		clickNode(this);
	 		var cur = this;
	 		
	 		setTimeout(function() {
		 		var tran = $(cur).attr( "transform" );
		 		tran = tran.replace(/[^0-9,.]*/gm, '');
// 		 		console.log(tran);
		 		var res = tran.split(",");
		 		scale = zoom.scale();
		 		var viewerWidth = $(document).width()-200;
		 		var viewerHeight = 600;
	
		        x = -res[0];
		        y = -res[1];
		        x = x * scale + viewerWidth / 2;
		        y = y * scale + viewerHeight / 2;
// 		        console.log(x+" "+y);
		        d3.select('g').transition()
		            .duration(500)
		            .attr("transform", "translate(" + x + "," + y + ")scale(" + scale + ")");
		            
		        zoom.scale(scale);
		        zoom.translate([x, y]);

			}, 1000);
	 		
	 		
 		});
 		
		
		function get_relationship_label (label, flag) {
    		if (flag) {
        		return label;
    		}
    		return ""
		}
		
 		//Check if current graph has any parent for the expanded children nodes...
		function getResults(Node, index, length){
		      //console.log(Node);
		      $.getJSON("../server/get_parent.php?go="+Node+"&"+navigo_api_verision, function(pjson){
		          //console.log(pjson);
		          for(var j=0; j<Object.keys(pjson).length;j++){
			      g.eachNode(function(u,value){
			          if(u == pjson[j].id){
			          	if(!g.hasEdge(pjson[j].id+"-"+Node)){
    			          	
    			          	
                			edgeStyle = "stroke: " + pjson[j].relationship.color + "; stroke-width:2px;"
                			var e = g.addEdge(pjson[j].id+"-"+Node, pjson[j].id, Node, {label:get_relationship_label (pjson[j].relationship.name, false), style: edgeStyle});
    			
			          		
// 			          		console.log(pjson[j].id+"-"+Node);
			          	}
				  	   }
			      });
			      function transition(selection) {
        			return selection.transition().duration(400);
      			  }
			      //renderer.transition(transition);
				  
			  }
				if(index == length -1 ){renderer.layout(layout).run(g, d3.select("svg g"));
					if(color_score == 0){
						paintParents();
						paintNode();
					}
					if(color_score === 1){
			        	//updateGraphScore();
			        	//renderer.layout(layout).run(g, d3.select("svg g"));
						paintNodeScore();
			        }
				}
				
			
		      }); 
		   
		   }

		  function clickNode(clickedNode){
			var g_term;
			var name = $(clickedNode).find("g").text();
// 			console.log(name);
			
			g.eachNode(function(u, value) {
				//console.log(value);
				var tmp_value = value.label;
			    tmp_value = tmp_value.replace(/<(?:.|\n)*?>/gm, '');
			    
    			if(name === tmp_value){
    				g_term = u;
					
    			
    			}
			});
			
			if(expandedNodes[name] == undefined){
				expandedNodes[name] = 0;
			}else{
				$(".status").text("Already Expanded");
				$(".status").change();
				//g.delNode(g_term);
				//renderer.layout(layout).run(g, d3.select("svg g"));
				return;
			}
			
			
			
			$(".status").text("loading "+g_term+"...");
			$('.status').change();
			if(g_term == "all"){$(".status").text("done");$('.status').change();return;}
			
			$.getJSON("http://kiharalab.org/web/inc/get_children.php?go="+g_term+"&"+navigo_api_verision,function(json){
    		
//     		console.log("finish"); 
			for(var i = 0; i< Object.keys(json).length; i++){
				//console.log(json[i].id);
 
				if(!g.hasNode(json[i].id)){g.addNode(json[i].id,{label:"<div class='term' style='padding: 10px; text-align:center; font-size:14px'>"+json[i].id+"<br>"+json[i].name.replace(/ /g,"<br>")+"</div>"});
				//check parents but affect speed of rendering
				if(!$('.simple-relationship').is(':checked'))getResults(json[i].id, i , Object.keys(json).length);
				
				}
				if(!g.hasEdge(g_term+"-"+json[i].id)) {
    				edgeStyle = "stroke: " + json[i].relationship.color + "; stroke-width:2px;"
                    g.addEdge(g_term+"-"+json[i].id, g_term, json[i].id, {label:get_relationship_label (json[i].relationship.name, false), style: edgeStyle});
				}
				
		
			}
			function transition(selection) {
        		return selection.transition().duration(400);
      		}
			//transition
      		//renderer.transition(transition);
			renderer.layout(layout).run(g, d3.select("svg g"));
			if(color_score==0){
				paintParents();
        		paintNode();
        	}
        	if(color_score === 1){
			        	//updateGraphScore();
			        	//renderer.layout(layout).run(g, d3.select("svg g"));
						paintNodeScore();
			}
        	$(".status").text("done");	
			$('.status').change();
        	
			});
}
var color_score = 0;
var arrayNodes = new Array();
var hash = {};
var hash_score = {};
var total_go = 0;
var max_raw_score_hash = {};

var slim_hash = {};

$("#rotate").click(function(){
layout = dagreD3.layout()
                    .nodeSep(10).rankSep(200)
                    .rankDir("TD");
		renderer.layout(layout).run(g, d3.select("svg g"));
		if(color_score==0){
			paintParents();
			paintNode();
		}
		if(color_score === 1){
			        	updateGraphScore();
			        	renderer.layout(layout).run(g, d3.select("svg g"));
						paintNodeScore();
						}
});

$("#rotate-back").click(function(){
layout = dagreD3.layout()
                    .nodeSep(10).rankSep(200)
                    .rankDir("LR");
		renderer.layout(layout).run(g, d3.select("svg g"));
		if(color_score==0){
			paintParents();
			paintNode();
		}
		if(color_score === 1){
			        	updateGraphScore();
			        	renderer.layout(layout).run(g, d3.select("svg g"));
						paintNodeScore();
			        }
});

// paint all the targeted nodes
	function paintNode(){
	
	arrayNodes.forEach(function(node){
		  //var nodeUI = graphics.getNodeUI(node);
		  //if(nodeUI != null)
		  //nodeUI.childNodes[0].attr('stroke','#555').attr('stroke-width','5');
		  g.eachNode(function(u, value) {
				//console.log(value);
    			if(node === u){
    				$(".node").each(function(index){
    					var name = $(this).find("g").text();
    					 var tmp_value = value.label;
						 tmp_value = tmp_value.replace(/<(?:.|\n)*?>/gm, '');
    					if(tmp_value === name){
    						//console.log("color"+this);
    						//$(this).find("rect").css("fill","#AEF89F");
                            
    						$(this).find("rect").css("stroke-width","10");
    						$(this).find("rect").css("stroke","#333");
    					}
    				});
    			
    			}
			});
		});
	
	
	}
	
	// paint all the targeted nodes based on score
	function paintNodeScore(){
		
		  var keys = Object.keys(hash_score);
		  var max = 0;
		  var min = 1000;
		  keys.forEach(function(k){
		     if(hash_score[k]>max)max = hash_score[k]; 
		      if(hash_score[k]<min)min = hash_score[k];
		  });
		  
		  //var color_string = "lightyellow, orange, deeppink, darkred";
		  //var color_string = "#FFD5D7, red";
		  var color_string = "lightyellow,red";
		  //var color_string ="#41B7C5, #F03B20";
		  
		  var colors = color_string.replace(/(, *| +)/g, ',').split(',');
		  var steps = 100;
		  colors = chroma.interpolate.bezier(colors);
		  var cs = chroma.scale(colors).mode('lab').correctLightness(true);
		   
		  //var colors = get_hex(10);
		  
        	keys.forEach(function(k){
		     
		   
		    g.eachNode(function(u, value) {
				//console.log(value);
    			if(k === u){
    				$(".node").each(function(index){
    					var name = $(this).find("g").text();
    					var tmp_value = value.label;
						 tmp_value = tmp_value.replace(/<(?:.|\n)*?>/gm, '');
    					if(tmp_value === name){
    						//console.log("color"+colors[100-Math.round(hash_score[k]*100)]);
    						//value.label = name + "("+hash_score[k]+")";
    						$(this).find("rect").css("fill",cs((hash_score[k]-min)/(max-min)).hex());
    						
    						//$(this).find("g ").append("<text>"+hash_score[k]+"</text>");
    					}
    				});
    			
    			}
			});
		  
		  });
		  
		  
	
	
	}
	
	function updateGraphScore(){
		
		var keys = Object.keys(hash_score);
		keys.forEach(function(k){
		     
		   
		    g.eachNode(function(u, value) {
				//console.log(value);
    			if(k === u){
    				$(".node").each(function(index){
    					var name = $(this).find("g").text();
    					var tmp_value = value.label;
    					//tmp_value = tmp_value.replace(/<br>/g," ");
						tmp_value = tmp_value.replace(/<(?:.|\n)*?>/gm, '');
    					if(tmp_value === name){
//     						console.log(name);
    						//console.log("color"+colors[100-Math.round(hash_score[k]*100)]);
    						//value.label = value.label + "<center>(<b>"+hash_score[k]+"</b>)</center>";
    						
    						//make the predicted terms bigger
    						var buff = value.label.replace(/<div(?:.|\n)*?>/gm, '<div class=\'term\' style=\'padding: 10px; text-align:center; font-size:40px\'>');
    						var re = /font-size\:50/;
							var tmp = re.exec(buff);
           
				           	if(tmp==null){
				           		//console.log("here"+tmp);
				           		if(max_raw_score == -1){
					           		value.label = buff + "<center><span style=\"font-size:50px; padding:15px;\"><b>"+(parseFloat(max_raw_score_hash[u])).toFixed(1)+"</b></span></center>";
				           		}
				           		else if(max_raw_score == 0)value.label = buff + "<center><span style=\"font-size:50px; padding:15px;\"><b>"+(hash_score[k]*100).toFixed(1)+"%</b></span></center>";
				           		else value.label = buff + "<center><span style=\"font-size:50px; padding:15px;\"><b>"+(hash_score[k]*max_raw_score).toFixed(1)+"</b></span></center>";
							}

    						    						
    					}
    				});
    			
    			}
			});
		  
		  });
		  
	}

		function get_hex(number){
        		var numberOfItems = number;
				var rainbow = new Rainbow(); 
				rainbow.setNumberRange(1, numberOfItems);
				rainbow.setSpectrum('red', 'white');
				var s = new Array;
				for (var i = 1; i <= numberOfItems; i++) {
    				var hexColour = rainbow.colourAt(i);
    				s.push('#' + hexColour);
    				//s += '#' + hexColour + ', ';
				}
				return s;
        }
        
        function paintParents(){
          //console.log(hash);
          var keys = Object.keys(hash);
		  var max = 0;
		  keys.forEach(function(k){
		     if(hash[k]>max)max = hash[k]; 
		  });
		  //console.log(max);
		  if(max>0){
			 var colors = get_hex(max+2);
			
			  
        	keys.forEach(function(k){
		     
		   
		    g.eachNode(function(u, value) {
				//console.log(value);
    			if(k === u){
    				$(".node").each(function(index){
    					var name = $(this).find("g").text();
    					var tmp_value = value.label;
						tmp_value = tmp_value.replace(/<(?:.|\n)*?>/gm, '');
    					if(tmp_value === name){
    						//console.log("color"+this);
    						//$(this).find("rect").css("fill",colors[(max-hash[k])]);
       					}
    				});
    			
    			}
			});
		  
		  });
		  }
		  
        }
/*
 setInterval(function(){
 	paintParents();
 	paintNode();
 },500);*/

$('.status').change(function(){
      //Do what you want when div changes
//       console.log($(".status").text());
      if($(".status").text() == "done"){
      	 
      	  $(".indicator").show();
          $(".status").show();
	      setTimeout(function() {
		    $(".status").hide();
		  }, 2000);
      }
      else{
	      $(".status").show();
      }
});


$("#reset-btn").click(function(event){
	total_go = 0;
	event.preventDefault();
	g = new dagreD3.Digraph();
	expandedNodes = {};
	arrayNodes = new Array();
	hash = {};
	color_score = 0;
	
	// Add nodes to the graph. The first argument is the node id. The second is
	// metadata about the node. In this case we're going to add labels to each of
	// our nodes.
	g.addNode("all",    { label: "<div class='term' style='padding: 10px; font-size:14px'>all</div>" });
	g.addNode("GO:0008150", {label: "<div class='term' style='padding: 10px; font-size:14px'>biological_process</div>"});
	g.addNode("GO:0005575", {label: "<div class='term' style='padding: 10px; font-size:14px'>cellular_component</div>"});
	g.addNode("GO:0003674", {label: "<div class='term' style='padding: 10px; font-size:14px'>molecular_function</div>"});
	
	
	// Add edges to the graph. The first argument is the edge id. Here we use null
	// to indicate that an arbitrary edge id can be assigned automatically. The
	// second argument is the source of the edge. The third argument is the target
	// of the edge. The last argument is the edge metadata.
	
	//g.addEdge(null, "kspacey",   "swilliams", { label: "K-PAX" });
	g.addEdge(null, "all","GO:0008150");
	g.addEdge(null, "all","GO:0005575");
	g.addEdge(null, "all","GO:0003674");
	function transition(selection) {
	        		return selection.transition().duration(400);
	      		}
				//transition
	//renderer.transition(transition);
	renderer.layout(layout).run(g, d3.select("svg g"));
	d3.select("g").attr("transform", "translate(500,20) scale(0.4)");
			console.log(zoom.scale(0.4).translate([500,20]));
});

  match_path_btn_click = function(){
	  
	  		arrayNodes = new Array();
  			total_go = 0;
  			 //clear hash array
  			expandedNodes = {};
  			hash = {};
  			color_score = 0;
    		
    		g = new dagreD3.Digraph();
            
            var temp_terms = $("#submit-txt").val().split("\n");
            
            var re = /GO\:\d{7}/;
            var g_terms = new Array();
            temp_terms.forEach(function(entry){
                console.log(entry);
            var tmp = re.exec(entry);
            //console.log(tmp);
           
            if(tmp!=null)g_terms.push(tmp[0]);
            });
   
            count = 0;
            var node_index = 0;
            g_terms.forEach(function(id){
            	node_index ++;
            	//window.setTimeout(function(){
            	arrayNodes.push(id);
            	matchPath(id,node_index,g_terms.length,0);
            	//},500);
            	count++;
           
            });
            
            setTimeout(function() {
		    if (total_go < arrayNodes.length )
		    {
		        // Handle error accordingly
		        alert("We have a problem loading all GO terms");
		        renderer.layout(layout).run(g, d3.select("svg g"));
		        $(".status").text("done");
		        $('.status').change();
				$('#overlay, #overlay-back').fadeOut(500);
				updateGraphScore();
		        renderer.layout(layout).run(g, d3.select("svg g"));
				paintNodeScore();
		    }
			}, 10000);
            //console.log(count);
  }

  $("#match-path-btn").click(function(event){
  		 	
	  	match_path_btn_click();
    });
    

	match_path_score_btn_click = function(){
			arrayNodes = new Array();
    		total_go = 0;
  			expandedNodes = {};
  			hash_score = {};
  			color_score = 1;
    		
    		g = new dagreD3.Digraph();
            
            var temp_terms = $("#submit-txt").val().split("\n");
            
            var re = /GO\:\d{7}/;
            var prob = /\d*(\.\d+)?$/;
            var g_terms = new Array();
            temp_terms.forEach(function(entry){
                console.log("entry:"+entry);
            var tmp = re.exec(entry);
            var prob_temp = prob.exec(entry);
            
            //console.log(prob_temp);
           	if(tmp!=null && prob_temp != null){
           		if(hash_score[tmp[0]] == undefined){
				hash_score[tmp[0]] = prob_temp[0];
				}
			}
            if(tmp!=null)g_terms.push(tmp[0]);
            
            
            });
   				
           	var node_index = 0;
            g_terms.forEach(function(id){
            	node_index ++;
            	//window.setTimeout(function(){
            	arrayNodes.push(id);
            	matchPath(id,node_index,g_terms.length,1);
            	//},500);

            });
            setTimeout(function() {
		    if (total_go < arrayNodes.length )
		    {
		        // Handle error accordingly
		        alert("We have a problem loading all GO terms");
		        renderer.layout(layout).run(g, d3.select("svg g"));
		        $(".status").text("done");
		        $('.status').change();
				$('#overlay, #overlay-back').fadeOut(500);
				updateGraphScore();
		        renderer.layout(layout).run(g, d3.select("svg g"));
				paintNodeScore();
		    }
			}, 10000);
            
            console.log(hash_score);
	}

    $("#match-path-score-btn").click(function(event){
    		
            match_path_score_btn_click();
    });
    
    $("#match-path-score2-btn").click(function(event){
    		arrayNodes = new Array();
    		total_go = 0;
  			expandedNodes = {};
  			hash_score = {};
    		color_score = 1;
    		
    		g = new dagreD3.Digraph();
            event.preventDefault();
            var temp_terms = $("#submit-txt").val().split("\n");
            
            var re = /GO\:\d{7}/;
            var prob = /\d*(\.\d+)?$/;
            
            var g_terms = new Array();
            temp_terms.forEach(function(entry){
            	var row = entry.split("\t");
            	
                console.log("entry:"+row[0]);
            	var tmp = "GO:"+row[0];
            	var prob_temp = row[9];
            
            //console.log(prob_temp);
           	if(tmp!=null && prob_temp != null){
           		if(hash_score[tmp] == undefined){
				hash_score[tmp] = prob_temp;
				}
			}
            if(tmp!=null)g_terms.push(tmp);
            
            
            });
			
           	var node_index = 0;
            g_terms.forEach(function(id){
            	node_index ++;
            	//window.setTimeout(function(){
            	arrayNodes.push(id);
            	matchPath(id,node_index,g_terms.length,1);
            	//},500);

            });
            
            setTimeout(function() {
		    if (total_go < arrayNodes.length )
		    {
		        // Handle error accordingly
		        alert("We have a problem loading all GO terms");
		        renderer.layout(layout).run(g, d3.select("svg g"));
		        $(".status").text("done");
		        $('.status').change();
				$('#overlay, #overlay-back').fadeOut(500);
				updateGraphScore();
		        renderer.layout(layout).run(g, d3.select("svg g"));
				paintNodeScore();
		    }
			}, 20000);
            console.log(hash_score);
            
    });
	
	
	
	
	
    // only showing nodes on path
    function matchPath(term,count,length,color_score){
        	 var g_term = term;
      console.log("working on "+term);
      $.getJSON("../server/get_path.php?go="+g_term+"&"+navigo_api_verision,function(json){
      	total_go++;
      	
//       	console.log(term+" "+count+" "+length+" "+total_go);
        var myjson = [];
        var counter = 0;
		for(var i = 0; i< Object.keys(json).length; i++){
			if(hash[json[i].id] == undefined){
				hash[json[i].id] = 0;
			}
			else hash[json[i].id]++;
			var my_term_name;
			if(json[i].name.split(",").length - 1 >0){
				my_term_name = json[i].name.replace(/,/g,",<br>");
				//my_term_name = json[i].name.replace(/ /g,"<br>");
			}
			else{
				my_term_name = json[i].name.replace(/ /g,"<br>");
			}
			//if(json[i].id=="all")continue;
			//font-size:50
			var slim = returnStarIfSlim(json[i].id, slim_hash);
			if(!g.hasNode(json[i].id))g.addNode(json[i].id,{label:"<div class='term' style='padding: 10px; text-align:center; font-size:14px'>"+slim+json[i].id+"<br>"+my_term_name+"</div>"});
			
 	 		
 
 	 	for(var j = 0; j< Object.keys(json[i].children).length; j++){
	 	
	 		my_term_name;
			if(json[i].children[j].name.split(",").length - 1 >0){
				my_term_name = json[i].children[j].name.replace(/,/g,"<br>");
				//my_term_name = json[i].children[j].name.replace(/ /g,"<br>");
			}
			else{
				my_term_name = json[i].children[j].name.replace(/ /g,"<br>");
			}
		var cslim = returnStarIfSlim(json[i].children[j].id, slim_hash);
		if(!g.hasNode(json[i].children[j].id))g.addNode(json[i].children[j].id,{label:"<div class='term' style='padding: 10px; text-align:center; font-size:14px'>"+cslim+json[i].children[j].id+"<br>"+my_term_name+"</div>"});
		
		
			
			if(!g.hasEdge(json[i].id+"-"+json[i].children[j].id)) {
    			
    			edgeStyle = "stroke: " + json[i].children[j].relationship.color + "; stroke-width:2px;"
    			var e = g.addEdge(json[i].id+"-"+json[i].children[j].id, json[i].id, json[i].children[j].id, {label:get_relationship_label(json[i].children[j].relationship.name, false), style: edgeStyle});
				//console.log(json[i].id+"->"+ json[i].children[j].id);	
				//console.log(g.edge(json[i].id+"-"+json[i].children[j].id))			
			}
		}
		
		}
		function defaultTransition(selection) {
		  return selection;
		}

		function continueExecution(){
		
		}
		//console.log(renderer.transition(defaultTransition));
		//console.log("aaaa:"+count+" "+length);
		//render.layout(layout).run(g, d3.select("svg g"));
		if(length>5 && length < 10)layout = dagreD3.layout()
                    .nodeSep(30).rankSep(200)
                    .rankDir("TD");
		
		if(length>10)layout = dagreD3.layout()
                    .nodeSep(50).rankSep(400)
                    .rankDir("TD");
		
		if(total_go == length){
		
		renderer.layout(layout).run(g, d3.select("svg g"));
		
			
		if(color_score === 0){paintParents();
        	paintNode();
        	}
        else if(color_score === 1){
        	updateGraphScore();
        	renderer.layout(layout).run(g, d3.select("svg g"));
			paintNodeScore();
        	}
        	
        setTimeout(function() {
		     $(".status").text("done");
			$('.status').change();
			$('#overlay, #overlay-back').fadeOut(500);
		}, 500);
      
       
		if(g.size()>0 && g.size() < 10){
			d3.select("g").attr("transform", "translate(500,20) scale(0.6)");
			console.log(zoom.scale(0.6).translate([500,20]));
			}
		if(g.size()>=10 && g.size() < 40){
			
			d3.select("g").attr("transform", "translate(260,20) scale(0.3)");
			console.log(zoom.scale(0.3).translate([260,20]));
		}
		
		if(g.size()>=40 && g.size() < 80){
			
			d3.select("g").attr("transform", "translate(220,20) scale(0.3)");
			console.log(zoom.scale(0.3).translate([220,20]));
		}
		if(g.size()>=80 && g.size() < 100){
			
			d3.select("g").attr("transform", "translate(280,20) scale(0.2)");
			console.log(zoom.scale(0.2).translate([280,20]));
		}
		
		if(g.size()>=100 && g.size() < 200){
			
			d3.select("g").attr("transform", "translate(50,20) scale(0.1)");
			console.log(zoom.scale(0.1).translate([50,20]));
		}
		
		if(g.size()>=200 && g.size() < 350){
			
			d3.select("g").attr("transform", "translate(80,20) scale(0.1)");
			console.log(zoom.scale(0.1).translate([80,20]));
		}
		
		if(g.size()>=350 && g.size() < 1000){
			
			d3.select("g").attr("transform", "translate(40,20) scale(0.07)");
			console.log(zoom.scale(0.07).translate([40,20]));
		}
		
		if(g.size()>=1000){
			
			d3.select("g").attr("transform", "translate(20,20) scale(0.05)");
			console.log(zoom.scale(0.05).translate([20,20]));
		}
		
		
	   var max_x =0;
	   var max_y =0;
			
	   $(".node").each(function(index){
	       						
	    		//console.log($(this).attr("transform"));
	    		var tmp = $(this).attr("transform");
	    		var tran = tmp.split(" ")[0];
				
				tran = tran.replace(/[^0-9,.]*/gm, '');
				var res = tran.split(",");
				
				x = parseFloat(res[0]);
				y = parseFloat(res[1]);
// 				console.log(x+" "+y);
				if(max_x < x)max_x = x;
				if(max_y < y)max_y = y;
				
	   });
	   
	   max_x = parseFloat(max_x*zoom.scale());
	   max_y = parseFloat(max_y*zoom.scale());
	   max_x += 500;
	   max_y += 0;
	   if(max_x < $(window).width())max_x = $(window).width();
	   if(max_y < $(window).height())max_y = $(window).height();

	   $("svg").css("width", max_x+"px");
	   $("svg").css("height", max_y+"px");
	   
		
		var cur = $(".node")[0];
	 		
	 		setTimeout(function() {
		 		var tran = $(cur).attr( "transform" );
		 		tran = tran.replace(/[^0-9,.]*/gm, '');
// 		 		console.log(tran);
		 		var res = tran.split(",");
		 		scale = zoom.scale();
		 		var viewerWidth = $(document).width()-200;
		 		var viewerHeight = 200;
	
		        x = -res[0];
		        y = -res[1];
		        x = x * scale + viewerWidth / 2+80;
		        y = y * scale + 100;
// 		        console.log(x+" "+y);
		        d3.select('g').transition()
		            .duration(500)
		            .attr("transform", "translate(" + x + "," + y + ")scale(" + scale + ")");
		            
		        zoom.scale(scale);
		        zoom.translate([x, y]);

			}, 0);	
		
	
       
       	}
	
		
		  
 
	}).error(function(jqXHR, textStatus, errorThrown) { alert(errorThrown); });
}


<?php if(isset($_GET['go']) ):?>
		job_id = "<?php echo $_GET['go']; ?>";
		$("#submit-txt").text(job_id);
        if($("#submit-txt").text().length > 0){
				$('#overlay, #overlay-back').fadeIn(500);
				$(".status").text("rendering graph...");
				$('.status').change();
				//$( "#match-path-btn" ).trigger( "click" );
				match_path_btn_click();
				//}
				
				//make the edge length longger if number of predicted terms is larger than 50
				/*layout = dagreD3.layout()
	                    .nodeSep(10).rankSep(200)
	                    .rankDir("TD");
                   */ 
            }else{
				alert("Empty prediction list!");
			}
<?php endif;?>
		


</script>

<div id="svgdataurl"></div>

</body>

</html>
