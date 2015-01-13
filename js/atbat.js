/**
 * @author Jonathan Lizano
 */

var restorePoints = [];
var events = [];

var eventscounter = 0;

var T1, T2, T3, T4 = "";

var G_OUT = 0;

var idevents, text, RBI, ER, playerid, batterNumberOut, Misce = 0;

var catcherDefensive=0;

function defenseLineup(){
	
	$('#defensivefield').attr('style','position:absolute;left:643px;top:237px;z-index:500;')
	
	$('#defensivecatcher').html(catcherDefensive);
	$('#defensivepitcher').html(pitcherDefensive);
	$('#defensive1b').html(v1bDefensive);
	$('#defensive2b').html(v2bDefensive);
	$('#defensive3b').html(v3bDefensive);
	$('#defensivess').html(ssDefensive);
	$('#defensivelf').html(lfDefensive);
	$('#defensivecf').html(cfDefensive);
	$('#defensiverf').html(rfDefensive);
	
}

function WizardLineupdp(){
	
	$('#wizardfielddp').attr('style','position:absolute;left:643px;top:237px;z-index:500;')
	
	if ( ! hitterBase1 ) document.getElementById('wdpb1').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb1').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase2 ) document.getElementById('wdpb2').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb2').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase3 ) document.getElementById('wdpb3').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb3').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	
	/*if ( ! hitterBase2 )  $('#wdpb2').attr('style','z-index: -90');
	else $('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase3 )  $('#wdpb3').attr('style','z-index: -90');
	else $('#wdpb1').attr('style','z-index: 90');
	*/
}

function WizardLineuptp(){
	
	$('#wizardfieldtp').attr('style','position:absolute;left:643px;top:237px;z-index:500;')
	
	if ( ! hitterBase1 ) document.getElementById('wdpb1').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb1').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase2 ) document.getElementById('wdpb2').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb2').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase3 ) document.getElementById('wdpb3').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb3').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	
	/*if ( ! hitterBase2 )  $('#wdpb2').attr('style','z-index: -90');
	else $('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase3 )  $('#wdpb3').attr('style','z-index: -90');
	else $('#wdpb1').attr('style','z-index: 90');
	*/
}

function WizardLineup(){
	
	$('#wizardfield').attr('style','position:absolute;left:643px;top:237px;z-index:500;')
	
/*	if ( ! hitterBase1 ) document.getElementById('wdpb1').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb1').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase2 ) document.getElementById('wdpb2').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb2').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase3 ) document.getElementById('wdpb3').style.display = "none"; //  $('#wdpb1').attr('style','z-index: -90');
	else document.getElementById('wdpb3').style.display = "block"; //$('#wdpb1').attr('style','z-index: 90');
	*/
	/*if ( ! hitterBase2 )  $('#wdpb2').attr('style','z-index: -90');
	else $('#wdpb1').attr('style','z-index: 90');
	
	if ( ! hitterBase3 )  $('#wdpb3').attr('style','z-index: -90');
	else $('#wdpb1').attr('style','z-index: 90');
	*/
}

function HideDefensive(){
	$('#defensivefield').attr('style','position:absolute;left:-2000px;top:-2000px;');
}

function HideWizarddp(){
	$('#wizardfielddp').attr('style','position:absolute;left:-2000px;top:-2000px;');
}

function HideWizardtp(){
	$('#wizardfieldtp').attr('style','position:absolute;left:-2000px;top:-2000px;');
}

function HideWizard(base){
	$('#wizardfield').attr('style','position:absolute;left:-2000px;top:-2000px;');
	switch (base) {
		case 'b1':
		outb1();
		checkbases('1B',1);
		storeEvent("R1po");
		r1();
		b1();
		break;

		case 'b2':
		outb2();
		checkbases('1B',1);
		storeEvent("R2po");
		r1();
		b1();
		break;

		case 'kb3':
		outb3();
		checkbases('1B',1);
		storeEvent("R3po");
		break;
		
		case 'b1':
		outb1();
		checkbases('1B',1);
		storeEvent("KR1po");
		r1();
		b1();
		break;

		case 'kb2':
		outb2();
		checkbases('1B',1);
		storeEvent("KR2po");
		r1();
		b1();
		break;

		case 'kb3':
		outb3();
		checkbases('1B',1);
		storeEvent("KR3po");
		break;

	}
	
}

function submitBall(){
	
	var data=$("#events-form").serialize();
	
	  $.ajax({
	   type: 'POST',
	    //url: '<?php echo Yii::app()->createAbsoluteUrl("person/ajax"); ?>',
	    url:'index.php?r=events/create',
	   data: data + '&ajax='+ 1,
	   dataType: 'json',
	success:function(data){
	                for (i=1;i<=eventscounter;i++){
	                	pos = i-1;
	                	document.getElementsByName("Events[idevents][]")[i].value = data[pos];
	                }
	                
	              },
	   /*error: function(data) { // if error occured
	         alert("Error occured.please try again");
	         alert(data);
	    },*/
	 
	  //dataType:'html'
	  });
	 
}
	

	
	/* url='index.php?r=events/submitBall';
	
	data=new Object();
	
	
	$.ajax({
	  type: 'POST', // type of request either Get or Post
	  url: url, // Url of the page where to post data and receive response 
	  data: data, // data to be post
	  dataType: 'json',
	  success: function(data){   
	  	} //function to be called on successful reply from server
	  }); */


function setHitterBase(hitterBase,id){
	url='index.php?r=events/setHitterBase';
	data=new Object();
	data['hitterBase']=hitterBase;
	data['id']=id;
	$.ajax({
	  type: 'POST', // type of request either Get or Post
	  url: url, // Url of the page where to post data and receive response 
	  data: data, // data to be post
	  });

}

function getBasesEvent(play,Lineup_idlineup){
	url='index.php?r=events/getBasesEvent';
	data=new Object();
	data['idlineup']=Lineup_idlineup;
	data['play']=play;
	$.ajax({
	  type: 'POST', // type of request either Get or Post
	  url: url, // Url of the page where to post data and receive response 
	  data: data, // data to be post
	  dataType: 'json',
	  success: function(data){   hitterBase1 = parseInt(data[0], 10); hitterBase2 = parseInt(data[1], 10); hitterBase3 = parseInt(data[2], 10); 
	  							 batterNumber1 = parseInt(data[3], 10); batterNumber2 = parseInt(data[4], 10); batterNumber3 = parseInt(data[5], 10); InitBases();} //function to be called on successful reply from server
	  });
	
	//b1before = <?php echo Yii::app()->user->setState('b1before',$b1); ?>;
	
}

function setBatterBase(BatterBase,id){
	url='index.php?r=events/setBatterBase';
	data=new Object();
	data['BatterBase']=BatterBase;
	data['id']=id;
	$.ajax({
	  type: 'POST', // type of request either Get or Post
	  url: url, // Url of the page where to post data and receive response 
	  data: data, // data to be post
	  //success: function(data){ alert(data); } //function to be called on successful reply from server
	  });

}

function runb3(){
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	batterNumber4=batterNumber3;
	hitterBase4=hitterBase3;
	setBatterBase('batterNumber4',batterNumber4);
	setHitterBase('hitterBase4',hitterBase4	);
	hitterBase3=0;
	batterNumber3=0;
	setHitterBase('hitterBase3',0);
	setBatterBase('batterNumber3',0);
	storeEvent("runplate");
	clearb3();
	r4();
	plate();
	RBItext();
	
}

function runb2(){
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	hitterBase3=hitterBase2; //ID player in base
	setHitterBase('hitterBase3',hitterBase3); //ID player in base
	batterNumber3=batterNumber2 //lineup Batter number of player in base
	setBatterBase('batterNumber3',batterNumber3);
	hitterBase2=0;
	batterNumber2=0;
	setHitterBase('hitterBase2',0);
	setBatterBase('batterNumber2',0);
	storeEvent("runb3");
	r3();
	clearb2();
	b3();
}

function runb1(){
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	hitterBase2=hitterBase1;
	setHitterBase('hitterBase1',0);

	batterNumber2=batterNumber1 //lineup Batter number of player in base
	//alert("Check Bases: b2"+batterNumber2);
	setBatterBase('batterNumber2',batterNumber2);
	//batterNumber=0;
	setHitterBase('hitterBase2',hitterBase2);
	setBatterBase('batterNumber1',0);
	hitterBase1=0;
	
	storeEvent("runb2");
	r2();
	clearb1();
	b2();
}

function outb3(type){
	
	if (type == 'dp') 
		statsdpoutb3(1);
		
	//Out variables 
	document.getElementsByName("Events[playerid][]")[eventscounter].value = hitterBase3;
	document.getElementsByName("Events[batterNumberOut][]")[eventscounter].value = batterNumber3;
	
	hitterBase3=0;
	batterNumber3=0;
	setHitterBase('hitterBase3',0);
	setBatterBase('batterNumber3',0);
	clearb3();
	
}

