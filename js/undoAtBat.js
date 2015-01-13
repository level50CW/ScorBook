/**
 * @author Jonathan Lizano
 */

var playerid = 0; //Player id of user with Out
var BatterNumberOut = 0; // Batter number of player with Out

function deleteEvent(id){
	url='index.php?r=events/delete&id='+id;
	data=new Object();
	data['id']=id;
	data['r']='events/delete';
	
	$.ajax({
	  type: 'POST', // type of request either Get or Post
	  url: url, // Url of the page where to post data and receive response 
	  //data: data, // data to be post
	  //success: function(data){ alert(data); } //function to be called on successful reply from server
	  });

}

function undoRBItext(){
	
	if ($('#RBI').css('color')=='rgb(255, 255, 255)') {
		var box = document.getElementById("RBI");
		//Pitcher stats
		document.getElementById("pR"+pitcher).value = parseInt(document.getElementById("pR"+pitcher).value, 10)-1;
		document.getElementById("pER"+pitcher).value = parseInt(document.getElementById("pER"+pitcher).value, 10)-1;
		
		//Batter stats
		document.getElementById("RBI"+batter).value = parseInt(document.getElementById("RBI"+batter).value, 10)-1;
		
		switch (box.value){
			case "RBI":
				if ($('#RBI').css('color')=='rgb(255, 255, 255)'){
					$('#RBI').attr('style',"color: #999999 !important");
				}
				
				break;
			case "RBI2":
				box.value = "RBI";
				break;
			case "RBI3":
				box.value = "RBI2";
				break;
			case "RBI4":
				box.value = "RB3";
				$('#RBI').attr('style',"color: #999999 !important");
				break;
			
		}
		
		
		
	}
	
	document.getElementsByName("Events[RBI][]")[eventscounter].value = document.getElementById("RBI").value;
}



function undorunplate(){
	batterNumber3=batterNumber4;
	hitterBase3=hitterBase4;
	setBatterBase('batterNumber3',batterNumber3);
	setHitterBase('hitterBase3',hitterBase3);
	setBatterBase('batterNumber4',0);
	setHitterBase('hitterBase4',0);
	//Score table
	//Team's runs
	document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)-1;
	//R
	document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)-1;
	undoRBItext();
	batterNumber4=0;
	hitterBase4=0;
	//storeEvent("runplate");
	//clearb3();
	//r4();
	clearplate();
	//RBItext();
	
	
}

function undorunb1(){
	setHitterBase('hitterBase1',0);
	hitterBase1 = 0;
	setBatterBase('batterNumber1',0);
	clearb1();
}


function undorunb2(){
	batterNumber1=batterNumber2;
	hitterBase1=hitterBase2;
	setBatterBase('batterNumber1',batterNumber1);
	setHitterBase('hitterBase1',hitterBase1);
	setBatterBase('batterNumber2',0);
	setHitterBase('hitterBase2',0);
	batterNumber2=0;
	hitterBase2=0;
	//storeEvent("runplate");
	clearb2();
	//r4();
	//plate();
	//RBItext();
	
}

function undorunb3(){
	batterNumber2=batterNumber3;
	hitterBase2=hitterBase3;
	setBatterBase('batterNumber2',batterNumber2);
	setHitterBase('hitterBase2',hitterBase2);
	setBatterBase('batterNumber3',0);
	setHitterBase('hitterBase3',0);
	batterNumber3=0;
	hitterBase3=0;
	//storeEvent("runplate");
	clearb3();
	//r4();
	//plate();
	//RBItext();
	
}

function undooutb3(hitterP, batterNumberOutP){
	hitterBase3=hitterP;
	batterNumber3=batterNumberOutP;
	setHitterBase('hitterBase3',hitterP);
	setBatterBase('batterNumber3',batterNumberOutP);
	
}

function undooutb2(hitterP, batterNumberOutP){
	hitterBase2=hitterP;
	batterNumber2=batterNumberOutP;
	setHitterBase('hitterBase2',hitterP);
	setBatterBase('batterNumber2',batterNumberOutP);

}

