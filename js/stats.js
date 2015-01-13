/**
 * @author Jonathan Lizano
 */

function statshr(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("H"+batter).value = parseInt(document.getElementById("H"+batter).value, 10)+numberstat;
	document.getElementById("RBI"+batter).value = parseInt(document.getElementById("RBI"+batter).value, 10)+numberstat;
	document.getElementById("R"+batter).value = parseInt(document.getElementById("R"+batter).value, 10)+numberstat;
	document.getElementById("HR"+batter).value = parseInt(document.getElementById("HR"+batter).value, 10)+numberstat;
	document.getElementById("TB"+batter).value = parseInt(document.getElementById("TB"+batter).value, 10)+4*numberstat;
	document.getElementById("XBH"+batter).value = parseInt(document.getElementById("XBH"+batter).value, 10)+numberstat;
	
	
	//Team's runs
	document.getElementById("r"+inning+battingteam).value = parseInt(document.getElementById("r"+inning+battingteam).value, 10)+numberstat;
	
	//Score table
	//R
	document.getElementById("r"+11+battingteam).value = parseInt(document.getElementById("r"+11+battingteam).value, 10)+numberstat;
	
	//H
	document.getElementById("r"+12+battingteam).value = parseInt(document.getElementById("r"+12+battingteam).value, 10)+numberstat;
	
	//Pitcher
	document.getElementById("pH"+pitcher).value = parseInt(document.getElementById("pH"+pitcher).value, 10)+numberstat;
	document.getElementById("pR"+pitcher).value = parseInt(document.getElementById("pR"+pitcher).value, 10)+numberstat;
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pER"+pitcher).value = parseInt(document.getElementById("pER"+pitcher).value, 10)+numberstat;
	document.getElementById("pHR"+pitcher).value = parseInt(document.getElementById("pHR"+pitcher).value, 10)+numberstat;
	//document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
}


function stats3b(numberstat){
	//player stats
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("H"+batter).value = parseInt(document.getElementById("H"+batter).value, 10)+numberstat;
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("v3B"+batter).value = parseInt(document.getElementById("v3B"+batter).value, 10)+numberstat;
	document.getElementById("TB"+batter).value = parseInt(document.getElementById("TB"+batter).value, 10)+3*numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("XBH"+batter).value = parseInt(document.getElementById("XBH"+batter).value, 10)+numberstat;
	
	
	//H
	document.getElementById("r"+12+battingteam).value = parseInt(document.getElementById("r"+12+battingteam).value, 10)+numberstat;
	
	//Pitcher
	document.getElementById("pH"+pitcher).value = parseInt(document.getElementById("pH"+pitcher).value, 10)+numberstat;
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pv3B"+pitcher).value = parseInt(document.getElementById("pv3B"+pitcher).value, 10)+numberstat;
	//document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
}

function stats2b(numberstat){ //2b base 2
	//player stats
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("H"+batter).value = parseInt(document.getElementById("H"+batter).value, 10)+numberstat;
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("v2B"+batter).value = parseInt(document.getElementById("v2B"+batter).value, 10)+numberstat;
	document.getElementById("TB"+batter).value = parseInt(document.getElementById("TB"+batter).value, 10)+2*numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("XBH"+batter).value = parseInt(document.getElementById("XBH"+batter).value, 10)+numberstat;
	
	//H
	document.getElementById("r"+12+battingteam).value = parseInt(document.getElementById("r"+12+battingteam).value, 10)+numberstat;
	
	//Pitcher
	document.getElementById("pH"+pitcher).value = parseInt(document.getElementById("pH"+pitcher).value, 10)+numberstat;
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pv2B"+pitcher).value = parseInt(document.getElementById("pv2B"+pitcher).value, 10)+numberstat;
	//document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
}

function stats1b(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("H"+batter).value = parseInt(document.getElementById("H"+batter).value, 10)+numberstat;
	document.getElementById("TB"+batter).value = parseInt(document.getElementById("TB"+batter).value, 10)+1*numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	
	//H
	document.getElementById("r"+12+battingteam).value = parseInt(document.getElementById("r"+12+battingteam).value, 10)+numberstat;
	
	//Pitcher
	document.getElementById("pH"+pitcher).value = parseInt(document.getElementById("pH"+pitcher).value, 10)+numberstat;
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	//document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
}