function outb2(type){
	
	if (type =='dp') 
		statsdpoutb2(1);
		
	//Out variables 
	document.getElementsByName("Events[playerid][]")[eventscounter].value = hitterBase2;
	document.getElementsByName("Events[batterNumberOut][]")[eventscounter].value = batterNumber2;
	
		
	//Out variables 
	setBatterBase('batterNumberOut',batterNumber2);
	setBatterBase('playerid',hitterBase2);
	
	
	hitterBase2=0;
	batterNumber2=0;
	setHitterBase('hitterBase2',0);
	setBatterBase('batterNumber2',0);
	clearb2();
}

function outb1(type){
	
	if (type == 'dp') 
		statsdpoutb1(1);
	
	//Out variables 
	document.getElementsByName("Events[playerid][]")[eventscounter].value = hitterBase1;
	document.getElementsByName("Events[batterNumberOut][]")[eventscounter].value = batterNumber1;
	
	
	//Out variables 
	setBatterBase('batterNumberOut',batterNumber1);
	setBatterBase('playerid',hitterBase1);
	
	setHitterBase('hitterBase1',0);
	setBatterBase('batterNumber1',0);
	hitterBase1=0;
	clearb1();
}


//out double play from Wizard
function outdp(position){ 
	out(position);
	statsoutdp(position,1);
}

//Check bases and run depending on the hit of the Batter
function checkbases(action,numberstat){
	

 if (numberstat)				
	switch (action){
		
		case "HR":
			var rbi=0;
			
			if (hitterBase3) {
				document.getElementById("R"+hitterBase3).value = parseInt(document.getElementById("R"+hitterBase3).value, 10)+numberstat;
				
				//Score table
				//Team's runs
				document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)+numberstat;
				//R
				document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)+numberstat;
				batterNumber4=batterNumber3;
				hitterBase4=hitterBase3;
				storeEvent("runplate");
				rbi++;
				hitterBase3=0;
				setBatterBase('batterNumber4',batterNumber4);
				setHitterBase('hitterBase4',hitterBase4);
				setHitterBase('hitterBase3',0);
				setBatterBase('batterNumber3',0);
				batterNumber3=0;
				
			}
			
			if (hitterBase2) {
				document.getElementById("R"+hitterBase2).value = parseInt(document.getElementById("R"+hitterBase2).value, 10)+numberstat;
				//Score table
				//Team's runs
				document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)+numberstat;
				//R
				document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)+numberstat;
				rbi++;
				batterNumber3=batterNumber2;
				storeEvent("runb3");
				hitterBase3=hitterBase2;
				//batterNumber4=batterNumber3;
				//hitterBase3=hitterBase3;
				storeEvent("runplate");
				hitterBase2=0;
				setHitterBase('hitterBase2',0);
				setBatterBase('batterNumber2',0);
				batterNumber2=0;
			}
			
			if (hitterBase1) {
				document.getElementById("R"+hitterBase1).value = parseInt(document.getElementById("R"+hitterBase1).value, 10)+numberstat;
				//Score table
				//Team's runs
				document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)+numberstat;
				//R
				document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)+numberstat;
				rbi++;
				batterNumber2=batterNumber1;
				storeEvent("runb2");
				hitterBase2=hitterBase1;
				batterNumber3=batterNumber2;
				storeEvent("runb3");
				hitterBase3=hitterBase2;
				batterNumber4=batterNumber3;
				storeEvent("runplate");
				hitterBase1=0;
				setHitterBase('hitterBase1',0);
				setBatterBase('batterNumber1',0);
				batterNumber1=0;
			}
			clearBases();
		break;
		
		case '3B':
			if (hitterBase1){
				checkbases('B1',1);
			}
			
			if (hitterBase2){
				checkbases('B2',1);
			}
			
			if (hitterBase3){
				if (hitterBase3 ) {
					document.getElementById("R"+hitterBase3).value = parseInt(document.getElementById("R"+hitterBase3).value, 10)+numberstat;
					rbi++;
					batterNumber4=batterNumber3;
					hitterBase4=hitterBase3;
					hitterBase3=0;
					batterNumber3=0;
					setBatterBase('batterNumber4',batterNumber4);
					setHitterBase('hitterBase4',hitterBase4);
					setHitterBase('hitterBase3',0);
					setBatterBase('batterNumber3',0);
					storeEvent("runplate");
					clearb3();
					r4();
					plate();
					RBItext();
					
					
					//Team's runs
					document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)+1;
					
					//Score table
					//R
					document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)+1;
					

				}
				
					
				if (hitterBase2) {
					
					hitterBase3=hitterBase2; //ID player in base
					setHitterBase('hitterBase3',hitterBase3); //ID player in base
					batterNumber3=batterNumber2 //lineup Batter number of player in base
					setBatterBase('batterNumber3',batterNumber3);
					hitterBase2=0;
					batterNumber2=0;
					setHitterBase('hitterBase2',0);
					setBatterBase('batterNumber2',0);
					storeEvent("runb3");
					r3();
					clearb2();
					b3();
					
									
				}
				
				if (hitterBase1) {
					
					
					hitterBase2=hitterBase1;
					setHitterBase('hitterBase1',0);
					
					batterNumber2=batterNumber1 //lineup Batter number of player in base
					//alert("Check Bases: b2"+batterNumber2);
					setBatterBase('batterNumber2',batterNumber2);
					//batterNumber=0;
					setHitterBase('hitterBase2',hitterBase2);
					setBatterBase('batterNumber1',0);
					hitterBase1=0;
					
					storeEvent("runb2");
					r2();
					clearb1();
					b2();
					
				}
			}	
			
			
		break;
		
		case '2B':
			if (hitterBase1) { //Players must run two base
			checkbases('B1',1);
			}
			
			if (hitterBase2) { //Players must run two base
			checkbases('move',1);
			}			
		break;
		
		case '1B':
			if (hitterBase1) { //Players must run two base
			checkbases('move',1);		
			}		
		break;
		
		case 'BB':
			if (hitterBase1) { //Players must run two base
			checkbases('move',1);		
			}		
		break;
		
		case 'HP':
			if (hitterBase1) { //Players must run two base
			checkbases('move',1);		
			}		
		break;
		
		default:
			
		//if (hitterBase1) { //Players must run one base
			
			if (hitterBase3 && hitterBase2  ) {
				document.getElementById("R"+hitterBase3).value = parseInt(document.getElementById("R"+hitterBase3).value, 10)+numberstat;
				rbi++;
				batterNumber4=batterNumber3;
				hitterBase4=hitterBase3;
				hitterBase3=0;
				batterNumber3=0;
				setBatterBase('batterNumber4',batterNumber4);
				setHitterBase('hitterBase4',hitterBase4);
				setHitterBase('hitterBase3',0);
				setBatterBase('batterNumber3',0);
				storeEvent("runplate");
				clearb3();
				r4();
				plate();
				RBItext();
				
				
				//Team's runs
				document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)+1;
				
				//Score table
				//R
				document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)+1;
				
				//H
				//document.getElementById("r"+12+battingteam).value = parseInt(document.getElementById("r"+12+battingteam).value, 10)+1;

			}
			
				
			if (hitterBase2) {
				
				hitterBase3=hitterBase2; //ID player in base
				setHitterBase('hitterBase3',hitterBase3); //ID player in base
				batterNumber3=batterNumber2 //lineup Batter number of player in base
				setBatterBase('batterNumber3',batterNumber3);
				hitterBase2=0;
				batterNumber2=0;
				setHitterBase('hitterBase2',0);
				setBatterBase('batterNumber2',0);
				storeEvent("runb3");
				r3();
				clearb2();
				b3();
				
								
			}
			
			if (hitterBase1) {
				
				
				hitterBase2=hitterBase1;
				setHitterBase('hitterBase1',0);
				
				batterNumber2=batterNumber1 //lineup Batter number of player in base
				//alert("Check Bases: b2"+batterNumber2);
				setBatterBase('batterNumber2',batterNumber2);
				//batterNumber=0;
				setHitterBase('hitterBase2',hitterBase2);
				setBatterBase('batterNumber1',0);
				hitterBase1=0;
				
				storeEvent("runb2");
				r2();
				clearb1();
				b2();
				
			}
		//}
		break;
		
	}
	
	
}



