var zoomBar;
var newLine;
function drawActivityBar()
{
	/*var activityBardiv=document.getElementById("activityBarDiv");
	var svg= $("<svg/>").attr("width","1080").attr("height","30").attr("id","svg").attr('xmlns','http://www.w3.org/2000/svg');

	var activityBar= $("<rect/>").attr("width","1080").attr("height","30").attr("x","10").attr("y","30").attr("id","activityBar");
	
	var newLine= $("<line/>").attr("x1","0").attr("y1","0").attr("x2","0").attr("y2","0").attr("id","selector");
	
	var zoomBar= $("<rect/>").attr("width","300").attr("height","30").attr("x","10").attr("y","30").attr("id","zoomBarView");
	
	svg.append(activityBar);
	svg.append(newLine);
	svg.append(zoomBar);
	
	
	activityBardiv.appendChild(svg[0]);*/
	
	//Find your root SVG element
	 var svg = document.getElementById('svg');
	 var activityBar = document.getElementById('activityBarView');
	 zoomBar= document.getElementById("zoomBarView");
	 newLine = document.getElementById("selector");
	// Create an SVGPoint for future math
	var pt = svg.createSVGPoint();
	
	// Get point in global SVG space
	function cursorPoint(evt){
	  pt.x = evt.clientX; pt.y = evt.clientY;
	  return pt.matrixTransform(svg.getScreenCTM().inverse());
	}
	
	activityBar.addEventListener('mousemove',function(evt){
		  var loc = cursorPoint(evt);
		  // Use loc.x and loc.y here
		  /*if(mousedown)
		  {
			if(loc.x>1080)
		  	{
				 evt.preventDefault();
		  	}
			  drawZoomBar(loc.x,30);
		  }*/
		//  console.log(loc);
		},false);
	
	activityBar.addEventListener('mouseout',function(){
		// mousedown=false;
	//	  console.log("blur");
		},false);
	
	var mousedown=false;
	activityBar.addEventListener('mousedown',function(evt){
		  var loc = cursorPoint(evt);
//		  console.log("Mouse down");
		  mousedown=true;
		},false);
	
	activityBar.addEventListener('mouseup',function(evt){
		  var loc = cursorPoint(evt);
		  // Use loc.x and loc.y here
		  		  mousedown=false;

//		  console.log("Mouse up");
		},false);
	
	activityBar.addEventListener('click',function(evt){
		  var loc = cursorPoint(evt);
		  // Use loc.x and loc.y here
//		  console.log("Click"+loc);
 		 // drawLine(loc.x);
		 // zoomBar.style.visibility="visible";
		 // newLine.style.visibility="hidden";
		  drawZoomBar(loc.x,20);
		  zoomBarMouseDown=false;
		  newLine.style.visibility="visible";
		  loc.x=10;
		  drawLine(loc.x);
		  
		
		  
		},false);
	
	
	
	var zoomBarMouseDown=false;
	zoomBar.addEventListener('mousemove',function(evt){
		  var loc = cursorPoint(evt);
		  // Use loc.x and loc.y here
		  /*if(zoomBarMouseDown)
			  drawLine(loc.x);*/
//		  console.log(loc);
		},false);
	
	zoomBar.addEventListener('mousedown',function(evt){
//		  console.log("Mouse down");
		  zoomBarMouseDown=true;
		},false);
	
	zoomBar.addEventListener('mouseup',function(evt){
		  		  zoomBarMouseDown=false;
//		  console.log("Mouse up");
		},false);
	
	zoomBar.addEventListener('click',function(evt){
		  var loc = cursorPoint(evt);
		  // Use loc.x and loc.y here
//		  console.log("Click"+loc);
		  zoomBarMouseDown=false;
		  newLine.style.visibility="visible";
		  drawLine(loc.x);
		},false);
	
	
	newLine.addEventListener('click',function(evt){
		  zoomBarMouseDown=false;
		},false);
	
	for(var i=0;i<=24;i++)
	{
		//45 change to 40 because size is decreases to laptop size
		addLine(svg,(i*30)+10,15,(i*30)+10,30,"visible","parent"+i+"Line");
		var text=i;
		if(i<=9)
			text="0"+i;
		/*console.log("x:"+((i*40)+10));*/
		addLabel(text,svg,(i*30)+3,10,10,"parent"+i+"Label","visible");
	}
	
	
	for(var i=0;i<=10;i++)
	{
		addLine(svg,(i*60)+10,80,(i*60)+10,86,"visible","child"+i+"Line");
		var text=i;
		if(i<=9)
			text="0"+i;
		
		addLabel(text,svg,(i*60),75,10,"child"+i+"Label","visible");
	}
	zoomBar.style.visibility="visible";
}
function drawLine(x)
{
	var newLine = document.getElementById("selector");
	newLine.setAttribute('x1',x);
	newLine.setAttribute('y1','79');
	newLine.setAttribute('x2',x);
	newLine.setAttribute('y2','119');
	var time=calculateTime(x-10);
	newLine.setAttribute("title", time);
	//timeSelected(time);
	}

