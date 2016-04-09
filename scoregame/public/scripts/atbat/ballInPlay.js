function BallInPlayController(){
    var self = this;

    var types = {
        'HBP': 'hit',
        '1B': 'hit',
        '2B': 'hit',
        '3B': 'hit',
        'HR': 'hit',

        'F': 'out',
        'GO': 'out',
        'SacF': 'out',
        'SacB': 'out',
        'FO': 'out',
        'TO': 'out',
        'DP': 'out',
        'TP': 'out',
        'PO': 'out',

        'KL': 'strike',
        'KSW': 'strike',

        'ERR': 'error',

        'SB': 'misc',
        'CS': 'misc',
        'WP': 'misc',

        'AR1': 'advance',
        'AR2': 'advance',
        'AR3': 'advance'
    };

    function initMenu(){
        $.contextMenu({
            selector: '.js-button-pitch-menu',
            trigger: 'left',
            items:{
                'HBP':{
                    name: 'HBP',
                    callback: menuHandle
                },
                '1B':{
                    name: '1B',
                    callback: menuHandle
                },
                '2B':{
                    name: '2B',
                    callback: menuHandle
                },
                '3B':{
                    name: '3B',
                    callback: menuHandle
                },
                'HR':{
                    name: 'HR',
                    callback: menuHandle
                },
                'F':{
                    name: 'Fly Out',
                    callback: menuHandle
                },
                'GO':{
                    name: 'Ground Out',
                    callback: menuHandle
                },
                'SacF':{
                    name: 'Sac Fly',
                    callback: menuHandle
                },
                'SacB':{
                    name: 'Sac Bunt',
                    callback: menuHandle
                },
                'FO':{
                    name: 'Force Out',
                    callback: menuHandle
                },
                'TO':{
                    name: 'Tag Out',
                    callback: menuHandle
                },
                'DP':{
                    name: 'Double Play',
                    callback: menuHandle
                },
                'TP':{
                    name: 'Triple Play',
                    callback: menuHandle
                },

                'PO':{
                    name: 'Picked Off Base',
                    disabled: true
                },

                'KL':{
                    name: 'Strikeout Looking',
                    callback: menuHandle
                },
                'KSW':{
                    name: 'Strikeout Swinging',
                    callback: menuHandle
                },

                'ERR':{
                    name: 'Error',
                    callback: menuHandle
                },

                'SB':{
                    name: 'Stolen Base',
                    callback: menuHandle
                },
                'CS':{
                    name: 'Caught Stealing',
                    callback: menuHandle
                },
                'WP':{
                    name: 'Wild Pitch',
                    disabled: true
                },

                'AR':{
                    name: 'Advanced Run',
                    items:{
                        'AR1':{
                            name: 'Advanced by 1 base',
                            callback: menuHandle
                        },
                        'AR2':{
                            name: 'Advanced by 2 bases',
                            callback: menuHandle
                        },
                        'AR3':{
                            name: 'Advanced by 3 bases',
                            callback: menuHandle
                        }
                    }
                }
            }
        });
    }

    function menuHandle(item){
        if (!self.onMenu(types[item], item))
            alert('This option is disabled');
    }

    self.onMenu = function(type, item){};

    initMenu();
}