function RBItext(){
	
	var box = document.getElementById("RBI");
	//Pitcher stats
	document.getElementById("pR"+pitcher).value = parseInt(document.getElementById("pR"+pitcher).value, 10)+1;
	document.getElementById("pER"+pitcher).value = parseInt(document.getElementById("pER"+pitcher).value, 10)+1;
	
	//Batter stats
	document.getElementById("RBI"+batter).value = parseInt(document.getElementById("RBI"+batter).value, 10)+1;
	
	
	switch (box.value){
		case "":
			box.value = "RBI";			
			break;
		case "RBI":
		
			if ($('#RBI').css('color')=='rgb(255, 255, 255)') box.value = "RBI2";
			else{
				//if ($('#RBI').css('color')=='rgb(153, 153, 153)'){
		
					$('#RBI').attr('style',"color: #FFFFFF !important");
					
				//}
			}
			
			break;
		case "RBI2":
			box.value = "RBI3";
			break;
		case "RBI3":
			box.value = "RBI4";
			break;
		case "RBI4":
			box.value = "RBI";
			$('#RBI').attr('style',"color: #999999 !important");
			document.getElementById("pR"+pitcher).value = parseInt(document.getElementById("pE"+pitcher).value, 10)-4;
			document.getElementById("pRE"+pitcher).value = parseInt(document.getElementById("pRE"+pitcher).value, 10)-4;
			break;
		
	}
	
	
	
	document.getElementsByName("Events[RBI][]")[eventscounter].value = document.getElementById("RBI").value;
}

function ERtext(){
	
	var box = document.getElementById("ER");
	
	switch (box.value){
		
		case "":
			box.value = "ER";
			break;
		case "ER":
			if ($('#ER').css('color')=='rgb(255, 255, 255)') {
				box.value = "Pitcher ER";
				$('#ER').attr('style',"color: #FFFFFF !important; font-size: 13px !important");
			}
			else{
				//if ($('#RBI').css('color')=='rgb(153, 153, 153)'){
		
					$('#ER').attr('style',"color: #FFFFFF !important");
					
				//}
			}
			break;
		case "Pitcher ER":
			box.value = "Team ER";
			break;
		case "Team ER":
			box.value = "ER";
			$('#ER').attr('style',"color: #999999 !important; font-size: 22px !important");
			break;
		
	}
	
	
	
	document.getElementsByName("Events[ER][]")[eventscounter].value = box.value;
}

function OUTtext(){
	
	var box = document.getElementById("OUT");
	
	switch (box.value){
		case "":
			box.value = "1";
			break;
		case "1":
			box.value = "2";
			break;
		case "2":
			box.value = "3";
			break;
		case "3":
			box.value = "";
			break;
		
	}
	
	
}



function storeEvent(eventtype){
	
	
	
	//Don't add if double click on out
	if (! ( ( eventtype == 'out') && ( G_OUT == 1) )  ){
			eventscounter++;
			var rowcopy = document.getElementById("rowevents").cloneNode(true) 
			rowcopy.id = 'rowcopy'+eventscounter;
	
			document.getElementById("events-form").appendChild(rowcopy);
		
			RBI = $('#rowcopy'+eventscounter).find("#Events_RBI");
		 
	}else return 0;
	
	//SET BATTER
	document.getElementsByName("Events[Batter][]")[eventscounter].value = batterNumber; 
	
	if ($('#RBI').css('color')=='rgb(255, 255, 255)')
		document.getElementsByName("Events[RBI][]")[eventscounter].value = document.getElementById("RBI").value;
	//batterNumber1 = batterNumber;
	
	switch (eventtype){
		
		case "HR":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 1; //Event by EventType
		events.push('HR');
		break;
		
		case "3B":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 2; //Event by EventType
		$('#base3button').attr('onclick', 'baseButtonUndo('+eventscounter+')');
		events.push('3B');
		setHitterBase('hitterBase3',batter);
		hitterBase3 = batter;
		setBatterBase('batterNumber3',batterNumber);
		break;
		
		case "2B":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 3; //Event by EventType
		events.push('2B');
		$('#base2button').attr('onclick', 'baseButtonUndo('+eventscounter+')');
		setHitterBase('hitterBase2',batter);
		hitterBase2 = batter;
		setBatterBase('batterNumber2',batterNumber);
		break;
		
		case "1B":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 4; //Event by EventType
		events.push('1B');
		$('#base1button').attr('onclick', 'baseButtonUndo('+eventscounter+')');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		case "BB":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 5; //Event by EventType
		events.push('BB');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		case "HP":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 6; //Event by EventType
		events.push('HP');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		//Button K
		case "KSO":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 7; //Event by EventType
		events.push('KSO');
		break;
		
		//Button K
		case "KS":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 8; //Event by EventType
		events.push('KS');
		break;
		
		//Button K
		case "KS23":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 9; //Event by EventType
		events.push('KS23');
		break;
		
		//Button K
		case "KS2":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 10; //Event by EventType
		events.push('KS2');
		break;
		
		//Button KSE
		case "KSE":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 11; //Event by EventType
		events.push('KSE');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		//Button K
		/*case "KFC":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 12; //Event by EventType
		events.push('KFC');
		break;*/
		
		//Button K
		case "KPB":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 13; //Event by EventType
		events.push('KPB');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		//Button K  / KS WP Dropped 3rd strike
		case "KWP":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 14; //Event by EventType
		events.push('KWP');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		//Button FC
		case "FCAR":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 15; //Event by EventType
		events.push('FCAR');
		
		break;
		
		//Button FC
		case "FCNB":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 16; //Event by EventType
		events.push('FCNB');
		break;
		
		//Button FC
		case "R1po":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 17; //Event by EventType
		events.push('R1po');
		break;
		
		//Button FC
		case "R2po":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 18; //Event by EventType
		events.push('R2po');
		break;
		
		//Button FC
		case "R3po":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 19; //Event by EventType
		events.push('R3po');
		break;
		
		//Button K //  KS FC all runners safely
		case "KFCAR":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 20; //Event by EventType
		events.push('KFCAR');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		//Button K // KS FC no base runners
		case "KFCNB":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 21; //Event by EventType
		events.push('KFCNB');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		break;
		
		//Button K //Runner 1st base putout
		case "KR1po":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 22; //Event by EventType
		events.push('KR1po');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		//Button K // //Runner 2st base putout
		case "KR2po":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 23; //Event by EventType
		events.push('KR2po');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		//Button K
		case "KR3po":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 24; //Event by EventType
		events.push('KR3po');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		//Button Sac
		case "4sac":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 25; //Event by EventType
		events.push('4sac');
		break;
		
		case "3sac": 
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 26; //Event by EventType
		events.push('3sac');
		break;
		
		case "2sac": //SF Sac Fly, Reached on Error
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 27; //Event by EventType
		events.push('2sac');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		 
		case "1sac": //SF Sac hit, reached on error
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 28; //Event by EventType
		events.push('1sac');
		setHitterBase('hitterBase1',batter);
		hitterBase1 = batter;
		setBatterBase('batterNumber1',batterNumber);
		break;
		
		case "0sacFCAR": //SF Sac hit, Fielder's choice -> FC: advance all runners safely
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 29; //Event by EventType
		events.push('0sacFCAR');
		break;
		
		case "0sacFCNB":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 30; //Event by EventType
		events.push('0sacFCNB');
		break;
		
		case "ball1":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 31; //Event by EventType
		document.getElementsByName("Events[Misce][]")[eventscounter].value = document.getElementById('ball1Button').value;
		events.push('ball1');
		break;
		
		case "ball2":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 32; //Event by EventType
		document.getElementsByName("Events[Misce][]")[eventscounter].value = document.getElementById('ball2Button').value;
		events.push('ball2');
		break;
		
		case "ball3":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 33; //Event by EventType
		document.getElementsByName("Events[Misce][]")[eventscounter].value = document.getElementById('ball3Button').value;
		events.push('ball3');
		break;
		
		case "ball4":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 34; //Event by EventType
		document.getElementsByName("Events[Misce][]")[eventscounter].value = document.getElementById('ball4Button').value;
		events.push('ball4');
		break;
		
		case "ball5":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 35; //Event by EventType
		document.getElementsByName("Events[Misce][]")[eventscounter].value = document.getElementById('ball5Button').value;
		events.push('ball5');
		break;
		
		case "ball6":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 36; //Event by EventType
		document.getElementsByName("Events[Misce][]")[eventscounter].value = document.getElementById('ball6Button').value;
		events.push('ball6');
		break;
		
		case "out":
		if (!G_OUT){
			document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 37; //Event by EventType
			//alert(document.getElementById("OutNumber").value);
			events.push('out');
		}
		break;
		
		case "balltrayectory":
			document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 38; //Event by EventType
			events.push('balltrayectory');
		break;
		
		case "runplate":
			document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 42; //Event by EventType
			events.push('runplate');
			document.getElementsByName("Events[Misce][]")[eventscounter].value = hitterBase3; //Event by EventType
			$('#base4button').attr('onclick', 'base4Button('+eventscounter+')');
			//alert("Run plate:"+batterNumber4);
			document.getElementsByName("Events[Batter][]")[eventscounter].value = batterNumber4;
			
		break;
		
		case "runb3":
			document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 41; //Event by EventType
			events.push('runb3');
			document.getElementsByName("Events[Misce][]")[eventscounter].value = hitterBase2; //Event by EventType
			$('#base3button').attr('onclick', 'base3Button('+eventscounter+')'); //Undo Base button
			//alert("Run 3b:"+batterNumber3);
			document.getElementsByName("Events[Batter][]")[eventscounter].value = batterNumber3;
			
		break;
		
		case "runb2":
			document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 40; //Event by EventType
			events.push('runb2');
			document.getElementsByName("Events[Misce][]")[eventscounter].value = hitterBase1; //Event by EventType
			$('#base2button').attr('onclick', 'base2Button('+eventscounter+')');
			//alert("Run 2b"+batterNumber2);
			document.getElementsByName("Events[Batter][]")[eventscounter].value = batterNumber2;
		break;
		
		case "E0":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 43; //Event by EventType
		events.push('E0');
		break;
		
		case "E9":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 44; //Event by EventType
		events.push('E9');
		break;
		
		case "E8":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 45; //Event by EventType
		events.push('E8');
		break;
		
		case "E7":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 46; //Event by EventType
		events.push('E7');
		break;
		
		case "E6":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 47; //Event by EventType
		events.push('E6');
		break;
		
		case "E5":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 48; //Event by EventType
		events.push('E5');
		break;
		
		case "E4":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 49; //Event by EventType
		events.push('E4');
		break;
		
		case "E3":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 50; //Event by EventType
		events.push('E3');
		break;
		
		case "E2":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 51; //Event by EventType
		events.push('E2');
		break;
		
		case "E1":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 52; //Event by EventType
		events.push('E1');
		break;
		
		case "CS":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 53; //Event by EventType
		events.push('CS');
		break;
		
		case "CS26":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 54; //Event by EventType
		events.push('CS26');
		break;
		
		case "CS25":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 55; //Event by EventType
		events.push('CS25');
		break;
		
		case "fE0":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 56; //Event by EventType
		events.push('fE0');
		break;
		
		case "fE9":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 57; //Event by EventType
		events.push('fE9');
		break;
		
		case "fE8":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 58; //Event by EventType
		events.push('fE8');
		break;
		
		case "fE7":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 59; //Event by EventType
		events.push('fE7');
		break;
		
		case "fE6":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 60; //Event by EventType
		events.push('fE6');
		break;
		
		case "fE5":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 61; //Event by EventType
		events.push('fE5');
		break;
		
		case "fE4":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 62; //Event by EventType
		events.push('fE4');
		break;
		
		case "fE3":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 63; //Event by EventType
		events.push('fE3');
		break;
		
		case "fE2":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 64; //Event by EventType
		events.push('fE2');
		break;
		
		case "fE1":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 65; //Event by EventType
		events.push('fE1');
		break;
		
		case "SB":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 66; //Event by EventType
		events.push('SB');
		break;
		
		case "PB":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 67; //Event by EventType
		events.push('PB');
		break;
		
		case "WP":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 68; //Event by EventType
		events.push('WP');
		break;
		
		case "BK":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 69; //Event by EventType
		events.push('BK');
		break;
		
		case "SBNStat":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 70; //Event by EventType
		events.push('SBNStat');
		break;
		
		case "PBNStat":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 71; //Event by EventType
		events.push('PBNStat');
		break;
		
		case "WPNStat":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 72; //Event by EventType
		events.push('WPNStat');
		break;
		
		case "BKNStat":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 73; //Event by EventType
		events.push('BKNStat');
		break;
		
		case "O":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 74; //Event by EventType
		events.push('O');
		break;
		
		case "DI":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 75; //Event by EventType
		events.push('DI');
		break;
		
		case "FC":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 76; //Event by EventType
		events.push('FC');
		break;
		
		case "lstBatter":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 77; //Event by EventType
		events.push('lstBatter');
		break;
		
		case "skpBatter":
		document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = 78; //Event by EventType
		events.push('skpBatter');
		break;
		
		
	}
	
	//Batters in bases
	document.getElementsByName("Events[b1][]")[eventscounter].value = hitterBase1; 
	document.getElementsByName("Events[b2][]")[eventscounter].value = hitterBase2; 
	document.getElementsByName("Events[b3][]")[eventscounter].value = hitterBase3;
	
	//document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value = "";
	document.getElementsByName("Events[text][]")[eventscounter].value = document.getElementById("T1").value;
	
	//Check Event to block controls
	
	if (idevents){ //Updating a play set of events
		document.getElementsByName("Events[idevents][]")[eventscounter].value = idevents;
		document.getElementsByName("Events[Batter][]")[eventscounter].value = batterNumber;
		document.getElementsByName("Events[Misce][]")[eventscounter].value = Misce;
		document.getElementsByName("Events[text][]")[eventscounter].value = text;
		document.getElementsByName("Events[ER][]")[eventscounter].value = ER;
		document.getElementsByName("Events[RBI][]")[eventscounter].value = '';
		document.getElementsByName("Events[playerid][]")[eventscounter].value = playerid;
		document.getElementsByName("Events[batterNumberOut][]")[eventscounter].value = batterNumberOut;
		
	}
	
	eventid = document.getElementsByName("Events[Events_type_idevents_type][]")[eventscounter].value;
	
	
	if (eventid <= 30) {
		blockcontrols();
	}
	 
	
	
	
}


