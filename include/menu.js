var ie5= (document.getElementById && document.all);
var ns6= (document.getElementById && !document.all);

var MenuTop = 50;    // posizione del menu rispetto alla parte superiore della pagina
var MenuLeft = 153;  // spostamento del menu

var timerID1 = null;
var timerID2 = null;
    
function statik(){
	if(ie5){
    		document.getElementById('menu').style.top = document.body.scrollTop + MenuTop;
    	} 
    	if(ns6){
    		document.getElementById('menu').style.top = window.pageYOffset + MenuTop;
    	}
}

function changeBG(obj, bgColor) {
   	if(ie5 || ns6){
	    	obj.style.backgroundColor = bgColor;
	}
}

function slideIn(){
	if(ie5 || ns6){
		if(parseInt(document.getElementById('menu').style.left) < 0){
			clearTimeout(timerID2);
			document.getElementById('menu').style.left = parseInt(document.getElementById('menu').style.left) + 5 + "px";
			timerID1=setTimeout("slideIn()", 5);
		}
	}
}

function slideOut(){
	if(ie5 || ns6){
		if(parseInt(document.getElementById('menu').style.left) > -MenuLeft){
			clearTimeout(timerID1);
			document.getElementById('menu').style.left = parseInt(document.getElementById('menu').style.left) - 5 + "px";
			timerID2=setTimeout("slideOut()", 5);
		}
	}
}

function reDo(){ 
	if(ie5 || ns6){
		window.location.reload(); 
	}
}

function slideMenuInit(){
    	if(ie5 || ns6){
		document.getElementById('menu').style.visibility = "visible";
		document.getElementById('menu').style.left = -MenuLeft;
		document.getElementById('menu').style.top = MenuTop;
	}
}


window.onresize = reDo;
setInterval ('statik()', 1);