function statsbb(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("BB"+batter).value = parseInt(document.getElementById("BB"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	
	//Pitcher doesn't have
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pBB"+pitcher).value = parseInt(document.getElementById("pBB"+pitcher).value, 10)+numberstat;
	document.getElementById("pB"+pitcher).value = parseInt(document.getElementById("pB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
}

function statshp(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("HP"+batter).value = parseInt(document.getElementById("HP"+batter).value, 10)+numberstat;
	document.getElementById("HBP"+batter).value = parseInt(document.getElementById("HBP"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	
	//Pitcher doesn't have
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pHBP"+pitcher).value = parseInt(document.getElementById("pHBP"+pitcher).value, 10)+numberstat;
	document.getElementById("pHB"+pitcher).value = parseInt(document.getElementById("pHB"+pitcher).value, 10)+numberstat;
	document.getElementById("pB"+pitcher).value = parseInt(document.getElementById("pB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
}

function statskso(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	
	//Pitcher 
	//document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;

	//fielding
	//catcher
	document.getElementById("fTC"+catcher).value = parseInt(document.getElementById("fTC"+catcher).value, 10)+numberstat;
	document.getElementById("fPO"+catcher).value = parseInt(document.getElementById("fPO"+catcher).value, 10)+numberstat;
;
}

function statsks(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	
	//Pitcher
	//document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;

	//fielding
	//catcher
	document.getElementById("fTC"+catcher).value = parseInt(document.getElementById("fTC"+catcher).value, 10)+numberstat;
	document.getElementById("fPO"+catcher).value = parseInt(document.getElementById("fPO"+catcher).value, 10)+numberstat;
	
}

function statsks23(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	
	//Pitcher
	//document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;
	
	//fielding
	//catcher
	document.getElementById("fTC"+catcher).value = parseInt(document.getElementById("fTC"+catcher).value, 10)+numberstat;
	document.getElementById("fA"+catcher).value = parseInt(document.getElementById("fA"+catcher).value, 10)+numberstat;
	
	//Base1
	document.getElementById("fTC"+base1).value = parseInt(document.getElementById("fTC"+base1).value, 10)+numberstat;
	document.getElementById("fA"+base1).value = parseInt(document.getElementById("fA"+base1).value, 10)+numberstat;
	
}

function statsks2(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
	
	//fielding
	//catcher
	document.getElementById("fTC"+catcher).value = parseInt(document.getElementById("fTC"+catcher).value, 10)+numberstat;
	document.getElementById("fPO"+catcher).value = parseInt(document.getElementById("fPO"+catcher).value, 10)+numberstat;
	
}

function statskse(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("OE"+batter).value = parseInt(document.getElementById("OE"+batter).value, 10)+numberstat;
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
	
	//Score table
	//E
	document.getElementById("r"+13+defensiveteam).value = parseInt(document.getElementById("r"+13+defensiveteam).value, 10)+numberstat;
	
}

function statskfcar(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("FC"+batter).value = parseInt(document.getElementById("FC"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
	
}

function statskfcnb(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("FC"+batter).value = parseInt(document.getElementById("FC"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
	
}

function statskr1po(numberstat){
	statsOut(1,1);
}

function statskr2po(numberstat){
	statsOut(2,1);
}

function statskr3po(numberstat){
	statsOut(3,1);
}

function statskpb(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
	
	//fielding
	//catcher
	document.getElementById("fPB"+catcher).value = parseInt(document.getElementById("fPB"+catcher).value, 10)+numberstat;
	
}

function statskwp(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("SO"+batter).value = parseInt(document.getElementById("SO"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pWP"+pitcher).value = parseInt(document.getElementById("pWP"+pitcher).value, 10)+numberstat;
	document.getElementById("pSO"+pitcher).value = parseInt(document.getElementById("pSO"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
	
	//Field
	document.getElementById("fC_WP"+catcher).value = parseInt(document.getElementById("fC_WP"+catcher).value, 10)+numberstat;
}

function statsfcar(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("FC"+batter).value = parseInt(document.getElementById("FC"+batter).value, 10)+numberstat;

	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
}

function statsfcnb(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("FC"+batter).value = parseInt(document.getElementById("FC"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
}

function statsr1po(numberstat){
	statsOut(1,1);
}

function statsr2po(numberstat){
	statsOut(2,1);
}

function statsr3po(numberstat){
	statsOut(3,1);
}

function statsr4sac(numberstat){ //SF Sacrifice fly
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("SF"+batter).value = parseInt(document.getElementById("SF"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSF"+pitcher).value = parseInt(document.getElementById("pSF"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat

}

function statsr3sac(numberstat){ //Sacrifice Hit / Sac Bunt
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("SH"+batter).value = parseInt(document.getElementById("SH"+batter).value, 10)+numberstat;
	document.getElementById("SAC"+batter).value = parseInt(document.getElementById("SAC"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSH"+pitcher).value = parseInt(document.getElementById("pSH"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat

}

function statsr2sac(numberstat){ //SF Sac Fly, Reached on Error
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("SF"+batter).value = parseInt(document.getElementById("SF"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("OE"+batter).value = parseInt(document.getElementById("OE"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSF"+pitcher).value = parseInt(document.getElementById("pSF"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat

}

function statsr1sac(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("SH"+batter).value = parseInt(document.getElementById("SH"+batter).value, 10)+numberstat;
	document.getElementById("SAC"+batter).value = parseInt(document.getElementById("SAC"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("OE"+batter).value = parseInt(document.getElementById("OE"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSH"+pitcher).value = parseInt(document.getElementById("pSH"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
}

function stats0sacFCAR(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("SH"+batter).value = parseInt(document.getElementById("SH"+batter).value, 10)+numberstat;
	document.getElementById("SAC"+batter).value = parseInt(document.getElementById("SAC"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("FC"+batter).value = parseInt(document.getElementById("FC"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSH"+pitcher).value = parseInt(document.getElementById("pSH"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
}

function stats0sacFCNB(numberstat){
	//player stats
	document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
	document.getElementById("SH"+batter).value = parseInt(document.getElementById("SH"+batter).value, 10)+numberstat;
	document.getElementById("SAC"+batter).value = parseInt(document.getElementById("SAC"+batter).value, 10)+numberstat;
	document.getElementById("LOB"+batter).value = parseInt(document.getElementById("LOB"+batter).value, 10)+numberstat;
	document.getElementById("FC"+batter).value = parseInt(document.getElementById("FC"+batter).value, 10)+numberstat;
	
	
	//Pitcher
	document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
	document.getElementById("pSH"+pitcher).value = parseInt(document.getElementById("pSH"+pitcher).value, 10)+numberstat;
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
}

function statsball(numberstat){
	
	//Pitcher
	document.getElementById("pB"+pitcher).value = parseInt(document.getElementById("pB"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
}


function statsstrike(numberstat){
	
	//Pitcher
	document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
}

//Receive the position of the defense player and returns his ID
function matchPlayerID(pos){
	//Match number of player with Id player
	
	var player=0;
	switch (pos){
		case 1: 
		player = pitcher;
		break;
		
		case 2: 
		player = catcher; 
		break; 
		
		case 3:
		player = base1;
		break;
		
		case 4: 
		player = base2;
		break;
		
		case 5: 
		player = base3; 
		break; 
		
		case 6:
		player = shortstop;
		break;
		
		case 7: 
		player = leftfield;
		break;
		
		case 8: 
		player = centerfield; 
		break; 
		
		case 9:
		player = rightfield;
		break;	
	}
	
	return player;
}

function statsOut(player, numberstat){
	
	if (numberstat != 0){
		
		player = matchPlayerID(player);
		
		//player stats
		document.getElementById("PA"+batter).value = parseInt(document.getElementById("PA"+batter).value, 10)+numberstat;
		document.getElementById("AB"+batter).value = parseInt(document.getElementById("AB"+batter).value, 10)+numberstat;
		
		
		//H
		//document.getElementById("r"+12+battingteam).value = parseInt(document.getElementById("r"+12+battingteam).value, 10)+numberstat;
		
		//Pitcher
		document.getElementById("pBF"+pitcher).value = parseInt(document.getElementById("pBF"+pitcher).value, 10)+numberstat;
		document.getElementById("pS"+pitcher).value = parseInt(document.getElementById("pS"+pitcher).value, 10)+numberstat;
		document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)+numberstat;
		document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat
		//document.getElementById("pH"+pitcher).value = parseInt(document.getElementById("pH"+pitcher).value, 10)+numberstat;
		
		
		if (player){
			document.getElementById("fTC"+player).value = parseInt(document.getElementById("fTC"+player).value, 10)+numberstat;
			document.getElementById("fPO"+player).value = parseInt(document.getElementById("fPO"+player).value, 10)+numberstat;
			if (player != pitcher   ) document.getElementById("fINN"+player).value = parseFloat(document.getElementById("fINN"+player).value, 10)+(numberstat)/3;
			
		}		
		//fielding
		
		//Inning = 1/3 by Out
		//pitcher
		document.getElementById("pIP"+pitcher).value = parseFloat(document.getElementById("pIP"+pitcher).value, 10)+(numberstat /3);
	
	}
	
}


function statsOutAssistance(pl1, pl2, numberstat){ //Remove Punch Out the player1 add Assistance  
	
	if (numberstat != 0){
		pl1 = matchPlayerID(pl1);
		pl2 = matchPlayerID(pl2);
		
		
		//Fielding
		//Player1
		document.getElementById("fPO"+pl1).value = parseInt(document.getElementById("fPO"+pl1).value, 10)+-1;
		document.getElementById("fA"+pl1).value = parseInt(document.getElementById("fA"+pl1).value, 10)+numberstat;
		document.getElementById("fINN"+pl2).value = parseFloat(document.getElementById("fINN"+pl2).value, 10)-(numberstat)/3;
		
		//fielding
		//Player2
		document.getElementById("fTC"+pl2).value = parseInt(document.getElementById("fTC"+pl2).value, 10)+numberstat;
		document.getElementById("fPO"+pl2).value = parseInt(document.getElementById("fPO"+pl2).value, 10)+numberstat;
		
		if (pl2 != pitcher ) document.getElementById("fINN"+pl2).value = parseFloat(document.getElementById("fINN"+pl2).value, 10)+(numberstat)/3;
		
	}
	
	
}

//Remove Punch Out the player1 add Out to player 2, remove assistance from player2
function removestatsOutAssistance(pl1, pl2, numberstat){ 
	
	
	pl1 = matchPlayerID(pl1);
	pl2 = matchPlayerID(pl2);
	
	
	//Fielding
	//Player1
	
	document.getElementById("fPO"+pl1).value = parseInt(document.getElementById("fPO"+pl1).value, 10)+-1;
	
	//fielding
	//Player2
	document.getElementById("fA"+pl2).value = parseInt(document.getElementById("fA"+pl2).value, 10)+-1;
	document.getElementById("fTC"+pl2).value = parseInt(document.getElementById("fTC"+pl2).value, 10)+numberstat;
	document.getElementById("fPO"+pl2).value = parseInt(document.getElementById("fPO"+pl2).value, 10)+numberstat;
	
	if (pl2 != pitcher ) document.getElementById("fINN"+pl2).value = parseFloat(document.getElementById("fINN"+pl2).value, 10)+(numberstat)/3;
	
}

//Remove Punch Out the player1 add Out to player 2, remove assistance from player2
function removestatsOut2p(pl1, pl2){ 
	
	
	pl1 = matchPlayerID(pl1);
	pl2 = matchPlayerID(pl2);
	
	
	//Fielding
	//Player1
	
	document.getElementById("fPO"+pl1).value = parseInt(document.getElementById("fPO"+pl1).value, 10)+-1;
	
	//fielding
	//Player2
	document.getElementById("fA"+pl2).value = parseInt(document.getElementById("fA"+pl2).value, 10)+-1;
	document.getElementById("fTC"+pl2).value = parseInt(document.getElementById("fTC"+pl2).value, 10)+1;
	document.getElementById("fPO"+pl2).value = parseInt(document.getElementById("fPO"+pl2).value, 10)+1;
	
	if (pl2 != pitcher ) document.getElementById("fINN"+pl2).value = parseFloat(document.getElementById("fINN"+pl2).value, 10)-(1)/3;
	else document.getElementById("pIP"+pitcher).value = parseFloat(document.getElementById("pIP"+pitcher).value, 10)-(1)/3;
	
	
}

//Remove Punch Out the player1 add Out to player 2, remove assistance from player2
function removestatsOut(pl1){ 
	
	
	pl1 = matchPlayerID(pl1);
	
	
	//Fielding
	//Player1
	
	//alert("Player to remove out: "+pl1);
	
	document.getElementById("fPO"+pl1).value = parseInt(document.getElementById("fPO"+pl1).value, 10)+-1;
	document.getElementById("fTC"+pl1).value = parseInt(document.getElementById("fTC"+pl1).value, 10)-1;
	
	if (pl1 != pitcher ) document.getElementById("fINN"+pl1).value = parseFloat(document.getElementById("fINN"+pl1).value, 10)-(1)/3;
	else {
		document.getElementById("pIP"+pitcher).value = parseFloat(document.getElementById("pIP"+pitcher).value, 10)-(1)/3;
		document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)-1;
		}
	
	
}

//Stats for Base button advance on error
function statsError(playerfield, playerbatter, numberstat){

	//alert("Player Field ID"+playerfield);
	//alert("Player Batter ID"+playerbatter);
	
	//player stats / Stole base
	document.getElementById("SB"+playerbatter).value = parseInt(document.getElementById("SB"+playerbatter).value, 10)+numberstat;
	
	//fielding Error
	document.getElementById("fE"+playerfield).value = parseInt(document.getElementById("fE"+playerfield).value, 10)+numberstat;
	
	//Score table
	//E
	document.getElementById("r"+13+defensiveteam).value = parseInt(document.getElementById("r"+13+defensiveteam).value, 10)+numberstat;
				
	
}

function statscs (playerbatter,numberstat){
	//player stats / Stole base
	document.getElementById("CS"+playerbatter).value = parseInt(document.getElementById("CS"+playerbatter).value, 10)+numberstat;
	document.getElementById("pCS"+pitcher).value = parseInt(document.getElementById("pCS"+pitcher).value, 10)+numberstat;
	document.getElementById("fCS"+catcher).value = parseInt(document.getElementById("fCS"+catcher).value, 10)+numberstat;
	
}

function statssb (playerbatter,numberstat){
	//player stats / Stole base
	document.getElementById("SB"+playerbatter).value = parseInt(document.getElementById("SB"+playerbatter).value, 10)+numberstat;
	document.getElementById("pSB"+pitcher).value = parseInt(document.getElementById("pSB"+pitcher).value, 10)+numberstat;
	document.getElementById("fSB"+catcher).value = parseInt(document.getElementById("fSB"+catcher).value, 10)+numberstat;
}

function statspb (numberstat){
	//player stats / Stole base
	document.getElementById("fPB"+catcher).value = parseInt(document.getElementById("fPB"+catcher).value, 10)+numberstat;
	
	
}

function statswp (playerbatter,numberstat){
	//player stats / Stole base
	document.getElementById("pWP"+pitcher).value = parseInt(document.getElementById("pWP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("fC_WP"+catcher).value = parseInt(document.getElementById("fC_WP"+catcher).value, 10)+numberstat;
}

function statsbk (playerbatter,numberstat){
	//player stats / Stole base
	document.getElementById("pBK"+pitcher).value = parseInt(document.getElementById("pBK"+pitcher).value, 10)+numberstat;
	
}

function statsFOut(fieldplayer,numberstat){
	document.getElementById("pAB"+pitcher).value = parseInt(document.getElementById("pAB"+pitcher).value, 10)-numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
}

function statsE0foulby (playerfield,numberstat){
	
	//Field
	document.getElementById("fTC"+playerfield).value = parseInt(document.getElementById("fTC"+playerfield).value, 10)+numberstat;
	document.getElementById("fE"+playerfield).value = parseInt(document.getElementById("fE"+playerfield).value, 10)+numberstat;
	
	
	//Score table
	//E
	document.getElementById("r"+13+defensiveteam).value = parseInt(document.getElementById("r"+13+defensiveteam).value, 10)+numberstat;
	
	
}


function filldp143 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
	
}

function statsdp163 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
}

function statsdp361 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
}	

function statsdp363 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
}	

function statsdp463 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
}

function statsdp543 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
}

function statsdp643 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
}

function statsdp63 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
}

function statsdp43 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	
	document.getElementById("pNP"+pitcher).value = parseInt(document.getElementById("pNP"+pitcher).value, 10)+numberstat;
	
	document.getElementById("pGIDP"+pitcher).value = parseInt(document.getElementById("pGIDP"+pitcher).value, 10)+numberstat;
}

function statsdpPosition (player,numberstat){
	
	player = matchPlayerID(player);
	
	//Field
	document.getElementById("fDP"+player).value = parseInt(document.getElementById("fDP"+player).value, 10)+numberstat;
	

}

function statsdpoutb1 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase1).value = parseInt(document.getElementById("GDP"+hitterBase1).value, 10)+numberstat;
	

}

function statsdpoutb2 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase2).value = parseInt(document.getElementById("GDP"+hitterBase2).value, 10)+numberstat;
	
	
}
function statsdpoutb3 (numberstat){
	
	//Batter
	document.getElementById("GDP"+hitterBase3).value = parseInt(document.getElementById("GDP"+hitterBase3).value, 10)+numberstat;
	
	
}

function statsoutdp (player, numberstat){
	player = matchPlayerID(player);
	
	//Field
	document.getElementById("fDP"+player).value = parseInt(document.getElementById("fDP"+player).value, 10)+numberstat;
}
	