function b1(){
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = "#FFFFFF";
	basecanvas.lineWidth = 1;
	//1B
	basecanvas.moveTo(345,180);
	basecanvas.lineTo(355,185); // \
	basecanvas.lineTo(365,180); //  /
	basecanvas.lineTo(355,175); //  \
	basecanvas.lineTo(345,180); // /
	basecanvas.fill();
	basecanvas.stroke();
	
}

function b2(){
	//2B
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = "#FFFFFF";
	basecanvas.lineWidth = 1;
	basecanvas.moveTo(242,152);
	basecanvas.lineTo(252,157); // \
	basecanvas.lineTo(262,152); //  /
	basecanvas.lineTo(252,147); //  \
	basecanvas.lineTo(242,152); // /
	basecanvas.fill();
	basecanvas.stroke();
}

function b3(){
	//3B
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = "#FFFFFF";
	basecanvas.lineWidth = 1;
	basecanvas.moveTo(140,180);
	basecanvas.lineTo(150,185); // \
	basecanvas.lineTo(160,180); //  /
	basecanvas.lineTo(150,175); //  \
	basecanvas.lineTo(140,180); // /
	basecanvas.fill();
	basecanvas.stroke();
}

function plate(){
	//PLATE
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = "#FFFFFF";
	basecanvas.lineWidth = 1;
	basecanvas.moveTo(242,230);
	basecanvas.lineTo(252,235); // \
	basecanvas.lineTo(262,230); //  /
	basecanvas.lineTo(262,225); // |
	basecanvas.lineTo(242,225); // |
	basecanvas.lineTo(242,230); // 
	basecanvas.fill(); 
	basecanvas.stroke();
	
}

function clearb1(){
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.strokeStyle = "#996535";
	basecanvas.lineWidth = 1;
	//1B
	basecanvas.moveTo(345,180);
	basecanvas.lineTo(355,185); // \
	basecanvas.lineTo(365,180); //  /
	basecanvas.lineTo(355,175); //  \
	basecanvas.lineTo(345,180); // /
	basecanvas.fill();
	basecanvas.stroke();
	
}

function clearb2(){
	//2B
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = '#996535';
	basecanvas.lineWidth = 1;
	//basecanvas.strokeStyle = "#996535";
	basecanvas.moveTo(242,152);
	basecanvas.lineTo(252,157); // \
	basecanvas.lineTo(262,152); //  /
	basecanvas.lineTo(252,147); //  \
	basecanvas.lineTo(242,152); // /
	basecanvas.fill();
	basecanvas.stroke();
}

function clearb3(){
	//3B
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = '#996535';
	basecanvas.lineWidth = 1;
	basecanvas.moveTo(140,180);
	basecanvas.lineTo(150,185); // \
	basecanvas.lineTo(160,180); //  /
	basecanvas.lineTo(150,175); //  \
	basecanvas.lineTo(140,180); // /
	basecanvas.fill();
	basecanvas.stroke();
}

function clearplate(){
	//PLATE
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = '#996535';
	basecanvas.lineWidth = 1;
	basecanvas.moveTo(242,230);
	basecanvas.lineTo(252,235); // \
	basecanvas.lineTo(262,230); //  /
	basecanvas.lineTo(262,225); // |
	basecanvas.lineTo(242,225); // |
	basecanvas.lineTo(242,230); // 
	basecanvas.fill(); 
	basecanvas.stroke();
	
}

