(function() {
  var out$ = typeof exports != 'undefined' && exports || this;

  var doctype = '<?xml version="1.0" standalone="no"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';

  function inlineImages(callback) {
    var images = document.querySelectorAll('svg image');
    var left = images.length;
    if (left == 0) {
      callback();
    }
    for (var i = 0; i < images.length; i++) {
      (function(image) {
        var href = image.attributes['xlink:href'].nodeValue;
        if (/^http/.test(href) && !(new RegExp('^' + window.location.host).test(href))) {
          throw new Error("Cannot render embedded images linking to external hosts.");
        }
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var img = new Image();
        img.src = image.getAttribute('xlink:href');
        img.onload = function() {
          canvas.width = img.width;
          canvas.height = img.height;
          ctx.drawImage(img, 0, 0);
          image.setAttribute('xlink:href', canvas.toDataURL('image/png'));
          left--;
          if (left == 0) {
            callback();
          }
        }
      })(images[i]);
    }
  }

  function styles(dom) {
    var used = "";
    /*
    var sheets = document.styleSheets;
    for (var i = 0; i < sheets.length; i++) {
      var rules = sheets[i].cssRules;
      if(rules == null)continue;
      for (var j = 0; j < rules.length; j++) {
        var rule = rules[j];
        if (typeof(rule.style) != "undefined") {
          var elems = dom.querySelectorAll(rule.selectorText);
          if (elems.length > 0) {
            used += rule.selectorText + " { " + rule.style.cssText + " }\n";
          }
        }
      }
    }
*/
    var s = document.createElement('style');
    s.setAttribute('type', 'text/css');
    s.innerHTML = "<![CDATA[\n" + used + "\n]]>";

    var defs = document.createElement('defs');
    //defs.appendChild(s);
    return defs;
  }

  out$.svgAsDataUri = function(el, scaleFactor, cb) {
    scaleFactor = scaleFactor || 1;

    inlineImages(function() {
      var outer = document.createElement("div");
      var clone = el.cloneNode(true);
      var width = $("svg").css("width").replace(/px/g,"");
      var height = $("svg").css("height").replace(/px/g,"");
      var w2 = width;
      var h2 = height;

      var xmlns = "http://www.w3.org/2000/xmlns/";

      clone.setAttribute("version", "1.1");
      clone.setAttributeNS(xmlns, "xmlns", "http://www.w3.org/2000/svg");
      clone.setAttributeNS(xmlns, "xmlns:xlink", "http://www.w3.org/1999/xlink");
      clone.setAttribute("width", width * scaleFactor);
      clone.setAttribute("height", height * scaleFactor);
      clone.setAttribute("viewBox", "0 0 " + w2  + " " + h2);
      outer.appendChild(clone);

      clone.insertBefore(styles(clone), clone.firstChild);

      var svg = doctype + outer.innerHTML;
      svg = svg.replace(/<br>/g,"<br/>");
	  //svg = svg.replace(/<foreignObject/g,"<foreignObject requiredExtensions=\"http://www.w3.org/1999/xhtml\"");
	  svg = svg.replace(/<div/g,"<div xmlns=\"http://www.w3.org/1999/xhtml\"");
	  
	  var blob = new Blob([svg], {type: "text/plain;charset=utf-8"});
	  //saveAs(blob, "figure.svg");
      
      var uri = 'data:image/svg+xml;base64,' + window.btoa(unescape(encodeURIComponent(svg)));
      //var uri = "data:image/svg+xml;utf8,"+svg;
      //console.log(html);
	  //var imgsrc = 'data:image/svg+xml;base64,'+ btoa(svg);
	  //uri = imgsrc;
	  //var myimg = '<img src="'+uri+'">';
	  //d3.select("#svgdataurl").html(myimg);
      if (cb) {
        cb(uri);
      }
    });
  }

  out$.saveSvgAsPng = function(el, name, scaleFactor) {
    out$.svgAsDataUri(el, scaleFactor, function(uri) {
      //console.log("svg:"+uri);
      //$("#downlink").html("");
      var image = new Image();
      
      image.onerror = function() {
	      alert("Error loading the image");
      }
     
      image.onload = function() {
        $("#canvas").show();
        var canvas = document.getElementById('canvas');
      
      	var canvas_final = document.createElement('canvas');
      	canvas_final.width = image.width;
      	canvas_final.height = image.height;
      	var ctx = canvas_final.getContext('2d');
        //canvas.width = image.width;
        canvas.height = 200 * image.height / image.width;
        var context = canvas.getContext('2d');
        context.clearRect(0,0,canvas.width, canvas.height);
        context.rect(0,0,image.width+300, image.height+300);
        context.fillStyle = "#eee";
        
        context.fill();
        context.drawImage(image, 0, 0, 200, 200 * image.height / image.width);
        
        ctx.clearRect(0,0,canvas_final.width, canvas_final.height); 
        ctx.drawImage(image, 0, 0);
		//console.log(image.crossOrigin);
        //var imgg = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");  // here is the most important part because if you dont replace you will get a DOM 18 exception.
		
		
		/* only work for firefox
		var a = document.createElement("a");
		a.download = "figure.png";
		try{
			a.href = canvas_final.toDataURL("image/png");
			a.innerHTML= "Download";
			$("#downlink").append(a);
		}
		catch(err) {
		    alert("Google Chrome does not allow this operation due to a security issue. To download figures, use the link to the figures in the PFP/ESG result page. Or please use Firefox, since FIrefox does not have this security issue.");
		}*/
		
		
		//a.click();
		//window.location.href = a.href; // it will save locally
      }
      image.src = uri;
      //window.location.href = uri;
      //image.crossOrigin = '*';
    });
  }
})();
