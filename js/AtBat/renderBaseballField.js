document.getElementById("content").style.width = "1100px";
document.getElementById("page").style.width = "1100px";

$("#redbar").append($("#span-23"));

var drawingCanvas = document.getElementById('myDrawing');


// Check the element is in the DOM and the browser supports canvas
if(drawingCanvas.getContext) {
// Initaliase a 2-dimensional drawing context
	var basecanvas = drawingCanvas.getContext('2d');
//Canvas commands go here
}

basecanvas.beginPath();

function printBases(){
	basecanvas.save();
	basecanvas.restore();

	// Create the yellow face
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = "#FFFFFF";

	//1B
	basecanvas.beginPath();
	basecanvas.moveTo(345,180);
	basecanvas.lineTo(355,185); // \
	basecanvas.lineTo(365,180); //  /
	basecanvas.lineTo(355,175); //  \
	basecanvas.lineTo(345,180); // /
	basecanvas.stroke();

	//2B
	basecanvas.beginPath();
	basecanvas.moveTo(242,152);
	basecanvas.lineTo(252,157); // \
	basecanvas.lineTo(262,152); //  /
	basecanvas.lineTo(252,147); //  \
	basecanvas.lineTo(242,152); // /
	basecanvas.stroke();

	//3B
	basecanvas.beginPath();
	basecanvas.moveTo(140,180);
	basecanvas.lineTo(150,185); // \
	basecanvas.lineTo(160,180); //  /
	basecanvas.lineTo(150,175); //  \
	basecanvas.lineTo(140,180); // /
	basecanvas.stroke();

	//PLATE
	basecanvas.beginPath();
	basecanvas.moveTo(242,230);
	basecanvas.lineTo(252,235); // \
	basecanvas.lineTo(262,230); //  /
	basecanvas.lineTo(262,225); // |
	basecanvas.lineTo(242,225); // |
	basecanvas.lineTo(242,230); //
	basecanvas.stroke();

	basecanvas.save();
}

basecanvas.beginPath();
var imageObj = new Image();
imageObj.onload = function() {
	basecanvas.drawImage(imageObj, -2, 85);
	printBases();
}
imageObj.src = 'images/Field.png';
basecanvas.stroke();
basecanvas.closePath();
basecanvas.beginPath();
basecanvas.globalCompositeOperation = 'source-over';