function r1(){
	basecanvas.beginPath();
	basecanvas.fillStyle = '#ff0000';
	basecanvas.strokeStyle = '#ff0000';	
	basecanvas.lineWidth = 3;
	basecanvas.moveTo(262,228);
	basecanvas.lineTo(358,180);
	basecanvas.stroke();

}

function r2(){
	//2B
	basecanvas.beginPath();
	basecanvas.fillStyle = '#ff0000';
	basecanvas.moveTo(358,180);
	basecanvas.strokeStyle = '#ff0000';
	basecanvas.lineWidth = 3;	
	basecanvas.lineTo(252,150);
	basecanvas.stroke();
}

function r3(){
	//3B
	basecanvas.beginPath();
	basecanvas.fillStyle = '#ff0000';
	basecanvas.moveTo(252,150);
	basecanvas.strokeStyle = '#ff0000';
	basecanvas.lineWidth = 3;	
	basecanvas.lineTo(147,180);
	basecanvas.stroke();
}

function r4(){
	//4B
	basecanvas.beginPath();
	basecanvas.strokeStyle = "#FF0000";
	basecanvas.fillStyle = "#FF0000";
	basecanvas.moveTo(147,180);
	basecanvas.lineWidth = 3;
	basecanvas.lineTo(245,230);
	basecanvas.stroke();
}

function clearBases(){
	hitterBase1=0;
	hitterBase2=0;
	hitterBase3=0;
	hitterBase4=0;
	batterNumber1=0;
	batterNumber2=0;
	batterNumber3=0;
	batterNumber4=0;
	
				
}

function textT1(text){
	
	basecanvas.fillStyle = '#996535';
	basecanvas.font = 'italic bold 30px sans-serif';
	basecanvas.textBaseline = 'bottom';
	basecanvas.fillText(text, 350, 100);
	//basecanvas.strokeText('HTML5 is cool?', 300, 100);
}

function textT2(text){
	
	basecanvas.fillStyle = '#996535';
	basecanvas.font = 'italic bold 17px sans-serif';
	basecanvas.textBaseline = 'bottom';
	basecanvas.fillText(text, 350, 170);
	//basecanvas.strokeText('HTML5 is cool?', 300, 100);
}

function textT3(text){
	
	basecanvas.fillStyle = '#996535';
	basecanvas.font = 'italic bold 17px sans-serif';
	basecanvas.textBaseline = 'bottom';
	basecanvas.fillText(text, 350, 200);
	//basecanvas.strokeText('HTML5 is cool?', 300, 100);
}

function textT4(text){
	
	basecanvas.fillStyle = '#996535';
	basecanvas.font = 'italic bold 17px sans-serif';
	basecanvas.textBaseline = 'bottom';
	basecanvas.fillText(text, 50, 250);
	//basecanvas.strokeText('HTML5 is cool?', 300, 100);
}

function fillhr(num){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	restorePoints.push(imgSrc);
	
	document.getElementById("RBI").value = "RBI";
	document.getElementById("T1").value = "HR";
	document.getElementById("ER").value = "ER";
	document.getElementById("B4").value = "HR";
	
	checkbases('HR',num);
	storeEvent("HR");
	
	// and store this value as a 'restoration point', to which we can later revert
	
	
	
	
	r1();
	r2();
	r3();
	r4();
	//b1();
	clearb1()
	clearb2()
	clearb3()
	//b2();
	//b3();
	plate();
	
	
	//Draw texts
	/* T1 = "HR";
	textT1(T1);
	T2 = "RBI";
	textT2(T2);
	T3 = "ER";
	textT3(T3);
	T4 = "HR";
	textT4(T4);*/
	

	
	//Increment stats
	statshr(num);
	
	
	
	//document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+1; falta
}



function fill3b (num){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	
	document.getElementById("T1").value = "3B"; 
	document.getElementById("B3").value = "3B"; 
	checkbases('3B',num);
	batterNumber3=batterNumber;
	//batterNumber=0;
	storeEvent("3B");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	r1();
	r2();
	r3();
	
	//b1();
	//b2();
	b3();
	//plate();
	
	

	
	stats3b(num);
	
}

	
function fill2b (num){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");

	document.getElementById("T1").value = "2B"; 
	document.getElementById("B2").value = "2B"; 
		
	checkbases('2B',num);
	storeEvent("2B");
	batterNumber2=batterNumber;
	//batterNumber=0;
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	r1();
	r2();
	//b1();
	b2();
	

	stats2b(num);
	
}

function fill1b (num){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	
	document.getElementById("T1").value = "1B"; 
	document.getElementById("B1").value = "1B"; 
	checkbases('1B',num);
	storeEvent("1B");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	r1();
	b1();
	

	stats1b(num);
	
	
}

function fillbb (num){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "BB"; 
	document.getElementById("B1").value = "BB"; 
	checkbases('BB',num);
	storeEvent("BB");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	r1();
	b1();
	
	
	
	statsbb(num);

	
}

function fillhp (num){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "HBP"; 
	document.getElementById("B1").value = "HBP"; 
	checkbases('1B',num);
	storeEvent("HP");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	r1();
	b1();
	

	statshp(1);
	
}

function fillKSO (pos,num){ //Strike out
	var imgSrc = drawingCanvas.toDataURL("images/png");
	//document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)+1;
	//document.getElementById("OutText").value = "K"; 
 	if (num)
 		out(pos,num);
 	document.getElementById("T1").value = "K"; 
	storeEvent("KSO");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	
	statskso(num);
	
}


function fillKS (pos,num){ //Strike out swinging - pos = 2
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "KS"; 
	//document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)+1;
	//document.getElementById("OutText").value = "KS"; 
	if (num)
		out(pos,num);	 
	document.getElementById("T1").value = "KS"; 
	storeEvent("KS");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	

	
	statsks(num);
	
}

function fillK23 (num){ //Strike 2-3
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	//document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)+1;
	//document.getElementById("OutText").value = "KS 2-3"; 
	if (num) {
		out(2,num);
		out(3,num);
	}

	document.getElementById("T1").value = "KS 2-3"; 
	storeEvent("KS23");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	

	
	statsks23(num);
	
}

function fillK2 (num){ //Strike 2-3
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	//document.getElementById("OutNumber").value  = parseInt(document.getElementById("OutNumber").value, 10)+1;
	//document.getElementById("OutText").value = "KS 2"; 
	if (num)
		out(2,num);	
		
	document.getElementById("T1").value = "KS 2"; 
	storeEvent("KS2");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);

	

	
	statsks2(num);
	
}

function fillKSE (num){ //Strike KS E
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	
	document.getElementById("T1").value = "KS E"; 
	document.getElementById("B1").value = "KS E"; 
	
	//num=1; //Assign one because it is submenu 
	
	checkbases('1B',num);
	storeEvent("KSE");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	r1();
	b1();

	statskse(num);
	
}

function fillKFCAR (num){ //KS FC all runners safely
	
	//num=1; //Assign one because it is submenu 
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "KS FC"; 
	document.getElementById("B1").value = "KS FC"; 
	
	checkbases('1B',num);
	
	storeEvent("KFCAR");
	
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	r1();
	b1();
		
	statskfcar(num);
	
}

function fillKFCNB (num){ //KS FC no base runners
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "KS FC"; 
	document.getElementById("B1").value = "KS FC"; 
	
	storeEvent("KFCNB");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	r1();
	b1();
	

	
	statskfcnb(num);
	
}

function fillKR1po (num){ //Runner 1st base putout

if (hitterBase1){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	
	
	//Out Wizard
	WizardLineup();
	
	if (!num) HideWizard('b1'); //Draw with num = 0
	
	
	$('#HideWizardbutton').attr('onclick',"HideWizard('b1')");
	
	
	
	document.getElementById("T1").value = "KS FC"; 
	document.getElementById("B1").value = "KS FC"; 
	
	storeEvent("KR1po");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statskr1po(num);
}
	
}

function fillKR2po (num){ //Runner 2st base putout

if (hitterBase2){
	var imgSrc = drawingCanvas.toDataURL("images/png");
	

	WizardLineup();
	
	if (!num) HideWizard('b2'); //Draw with num = 0
	
	
	$('#HideWizardbutton').attr('onclick',"HideWizard('b2')");
	
	
	
	document.getElementById("T1").value = "KS FC"; 
	document.getElementById("B1").value = "KS FC";
	
	storeEvent("KR2po");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statskr2po(num);
}
}