function undooutb1(hitterP, batterNumberOutP){
	hitterBase1=hitterP;
	batterNumber1=batterNumberOutP;
	setHitterBase('hitterBase1',hitterP);
	setBatterBase('batterNumber1',batterNumberOutP);
	
}


function undo(){
	

  if (eventscounter) {
		
	
	//Restore canvas
	if (restorePoints.length > 0) {
		// Create a new Image object
		var oImg = new Image();
		// When the image object is fully loaded in the memory...
		oImg.onload = function() {
			// Get the canvas context
			//var canvasContext = drawingCanvas.getContext("2d");		
			// and draw the image (restore point) on the canvas. That would overwrite anything
			// already drawn on the canvas, which will basically restore it to a previous point.
			basecanvas.drawImage(oImg, 0, 0);
		}
		// The source of the image, is the last restoration point
		oImg.src = restorePoints.pop();
	}
	var x = document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter];
	
	//Remove event from form
	
	//if (x.value !=37){//If event different to OUT
		
		
		
	//} 
	
		//Remove stats
		if ( events[events.length-1] != 'out' )  {
			var undoevent = events.pop()
		}else {
			var undoevent = events[events.length-1];
		} 
	
	
		if (undoevent){
			undoEvent(undoevent);
			//Print bases again after clear the field	
			idevents = 0;
			InitBases();
		}
		
		
		
	}
	
	

	
}

function deleteEventDB(){
	//Delete event from database if exists 
	idevent = document.getElementsByName("Events[idevents][]")[eventscounter].value;
	if ( idevent ) 
		deleteEvent(idevent);
		
	document.getElementById("events-form").removeChild(document.getElementById("events-form").lastChild);
	eventscounter--;
	  
	
}

function undoBases() { //Undo runbase X
		switch ( document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value ) {
				case '40': // //'2b':
					//undorunb2();
					return hitterBase2;
				break;
				case '41': //'3b':
					//undorunb3();
					return hitterBase3;
				break;
				case  '42': //'4b':
					//undorunplate();
					//Score table
					//Team's runs
					//document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)-1;
					//R
					//document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)-1;
					//undoRBItext();
					return hitterBase4; 
				break;
				case '66':  //Stolen Base // check MISCE with the base 
				
				case '67': //Passed ball // check MISCE with the base 
				case '68':
				case '69':
				case '70':
				case '71':
				case '72':
				case '73':
				case '74':
				case '75':
				case '76':
					switch ( document.getElementsByName("Events[Misce][]")[eventscounter].value ) {
						
						case '2b':
							undorunb2();
							return hitterBase1;
						break;
						case '3b':
							undorunb3();
							return hitterBase2;
						break;
						case '4b':
							undorunplate();
							return hitterBase3;
						break;
						
					}
					
				break;
				
			}
}

function undoOutBase(playerid, batterNumberOut) { //Undo out on base X
		switch ( document.getElementsByName("Events[Misce][]")[eventscounter].value ) {
				case '2b':
					undooutb1(playerid, batterNumberOut);
					return hitterBase1;
				break;
				case '3b':
					undooutb2(playerid, batterNumberOut);
					return hitterBase2;
				break;
				case '4b':
					undooutb3(playerid, batterNumberOut);
					return hitterBase3; 
				break;
			}
}

