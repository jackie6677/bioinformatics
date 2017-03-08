function getPredGOFromServer(url) {
    $.isLoading({ text: "Loading", 
    tpl: '<span class="isloading-wrapper isloading-show isloading-overlay">Loading...<i class="icon-refresh icon-spin"></i></span>', });
                            
    $.get(url, function (data) {
        
        var re = /job_id=[0-9]+_*[0-9]*/gi;
        var tmp = re.exec(url);
        if (tmp == null) {
            $.isLoading( "hide" );
            return;
        }
        tmp = tmp[0].replace("job_id=","").split("_");
        var subid = "";
        if (tmp.length == 2) {
            subid = parseInt(tmp[1]);
        }
        console.log(subid);
        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(data,"text/xml");
        
        
        var preds = "";
        if (subid != "" && !_.isNaN(subid)) {
            var seqXml = xmlDoc.getElementsByTagName("sequence")[subid-1];
            preds = seqXml.getElementsByTagName("prediction");
        } else {
            preds = xmlDoc.getElementsByTagName("prediction");
        }
        
        var filtered_go_list = getFilteredGOFromPreds(preds, xmlDoc);

		//var re = /GO:[0-9]{7,7}/gi;
		//var terms = res.match(re);
        var terms = filtered_go_list;
        
		$("#go-pair").tokenInput("clear");
	
		for (var term in terms){
			if (terms[term].length == 10 )$("#go-pair").tokenInput("add", {id: terms[term]});
			else if (terms[term].length >= 1 ){
				fileDisplayArea0.innerText += "GO Term: "+terms[term]+" could not be parsed! ";
			}
		}
        
        $.isLoading( "hide" );
        
        if (terms.length == 0) {
            alert("No GO term above moderate cutoff!");
        }
    }); 
}


function getFilteredGOFromPreds(preds, xmlDoc) {
    var golist = _.object(_.map(preds, function(pred){
        
        if ( xmlDoc.getElementsByTagName("PFP_Job").length == 0 )
        {
            var go = pred.getElementsByTagName("term")[0].childNodes[0].nodeValue;
            var score = pred.getElementsByTagName("probability")[0].childNodes[0].nodeValue;;
            return [go, {"score":score, "id":go}];
        } else {
            var go = pred.getElementsByTagName("GO_TERM")[0].childNodes[0].nodeValue;
            var score = pred.getElementsByTagName("raw_score")[0].childNodes[0].nodeValue;;
            return [go, {"score":score, "id":go}];
        }
        
    }));
    return _.uniq(_.pluck(_.filter(golist, function(go){
        if ( xmlDoc.getElementsByTagName("PFP_Job").length == 0 )
        {
            return parseFloat(go['score']) >= 0.4;
        } else {
            return parseFloat(go['score']) >= 500;
        }

    }),'id'));
}



function getPredProAndGOFromServer(url) {
    $.isLoading({ text: "Loading", 
    tpl: '<span class="isloading-wrapper isloading-show isloading-overlay">Loading...<i class="icon-refresh icon-spin"></i></span>', });
                            
    $.get(url, function (data) {
        
        var re = /job_id=[0-9]+_*[0-9]*/gi;
        var tmp = re.exec(url);
        if (tmp == null) {
            $.isLoading( "hide" );
            return;
        }
        tmp = tmp[0].replace("job_id=","").split("_");
        var subid = "";
        if (tmp.length == 2) {
            subid = parseInt(tmp[1]);
        }
        console.log(subid);
        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(data,"text/xml");
        
        
        var seqs = "";
        if (subid != "" && !_.isNaN(subid)) {
            $.isLoading( "hide" );
            return;
        } else {
            seqs = xmlDoc.getElementsByTagName("sequence")
        }
        
        
        var prolist = _.object(_.map(seqs, function(seq, index){

            var seqXml = xmlDoc.getElementsByTagName("sequence")[index];
            var preds = seqXml.getElementsByTagName("prediction");
            var des = seqXml.getElementsByTagName("description")[0].childNodes[0].nodeValue;
            des = des.replace(/[^a-z0-9 |]/gi,'').replace(/ /gi,"_").substring(0,10);
            var gos = getFilteredGOFromPreds(preds, xmlDoc);
            return [des, {"preds":gos, "name":des}];
                        
        }));
        
        var sb = _.reduce(prolist, function(accumulator, currentItem){
            if (currentItem['preds'].length == 0) {
                return accumulator;
            }
            accumulator += currentItem["name"];
            accumulator += " ";
            currentItem['preds'].forEach(function(go) {
                accumulator += go;
                accumulator += ",";
            });
            accumulator += "\n";
            return accumulator;
                
        }, "");;
        
        document.getElementById("mp-submit-txt").value = sb;
        $.isLoading( "hide" );			
    });
}