function fillKR3po (num){ //Runner 3st base putout

if (hitterBase3){

	var imgSrc = drawingCanvas.toDataURL("images/png");
	
	
	WizardLineup();
	
	if (!num) HideWizard('b3'); //Draw with num = 0
	
	$('#HideWizardbutton').attr('onclick',"HideWizard('b3')");
	
	document.getElementById("T1").value = "KS FC"; 
	document.getElementById("B1").value = "KS FC";
	
	storeEvent("KR3po");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statskr3po(num);
}
}

function fillKPB (num){ //Strikeout Passed Ball
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	
	document.getElementById("T1").value = "KS PB"; 
	document.getElementById("B1").value = "KS PB"; 
	
	checkbases('1B',num);	
	storeEvent("KPB");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	r1();	
	b1();
	
	statskpb(num);
}

function fillKWP (num){ //BUtton K / KS WP Dropped 3rd strike
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "KS WP"; 
	document.getElementById("B1").value = "KS WP"; 
		
	checkbases('1B',num);
	storeEvent("KWP");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	r1();	
	b1();
	
	statskwp(num);
}

function fillFCAR (num){ //KS FC all runners safely
	

	//num=1; //Assign one because it is submenu 
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "FC"; 
	document.getElementById("B1").value = "FC"; 	
	checkbases('1B',num);
	
	storeEvent("FCAR");
	
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	r1();
	b1();
		
	statsfcar(num);
	
}

function fillFCNB (num){ //KS FC no base runners
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "FC"; 
	document.getElementById("B1").value = "FC"; 
		
	storeEvent("FCNB");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	b1();
	r1();
	

	
	statsfcnb(num);
	
}

function fillR1po (num){ //Runner 1st base putout

if (hitterBase1){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	

	//Out Wizard
	WizardLineup();
	
	$('#HideWizardbutton').attr('onclick',"HideWizard('b1')");
	
	document.getElementById("T1").value = "FC"; 
	document.getElementById("B1").value = "FC"; 
	
	storeEvent("R1po");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statsr1po(num);
}
	
	
}

function fillR2po (num){ //Runner 2st base putout
	
if (hitterBase2){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	

	//Out Wizard
	WizardLineup();
	
	$('#HideWizardbutton').attr('onclick',"HideWizard('b2')");
	
	document.getElementById("T1").value = "FC"; 
	document.getElementById("B1").value = "FC"; 
	
	storeEvent("R2po");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statsr2po(num);
}
}

function fillR3po (num){ //Runner 3st base putout
	
if (hitterBase3){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	

	//Out Wizard
	WizardLineup();
	
	$('#HideWizardbutton').attr('onclick',"HideWizard('b3')");
	
	document.getElementById("T1").value = "FC"; 
	document.getElementById("B1").value = "FC"; 
	
	storeEvent("R3po");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statsr3po(num);
}
}

function fill4sac (num){ //SF Sacrifice fly
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	
	checkbases('1B',num);
	
	out(0);
	
	storeEvent("4sac");
	
	document.getElementById("T1").value = "SF"; 
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
		
	statsr4sac(num);
}


function fill3sac (num){ //SF Sacrifice hit
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	
	
	out(0);
	
	document.getElementById("T1").value = "SH"; 
	storeEvent("3sac");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	

	
	statsr3sac(num);
}

function fill2sac (num){ //SF Sac Fly, Reached on Error
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "SFE"; 
	document.getElementById("B1").value = "SFE"; 
		
	checkbases('1B',num);
	
	storeEvent("2sac");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	r1();
	b1();
	

	
	statsr2sac(num);
}	
	
function fill1sac (num){ //SF Sac hit, reached on error
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "SAC E"; 
	document.getElementById("B1").value = "SAC E"; 	
	checkbases('1B',num);
	storeEvent("1sac");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	r1();
	b1();
	

	
	statsr1sac(num);
}	

function fill0sacFCAR (num){ //SF Sac hit, Fielder's choice -> FC: advance all runners safely
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "SAC FC"; 
	document.getElementById("B1").value = "SAC FC"; 
		
	
	checkbases('1B',num);
	
	storeEvent("0sacFCAR");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	r1();
	b1();
	

	
	stats0sacFCAR(num);
}	

function fill0sacFCNB (num){ //SF Sac hit, Fielder's choice -> FC: advance all runners safely
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	document.getElementById("T1").value = "SAC FC"; 
	document.getElementById("B1").value = "SAC FC"; 
	
	
	storeEvent("0sacFCNB");
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	b1();
	r1();
	

	
	stats0sacFCNB(num);
}


function fillsacR1po (num){ //Runner 1st base putout

if (hitterBase1){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	

	//Out Wizard
	WizardLineup();
	
	outb1();
	checkbases('1B',num);
	storeEvent("R1po");
	r1();
	b1();
	
	document.getElementById("T1").value = "SAC FC"; 
	document.getElementById("B1").value = "SAC FC"; 
	
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statssacr1po(num);
}
	
	
}

function fillsacR2po (num){ //Runner 2st base putout
	
if (hitterBase2){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	

	//Out Wizard
	WizardLineup();
	
	outb2();
	checkbases('1B',num);
	storeEvent("R2po");
	r1();
	b1();
	
	document.getElementById("T1").value = "SAC FC"; 
	document.getElementById("B1").value = "SAC FC"; 
	
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statssacr2po(num);
}
}

function fillsacR3po (num){ //Runner 3st base putout
	
if (hitterBase3){
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	

	//Out Wizard
	WizardLineup();
	
	outb1();
	checkbases('1B',num);
	storeEvent("R3po");
	r1();
	b1();
	
	document.getElementById("T1").value = "SAC FC"; 
	document.getElementById("B1").value = "SAC FC"; 
	
	
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	statssacr3po(num);
}
}

function reducePlus(){
	if (document.getElementById('ball'+6+'Button').value[0] > 4) { //Change to number plus +
								var num = parseInt( document.getElementById('ball'+6+'Button').value[0],10) - 1 ;
								document.getElementById('ball'+6+'Button').value =  num + "+";
								
							}
							else { //Remove + to button 6
								if (document.getElementById('ball'+6+'Button').value == "4+"){
									document.getElementById('ball'+6+'Button').value = "+++";
								}else
									if (document.getElementById('ball'+6+'Button').value == "+++"){
										document.getElementById('ball'+6+'Button').value = "++";
									}else{
										if (document.getElementById('ball'+6+'Button').value == "++"){
											document.getElementById('ball'+6+'Button').value="+";
										}else
											//REmove the + and clear button 5
											if (document.getElementById('ball'+6+'Button').className == 'B4_gray' &&  (document.getElementById('ball'+5+'Button').value=='F' || ball == 4 ) ){
												document.getElementById('ball'+6+'Button').value = ' ';
												document.getElementById('ball'+6+'Button').disabled=true;
												document.getElementById('ball'+5+'Button').value = ' '; 
												
											}else{
												document.getElementById('ball'+6+'Button').className ="B4_gray";
												document.getElementById('ball'+6+'Button').style.color = "#555555";
												ballnumber--;
											}
														
									}
					 					
							}
						statsstrike(-1);
}

function deleteBall(ball,numStats){
	
	deleteBallflag = 1;
	
	if (deleteBallPos[ballnumber] != 6) {
		document.getElementById('ball'+deleteBallPos[ballnumber]+'Button').value = " ";
		
		//If ball 5 clear button 6
		if (deleteBallPos[ballnumber] == 5){
			document.getElementById('ball'+6+'Button').value=" ";
			document.getElementById('ball'+6+'Button').disabled=true;
		}
		
		
		if (deleteBallPos[ballnumber] <= 3 )
			statsball(-numStats);
		else
			statsstrike(-numStats);
			
		ballnumber--;							
		undo();
	}else{ //Reduce ++++ 
		if (document.getElementById('ball'+6+'Button').value != ' ' && 
			document.getElementById('ball'+6+'Button').className != 'B4_gray'){
			reducePlus();
							
		}else{ //Delete the + button and clear the last ball or strike
					document.getElementById('ball'+6+'Button').value=" ";
					document.getElementById('ball'+6+'Button').disabled=true;
					ballnumber--;
					deleteBall(deleteBallPos[ballnumber],numStats);
				
		}
	}
	
	
}