function calculateTime(position)
{
	var minute=getMinute(parentPosition);
	var hour=getHour(parentPosition);
	var childMinutes=(position*4/60);
	
	var childSeconds=((position*4)%60);
	
	var totalMinutes=minute+parseInt(childMinutes);
	if(totalMinutes>=60)
	{
		hour++;
		totalMinutes=totalMinutes-60;
	}
	if(hour<=9)
		hour="0"+hour;
	if(totalMinutes<=9)
		totalMinutes="0"+totalMinutes;
	if(childSeconds<=9)
		childSeconds="0"+childSeconds;
	
	return hour+":"+totalMinutes+":"+childSeconds;
}
var svgns = "http://www.w3.org/2000/svg";

function drawZoomBar(x,width)
{
	//console.log("x:"+x+"width:"+width);
	var hafPosition=width/2;
	x=x-hafPosition;
	if(x<10)
		x=10;
	if((x+width)>=730)
		x=730-width;
	/*console.log("after x:"+x);*/
	var newLine = document.getElementById("zoomBar");
	newLine.setAttribute('x',x);
	newLine.setAttribute('y','29');
	newLine.setAttribute('width',width);
	newLine.setAttribute('height','22');
	newLine.setAttribute("visibility", "visible");
	parentPosition=x-10;
	updateZoomView(parentPosition);
	
}
var zoomBarWidth=20;
var zoomBarMinutes=30;
var pixelsInMinute=30;
var noOfMinutesInHour=60;
var parentPosition;
/*alert("pixelsInMinute:"+pixelsInMinute+"zoomBarMinutes:"+zoomBarMinutes);*/
function updateZoomView(position)
{
	//console.log("updateZoomBar :"+position);
	for(var i=0;i<=10;i++)
	{
		var line=document.getElementById("child"+i+"Line");
		line.setAttribute("visibility", "visible");
		var lbl=document.getElementById("child"+i+"Label");
		lbl.setAttribute("visibility", "visible");
	    var minute=getMinute(position);
	    var hour=getHour(position);
	    
	    if(minute<=9)
	    	minute="0"+minute;
	    
	    if(hour<=9)
	    	hour="0"+hour;
	    
	/*console.log("minute:"+minute+"hour"+hour);*/
	lbl.childNodes[0].data=hour+":"+minute;
	position+=2;
	//position increase is zoom bar view is position is 2(00:00 to 00:26)
	//position increase is zoom bar view is position is 3(00:00 to 00:40)
	//position increase is zoom bar view is position is 4(00:00 to 00:53)

	}
}


function hideZoomView()
{
	var newLine = document.getElementById("zoomBar");
	newLine.setAttribute("visibility", "visible");
	
	 var zoomBar= document.getElementById("zoomBarView");
	 zoomBar.style.visibility="visible";
	 
	 var selector = document.getElementById("selector");
	 selector.style.visibility="visible";
	 
	for(var i=0;i<=10;i++)
	{
		var line=document.getElementById("child"+i+"Line");
		line.setAttribute("visibility", "visible");
		var lbl=document.getElementById("child"+i+"Label");
		lbl.setAttribute("visibility", "visible");
	}
}


function getMinute(position)
{
	position=(position%pixelsInMinute);
	
	return parseInt((noOfMinutesInHour/pixelsInMinute)*position);
}


function getHour(position)
{
	return parseInt((position/pixelsInMinute));
	
}



function addLabel(text,parent,x,y,fontSize,id,visibility)
{
	var rect = document.createElementNS(svgns, 'text');
	rect.setAttribute('x', x);
	rect.setAttribute('y', y);
	rect.setAttribute('id', id);
	rect.setAttribute('fill', 'Black');
	rect.setAttribute("font-size",fontSize);
	rect.setAttribute("visibility",visibility);
	var textNode = document.createTextNode(text);
	rect.appendChild(textNode);

	parent.appendChild(rect);
}

function addLine(parent,x1,y1,x2,y2,visibility,id)
{
	var rect = document.createElementNS(svgns, 'line');
	rect.setAttribute('x1', x1);
	rect.setAttribute('id', id);
	rect.setAttribute('y1', y1);
	rect.setAttribute('x2', x2);
	rect.setAttribute('y2', y2);
	rect.setAttribute('fill', 'Black');
	rect.setAttribute('stroke', '#000000');
	rect.setAttribute("visibility",visibility);

	parent.appendChild(rect);
}

function addElement(text,parent,x,y)
{
	var rect = document.createElementNS(svgns, 'rect');
	rect.setAttributeNS(null, 'x', x);
	rect.setAttributeNS(null, 'y', y);
	rect.setAttributeNS(null, 'height', '50');
	rect.setAttributeNS(null, 'width', '50');
	rect.setAttributeNS(null, 'fill', '#'+Math.round(0xffffff * Math.random()).toString(16));
	document.getElementById('svgOne').appendChild(rect);
}

function loadInitialSelection()
{
	 zoomBar.style.visibility="visible";
	 newLine.style.visibility="visible";
	drawZoomBar(10, 20);
	newLine.style.visibility="visible";
	drawLine(11);
}

function on_mouse_move(e) {
	var event=e;
	  varx = event.clientX,
	    y = event.clientY;
	  document.getElementById("XLOc").html(x);
	  document.getElementById("YLOc").html(y);
	}