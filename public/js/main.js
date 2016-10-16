var labelType, useGradients, nativeTextSupport, animate;
var needFixNodes = new Array();
(function() {
  var ua = navigator.userAgent,
    iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
    typeOfCanvas = typeof HTMLCanvasElement,
    nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
    textSupport = nativeCanvasSupport 
    && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
    labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
    nativeTextSupport = labelType == 'Native';
    useGradients = nativeCanvasSupport;
    animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
    elem: false,
    write: function(text){
        if (!this.elem) 
        this.elem = document.getElementById('log');
        this.elem.innerHTML = text;
       this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
    }
};

function init(){    
    $jit.ST.Plot.NodeTypes.implement({
    /*
        'nodeline': {
          'render': function(node, canvas, animating) {
                if(animating === 'expand' || animating === 'contract') {
                  var pos = node.pos.getc(true), nconfig = this.node, data = node.data;
                  var width  = nconfig.width, height = nconfig.height;
                  var algnPos = this.getAlignedPos(pos, width, height);
                  var ctx = canvas.getCtx(), ort = this.config.orientation;
                  ctx.beginPath();
                  if(ort == 'left' || ort == 'right') {
                      ctx.moveTo(algnPos.x, algnPos.y + height / 2);
                      ctx.lineTo(algnPos.x + width, algnPos.y + height / 2);
                  } else {
                      ctx.moveTo(algnPos.x + width / 2, algnPos.y);
                      ctx.lineTo(algnPos.x + width / 2, algnPos.y + height);
                  }
                  ctx.stroke();
              } 
          }
        },
       */ 
        'adv-rect': {  
		'render': function(node, canvas) {  
			var width = node.getData('width'),  
				height = node.getData('height'),  
				pos = this.getAlignedPos(node.pos.getc(true), width, height),  
				posX = pos.x + width/2,
				posY = pos.y + height/2,
				radius = node.getCanvasStyle("radius"),
				RoundRect = {
					'render': function(type, pos, width, height, radius, canvas) {
						var ctx = canvas.getCtx(),
							x = pos.x - width/2,
							y = pos.y - height/2;
	
						ctx.beginPath();  
						ctx.moveTo(x,y+radius);  
						ctx.lineTo(x,y+height-radius);  
						ctx.quadraticCurveTo(x,y+height,x+radius,y+height);  
						ctx.lineTo(x+width-radius,y+height);  
						ctx.quadraticCurveTo(x+width,y+height,x+width,y+height-radius);  
						ctx.lineTo(x+width,y+radius);  
						ctx.quadraticCurveTo(x+width,y,x+width-radius,y);  
						ctx.lineTo(x+radius,y);  
						ctx.quadraticCurveTo(x,y,x,y+radius);  
						ctx[type]();
					}	
				};

			if (radius > 0) {
				RoundRect.render('fill', {x: posX, y: posY}, width, height, radius, canvas);
				RoundRect.render('stroke', {x: posX, y: posY}, width, height, radius, canvas);
			} else {
				this.nodeHelper.rectangle.render('fill', {x: posX, y: posY}, width, height, canvas);  
				this.nodeHelper.rectangle.render('stroke', {x: posX, y: posY}, width, height, canvas);
			}  
		},
		'contains': function(node, pos) {
			var width = node.getData('width') - (node.getCanvasStyle("lineWidth") ? node.getCanvasStyle("lineWidth") : 0),
				height = node.getData('height') - (node.getCanvasStyle("lineWidth") ? node.getCanvasStyle("lineWidth") : 0),
				npos = this.getAlignedPos(node.pos.getc(true), width, height);
			return this.nodeHelper.rectangle.contains({x:npos.x+width/2, y:npos.y+height/2}, pos, width, height);
		}
	}
          
    });
    var st = new $jit.ST({
        'injectInto': 'infovis',
       
        transition: $jit.Trans.Quart.easeInOut,
        levelsToShow : 32,
		levelDistance: 200,
		siblingOffset: 20,
		duration: 150,
		fps: 25,
		constrained:false,
        Node: {
        	overridable: true,
	  	  	width: 120,
	  	  	height:20,
	  	  	alpha:1,
	  	  	align:"left",
	  	  	autoHeight: false,
	  	  	autoWidth: false,
			type: "adv-rect",
			CanvasStyles: {
				fillStyle: "#F1F4F7",
				strokeStyle: "#CCC",
				lineWidth: 0.5,
				radius: 4
			}
        },
        
        Edge: {
            type: 'bezier',
            lineWidth: 0.5,
            dim:60,
            color:'#333',
            overridable: true
        },
        Label: {
			type: "HTML",
			size: 10,
			style: "bold",
			family: "Sans-serif", //'Lucida Grande' 'DejaVu Sans' Verdana Arial FreeSans Helvetica 'Bitstream Vera Sans'  
			color: "#333",
			textBaseline: "middle",
		},
        
        Navigation: {
            enable: true,
            zooming: 50,
            panning: true
        },
        
        Events: {
			enable: true,
			type: "HTML",
			onMouseEnter: function (node) {
				st.canvas.getElement().style.cursor = "pointer";
				$("#go-id").val(node.id);
                $("#go-name").val(node.name);
			},
			onMouseLeave: function () {
				st.canvas.getElement().style.cursor = "";
			},
			onClick: function (node) {
				if (!node) return;
				console.log("click"+node.id);
				st.onClick(node.id);
				
				$.getJSON("http://dragon.bio.purdue.edu:4567/get_info/" + node.id + "", function(json){
                	st.addSubtree(json, "replot", {  
        			hideLabels: false,  
        			onComplete: function() {  
            		
       	 			}
       	 		  
    				});  
            	});
				//displayInformation(node);
			}
		},
		/*
        request: function(nodeId, level, onComplete) {
        	
            $.getJSON("http://dragon.bio.purdue.edu:4567/get_info/" + nodeId + "", function(json){
            	//for(var i = 0; i< Object.keys(json).length; i++){
            	 
            	 
            	 //}
            	 console.log("node:"+nodeId);
                onComplete.onComplete(nodeId, json);
            });
        },*/
        
        onBeforeCompute: function(node){
            //NProgress.start();
	    Log.write("loading " + node.name);
        },
        
        onAfterCompute: function(){
            Log.write("done");
	   // NProgress.done();
        },
        onCreateLabel: function(label, node){
            //label.id = node.id;
            var temp = node.name.split(" ");
            var name = node.name;
            if(temp.length >= 4) {
            	
            	name = temp[0]+" "+temp[1]+" "+temp[2]+"...";
            }     
            label.innerHTML = name;
            
            label.onclick = function(){
                //st.onClick(node.id);
            };
            //set label styles
            /*
            var style = label.style;        
            style.cursor = 'pointer';
            style.color = '#000';
            style.fontSize = '0.8em';
            style.textAlign= 'center';
            style.textDecoration = 'none';
            style.paddingTop = '3px';*/
            //style.paddingLeft = '25px';
        },
        
        onBeforePlotNode: function(node){
        	var parents = node.getParents();
  			if(parents.length > 1) {
  				//node.pos.y = parents[0].pos.y;
  				var total=0;
  				parents.forEach(function(p){
  					total += p.pos.y;
  					
  				});
    			node.pos.y = total/(parents.length);
    			
  				var children = node.getSubnodes();
  				if(children.length >= 1){
  					needFixNodes.push(node);
  					children.forEach(function(c){
  						needFixNodes.push(c);
  					});
  				}
  				
  			}
  			
  			
  			needFixNodes.forEach(function(nodefix){
					parents.forEach(function(p){
  					if(nodefix.id == p.id){
  						if(Math.abs(node.pos.y - p.pos.y)>=50){
  							var pc = p.getSubnodes();
  							node.pos.y = p.pos.y+30*(pc.indexOf(node)-2);
  						}
  					
  					}
  					
  					});
  					
  				});
            if (node.selected) {
            	$("#go-id").val(node.id);
                $("#go-name").val(node.name);
                //node.data.$color = "#00a2e8";
                console.log(node);
                //node.data.$color = "#e35";
            }
            else {
                //delete node.data.$color;
}
        },
        onBeforePlotLine: function(adj){
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#e35";
                adj.data.$lineWidth = 0.5;
                //console.log(adj.data);
            }
            else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
        }
    });
    
    var go_term = $("#go-term").html()
    $.getJSON("http://dragon.bio.purdue.edu:4567/get_info/" + go_term + "", function(json) {
        var myjson = {
		id:"all",
		name:"all",
		data:{},
		children:[
		
		{
		  id:"GO:0008150",
		  name:"biological_process",
		  data:{},
		  children:[]
		},
		{
		  id:"GO:0005575",
		  name:"cellular_component",
		  data:{},
		  children:[]
		},{
		  id:"GO:0003674",
		  name:"molecular_function",
		  data:{},
		  children:[]
		}
		
		]
	}
	if(go_term != "GO:0008150"){
		st.loadJSON(json);
		st.compute();
		st.onClick(st.root);
	}
	else{
		st.loadJSON(myjson);
        st.compute();
        st.onClick(st.root);
       }
    });
    
    $("#center-btn").click(function(){
        alert("this doesn't work yet - must fix panning issues first");
    });
    $("#match-btn").click(function(){
       //window.location = "http://dragon.bio.purdue.edu:4567/";
       var g_term = $("#search-txt").val();
      $.getJSON("http://dragon.bio.purdue.edu:4567/get_path/"+g_term+"",function(json){
        var myjson = [];
	for(var i = 1; i< Object.keys(json).length; i++){
          var tmpid;
	  if(i!=0)tmpid = json[i].id.split(":");
	  else tmpid = "root";
	  	  
	  
	  myjson.push(tmpid);
	  //console.log(tmpid);
	  //$("#GO\\:"+tmpid[1]).trigger('click');	  
	}
        $("#root").trigger('click'); 
	var myVar = setInterval(function(){
	console.log(myjson);
		var tmp = -1;
		for(var i = 0;i<myjson.length;i++){
		  if($("#GO\\:"+myjson[i][1]).length){
		    $("#GO\\:"+myjson[i][1]).trigger('click');
		    tmp = i;
		    var node = st.graph.getNode("GO:"+myjson[i][1]);
		    console.log(node.getData('color'));
		    
		    hex = node.getData('color');
		    hex = hex.replace(/^\s*#|\s*$/g, '');
		    if(hex.length == 3)hex = hex.replace(/(.)/g, '$1$1');
		    percent = 20;
		    var r = parseInt(hex.substr(0, 2), 16),
		        g = parseInt(hex.substr(2, 2), 16),
			b = parseInt(hex.substr(4, 2), 16);

		    var newHex = '#' +
		           ((0|(1<<8) + r - (256 - r) * (percent-30) / 100).toString(16)).substr(1) +
			          ((0|(1<<8) + g - (256 - g) * percent / 100).toString(16)).substr(1) +
				         ((0|(1<<8) + b - (256 - b) * percent / 100).toString(16)).substr(1);

		    if(node.getData('color')=='#ccc')node.data.$color = "#FCB6B6";
		    else node.data.$color = newHex;
		    //node.setData('width', 30);
		    //st.fx.animate({  
		     // modes: ['node-property:width'],  
		      //  duration: 1000  
			//}); 
		    break;
		    //myjson.splice(i,1);

		  }
		  //delete myjson[tmp];
		// myjson.splice(tmp,1);
		  //console.log(myjson.length);
		}
		if(tmp!=-1)myjson.splice(tmp,1);
		if(myjson.length > 0 ){}
		else{
		  clearInterval(myVar);
		}
	}, 2000);

      }); 
    
    }); 
    $("#search-btn").click(function(){
        var g_term = $("#search-txt").val();
        window.location="http://dragon.bio.purdue.edu:4567/" + g_term + "";

    });
     $( "#slider-range-min" ).slider({
      range: "min",
      value: 200,
      min: 10,
      max: 700,
      slide: function( event, ui ) {
        $( "#amount" ).val( ui.value );
        st.config.levelDistance = ui.value;
       
        st.refresh();
        //console.log(st.config.levelDistance);
      }
    });
    $( "#amount" ).val( $( "#slider-range-min" ).slider( "value" ) );
    
    $( "#slider-height-min" ).slider({
      range: "min",
      value: 20,
      min: -100,
      max: 100,
      slide: function( event, ui ) {
        $( "#amount2" ).val( ui.value );
        st.config.siblingOffset = ui.value;
       
        st.refresh();
        //console.log(st.config.levelDistance);
      }
    });
    $( "#amount2" ).val( $( "#slider-height-min" ).slider( "value" ) );
    
    
    $("#match-path-btn").click(function(){
            //console.log("aaaa");
           
		     
             event.preventDefault();
            var temp_terms = $("#submit-txt").val().split("\n");
            
            var re = /GO\:\d{7}/;
            var g_terms = new Array();
            temp_terms.forEach(function(entry){
                console.log(entry);
            	var tmp = re.exec(entry);
            	console.log(tmp);
            	
            	if(tmp!=null)g_terms.push(tmp[0]);
            });
            
            //console.log(g_terms);
            g_terms.forEach(function(id){
            	//arrayNodes.push(id);
            	matchPath(id);
            });
           
            
    	});
    	// only showing nodes on path
    	 function matchPath(term){
        	
       		var g_term = term;
      		$.getJSON("http://dragon.bio.purdue.edu:4567/get_path/"+g_term+"",function(json){
      		console.log(json);
      		var type = "replot";
      		
      		for(var i = 0; i< Object.keys(json).length; i++){
      			
      			if(json[i].id == "all")continue;
      			
      			subtree = json[i];
      			subtree.id = json[i].id;  
    			Log.write("adding subtree...");    
    			//add the subtree  
    			st.addSubtree(subtree, type, {  
        		hideLabels: false,  
        		onComplete: function() {
        			st.compute();
            		Log.write("subtree added");  
       	 		}
       	 		  
    			});  
			
      		}
        	
			});
		}
        
}