function fillball(ball,numStats){
		
	deleteBallflag = 0;	

	//Check if delete is required
	switch ( ball ){
		case 4:
			if ( ball4 < ballvalue) deleteBall(ball, numStats); 
		break;
		case 5:
			if ( ball5 < ballvalue) deleteBall(ball, numStats); 
		break;
		default:
			////if ( deleteBallPos[ballnumber] != ball && document.getElementById('ball'+ball+'Button').value != " "  ) //
			if ( ( document.getElementById('ball'+ball+'Button').value < ballnumber &&   document.getElementById('ball'+ball+'Button').value != " "  ) || 
			( ballnumber != 0 && deleteBallPos[ballnumber] == ball && ball <3 )
			)
			{
			deleteBall(ball, numStats);
			}
		break;
	}
	
	
	if (!deleteBallflag) {
		
		if ( ballnumber < 5 ) {
			ballnumber++;
			ballvalue = ballnumber;
		}
		
		
		
		if  (ball == 4 || ball == 5)  {
			
			if (ball == 4 && document.getElementById('ball'+ball+'Button').value == " " ){
				ball4 = document.getElementById('ball'+ball+'Button').value;
				deleteBallPos[ballnumber] = 4;
			}
			
			if (ball == 5 && document.getElementById('ball'+ball+'Button').value == " " ){
				ball5 = document.getElementById('ball'+ball+'Button').value;
				deleteBallPos[ballnumber] = 5;
				
				document.getElementById('ball'+6+'Button').disabled=false;
				document.getElementById('ball'+6+'Button').value='+';
				document.getElementById('ball'+6+'Button').style.class = ''; 
			}
			
			
			if (  document.getElementById('ball'+ball+'Button').value != ' ' &&
				  document.getElementById('ball'+ball+'Button').value <= 5 ){
				ballvalue = 'C';
				ballnumber--;
				deleteBallflag=1; //Don't save ball
			}
			
			if (  document.getElementById('ball'+ball+'Button').value == 'C' ){
				ballvalue = 'F';
				ballnumber--;
				deleteBallflag=1; //Don't save ball
			}
			
			if (  document.getElementById('ball'+ball+'Button').value == 'F' ){
				ballvalue = ' ';
				ballnumber--;
				deleteBall(numStats,1);
				
				
				if (ball == 5){
					document.getElementById('ball'+6+'Button').value=" ";
					document.getElementById('ball'+6+'Button').disabled=true;
				}
				
				
			}
			
	
		}else{
			switch ( ball ){
			case 1:
				ball1 = ballvalue;
				deleteBallPos[ballnumber] = 1;
			break;
			case 2:
				ball2 = ballvalue;
				deleteBallPos[ballnumber] = 2;
			break;
			case 3:
				ball3 = ballvalue;
				deleteBallPos[ballnumber] = 3;
			break;
			}
			
		}
		
		if (!deleteBallflag){
			storeEvent("ball"+ball);
		
			if (ball < 4 )
				statsball(numStats);
			else
				statsstrike(numStats);
									
			if ( numStats )
				submitBall();
			
		}
		
		if (ball == 6){
			if (document.getElementById('ball'+ball+'Button').value == "+++"){
				document.getElementById('ball'+ball+'Button').value = "4+";
			}else{
				if (document.getElementById('ball'+ball+'Button').className=='B4_gray'){
					
					document.getElementById('ball'+ball+'Button').style.color='#FFF';
					document.getElementById('ball'+ball+'Button').className='B6';	
				}else{
					if (document.getElementById('ball'+ball+'Button').value[0] > 3) { //Change to number plus +
						var num = parseInt( document.getElementById('ball'+ball+'Button').value[0],10) + 1 ;
						document.getElementById('ball'+ball+'Button').value =  num + "+";
						
					}else{
						document.getElementById('ball'+ball+'Button').value=document.getElementById('ball'+ball+'Button').value+"+";
						document.getElementById('ball'+ball+'Button').style.color='#FFF';
					}

				}
				
			}
		}else{
			document.getElementById('ball'+ball+'Button').value = ballvalue;
		}
		
		deleteBallPos[ballnumber] = ball;
	}
	
	
}

function fillballtray(x,y){
	storeEvent("balltrayectory");
        
    var imgSrc = drawingCanvas.toDataURL("images/png");
    
    restorePoints.push(imgSrc);
   	
   	// Create the yellow face
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = "#FFFFFF";
	basecanvas.lineWidth = 1;
   	
   	basecanvas.beginPath();
	basecanvas.moveTo(255,230);
	basecanvas.lineTo(x,y); // \
	basecanvas.stroke();
	
	document.getElementById("ballx").value = x; 
	document.getElementById("bally").value = y; 
	document.getElementsByName("Events[Misce][]")[eventscounter].value = x + '-' + y;
}


function out(pos,num){
	
	//Round corners
	
	$('#OutNumber').css('background', '#FFFFFF');
	
	if (pos != 0){ //Sacrify fly out 
		if (pos > 6) pos = 'F'+pos;
	
		if ( valN = $('#OutText').val() ) { //If there is a value on OutText
			pl1 =  parseInt( valN.slice(-1) , 10); //Read the last player 
			
			statsOutAssistance(pl1, pos,num);
			statsOut(pl1,-num); //Out statistics 
			statsOut(pos,num); //Out statistics 
			
			$('#OutText').val( valN +'-'+pos );
		}else{
			statsOut(pos,num); //Out statistics 
			$('#OutText').val(pos);
		} 	
	}
	
	//Change the title 1 if it's empty
	if (! $('#T1').val() ) $('#T1').val( $('#OutText').val() );
	storeEvent("out");
	
	G_OUT = 1;
	
		for (i=1;i<=eventscounter;i++){
			if (document.getElementsByName("Events[Events_type_idevents_type][]")[i].value == 37){ //Event Out
				document.getElementsByName("Events[Misce][]")[i].value = $('#OutNumber').val() ; //Event by EventType
			}
		}

}


function dp_out(){
	
	$('#OutNumber').val( parseInt( $('#OutNumber').val() , 10) + 1)  ;
	
}

 /*
  
  array('P', 'C', '1B', '2B', '3B','SS',
	   'LF', 'CF', 'RF', 'EF','DH', 'PH',
	   'PR',  'CR', 'EH',  'X');
	   
	   */			  
function matchPositionIDPlayer(pos){
	var player=0;
	switch (pos){
		case 'P': 
		player = pitcher;
		break;
		
		case 'C': 
		player = catcher; 
		break; 
		
		case '1B':
		player = base1;
		break;
		
		case '2B': 
		player = base2;
		break;
		
		case '3B': 
		player = base3; 
		break; 
		
		case 'SS':
		player = shortstop;
		break;
		
		case 'LF': 
		player = leftfield;
		break;
		
		case 'CF': 
		player = centerfield; 
		break; 
		
		case 'RF':
		player = rightfield;
		break;
		
		case 'EF':
		player = 0;
		break;	
		
		case 'DH':
		player = designatedhitter;
		break;
		
		case 'PH':
		player = pinchhitter;
		break;
		
		case 'PR':
		player = pinchrunner;
		break;
		
		case 'CR':
		player = 0;
		break;
		
		case 'EH':
		player = 0;
		break;
		
		case 'X':
		player = 0;
		break;
		
	}
	
	return player;
}
				  
				  
function fillError(type, position ){ 
//type: base2 
//position of the error
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	
	var playerfield = matchPositionIDPlayer(position);
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = type;
	
	switch (type){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			
			runb3();
			//Score table
			//Team's runs
			document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)+1;
			//R
			document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)+1;
			
		break;
			
	}	
	
	switch(position){
		case 'EF':
			storeEvent('E0');
		break;
		
		case 'RF':
			storeEvent('E9');
		break;
		
		case 'CF':
			storeEvent('E8');
		break;
		
		case 'LF':
			storeEvent('E7');
		break;
		
		case 'SS':
			storeEvent('E6');
		break;
		
		case '3B':
			storeEvent('E5');
		break;
		
		case '2B':
			storeEvent('E4');
		break;
		
		case '1B':
			storeEvent('E3');
		break;
		
		case 'C':
			//alert('catcher');
			storeEvent('E2');
		break;
		
		case 'P':
			storeEvent('E1');
		break;
		
	}
	
	statsError(playerfield,playerbatter,1);
}


function fillCS(base,num){
	storeEvent('CS');
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			outb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			out(2,num);
			outb2();
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			out(2,num);
			outb3();
		break;
			
	}	
	
	//WizardLineup();
	
	statscs(playerbatter,num);
	
}

function fillCS26(num){
	
	
	outb1();
	
	out(2,num);
	out(6,num);
	
	storeEvent('CS26');
	
	statscs(hitterBase1,num);
	
}

function fillCS25(base,num){
	
	/* switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			outb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			outb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			outb3();
		break;
			
	}	*/
	outb2();
	
	out(2,num);
	out(5,num);
	
	storeEvent('CS25');
	
	statscs(hitterBase2,num);
	
}

