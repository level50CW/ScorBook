<?php

$idgame = Yii::app()->user->getState('idgame');

function loadTableTeam ( $id, $form, $model, $idteam, $idgame ){
                    
    $positions = array('P', 'C', '1B', '2B', '3B','SS',
                       'LF', 'CF', 'RF', 'EF','DH', 'PH',
                       'PR', 'CR', 'EH', 'X');
    
    //LOAD LINEUP
    $idLineup = gettype($id) == "array" ? (string)$id[0]->idlineup : $id;
    $criteria = new CDbCriteria();
    $criteria->addcondition("idlineup=".$idLineup);
    $lineup = Lineup::model()->findAll($criteria);
    
    
    //LOAD TEAM INFO
    if (! $teamid=$lineup[0]->Teams_idteam) $teamid = 0 ;
    
    if (Yii::app()->user->getState('idteamhome') == $teamid) {
        $name = Yii::app()->user->getState('teamhome');
        echo "<script> idteamhome = $teamid </script>";
    }else {
        $name = Yii::app()->user->getState('teamvisiting');
        echo "<script> idteamvisiting = $teamid</script>";
    }

    $scoreteam = Yii::app()->user->getState('scoreteam');
    $name = $scoreteam =='home' ? Yii::app()->user->getState('teamhome') : Yii::app()->user->getState('teamvisiting');
    echo Yii::trace(CVarDumper::dumpAsString( Yii::app()->user->getState('idteamvisiting') ),'teamvis');
    
    echo "<table>";
    
    if ($name) echo "<tr class='blacktitle'> <td colspan=40>" . $name ." - Game - ".Yii::app()->user->getState('scoretype') . " Statistics </td> </tr>";
    else echo "<tr> <td colspan=14> LINEUP MUST BE CREATED </td> </tr>";
    
    //LOAD BATTERS
    $criteria = new CDbCriteria();
    $criteria->addcondition("Lineup_idlineup=$idLineup");
    $Batters = Batters::model()->findAll($criteria);
    
    $count = sizeof($Batters);
    
    $criteria = new CDbCriteria();
    
    switch (Yii::app()->user->getState('scoretime')){
        case 'season':
        break;
            
        case 'game':
            $criteria->addcondition("Games_idgame=$idgame");
            
        break;
            
        case 'situation':
        
        break;   
    }
            
    switch (Yii::app()->user->getState('scoretype')){
        case 'batting':
            echo "<th class='score_green'>#</th><th class='score_green' style='width: 120px'>PLAYER</th><th class='score_green'>G</th>
            <th class='score_green'>AB</th><th class='score_green'>R</th><th class='score_green'>H</th><th class='score_green'>2B</th>
            <th class='score_green'>3B</th><th class='score_green'>HR</th><th class='score_green'>RBI</th><th class='score_green'>BB</th>
            <th class='score_green'>SO</th><th class='score_green'>SB</th><th class='score_green'>CS</th><th class='score_green'>HBP</th>
            <th class='score_green'>SAC</th><th class='score_green'>PA</th><th class='score_green'>XBH</th>
            <th class='score_green'>AVG</th><th class='score_green'>OBP</th><th class='score_green'>SLG</th><th class='score_green'>OPS</th>";
            
            $Statshitting = new Statshitting;
            $StatshittingArray = Statshitting::model()->findAll($criteria);
            
            $count_stats_hit = count ($StatshittingArray);
            
            for ($i=0;$i < $count; $i++){
                
                $player = Players::model()->findByPK($Batters[$i]->Players_idplayer);
                
                $class=( $i  %  2 == 0 ) ?  'grayatbat':'black';
                echo "<tr class='$class'>";
                    
                    echo "<td> ".$Batters[$i]->Number." </td>";
                    echo "<td> ".$player->Firstname ." ".$player->Lastname." </td>";
                    
                    //Search the player stats
                    $e=0;
                    if ($count_stats_hit){
                        for ($e;$e < $count_stats_hit; $e++){
                            //echo "8P".$StatshittingArray[$e]->Players_idplayer."<br>";    
                            //echo "Batterid".$Batters[$i]->Players_idplayer."<br>";
                            
                            if ($StatshittingArray[$e]->Players_idplayer == $Batters[$i]->Players_idplayer){
                                $Statshitting =  $StatshittingArray[$e];
                                $e = $count_stats_hit;
                            
                            } 
                        }
                    }
                    //echo "<td> ".$Statshitting->G." </td>";
                                        
                    $criteriaT = new CDbCriteria();
                    $criteriaT->select ="sum(G) as g_total";
                    $criteriaT->addcondition("Players_idplayer=".$Batters[$i]->Players_idplayer);
                    $StatshittingArraySum = Statshitting::model()->findAll($criteriaT);

                
                    echo "<td>".$StatshittingArraySum[0]->g_total." </td>";
                    echo "<td> ".$Statshitting->AB." </td>";
                    echo "<td> ".$Statshitting->R." </td>";
                    echo "<td> ".$Statshitting->H." </td>";
                    echo "<td> ".$Statshitting->v2B." </td>";
                    echo "<td> ".$Statshitting->v3B." </td>";
                    echo "<td> ".$Statshitting->HR." </td>";
                    echo "<td> ".$Statshitting->RBI." </td>";
                    echo "<td> ".$Statshitting->BB." </td>";
                    echo "<td> ".$Statshitting->SO." </td>";
                    echo "<td> ".$Statshitting->SB." </td>";
                    echo "<td> ".$Statshitting->CS." </td>";
                    echo "<td> ".$Statshitting->HBP." </td>";
                    echo "<td> ".$Statshitting->SAC." </td>";
                    echo "<td> ".$Statshitting->PA." </td>";
                    echo "<td> ".$Statshitting->XBH." </td>";
                    echo "<td> ".$Statshitting->AVG." </td>";
                    echo "<td> ".$Statshitting->OBP." </td>";
                    echo "<td> ".$Statshitting->SLG." </td>";
                    echo "<td> ".$Statshitting->OPS." </td>";
                    
                    
                echo "</tr>";
                    $AB += $Statshitting->AB;
                    $R += $Statshitting->R;
                    $H += $Statshitting->H;
                    $v2B += $Statshitting->v2B;
                    $v3B += $Statshitting->v3B;
                    $HR += $Statshitting->HR;
                    $RBI += $Statshitting->RBI;
                    $BB += $Statshitting->BB;
                    $SO += $Statshitting->SO;
                    $SB += $Statshitting->SB;
                    $CS += $Statshitting->CS;
                    $AVG += $Statshitting->AVG;
                    $OBP += $Statshitting->OBP;
                    $SLG += $Statshitting->SLG;
                    $OPS += $Statshitting->OPS;
                    $SAC += $Statshitting->SAC;
                    $HBP += $Statshitting->HBP;
                    $PA += $Statshitting->PA;
                    $XBH += $Statshitting->XBH;
                
            }
                echo "</tr>";
                echo "<tr class='scorewhite'> <td colspan=2 class='scoregreentr'> TOTAL </td>";
                echo "<td >" . (isset($G) ? $G : '') . "</td>";
                echo "<td >" . (isset($AB) ? $AB : '') . "</td>";
                echo "<td >" . (isset($R) ? $R : '') . "</td>";
                echo "<td >" . (isset($H) ? $H : '') . "</td>";
                echo "<td >" . (isset($v2B) ? $v2B : '') . "</td>";
                echo "<td >" . (isset($v3B) ? $v3B : '') . "</td>";
                echo "<td >" . (isset($HR) ? $HR : '') . "</td>";
                echo "<td >" . (isset($RBI) ? $RBI : '') . "</td>";
                echo "<td >" . (isset($BB) ? $BB : '') . "</td>";
                echo "<td >" . (isset($SO) ? $SO : '') . "</td>";
                echo "<td >" . (isset($SB) ? $SB : '') . "</td>";
                echo "<td >" . (isset($CS) ? $CS : '') . "</td>";
                echo "<td >" . (isset($HBP) ? $HBP : '') . "</td>";
                echo "<td >" . (isset($SAC) ? $SAC : '') . "</td>";
                echo "<td >" . (isset($PA) ? $PA : '') . "</td>";
                echo "<td >" . (isset($XBH) ? $XBH : '') . "</td>";
                echo "<td >" . (isset($AVG) ? $AVG : '') . "</td>";
                echo "<td >" . (isset($OBP) ? $OBP : '') . "</td>";
                echo "<td >" . (isset($SLG) ? $SLG : '') . "</td>";
                echo "<td >" . (isset($OPS) ? $OPS : '') . "</td>";
                echo  "</tr>";
        break;
            
        case 'fielding':
            echo "<th class='score_green'>#</th><th class='score_green'  style='width: 120px'>PLAYER</th><th class='score_green'>G</th><th class='score_green'>GS</th><th class='score_green'>I</th><th class='score_green'>TC</th><th class='score_green' >PO</th><th class='score_green'>A</th><th class='score_green'>E</th><th class='score_green'>DP</th><th class='score_green'>SB</th><th class='score_green'>CS</th><th class='score_green'>SBPCT</th><th class='score_green'>PB</th><th class='score_green'>C_WP</th><th class='score_green'>FPCT</th><th class='score_green'>RF</th>";
            //Load stats of players fielding
            //$idgame = Yii::app()->user->getState('idgame');
            //$criteria = new CDbCriteria();
            //$criteria->addcondition("Games_idgame=$idgame");
            $Statsfielding = new Statsfielding;
            $StatsfieldingArray = Statsfielding::model()->findAll($criteria);
            $count_stats_field = count ($StatsfieldingArray);
            
            
            for ($i=0;$i < $count; $i++){
                //echo "Game ID: $idgame - ".$Batter[$i]->Players_idplayer."<BR>";
            
                $player = Players::model()->findByPK($Batters[$i]->Players_idplayer);
                
                $class=( $i  %  2 == 0 ) ?  'grayatbat':'black';
                echo "<tr class='$class'>";
                    
                    echo "<td> ".$Batters[$i]->Number." </td>";
                    echo "<td> ".$player->Firstname ." ".$player->Lastname." </td>";
                    
                    //Search the player stats
                    $e=0;
                    if ($count_stats_field){
                        for ($e;$e < $count_stats_field; $e++){
                            if ($StatsfieldingArray[$e]->Players_idplayer == $Batters[$i]->Players_idplayer){
                                $Statsfielding =  $StatsfieldingArray[$e];
                                $e = $count_stats_field;
                            } 
                        }
                    }
                    $criteriaT = new CDbCriteria();
                    $criteriaT->select ="sum(G) as g_total";
                    $criteriaT->addcondition("Players_idplayer=".$Batters[$i]->Players_idplayer);
                    $StatshittingArraySum = Statshitting::model()->findAll($criteriaT);
                    
                    echo "<td>".$StatshittingArraySum[0]->g_total." </td>";
                    echo "<td> ".$Statsfielding->GS." </td>";
                    echo "<td> ".$Statsfielding->INN." </td>";
                    echo "<td> ".$Statsfielding->TC." </td>";
                    echo "<td> ".$Statsfielding->PO." </td>";
                    echo "<td> ".$Statsfielding->A." </td>";
                    echo "<td> ".$Statsfielding->E." </td>";
                    echo "<td> ".$Statsfielding->DP." </td>";
                    echo "<td> ".$Statsfielding->SB." </td>";
                    echo "<td> ".$Statsfielding->CS." </td>";
                    echo "<td> ".$Statsfielding->SBPCT." </td>";
                    echo "<td> ".$Statsfielding->PB." </td>";
                    echo "<td> ".$Statsfielding->C_WP." </td>";
                    echo "<td> ".$Statsfielding->FPCT." </td>";
                    echo "<td> ".$Statsfielding->RF." </td>";
                    
                    $G += $StatshittingArraySum[0]->g_total;
                    $GS += $Statsfielding->GS;
                    $INN += $Statsfielding->INN;
                    $TC += $Statsfielding->TC;
                    $PO += $Statsfielding->PO;
                    $A += $Statsfielding->A;
                    $E += $Statsfielding->E;
                    $DP += $Statsfielding->DP;
                    $SB += $Statsfielding->SB;
                    $CS += $Statsfielding->CS;
                    $SBPCT += $Statsfielding->SBPCT;
                    $PB += $Statsfielding->PB;
                    $C_WP += $Statsfielding->C_WP;
                    $FPCT += $Statsfielding->FPCT;
                    $RF += $Statsfielding->RF;
                
            }
                echo "</tr>";
                echo "<tr class='scorewhite'> <td colspan=2 class='scoregreentr'> TOTAL </td>";
                echo "<td >$G</td>";
                echo "<td >$GS</td>";
                echo "<td >$INN</td>";
                echo "<td >$TC</td>";
                echo "<td >$PO</td>";
                echo "<td >$A</td>";
                echo "<td >$E</td>";
                echo "<td >$DP</td>";
                echo "<td >$SB</td>";
                echo "<td >$CS</td>";
                echo "<td >$SBPCT</td>";
                echo "<td >$PB</td>";
                echo "<td >$C_WP</td>";
                echo "<td >$FPCT</td>";
                echo "<td >$RF</td>";
                echo  "</tr>";
        break;
            
        case 'pitching':
            //$criteria = new CDbCriteria();
            //$criteria->addcondition("Games_idgame=$idgame");
            echo "<th class='score_green'>#</th><th class='score_green' style='width: 120px'>PLAYER</th><th class='score_green'>W</th><th class='score_green'>L</th><th class='score_green'>ERA</th><th class='score_green'>G</th><th class='score_green'>GS</th><th class='score_green'>SV</th><th class='score_green'>SVO</th><th class='score_green'>IP</th><th class='score_green'>H</th><th class='score_green'>R</th><th class='score_green'>ER</th><th class='score_green'>HR</th><th class='score_green'>BB</th><th class='score_green'>SO</th>
            <th class='score_green'>HB</th><th class='score_green'>CS</th><th class='score_green'>TBF</th><th class='score_green'>SB</th><th class='score_green'>NP</th>
            <th class='score_green'>WPCT</th><th class='score_green'>OBP</th><th class='score_green'>SLG</th><th class='score_green'>GO_AO</th>
            <th class='score_green'>OPS</th><th class='score_green'>BB_9</th><th class='score_green'>H_9</th><th class='score_green'>K_9</th>
            <th class='score_green'>k_BB</th><th class='score_green'>P_IP</th>
            <th class='score_green'>AVG</th><th class='score_green'>WHIP</th>";
            $criteriaB = new CDbCriteria();
            $criteriaB->addcondition("Lineup_idlineup=$idLineup and DefensePosition=1");
            $Batters = Batters::model()->findAll($criteriaB);
            $count = sizeof($Batters);
            
            //Load stats of players
            $Statspitching = new Statspitching;
            $StatspitchingArray = Statspitching::model()->findAll($criteria);
            
            $count_stats_pit = count ($StatspitchingArray);
        
            for ($i=0;$i < $count; $i++){
                $player = Players::model()->findByPK($Batters[$i]->Players_idplayer);
                
                $class=( $i  %  2 == 0 ) ?  'grayatbat':'black';
                echo "<tr class='$class'>";
                    
                    echo "<td> ".$Batters[$i]->Number." </td>";
                    echo "<td> ".$player->Firstname ." ".$player->Lastname." </td>";
                    
                    //Search the player stats
                    $e=0;
                    if ($count_stats_pit){
                        for ($e;$e < $count_stats_pit; $e++){
                            if ($StatspitchingArray[$e]->Players_idplayer == $Batters[$i]->Players_idplayer){
                                $Statspitching =  $StatspitchingArray[$e];
                                $e = $count_stats_pit;
                            } 
                        }
                    }
                    
                    $criteriaT = new CDbCriteria();
                    $criteriaT->select ="sum(G) as g_total";
                    $criteriaT->addcondition("Players_idplayer=".$Batters[$i]->Players_idplayer);
                    $StatshittingArraySum = Statshitting::model()->findAll($criteriaT);
                    
                    
                    echo "<td> ".$Statspitching->W." </td>";
                    echo "<td> ".$Statspitching->L." </td>";
                    echo "<td> ".$Statspitching->ERA." </td>";
                    echo "<td> ".$StatshittingArraySum[0]->g_total." </td>";
                    echo "<td> ".$Statspitching->GS." </td>";
                    echo "<td> ".$Statspitching->SV." </td>";
                    echo "<td> ".$Statspitching->SVO." </td>";
                    echo "<td> ".$Statspitching->IP." </td>";
                    echo "<td> ".$Statspitching->H." </td>";
                    echo "<td> ".$Statspitching->R." </td>";
                    echo "<td> ".$Statspitching->ER." </td>";
                    echo "<td> ".$Statspitching->HR." </td>";
                    echo "<td> ".$Statspitching->BB." </td>";
                    echo "<td> ".$Statspitching->SO." </td>";
                    echo "<td> ".$Statspitching->HB." </td>";
                    echo "<td> ".$Statspitching->CS." </td>";
                    echo "<td> ".$Statspitching->BF." </td>";
                    echo "<td> ".$Statspitching->SB." </td>";
                    echo "<td> ".$Statspitching->NP." </td>";
                    echo "<td> ".$Statspitching->WPCT." </td>";
                    echo "<td> ".$Statspitching->OBP." </td>";
                    echo "<td> ".$Statspitching->SLG." </td>";
                    echo "<td> ".$Statspitching->GO_AO." </td>";
                    echo "<td> ".$Statspitching->OPS." </td>";
                    echo "<td> ".$Statspitching->BB_9." </td>";
                    echo "<td> ".$Statspitching->H_9." </td>";
                    echo "<td> ".$Statspitching->K_9." </td>";
                    echo "<td> ".$Statspitching->K_BB." </td>";
                    echo "<td> ".$Statspitching->P_IP." </td>";
                    echo "<td> ".$Statspitching->AVG." </td>";
                    echo "<td> ".$Statspitching->WHIP." </td>";
                echo "</tr>";
                
                    $W += $Statspitching->W;
                    $L += $Statspitching->L;
                    $ERA += $Statspitching->ERA;
                    $G += $StatshittingArraySum[0]->g_total;
                    $GS += $Statspitching->GS;
                    $SV += $Statspitching->SV;
                    $SVO += $Statspitching->SVO;
                    $IP += $Statspitching->IP;
                    $H += $Statspitching->H;
                    $R += $Statspitching->R;
                    $ER += $Statspitching->ER;
                    $HR += $Statspitching->HR;
                    $BB += $Statspitching->BB;
                    $SO += $Statspitching->SO;
                    $HB += $Statspitching->HB;
                    $CS += $Statspitching->CS;
                    $BF += $Statspitching->BF;
                    $SB += $Statspitching->SB;
                    $NP += $Statspitching->NP;
                    
                    $WPCT += $Statspitching->WPCT;
                    $OBP += $Statspitching->OBP;
                    $SLG += $Statspitching->SLG;
                    $GO_AO += $Statspitching->GO_AO;
                    $OPS += $Statspitching->OPS;
                    $BB_9 += $Statspitching->BB_9;
                    $H_9 += $Statspitching->H_9;
                    $K_9 += $Statspitching->K_9;
                    $K_BB += $Statspitching->K_BB;
                    $P_IP += $Statspitching->P_IP;
                    
                    $AVG += $Statspitching->AVG;
                    $WHIP += $Statspitching->WHIP;
                    
                
            }
            echo "<tr class='scorewhite'> <td colspan=2 class='scoregreentr'> TOTAL </td>";
            echo "<td >$W</td>";
            echo "<td >$L</td>";
            echo "<td >$ERA</td>";
            echo "<td >$G</td>";
            echo "<td >$GS</td>";
            echo "<td >$SV</td>";
            echo "<td >$SVO</td>";
            echo "<td >$IP</td>";
            echo "<td >$H</td>";
            echo "<td >$R</td>";
            echo "<td >$ER</td>";
            echo "<td >$HR</td>";
            echo "<td >$BB</td>";
            echo "<td >$SO</td>";
            echo "<td >$HB</td>";
            echo "<td >$CS</td>";
            echo "<td >$BF</td>";
            echo "<td >$SB</td>";
            echo "<td >$NP</td>";
            echo "<td >$WPCT</td>";
            echo "<td >$OBP</td>";
            echo "<td >$SLG</td>";
            echo "<td >$GO_AO</td>";
            echo "<td >$OPS</td>";
            echo "<td >$BB_9</td>";
            echo "<td >$H_9</td>";
            echo "<td >$K_9</td>";
            echo "<td >$K_BB</td>";
            echo "<td >$P_IP</td>";
            echo "<td >$AVG</td>";
            echo "<td >$WHIP</td>";
            echo  "</tr>";
            
        break;   
    }

    
    
    
    
    
    //Load stats of players Hitting
    //$criteria = new CDbCriteria();
    //$idgame = Yii::app()->user->getState('idgame');
    //$criteria->addcondition("Games_idgame=$idgame");
    
    
    
    
    
    
    
    
    
    echo "</tr>";
    echo "</table>";

    //En esta seccion se va a crear el link para poder actualizar los stats

    //echo '<a href="'.$idgame.'">juego: '.$idgame.' - equipo actual: '.$teamid.'- tipo: '.Yii::app()->user->getState('scoretype').'</a>';
        
}


