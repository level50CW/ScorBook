    
 <?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#Misc',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
				
            
        }', 
			        
           'items' => array(
                        'F0' => array('name' => 'E0: Dropped foul by EF','callback' => 'js:function(){ fillE0foulby("EF",1); }'),
                        'F1' => array('name' => 'E1: Dropped foul by RF','callback' => 'js:function(){ fillE0foulby("RF",1); }'),
                        'F2' => array('name' => 'E2: Dropped foul by CF','callback' => 'js:function(){ fillE0foulby("CF",1); }'),
                        'F3' => array('name' => 'E0: Dropped foul by LF','callback' => 'js:function(){ fillE0foulby("lF",1); }'),
                        'F4' => array('name' => 'E1: Dropped foul by SS','callback' => 'js:function(){ fillE0foulby("SS",1); }'),
                        'F5' => array('name' => 'E2: Dropped foul by 3B','callback' => 'js:function(){ fillE0foulby("3B",1); }'),
                        'F6' => array('name' => 'E0: Dropped foul by 2B','callback' => 'js:function(){ fillE0foulby("2B",1); }'),
                        'F7' => array('name' => 'E1: Dropped foul by 1B','callback' => 'js:function(){ fillE0foulby("1B",1); }'),
                        'F8' => array('name' => 'E2: Dropped foul by Catcher','callback' => 'js:function(){ fillE0foulby("C",1); }'),
                        'F9' => array('name' => 'E0: Dropped foul by Pitcher','callback' => 'js:function(){ fillE0foulby("P",1); }'),
                        
                        'LB' => array('name' => 'Last Batter','callback' => 'js:function(){ LastBatter(); }'),
                        'SB' => array('name' => 'Skip Batter','callback' => 'js:function(){ SkipBatter(); }'),
                        'RRP' => array('name' => 'Reassign Responsible Pitcher','callback' => 'js:function(){ FOut53(); }'),
                        //'SBS' => array('name' => 'Switch Batter Side','callback' => 'js:function(){ FOut63(); }'),
                        
                        'OBR' => array('name' => 'OBR: On By Rule (tie break)','callback' => 'js:function(){ FOutOP(); }'),
                        'ITB' => array('name' => 'ITB: International Tie Breaker','callback' => 'js:function(){ FOutFO(); }'),
                        'TP' => array('name' => 'TP: Triple Play Wizard','callback' => 'js:function(){ WizardLineuptp(); }'),
                        'CO' => array('name' => 'CO: Catcher\'s Obstruction','callback' => 'js:function(){ FOutFO(); }'),
                        'E' => array('name' => 'E: Reach Base On Error','callback' => 'js:function(){ FOutFO(); }'),
                        
                        'Undo' => array('name' => 'Undo','callback' => 'js:function(){ undo(); }'),
                        'quit' => array('name' => 'Cancel','icon'=>'quit'),
                    ),
                )
       
  	 );
    ?>
    
 
  <?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#OutNumber',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
				
            
        }', 
			        
           'items' => array(
                        'F0' => array('name' => 'F0','callback' => 'js:function(){ FOut(0); }'),
                        'F1' => array('name' => 'F1','callback' => 'js:function(){ FOut(1); }'),
                        'F2' => array('name' => 'F2','callback' => 'js:function(){ FOut(2); }'),
                        'F3' => array('name' => 'F3','callback' => 'js:function(){ FOut(3); }'),
                        'F4' => array('name' => 'F4','callback' => 'js:function(){ FOut(4); }'),
                        'F5' => array('name' => 'F5','callback' => 'js:function(){ FOut(5); }'),
                        'F6' => array('name' => 'F6','callback' => 'js:function(){ FOut(6); }'),
                        'F7' => array('name' => 'F7','callback' => 'js:function(){ FOut(7); }'),
                        'F8' => array('name' => 'F8','callback' => 'js:function(){ FOut(8); }'),
                        'F9' => array('name' => 'F9 Fly Out','callback' => 'js:function(){ FOut(9); }'),
                        
                        '3U' => array('name' => '3 unassisted','callback' => 'js:function(){ FOut3(1); }'),
                        '43GO' => array('name' => '4-3 Ground Out','callback' => 'js:function(){ FOut43(1); }'),
                        '53' => array('name' => '5-3','callback' => 'js:function(){ FOut53(1); }'),
                        '63' => array('name' => '6-3','callback' => 'js:function(){ FOut63(1); }'),
                        
                        'OP' => array('name' => 'Other Putout','callback' => 'js:function(){ FOutOP(); }'),
                        'FO' => array('name' => 'Fly Out','callback' => 'js:function(){ FOutFO(); }'),
                        'GO' => array('name' => 'Ground Out','callback' => 'js:function(){ FOutGO(); }'),
                        'quit' => array('name' => 'Cancel','icon'=>'quit'),
                    ),
                )
       
  	 );
    ?>
    
 
  <?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#baseFunctionb4',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
				
            
        }', 
			        
           'items' => array(
                        'E0' => array('name' => 'E0: Advance on error by EF','callback' => 'js:function(){ fillError("4b","EF"); }'),
                        'E9' => array('name' => 'E9: Advance on error by RF','callback' => 'js:function(){ fillError("4b","RF"); }'),
                        'E8' => array('name' => 'E8: Advance on error by CF','callback' => 'js:function(){ fillError("4b","CF"); }'),
                        'E7' => array('name' => 'E7: Advance on error by LF','callback' => 'js:function(){ fillError("4b","LF"); }'),
                        'E6' => array('name' => 'E6: Advance on error by SS','callback' => 'js:function(){ fillError("4b","SS"); }'),
                        'E5' => array('name' => 'E5: Advance on error by 3B','callback' => 'js:function(){ fillError("4b","3B"); }'),
                        'E4' => array('name' => 'E4: Advance on error by 2B','callback' => 'js:function(){ fillError("4b","2B"); }'),
                        'E3' => array('name' => 'E3: Advance on error by 1B','callback' => 'js:function(){ fillError("4b","1B"); }'),
                        'E2' => array('name' => 'E2: Advance on error by Catcher','callback' => 'js:function(){ fillError("4b","C"); }'),
                        'E1' => array('name' => 'E1: Advance on error by Pitcher','callback' => 'js:function(){ fillError("4b","P"); }'),
                        
                        'FC' => array('name' => 'FC: Fielders Choice','callback' => 'js:function(){ fillFC("4b"); }'),
                        'DI' => array('name' => 'DI: Defensive Indifference','callback' => 'js:function(){ fillDI("4b"); }'),
                        'O' => array('name' => 'Other / Batted Forward','callback' => 'js:function(){ fillO("4b"); }'),
                        
                        'bk' => array('name' => 'BK: Balk (no stat)','callback' => 'js:function(){ fillBKNStat("4b"); }'),
                        'wp' => array('name' => 'WP: Wild Pitch (no stat)','callback' => 'js:function(){ fillWPNStat("4b"); }'),
                        'pb' => array('name' => 'PB: Pass Ball (no stat)','callback' => 'js:function(){ fillPBNStat("4b"); }'),
                        'sb' => array('name' => 'SB: from pickoff attempt','callback' => 'js:function(){ fillSBNStat("4b",1); }'),
                        
                        'BK' => array('name' => 'BK: Balk','callback' => 'js:function(){ fillBK("4b",1); }'),
                        'WP' => array('name' => 'WP: Wild Pitch','callback' => 'js:function(){ fillWP("4b",1); }'),
                        'PB' => array('name' => 'PB: Pass Ball','callback' => 'js:function(){ fillPB("4b",1); }'),
                        'SB' => array('name' => 'SB: Stolen Base','callback' => 'js:function(){ fillSB("4b",1); }'),
						
                        'CSE6' => array('name' => 'CS E6: Advance on error, charge CS','callback' => 'js:function(){ fillError("4b","P"); }'),
                        'CS' => array('name' => 'Caught Stealing','callback' => 'js:function(){ fillCS("4b",1); }'),
                        'CS26' => array('name' => 'Caught Stealing 2-5','callback' => 'js:function(){ fillCS25("4b",1); }'),
                      	'quit' => array('name' => 'Cancel','icon'=>'quit'),
                    ),
                )
       
  	 );
    ?>
    
  <?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#baseFunctionb3',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
				
            
        }', 
			        
           'items' => array(
                        'E0' => array('name' => 'E0: Advance on error by EF','callback' => 'js:function(){ fillError("3b","EF"); }'),
                        'E9' => array('name' => 'E9: Advance on error by RF','callback' => 'js:function(){ fillError("3b","RF"); }'),
                        'E8' => array('name' => 'E8: Advance on error by CF','callback' => 'js:function(){ fillError("3b","CF"); }'),
                        'E7' => array('name' => 'E7: Advance on error by LF','callback' => 'js:function(){ fillError("3b","LF"); }'),
                        'E6' => array('name' => 'E6: Advance on error by SS','callback' => 'js:function(){ fillError("3b","SS"); }'),
                        'E5' => array('name' => 'E5: Advance on error by 3B','callback' => 'js:function(){ fillError("3b","3B"); }'),
                        'E4' => array('name' => 'E4: Advance on error by 2B','callback' => 'js:function(){ fillError("3b","2B"); }'),
                        'E3' => array('name' => 'E3: Advance on error by 1B','callback' => 'js:function(){ fillError("3b","1B"); }'),
                        'E2' => array('name' => 'E2: Advance on error by Catcher','callback' => 'js:function(){ fillError("3b","C"); }'),
                        'E1' => array('name' => 'E1: Advance on error by Pitcher','callback' => 'js:function(){ fillError("3b","P"); }'),
                        
                        'FC' => array('name' => 'FC: Fielders Choice','callback' => 'js:function(){ fillFC("3b"); }'),
                        'DI' => array('name' => 'DI: Defensive Indifference','callback' => 'js:function(){ fillDI("3b"); }'),
                        'O' => array('name' => 'Other / Batted Forward','callback' => 'js:function(){ fillO("3b"); }'),
                        
                        'bk' => array('name' => 'BK: Balk (no stat)','callback' => 'js:function(){ fillBKNStat("3b"); }'),
                        'wp' => array('name' => 'WP: Wild Pitch (no stat)','callback' => 'js:function(){ fillWPNStat("3b"); }'),
                        'pb' => array('name' => 'PB: Pass Ball (no stat)','callback' => 'js:function(){ fillPBNStat("3b"); }'),
                        'sb' => array('name' => 'SB: from pickoff attempt','callback' => 'js:function(){ fillSBNStat("3b",1); }'),
                        
						
                        'BK' => array('name' => 'BK: Balk','callback' => 'js:function(){ fillBK("3b",1); }'),
                        'WP' => array('name' => 'WP: Wild Pitch','callback' => 'js:function(){ fillWP("3b",1); }'),
                        'PB' => array('name' => 'PB: Pass Ball','callback' => 'js:function(){ fillPB("3b",1); }'),
                        'SB' => array('name' => 'SB: Stolen Base','callback' => 'js:function(){ fillSB("3b",1); }'),
						
						
                        'CSE6' => array('name' => 'CS E6: Advance on error, charge CS','callback' => 'js:function(){fillError("3b","3B"); }'),
                        'CS' => array('name' => 'Caught Stealing','callback' => 'js:function(){ fillCS("3b"); }'),
                         'CS26' => array('name' => 'Caught Stealing 2-6','callback' => 'js:function(){ fillCS25("3b"); }'),
                      	'quit' => array('name' => 'Cancel','icon'=>'quit'),
                    ),
                )
       
  	 );
    ?>
    
 <?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#baseFunctionb2',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
				
            
        }', 
			        
           'items' => array(
                        'E0' => array('name' => 'E0: Advance on error by EF','callback' => 'js:function(){ fillError("2b","EF"); }'),
                        'E9' => array('name' => 'E9: Advance on error by RF','callback' => 'js:function(){ fillError("2b","RF"); }'),
                        'E8' => array('name' => 'E8: Advance on error by CF','callback' => 'js:function(){ fillError("2b","CF"); }'),
                        'E7' => array('name' => 'E7: Advance on error by LF','callback' => 'js:function(){ fillError("2b","LF"); }'),
                        'E6' => array('name' => 'E6: Advance on error by SS','callback' => 'js:function(){ fillError("2b","SS"); }'),
                        'E5' => array('name' => 'E5: Advance on error by 3B','callback' => 'js:function(){ fillError("2b","3B"); }'),
                        'E4' => array('name' => 'E4: Advance on error by 2B','callback' => 'js:function(){ fillError("2b","2B"); }'),
                        'E3' => array('name' => 'E3: Advance on error by 1B','callback' => 'js:function(){ fillError("2b","1B"); }'),
                        'E2' => array('name' => 'E2: Advance on error by Catcher','callback' => 'js:function(){ fillError("2b","C"); }'),
                        'E1' => array('name' => 'E1: Advance on error by Pitcher','callback' => 'js:function(){ fillError("2b","P"); }'),
                        
                        'FC' => array('name' => 'FC: Fielders Choice','callback' => 'js:function(){ fillFC("2b"); }'),
                        'DI' => array('name' => 'DI: Defensive Indifference','callback' => 'js:function(){ fillDI("2b"); }'),
                        'O' => array('name' => 'Other / Batted Forward','callback' => 'js:function(){ fillO("2b"); }'),
                   
						
						'bk' => array('name' => 'BK: Balk (no stat)','callback' => 'js:function(){ fillBKNStat("2b"); }'),
                        'wp' => array('name' => 'WP: Wild Pitch (no stat)','callback' => 'js:function(){ fillWPNStat("2b"); }'),
                        'pb' => array('name' => 'PB: Pass Ball (no stat)','callback' => 'js:function(){ fillPBNStat("2b"); }'),
                        'sb' => array('name' => 'SB: from pickoff attempt','callback' => 'js:function(){ fillSBNStat("2b",1); }'),
                        
                        'BK' => array('name' => 'BK: Balk','callback' => 'js:function(){ fillBK("2b",1); }'),
                        'WP' => array('name' => 'WP: Wild Pitch','callback' => 'js:function(){ fillWP("2b",1); }'),
                        'PB' => array('name' => 'PB: Pass Ball','callback' => 'js:function(){ fillPB("2b",1); }'),
                        'SB' => array('name' => 'SB: Stolen Base','callback' => 'js:function(){ fillSB("2b",1); }'),
						
                        'CSE6' => array('name' => 'CS: Advance on error, charge CS','callback' => 'js:function(){ fillError("2b","SS"); }'),
                        'CS' => array('name' => 'Caught Stealing','callback' => 'js:function(){ fillCS("2b"); }'),
                         'CS26' => array('name' => 'Caught Stealing 2-6','callback' => 'js:function(){ fillCS26(1); }'),
                      	'quit' => array('name' => 'Cancel','icon'=>'quit'),
                    ),
                )
       
  	 );
    ?>


 <?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#OUT',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
            
        }',
            'build' => 'js: function($trigger) {
            return {
                callback: function(key, options) {
                   switch(key)
				   {
				   	case "Undo":
                    undo();
					break;
					case "HR":
					fillhr();
					break;
				   }
                },
                items: {
                    "F0": {name: "F0"},
                    "F1": {name: "F1", icon: ""},
                    "F2": {name: "F2", icon: " "},
                    "F3": {name: "F3", icon: " "},
                    "F4": {name: "F4", icon: " "},
                    "F5": {name: "F5",icon: " "},
                    "F6": {name: "F6", icon: ""},
                    "F7": {name: "F7", icon: " "},
                    "F8": {name: "F8", icon: " "},
                    "F9": {name: "F9 Fly Out", icon: " "},
                    "3U": {name: "3 unassisted"},
                    "4-3": {name: "4-3 Ground Out", icon: ""},
                    "5-3": {name: "5-3", icon: " "},
                    "6-3": {name: "6-5", icon: " "},
                    "OP": {name: "Other Putout", icon: " "},
                    "FO": {name: "Fly Out"},
                    "GO": {name: "Grund Out", icon: ""},
                    "cancel": {name: "Cancel", icon: "quit"}
                }
            }
           }',
        )
    );
    ?>

 <?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#K',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
				
            
        }', 
			        
           'items' => array(
                        'KWP' => array('name' => 'KWP','callback' => 'js:function(){ fillKWP(1); }'),
                        'KPB' => array('name' => 'KPB','callback' => 'js:function(){ fillKPB(1); }'),
                        'KFC' => array('name' => 'KS FC',
	                            'items' => array(
	                                'FCAR' =>  array('name' => 'FC: Advance all runners safely','callback' => 'js:function(){ fillKFCAR(1); }'),
	                                'FCNB' =>  array('name' => 'FC: Advance no base runners','callback' => 'js:function(){ fillKFCNB(1); }'),
	                                'R1po' =>  array('name' => 'Runner at 1st base putout','callback' => 'js:function(){ fillKR1po(1); }'),
	                           	 	'R2po' =>  array('name' => 'Runner at 2st base putout','callback' => 'js:function(){ fillKR2po(1); }'),
	                           	 	'R3po' =>  array('name' => 'Runner at 3st base putout','callback' => 'js:function(){ fillKR3po(1); }'),
	                           	 	),
                        		),
                        
                        'KSE' => array('name' => 'KSE','callback' => 'js:function(){ fillKSE(1); }'),
                        'K2' => array('name' => 'K2','callback' => 'js:function(){ fillK2(1); }'),
                        'K23' => array('name' => 'K23','callback' => 'js:function(){ fillK23(1); }'),
                        'KS' => array('name' => 'KS','callback' => 'js:function(){ fillKS(2,21); }'),
                        'KSO' => array('name' => 'KSO','callback' => 'js:function(){ fillKSO(1,1); }'),
                    ),
                )
       
  	 );
    ?>
    
