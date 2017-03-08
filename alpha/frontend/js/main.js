
	$('[data-toggle="tooltip"]').tooltip(); 
	$('.go-term').typeahead({
	
	    source: function (query, process) {
	        return $.getJSON(
	            '../inc/get_go_term.php',
	            { query: query },
	            function (data) {

				    var newData = [];
				
				    $.each(data, function(){
				
				        newData.push(this.acc+" "+this.name);
				
				    });
				
				    return process(newData);
				
				}); 
	    },
	    
	    updater:function (item) {
			var res = item.split(" ");
	        return res[0];
	    }
	    
	
	});
	
	
	$('#go-parent-query').typeahead({
	
	    source: function (query, process) {
	    	
	    	
	        return $.getJSON(
	            '../inc/get_go_term.php',
	            { query: query },
	            function (data) {

				    var newData = [];
				
				    $.each(data, function(){
				
				        newData.push(this.acc+" "+this.name);
				
				    });
				
				    return process(newData);
				
				}); 
	    },
	    
	    updater:function (item) {
	    
	    	var res = item.split(" ");
	    	$("#parent-vis").html("");
	    	$("#parent-vis").append("<div class='panel panel-default'><iframe frameBorder=\"0\" width=\"100%\" height=\"600\" src=\"../inc/vis.php?go="+res[0]+"\"></iframe></div><br>");
	    	 $.getJSON("../inc/get_path?parent&go="+res[0]+"", function(pjson){
		          //console.log(pjson);
		          var box = document.getElementById("go-parents-box")
		          box.value="";
		          for(var j=0; j<Object.keys(pjson).length;j++){
			 
					  box.value += pjson[j].id;
					  box.value +=", ";
			      
				  }
			
		      }); 
		      
			
	        return res[0];
	    }
	    
	
	});
	

	$('#org').typeahead({
	
	    source: function (query, process) {
	        return $.getJSON(
	            '../inc/get_org.php',
	            { query: query },
	            function (data) {
					console.log(data);
				    var newData = [];
				
				    $.each(data, function(){
				
				        newData.push(this.id);
				
				    });
				
				    return process(newData);
				
				}); 
	    },
	
	
	});
	
	
	$(".protein-go").tokenInput("../inc/get_go_term.php", {
            theme: "facebook",
            propertyToSearch: "id",
            resultsFormatter: function(item){ return "<li>" + "<div class='full_name'>" + item.id + "</div><div class='email'>" + item.name + "</div></div></li>" },
            tokenFormatter: function(item) { return "<li><p>" + item.id +"</p></li>" },
    });
	
	$("#submit1").click(function(){
		$("#method1").submit();
	});
	
	$('#preview').click(function(){
		var gopair = document.getElementById("go-parent-query");
		//console.log(gopair.value);
		var mypair = gopair.value.replace(/,/g,"\\n");
		
		var res = gopair.value.split(",");
		var box = document.getElementById("go-parents-box")
		box.value="";
		console.log(res);
		for (i = 0; i < res.length; i++) {
			//var cur_go = res[i];
	    	 $.getJSON("../inc/get_path.php?parent&go="+res[i]+"", function(pjson){
		          //console.log(pjson);
		          box.value += pjson[Object.keys(pjson).length-1].id + ": ";
		          for(var j=0; j<Object.keys(pjson).length;j++){
			 
					  box.value += pjson[j].id;
					  box.value +=", ";
			      
				  }
				  box.value += "\n\n";
			
		      });
		 }  
		$('#go-pair-vis').remove();
		
		$("#parent-vis").append("<iframe id='go-pair-vis' style='margin-top:5px' frameBorder=\"0\" width=\"100%\" height=\"600\" src=\"../inc/vis.php?go="+mypair+"\"></iframe><br>");
		
	});
	
	$("#submit2").click(function(){
		//console.log($("#protein1").val());
		$("#method2").submit();
	});
	
	$("#submit3").click(function(){
		//console.log($("#protein1").val());
		var x = document.getElementById("check-box");
	    //alert(x.checked);
	    if(x.checked == true){
		    var type = document.getElementById("method-type");
		    type.value = 4;
	    }else{
		    var type = document.getElementById("method-type");
		    type.value = 3;
	    }
		$("#method3").submit();
		
	});
	
	$("#submit4").click(function(event){
		//console.log($("#protein1").val());
		var res = document.getElementById("mp-submit-txt3").value.split(" ");
        if (res == "") {
			fileDisplayAreaEnrich.innerHTML = '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Empty Organism, please choose from the dropdown when typing...</div>';
		    event.preventDefault();
            return;
            
        }
        
		var tmp = document.getElementById("org").value;
		tmp = tmp.replace(/[^0-9]/gm, '');
		document.getElementById("org").value = tmp;
		$("#method4").submit();
        
	});
	function resetTerms(){
		$("#pro-id1").val("");
		$("#pro-id2").val("");
		$("#protein1").tokenInput("clear");
		$("#protein2").tokenInput("clear");
		
	}
	function addterms(){
		$("#pro-id1").val("Q9BX51");
		$("#pro-id2").val("Q9UJ14");
		$("#protein1").tokenInput("clear");
		$("#protein2").tokenInput("clear");
		
		$("#protein1").tokenInput("add", {id: "GO:0003840"});
		$("#protein1").tokenInput("add", {id: "GO:0006749"});
		$("#protein1").tokenInput("add", {id: "GO:0019370"});
		$("#protein1").tokenInput("add", {id: "GO:0031362"});

		
		$("#protein2").tokenInput("add", {id: "GO:0003840"});
		$("#protein2").tokenInput("add", {id: "GO:0006508"});
		$("#protein2").tokenInput("add", {id: "GO:0006749"});
		$("#protein2").tokenInput("add", {id: "GO:0006750"});
		$("#protein2").tokenInput("add", {id: "GO:0016020"});
		$("#protein2").tokenInput("add", {id: "GO:0016021"});
		$("#protein2").tokenInput("add", {id: "GO:0016740"});
		$("#protein2").tokenInput("add", {id: "GO:0016746"});
		$("#protein2").tokenInput("add", {id: "GO:0016787"});
		$("#protein2").tokenInput("add", {id: "GO:0019370"});
		$("#protein2").tokenInput("add", {id: "GO:0031362"});

		
	}
	
	function addtext_parent_vis(){
		$("#go-parent-query").tokenInput("clear");
		$("#go-parent-query").tokenInput("add", {id: "GO:0016064"});
		$("#go-parent-query").tokenInput("add", {id: "GO:0002455"});
		$("#go-parent-query").tokenInput("add", {id: "GO:0019724"});
	}
	
	function rmtext_parent_vis(){
		//$("#go-id1").val("GO:0016064");
		//$("#go-id2").val("GO:0002455");
		$("#go-parent-query").tokenInput("clear");
		
		
	}
	
	function addtext(){
		//$("#go-id1").val("GO:0016064");
		//$("#go-id2").val("GO:0002455");
		$("#go-pair").tokenInput("clear");
		$("#go-pair").tokenInput("add", {id: "GO:0016064"});
		$("#go-pair").tokenInput("add", {id: "GO:0002455"});
		$("#go-pair").tokenInput("add", {id: "GO:0019724"});

	}
	function rmtext(){
		//$("#go-id1").val("GO:0016064");
		//$("#go-id2").val("GO:0002455");
		$("#go-pair").tokenInput("clear");
		
	}
	
	function addtext_method3(){
		
		document.getElementById("mp-submit-txt").value = "A0AVK6 GO:0033301,GO:0008283,GO:0060718,\nA0M8Q6 GO:0006956,GO:0006958,\nA0M8Q7 GO:0006956,GO:0006958,";

	}
	function rmtext_method3(){
		
		document.getElementById("mp-submit-txt").value = "";
	}
	
	
	function addtext_method4(){
		document.getElementById("org").value = "Homo sapiens [9606]";
		document.getElementById("mp-submit-txt3").value = "A0AVK6 GO:0033301,GO:0008283,GO:0060718,\nA0M8Q6 GO:0006956,GO:0006958,";

	}
	function rmtext_method4(){
		document.getElementById("org").value = "";
		document.getElementById("mp-submit-txt3").value = "";
	}
	
	window.onload = function() {
		
			var fileInputParent = document.getElementById('fileInput-parent-vis');
			var fileDisplayParent = document.getElementById('fileDisplayAreaParentVis');
			
			var fileInput0 = document.getElementById('fileInput0');
			var fileDisplayArea0 = document.getElementById('fileDisplayArea0');
			
			var fileInput = document.getElementById('fileInput');
			var fileDisplayArea = document.getElementById('fileDisplayArea');
			var fileInput2 = document.getElementById('fileInput2');
			var fileDisplayArea2 = document.getElementById('fileDisplayArea2');
			
			var fileInputEnrich = document.getElementById('fileInput-go-enrich');
			var fileDisplayAreaEnrich = document.getElementById('fileDisplayAreaEnrich');
			
			var fileInputMp = document.getElementById('fileInput-mp');
			var fileDisplayAreaMp = document.getElementById('fileDisplayAreaMp');
			
			if (fileInputParent != null) {
    			fileInputParent.addEventListener('change', function(e) {
    				var file = fileInputParent.files[0];
    				var textType = /text.*/;
    				if (file.type.match(textType)) {
    					var reader = new FileReader();
    					reader.onload = function(e) {
    						var re = /GO:[0-9]{7,7}/gi;
    						var res = reader.result;
    						//fileDisplayArea.innerText = res[0];
    						var terms = res.match(re);
    						//console.log(terms.length);
    						$("#go-parent-query").tokenInput("clear");
						
    						for(var term in terms){
    							console.log(terms[term]);
							
    							if(terms[term].length == 10 )$("#go-parent-query").tokenInput("add", {id: terms[term]});
    							else if(terms[term].length >= 1 ){
    								fileDisplayParent.innerHTML += '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>GO Term: '+terms[term]+' could not be parsed! </div>';
    							}
    						}
    					}
    					reader.readAsText(file);	
    				} else {
    					fileDisplayParent.innerHTML = "File not supported!";
    				}
    			});
            }
			
            if (fileInput0 != null) {
    			fileInput0.addEventListener('change', function(e) {
    				var file = fileInput0.files[0];
    				var textType = /text.*/;
	
    				if (file.type.match(textType)) {
    					var reader = new FileReader();
	
    					reader.onload = function(e) {
						
    						var re = /GO:[0-9]{7,7}/gi;
    						var res = reader.result;
    						//fileDisplayArea.innerText = res[0];
						
    						var terms = res.match(re);
						
    						//console.log(terms.length);
    						$("#go-pair").tokenInput("clear");
						
    						for(var term in terms){
						
    							//console.log(terms[term]);
							
    							if(terms[term].length == 10 )$("#go-pair").tokenInput("add", {id: terms[term]});
    							else if(terms[term].length >= 1 ){
    								fileDisplayArea0.innerText += "GO Term: "+terms[term]+" could not be parsed! ";
    							}
    						}
    					}
    					reader.readAsText(file);	
    				} else {
    					fileDisplayArea0.innerText = "File not supported!";
    				}
    			});
            }
			
			if (fileInput != null) {
    			fileInput.addEventListener('change', function(e) {
    				var file = fileInput.files[0];
    				var textType = /text.*/;
	
    				if (file.type.match(textType)) {
    					var reader = new FileReader();
    					reader.onload = function(e) {
    						var res = reader.result.split("\n");
    						//fileDisplayArea.innerText = res[0];
    						var line1 = res[0];
    						var tmp = line1.split(" ");
    						var pro1 = tmp[0];
    						tmp = tmp[1];
    						var terms = tmp.split(",");
    						//console.log(terms.length);
    						$("#pro-id1").val(pro1);
    						for(var term in terms){
    							//console.log(terms[term]);
    							if(terms[term].length >= 10 )$("#protein1").tokenInput("add", {id: terms[term]});
    						}
    						var line2 = res[1];
    						tmp = line2.split(" ");
    						var pro2 = tmp[0];
    						tmp = tmp[1];
    						terms = tmp.split(",");
    						//console.log(terms.length);
    						$("#pro-id2").val(pro2);
    						for(var term in terms){
						
    							//console.log(terms[term]);
    							if(terms[term].length >= 10 )$("#protein2").tokenInput("add", {id: terms[term]});
    						}
    					}
    					reader.readAsText(file);	
    				} else {
    					fileDisplayArea.innerText = "File not supported!"
    				}
    			});
            }
			
			if (fileInputMp != null) {
    			fileInputMp.addEventListener('change', function(e) {
    				var file = fileInputMp.files[0];
    				var textType = /text.*/;
					
    
    				if (file.type.match(textType)) {
    					var reader = new FileReader();
	
    					reader.onload = function(e) {
							
							
    						//var res = reader.result;
    						
/*
    						$.isLoading({ text: "Loading", 
    tpl: '<span class="isloading-wrapper isloading-show isloading-overlay">Loading...<i class="icon-refresh icon-spin"></i></span>', });
    						$.post( "../tools/format_checker.php", { file: res }, function( data ) {
							  $("#mp-submit-txt").val(data);
							  $.isLoading( "hide" );
							}, "json");
							
*/
    						//fileDisplayArea.innerText = res[0];
							
/*
    						for(var line in res){
    							console.log(res[line])
    							if(res[line].length < 1)continue;
    							var line = res[line];
    							var tmp = line.split(" ");
    							var pro1 = tmp[0];
    							tmp = tmp[1];
							
    							if(tmp == undefined){
    								fileDisplayAreaMp.innerText = "File format not supported!";
    							}
    							var terms = tmp.split(",");
							
    							if(terms == undefined){
    								fileDisplayAreaMp.innerText = "File format not supported!";
    							}
    							//console.log(terms.length);
    							var prev = $("#mp-submit-txt").val();
    							prev += pro1;
    							prev += " ";
							
    							for(var term in terms){
							
    								//console.log(terms[term]);
    								if(terms[term].length >= 10 ){
    									prev += terms[term];
    									prev += ",";
									
    								}
    							}
							
    							prev += "\n";
							
    							//$("#mp-submit-txt").val(prev);
    							//$("#mp-submit-txt2").val(prev);
    							
							
    						}
*/
						
    						//var res = document.getElementById("mp-submit-txt").value.split(" ");
				        
						
						
    					}
	
    					//reader.readAsText(file);
	
    				} else {
    					//fileDisplayAreaMp.innerText = "File not supported!";

    				}
    			});

            }
			
            if (fileInputEnrich != null) {
    			fileInputEnrich.addEventListener('change', function(e) {
    				var file = fileInputEnrich.files[0];
    				var textType = /text.*/;
    				console.log("enrichment");
    				if (file.type.match(textType)) {
    					var reader = new FileReader();
	
    					reader.onload = function(e) {
						
    						var res = reader.result.split("\n");
    						//fileDisplayArea.innerText = res[0];
						
    						for(var line in res){
    							console.log(res[line])
    							if(res[line].length < 1)continue;
    							var line = res[line];
    							var tmp = line.split(" ");
    							var pro1 = tmp[0];
    							tmp = tmp[1];
							
    							if(tmp == undefined){
    								fileDisplayAreaEnrich.innerText = "File format not supported!";
    							}
    							var terms = tmp.split(",");
							
    							if(terms == undefined){
    								fileDisplayAreaEnrich.innerText = "File format not supported!";
    							}
    							//console.log(terms.length);
    							var prev = $("#mp-submit-txt3").val();
    							prev += pro1;
    							prev += " ";
							
    							for(var term in terms){
							
    								//console.log(terms[term]);
    								if(terms[term].length >= 10 ){
    									prev += terms[term];
    									prev += ",";
									
    								}
    							}
							
    							prev += "\n";
							
    							//$("#mp-submit-txt").val(prev);
    							//$("#mp-submit-txt2").val(prev);
    							$("#mp-submit-txt3").val(prev);
							
    						}
						
    						var res = document.getElementById("mp-submit-txt3").value.split(" ");
				        
    						$.get("http://www.uniprot.org/uniprot/"+res[0]+".xml", function(data){
    							//console.log(data);
    							  var organism = data.getElementsByTagName("organism")[0];
    							  if (organism) {
    							  	var name = organism.getElementsByTagName("name")[0].innerHTML;
    							    var dbref = organism.getElementsByTagName("dbReference")[0];
    							    if (dbref) {
    							     	console.log(dbref.getAttribute("id"));
    							     	//$("#org").value = dbref.getAttribute("id");
    							     	//console.log();
    							     	document.getElementById("org").value = name+" ["+dbref.getAttribute("id")+"]";
    							    }
    							  }
    						}).fail(function(){
    							fileDisplayAreaEnrich.innerHTML = '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Could Not Find Organism Based on First Protein Name: <b>'+res[0]+'</b> could not be parsed! Please Input Manually.</div>';
    						});
						
						
    					}
	
    					reader.readAsText(file);	
    				} else {
    					fileDisplayAreaEnrich.innerText = "File not supported!"
    				}
    			});
            }
	}

	

    $('#mp-submit-txt3').bind('input propertychange', function() {
		
	      if(this.value.length){
	        //console.log(document.getElementById("mp-submit-txt3").value);
	        var res = document.getElementById("mp-submit-txt3").value.split(" ");
	        console.log( res[0] );
			$.get("http://www.uniprot.org/uniprot/"+res[0]+".xml", function(data){
				//console.log(data);
				  var organism = data.getElementsByTagName("organism")[0];
				  if (organism) {
				  	var name = organism.getElementsByTagName("name")[0].innerHTML;
				    var dbref = organism.getElementsByTagName("dbReference")[0];
				    if (dbref) {
				     	console.log(dbref.getAttribute("id"));
				     	//$("#org").value = dbref.getAttribute("id");
				     	//console.log();
				     	document.getElementById("org").value = name+" ["+dbref.getAttribute("id")+"]";
				    }
				  }
			}).fail(function(){
							fileDisplayAreaEnrich.innerHTML = '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Could Not Find Organism Based on First Protein Name: <b>'+res[0]+'</b> Please Input Manually.</div>';
						});
	      }
	});
	