$gameid = Yii::app()->user->getState('idgame');

switch (Yii::app()->user->getState('scoreteam')){
        case 'home':
            if (! Yii::app()->user->getState('idlineuphome')){
                $criteria = new CDbCriteria();
                $idteam =  Yii::app()->user->getState('idteamhome');
                $criteria->addcondition("Games_idgame=$gameid AND Teams_idteam=$idteam");
                
                $lineup = new Lineup;
                $lineup = Lineup::model()->findAll($criteria);
                Yii::app()->user->setState('idlineuphome', $lineup[0]['idlineup']);
            }else $lineup = Yii::app()->user->getState('idlineuphome');
        break;
            
        case 'visiting':
            //if (! Yii::app()->user->getState('idlineupvisiting')){
                $criteria = new CDbCriteria();
                $idteam =  Yii::app()->user->getState('idteamvisiting');
                $criteria->addcondition("Games_idgame=$gameid AND Teams_idteam=$idteam");
                
                $lineup = new Lineup;
                $lineup = Lineup::model()->findAll($criteria);
                Yii::app()->user->setState('idlineupvisiting', $lineup[0]['idlineup']);
                $lineup = Yii::app()->user->getState('idlineupvisiting');
            //}else $lineup = Yii::app()->user->getState('idlineupvisiting');
        break;
        
        
}

//echo Yii::app()->user->getState('idteamvisiting')."LINEUP $idteam -Game $gameid---idlineupVisiting".Yii::app()->user->getState('idlineupvisiting');   

$form = null; $idteam = null;
loadTableTeam($lineup,$form,$model,$idteam,$idgame );
                
                
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'events-form',
    'enableAjaxValidation'=>false,
)); ?>
    
    <?php echo CHtml::hiddenfield('link',' ',array('id' => "link","class"=>'score_button')); ?>
    
<?php $this->endWidget(); ?>