<?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#FC',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
            
        }',
            'items' => array(
                            'FCAR' =>  array('name' => 'FC: Advance all runners safely','callback' => 'js:function(){ fillFCAR(1); }'),
                            'FCNB' =>  array('name' => 'FC: Advance no base runners','callback' => 'js:function(){ fillFCNB(1); }'),
                            'R1po' =>  array('name' => 'Runner at 1st base putout','callback' => 'js:function(){ fillR1po(1); }'),
                       	 	'R2po' =>  array('name' => 'Runner at 2st base putout','callback' => 'js:function(){ fillR2po(1); }'),
                       	 	'R3po' =>  array('name' => 'Runner at 3st base putout','callback' => 'js:function(){ fillR3po(1); }'),
                       	 	),
            )
    );
    ?>

<?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#DP',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
            
        }',
        	   'items' => array(
                	'143' => array('name' => '1-4-3 DP','callback' => 'js:function(){ filldp143(1); }'),
                   	'163' => array('name' => '1-6-3 DP','callback' => 'js:function(){ filldp163(1); }'),
                    '361' => array('name' => '3-6-1 DP','callback' => 'js:function(){ filldp361(1); }'),
                    '363' => array('name' => '3-6-3 DP','callback' => 'js:function(){ filldp363(1); }'),
                    
					'463' => array('name' => '4-6-3 DP','callback' => 'js:function(){ filldp463(1); }'),
                   	'543' => array('name' => '5-4-3 DP','callback' => 'js:function(){ filldp543(1); }'),
                    '643' => array('name' => '6-4-3 DP','callback' => 'js:function(){ filldp643(1); }'),
                    '63' => array('name' => '6-3 DP','callback' => 'js:function(){ filldp63(1); }'),
                    
					'43' => array('name' => '4-3 DP Tag','callback' => 'js:function(){ filldp43(1); }'),
                   	'36' => array('name' => '3-6 DP Reverse Force','callback' => 'js:function(){ filldp36(1); }'),
                    'DPW' => array('name' => 'Double Play Wizard','callback' => 'js:function(){ filldpw(); }'),
                    'cancel' => array('name' => 'Cancel'),
                           
             ),
                )
				
   	);
    ?>
    
    <?php //MISC Functions
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#SAC',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
            
        }',
        	'items' => array(
                        '0SAC' => array('name' => 'SAC FC: Sac Hit, Fielder\'s Choice',
	                            'items' => array(
	                                'FCAR' =>  array('name' => 'FC: Advance all runners safely','callback' => 'js:function(){ fill0sacFCAR(1); }'),
	                                'FCNB' =>  array('name' => 'FC: Advance no base runners','callback' => 'js:function(){ fill0sacFCNB(1); }'),
	                                'R1po' =>  array('name' => 'Runner at 1st base putout','callback' => 'js:function(){ fillsacR1po(1); }'),
	                           	 	'R2po' =>  array('name' => 'Runner at 2st base putout','callback' => 'js:function(){ fillsacR2po(1); }'),
	                           	 	'R3po' =>  array('name' => 'Runner at 3st base putout','callback' => 'js:function(){ fillsacR3po(1); }'),
	                           	 	),
                        		),
                        
                        '1SAC' => array('name' => 'SAC E: Sac Hit, Reached on Error','callback' => 'js:function(){ fill1sac(1); }'),
                       	'2SAC' => array('name' => 'SFE: Sac Fly, Reached on Error','callback' => 'js:function(){ fill2sac(1); }'),
                        '3SAC' => array('name' => 'SH: Sacrifice Hit (Bunt)','callback' => 'js:function(){ fill3sac(1); }'),
                        '4SAC' => array('name' => 'SF: Sacrifice Fly','callback' => 'js:function(){ fill4sac(1); }'),
                        
                    ),
                )
				
   	);
    ?>

    <?php //MISC Functions
    /* $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#Misc',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            	var m = "clicked: " + key;
            
        }',
            'build' => 'js: function($trigger) {
            return {
                callback: function(key, options) {
                   switch(key)
				   {
				   	case "Undo":
                    undo();
					break;
					case "HR":
					fillhr();
					break;
				   }
                },
                items: {
                    "edit": {name: "Run"},
                    "cut": {name: " ", icon: ""},
                    "copy": {name: " ", icon: " "},
                    "HR": {name: "HR", icon: " "},
                    "Undo": {name: "Undo", icon: " "},
                    "sep1": "---------",
                    "quit": {name: "Cancel", icon: "quit"}
                }
            }
           }',
        )
    );*/
    ?>
    
<?php
    $this->widget('ext.jcontextmenu.JContextMenu', array(
            'selector' => '#batter',
             'trigger' => 'left',
            'ignoreRightClick' => true,
            'callback' => 'js:function(key, options) {
            var m = "you clicked: " + cancel;
            
        }',
            'build' => 'js: function($trigger) {
            return {
                callback: function(key, options) {
                    var m = "clicked: " + key;
                    fillhr();
                },
                items: {
                    "edit": {name: "Run"},
                    "cut": {name: " ", icon: ""},
                    "copy": {name: " ", icon: " "},
                    "paste": {name: " ", icon: " "},
                    "delete": {name: "", icon: " "},
                    "sep1": "---------",
                    "quit": {name: "Cancel", icon: "quit"}
                }
            }
           }',
        )
    );
   ?>
    