function fillE0foulby(position,num){ //BUtton MISC //falta implementar
	
	var playerfield = matchPositionIDPlayer(position);
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = position;

	switch(position){
		case 'EF':
			storeEvent('fE0');
		break;
		
		case 'RF':
			storeEvent('fE9');
		break;
		
		case 'CF':
			storeEvent('fE8');
		break;
		
		case 'LF':
			storeEvent('fE7');
		break;
		
		case 'SS':
			storeEvent('fE6');
		break;
		
		case '3B':
			storeEvent('fE5');
		break;
		
		case '2B':
			storeEvent('fE4');
		break;
		
		case '1B':
			storeEvent('fE3');
		break;
		
		case 'C':
			//alert('catcher');
			storeEvent('fE2');
		break;
		
		case 'P':
			storeEvent('fE1');
		break;
		
	}
	
	statsE0foulby(playerfield,num);
} 

function fillSB(base,num){ //Stolen Base
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	
	storeEvent('SB');
	
	if (num)
 		statssb(playerbatter,num);
	
}

function fillPB(base,num){ //Pass Ball
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	
	storeEvent('PB');
	
	if (num)
		statspb (num);
}

function fillWP(base,num){ //Wild Pitch
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	
	storeEvent('WP');
	if (num)
 		statswp(playerbatter,num);
	
}

function fillBK(base,num){ //Stolen Base
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	storeEvent('BK');
 	statsbk(playerbatter,num);
	
}



function fillSBNStat(base,num){ //Stolen Base pickoff attempt
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	storeEvent('SBNStat');

 	statssb(playerbatter,num);
	
}

function fillPBNStat(base){ //Stolen Base
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	
	storeEvent('PBNStat');
	
}

function fillWPNStat(base){ //Stolen Base
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	

 	storeEvent('WPNStat');
}

function fillBKNStat(base){ //Stolen Base
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
 	
 	storeEvent('BKNStat');
}

function fillO(base){ //Other / Batted Forward
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	storeEvent('O');
 	
}

function fillDI(base){ //DI: Defensive Indifference
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	storeEvent('DI');
}

function fillFC(base){ //FC: Fielders Choice
	
	document.getElementsByName("Events[Misce][]")[eventscounter].value = base;
	
	var imgSrc = drawingCanvas.toDataURL("images/png");
	// and store this value as a 'restoration point', to which we can later revert
	restorePoints.push(imgSrc);
	
	
	switch (base){
		
		case '2b':
			playerbatter = hitterBase1;
			runb1();
			
		break;
		
		case '3b':
			playerbatter = hitterBase2;
			runb2();
			
		break;
		
		case '4b':
			playerbatter = hitterBase3;
			runb3();
		break;
			
	}	
	storeEvent('FC');
}


function filldp143(num){
	
	statsdp143(num);
	
	outb1();
	
	out (1,num);
	out (4,num);
	G_OUT = 0;
	dp_out();
	out (3,num);
	
	
	
}

function filldp163(num){
	
	statsdp163(num);
	
	outb1();
	out (1,num);
	statsdpPosition(1,num);
	out (6);
	statsdpPosition(6,num);
	G_OUT = 0;
	dp_out();
	out (3,num);
	statsdpPosition(3,num);
	
	
	
}

function filldp361(num){
	
	statsdp361(num);
	
	outb1();
	
	out (3,num);
	statsdpPosition(3,num);
	out (6,num);
	statsdpPosition(6,num);
	G_OUT = 0;
	dp_out();
	out (1,num);
	statsdpPosition(1,num);
	
}

function filldp363(num){
	
	statsdp363(num);
	
	outb1();
	
	out (3,num);
	statsdpPosition(3,num);
	out (6,num);
	statsdpPosition(6,num);
	G_OUT = 0;
	dp_out();
	out (3,num);
	
}

function filldp463(num){
	
	statsdp463(num);
	
	outb1();
	
	out (4,num);
	statsdpPosition(4,num);
	out (6,num);
	statsdpPosition(6,num);
	G_OUT = 0;
	dp_out();
	out (3,num);
	statsdpPosition(3,num);
	
}

function filldp543(num){
	statsdp543(num);
	
	outb1();
	
	out (5,num);
	statsdpPosition(5,num);
	out (4,num);
	statsdpPosition(4,num);
	G_OUT = 0;
	dp_out();
	out (3,num);
	statsdpPosition(3,num);
	
}

function filldp643(num){
	statsdp643(num);
	outb1();
	
	out (6,num);
	statsdpPosition(6,num);
	out (4,num);
	statsdpPosition(4,num);
	G_OUT = 0;
	dp_out();
	out (3,num);
	statsdpPosition(3,num);
}

function filldp63(num){
	statsdp63(num);
	outb1();
	
	out (6,num);
	statsdpPosition(6,num);
	G_OUT = 0;
	dp_out();
	out (3,num);
	statsdpPosition(3,num);
}

function filldp43(num){
	statsdp43(num);
	outb1();
	
	out (4,num);
	statsdpPosition(4,num);
	G_OUT = 0;
	dp_out();
	out (3,num);
	statsdpPosition(3,num);
	
}

function filldp36(num){
	statsdp36(num);
	outb1();
	
	out (3,num);
	statsdpPosition(3,num);
	statsdpPosition(6,num);
	
}

function filldpw(){
	
	WizardLineupdp();
}
    
function FOut(PositionNumber){
	
	
	fieldplayer = matchPlayerID(PositionNumber);
	
	out(PositionNumber);
	
	$('#OutText').val('F'+PositionNumber);
	
	$('#T1').val( $('#OutText').val() );
	
	statsFOut(fieldplayer,1);
	
}

function FOut3(num){
	
	out(3,num);
	
	$('#OutText').val(PositionNumber);
	
	$('#T1').val( $('#OutText').val() );
	
	statsFOut(fieldplayer,num);
	
}

function FOut43(num){
	
	out(4,num);
	out(3,num);
	
	
	$('#OutText').val('4-3');
	
	$('#T1').val( $('#OutText').val() );
	
	
}

function FOut53(num){
	
	out(5,num);
	out(3,num);
	
	
	$('#OutText').val('5-3');
	
	$('#T1').val( $('#OutText').val() );
	
	
}
   
function FOut63(num){
	
	out(6,num);
	out(3,num);
	
	
	$('#OutText').val('6-3');
	
	$('#T1').val( $('#OutText').val() );
	
	
}     

function FOutFO(){
	
	out(0,0);
	
	
	$('#OutText').val('F');
	
	$('#T1').val( $('#OutText').val() );
	
	
}

function FOutGO(){
	
	out(0,0);
	
	$('#OutText').val('');
	
	$('#T1').val( $('#OutText').val() );
	
	
}

//
function LastBatter(){
	$('#T1').val('Last Batter');
	storeEvent('lstBatter');
	
}

function SkipBatter(){
	$('#T1').val('Skipped Batter');
	document.getElementById('T1').style.fontSize = '20px';
	document.getElementById('T1').setAttribute('style', 'font-size:18px !important');
	storeEvent('skpBatter');
}

function fillOBR(){ //OBR: On By Rule (tie break)
	
}

function fillITB(){ //ITB: International Tie Breaker
	
}
  
  
function fillfillCO(){ //CO: Catcher\'s Obstruction
	
}

function fillE(){ //E: Reach Base On Error
	
}
                
function clickPos1(num){
	
	out(1,num);
}

function clickPos2(num){
	out(2,num);
}

function clickPos3(num){
	out(3,num);
}

function clickPos4(num){
	out(4,num);
}

function clickPos5(num){
	out(5,num);
}

function clickPos6(num){
	out(6,num);
}

function clickPos7(num){
	out(7,num);
}

function clickPos8(num){
	out(8,num);
}

function clickPos9(num){
	out(9,num);
}

function blockcontrols(){
	//alert($("#buttonHP").attr("onclick"));
	$("#buttonHR").attr("onclick", false);
	$("#button3B").attr("onclick", false);
	$("#button2B").attr("onclick", false);
	$("#button1B").attr("onclick", false);
	$("#buttonBB").attr("onclick", false);
	$("#buttonHP").attr("onclick", false);
	
	$("#K").attr("id", 'K_dis');
	$("#FC").attr("id", 'FC_dis');
	$("#DP").attr("id", 'DP_dis');
	$("#SAC").attr("id", 'SAC_dis');
		
}

function enableControls(){
	$("#buttonHR").attr("onclick", 'fillhr(1)');
	$("#button3B").attr("onclick", 'fill3b(1)');
	$("#button2B").attr("onclick", 'fill2b(1)');
	$("#button1B").attr("onclick", 'fill1b(1)');
	$("#buttonBB").attr("onclick", 'fillbb(1)');
	$("#buttonHP").attr("onclick", 'fillhp(1)');
	
	$("#K_dis").attr("id", 'K');
	$("#FC_dis").attr("id", 'FC');
	$("#DP_dis").attr("id", 'DP');
	$("#SAC_dis").attr("id", 'SAC');
}