//Undo stats of event 
function undoEvent(eventtype){
	
	switch (eventtype){
		
		case "HR":
		statshr(-1);
		document.getElementById("RBI").value = "";
		document.getElementById("T1").value = "";
		document.getElementById("ER").value = "";
		document.getElementById("B4").value = "";
		if (play > 1) getBasesEvent(play,Lineup_idlineup);
		deleteEventDB();	
		break;
		
		case "3B":
		stats3b(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B3").value = ""; 
		if (play > 1) getBasesEvent(play,Lineup_idlineup);
		deleteEventDB();
		break;
		
		case "2B":
		stats2b(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B2").value = "";
		if (play > 1) getBasesEvent(play,Lineup_idlineup); 	
		deleteEventDB();	
		break;
		
		case "1B":
		stats1b(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		//undorunb1();
		if (play > 1 && eventscounter == 1) getBasesEvent(play,Lineup_idlineup);
		deleteEventDB();		
		break;
		
		case "BB":
		statsbb(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		if (play > 1) getBasesEvent(play,Lineup_idlineup);
		deleteEventDB();
		break;
		
		case "HP":
		statshp(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		if (play > 1) getBasesEvent(play,Lineup_idlineup);
		deleteEventDB();			
		break;
		
		case "SAC":
		statssac(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();			
		break;
		
		case "KSO":
		statskso(-1);
		document.getElementById("T1").value = ""; 
		//document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)-1;
		//document.getElementById("OutText").value = "";  
		deleteEventDB();		
		undo();
		break;
		
		case "KS":
		statsks(-1);
		document.getElementById("T1").value = ""; 
		//document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)-1;
		//document.getElementById("OutText").value = "";  
		deleteEventDB();	
		undo();	
		break;
		
		case "KS23":
		statsks23(-1);
		document.getElementById("T1").value = ""; 
		//document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)-1;
		//document.getElementById("OutText").value = "";  	
		deleteEventDB();		
		undo();	
		undo();	
		break;
		
		case "KS2":
		statsks2(-1);
		document.getElementById("T1").value = ""; 
		//document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)-1;
		//document.getElementById("OutText").value = "";  
		deleteEventDB();
		undo();			
		break;
		
		case "KSE":
		statskse(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();
		undorunb1();	
		break;
		
		case "KPB":
		statskpb(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();	
		undorunb1();
		break;
		
		case "KWP":
		statskwp(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();
		undorunb1();
		break;
		
		
		case "KFCAR":
		statskfcar(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();
		undorunb1();
		break;
		
		case "KFCNB":
		statskfcnb(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();
		undorunb1();	
		break;
		
		case "KR1po":
		statskr1po(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();	
		break;
		
		case "KR2po":
		statskr2po(-1);
		deleteEventDB();	
		break;
		
		case "KR3po":
		statskr3po(-1);
		deleteEventDB();	
		break;
		
		case "FCAR":
		statsfcar(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();	
		break;
		
		case "FCNB":
		statsfcnb(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();	
		break;
		
		case "R1po":
		statsr1po(-1);
		deleteEventDB();	
		break;
		
		case "R2po":
		statsr2po(-1);
		deleteEventDB();	
		break;
		
		case "R3po":
		statsr3po(-1);
		deleteEventDB();	
		break;
		
		case "4sac":
		stats4sac(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)-1;
		document.getElementById("OutText").value = ""; 
		deleteEventDB();	
		break;
		
		case "3sac":
		stats3sac(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)-1;
		document.getElementById("OutText").value = ""; 
		deleteEventDB();	
		break;
		
		case "2sac":
		stats2sac(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();	
		break;
		
		case "1sac":
		stats1sac(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();	
		break;
		
		case "0sacFCAR":
		stats0sacFCAR(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();	
		break;
		
		case "0sacFCNB":
		stats0sacFCNB(-1);
		document.getElementById("T1").value = ""; 
		document.getElementById("B1").value = ""; 
		deleteEventDB();	
		break;
		
		case "balltrayectory":
		document.getElementById("ballx").value = ""; 
		document.getElementById("bally").value = ""; 
		
			if (restorePoints.length > 0) {
			// Create a new Image object
			var oImg = new Image();
			// When the image object is fully loaded in the memory...
			oImg.onload = function() {
				// Get the canvas context
				//var canvasContext = drawingCanvas.getContext("2d");		
				// and draw the image (restore point) on the canvas. That would overwrite anything
				// already drawn on the canvas, which will basically restore it to a previous point.
				basecanvas.drawImage(oImg, 0, 0);
			}
			// The source of the image, is the last restoration point
			oImg.src = restorePoints.pop();
			}
		
		cancelBallTrayectory();
		deleteEventDB();	
		break;
		
		case "out":
			
			var changetitle = 0;
			
			if ( $('#T1').val() == 	$('#OutText').val() ){
				changetitle = 1;
			}		
			//Remove the out from stats
			if ( valN = $('#OutText').val() ) { //If there is a value on OutText
				pl1 =  parseInt( valN.slice(-1) , 10); //Read the last player
				$('#OutText').val( valN.slice(0,-2) );
				valN = $('#OutText').val();
				
				pl2 = parseInt( valN.slice(-1) , 10);
				
				if (pl2){
					removestatsOut2p(pl1, pl2);
				}else 
					if (pl1 != 0) removestatsOut(pl1);
				
				//$('#OutText').val( valN.slice(-2) );
			}	
				
			//Set T1 text
			if (changetitle )
				$('#T1').val($('#OutText').val());
			
			if ($('#OutText').val() == ""){ //Search the out event to store the sequence
				/*for (i=1;i<=eventscounter;i++){
					if (document.getElementsByName("Events[Events_type_idevents_type][]")[i].value == 37){ //Event Out
						document.getElementsByName("Events[Misce][]")[i].value = $('#OutText').val() ; //Event by EventType
						
					}
				}*/
				$('#OutNumber').css('background', '#999999');
				//eventscounter--;
				//
				deleteEventDB();
				events.pop();
				G_OUT = 0;
				
			}
				
		break;
		
		case "runplate":
			undorunplate();
			undoRBItext();
			deleteEventDB();	
		break;
		
		case "runb3":
			undorunb3();
			deleteEventDB();	
		break;
		
		case "runb2":
			undorunb2();
			deleteEventDB();	
		break;
		
		case "E0":
			playerBatter =  undoBases();
			statsError(0,playerBatter,-1);
			deleteEventDB();	
			
		break;
		
		case "E9": //rightfield
			playerBatter =  undoBases();
			statsError(rightfield,playerBatter,-1);
			undoBases(); 
			deleteEventDB();	
		break;
		
		case "E8": //center field
			playerBatter =  undoBases();
			statsError(centerfield,playerBatter,-1);
			undoBases();
			deleteEventDB();	
		break;
		
		case "E7":
			playerBatter =  undoBases();
			statsError(leftfield,playerBatter,-1);
			undoBases();
			deleteEventDB();	
		break;
		
		case "E6":
			playerBatter =  undoBases();
			statsError(shortstop,playerBatter,-1);
			undoBases();
			deleteEventDB();	
		break;
		
		case "E5":
			playerBatter =  undoBases();
			statsError(base3,playerBatter,-1);
			undoBases();
			deleteEventDB();	

		break;
		
		case "E4":
			playerBatter =  undoBases();
			statsError(base2,playerBatter,-1);
			undoBases();
			deleteEventDB();	
		break;
		
		case "E3":
			playerBatter =  undoBases();
			statsError(base1,playerBatter,-1);
			undoBases();
			deleteEventDB();	
		break;
		
		case "E2":
			playerBatter =  undoBases();
			statsError(catcher,playerBatter,-1);
			undoBases();
		break;
		
		case "E1":
			playerBatter =  undoBases();
			statsError(pitcher,playerBatter,-1);
			undoBases();
			deleteEventDB();	
		break;
		
		case "CS":
			playerid = document.getElementsByName("Events[playerid][]")[eventscounter].value;
			BatterNumberOut = document.getElementsByName("Events[BatterNumberOut][]")[eventscounter].value;
			playerbatter = undoOutBase ( playerid,BatterNumberOut );
			statscs (playerbatter,-1);
			deleteEventDB();	
			undo(); //Undo out;
		break;
		
		case "CS26":
			playerid = document.getElementsByName("Events[playerid][]")[eventscounter].value;
			BatterNumberOut = document.getElementsByName("Events[BatterNumberOut][]")[eventscounter].value;
			undooutb1(playerid, batterNumberOut);
			statscs(hitterBase1,-1);
			deleteEventDB();	
			undo(); //Undo out;
		break;
		
		case "CS25":
			playerid = document.getElementsByName("Events[playerid][]")[eventscounter].value;
			BatterNumberOut = document.getElementsByName("Events[BatterNumberOut][]")[eventscounter].value;
			undooutb1(playerid, batterNumberOut);
			statscs(hitterBase1,-1);
			deleteEventDB();	
			undo(); //Undo out;
		break;
		
		case "fE0":
			statsE0foulby(0,-1);
			deleteEventDB();	
		break;
		
		case "fE9":
			statsE0foulby(rightfield,-1);
			deleteEventDB();	
		break;
		
		case "fE8":
			statsE0foulby(centerfield,-1);
			deleteEventDB();	
		break;
		
		case "fE7":
			statsE0foulby(leftfield,-1);
			deleteEventDB();	
		break;
		
		case "fE6":
			statsE0foulby(shortstop,-1);
			deleteEventDB();	
		break;
		
		case "fE5":
			statsE0foulby(base3,-1);
			deleteEventDB();	
		break;
		
		case "fE4":
			statsE0foulby(base2,-1);
			deleteEventDB();	
		break;
		
		case "fE3":
			statsE0foulby(base1,-1);
			deleteEventDB();	
		break;
		
		case "fE2":
			statsE0foulby(catcher,-1);
			deleteEventDB();	
		break;
		
		case "fE1":
			statsE0foulby(pitcher,-1);
			deleteEventDB();	
		break;
		
		case "SB":
			playerbatter = undoBases();
			statssb(playerbatter, -1);	
			deleteEventDB();	
			undo();
			//alert("undo Player"+playerbatter);
			
			
			 
		break;
		
		case "PB":
			playerbatter = undoBases();
			statspb (playerbatter,-1);
			deleteEventDB();
			undo();
		break;
		
		case "WP":
			playerbatter = undoBases();
			statswp (playerbatter,-1);
			deleteEventDB();
			undo();
		break;
		
		case "BK":
			playerbatter = undoBases();
			statsbk (playerbatter,-1);
			deleteEventDB();
			undo();
		break;
		
		case "SBNStat":
			playerbatter = undoBases();
			statssb (playerbatter,-1);
			deleteEventDB();
			undo();
		break;
		
		case "PBNStat":
			playerbatter = undoBases();
			deleteEventDB();
			undo();
		break;
		
		case "WPNStat":
			playerbatter = undoBases();
			deleteEventDB();
			undo();
		break;
		
		case "BKNStat":
			playerbatter = undoBases();
			deleteEventDB();
			undo();
		break;
		
		case "O":
			playerbatter = undoBases();
			deleteEventDB();
			undo();
		break;
		
		case "DI":
			playerbatter = undoBases();
			deleteEventDB();
			undo();
		break;
		
		case "FC":
			playerbatter = undoBases();
			deleteEventDB();
			undo();	
		break;
		
		case "ball1":
			deleteEventDB();
		break;
		
		case "ball2":
			deleteEventDB();
		break;
		
		case "ball3":
			deleteEventDB();
		break;
		
		case "ball4":
			deleteEventDB();
		break;
		
		case "ball5":
			deleteEventDB();
		break;
		
		case "ball6":
			deleteEventDB();
		break;
		
	}
	
	enableControls();
	//Events[Events_type_idevents_type] = events;
	
	//document.getElementById("Events_Events_type_idevents_type")[].value  = events;
	
	//document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = events[eventscounter];
	
	
	//document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = "";
	
	//Undo run bases 
	if (eventscounter){
		var eventtype = document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value;
		if ( eventtype == 40 || eventtype == 41 || eventtype == 42 || eventtype == 38 ) {
			undo();
		}
	}
		//for (i=0; i < 3; i++){
			
		//}
	
	//undo out when out=0
	if ( document.getElementById("OutNumber").value == 0 ) {
		$('#OutNumber').css('background', '#999999');
		document.getElementById("OutNumber").value = 1;
	}

}




//Remove event when clic on Base 
function baseButtonUndo(eventNumber){
	
	tmpeventscounter = eventscounter;
	
	eventscounter = eventNumber;
	
	undo();
	
	//var element = document.getElementById("rowcopy"+eventscounter);
	//element.parentNode.removeChild(element);
	
	eventscounter = tmpeventscounter;
}

