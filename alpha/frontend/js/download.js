d3.select("#save").on("click", function(){
  //saveSvgAsPng(document.getElementById("diagram"), "diagram.png", 3);
  
  var text = "
<style type='text/css'>
		svg {
	  		overflow:scroll;
	  		width:100%;
	  		height:100%;
		}

		text {
		  font-weight: 300;
		  font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serf;
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
		  stroke-width: 1.5px;
		  fill: none;
		}
    </style> <script src='http://d3js.org/d3.v3.min.js'></script>
    "
    
    ;
  text += "<svg>";
  text += d3.select("svg").html();
  text += "</svg>";
  console.log(text);
  var blob = new Blob([text], {type: "text/plain;charset=utf-8"});
  saveAs(blob, "hello world.txt");
 
});

