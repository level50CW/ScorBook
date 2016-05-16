function ScorePadController(conf) {
    var self = this;

    conf = conf || {};

    var VIEW_COLUMN_COUNT = conf.columnCount || 5;

    var $scorePad = {
        visitor: $('.js-scorepad[team=visitor]'),
        home: $('.js-scorepad[team=home]')
    };

    var currentState,
        scorePadTable,
        currentViewColumn,
        currentBases,
        createNextCell,
        columnsCounter;

    resetGlobals();
    function resetGlobals() {
        currentState = {
            inning: -1,
            state: 0,
            pitch: 0
        };
        scorePadTable = {};
        currentViewColumn = 0;
        columnsCounter = {
            visitor:0,
            home:0
        };
        createNextCell = true;
    }

    function getCell(team, batter, inning) {
        var column, i;

        if (!scorePadTable[team])
            scorePadTable[team] = {};
        if (!scorePadTable[team][inning]) {
            scorePadTable[team][inning] = {};
            column = scorePadTable[team][inning].column = 0;
            for (i = 1; i <= 9; i++) {
                scorePadTable[team][inning][i] = [];
                scorePadTable[team][inning][i][column] = {};
            }
            columnsCounter[team]++;
        }

        var cells = scorePadTable[team][inning][batter];
        column = scorePadTable[team][inning].column;

        if (cells[column].inuse && createNextCell) {
            column = ++scorePadTable[team][inning].column;
            for (i = 1; i <= 9; i++) {
                scorePadTable[team][inning][i][column] = {};
            }
            columnsCounter[team]++;
        }

        if (createNextCell){
            createNextCell = false;
            return cells[column];
        }

        var used = cells.filter(function(e){ return !!e.inuse;});
        return used.length==0 ? cells[column] : used[used.length-1];
    }

    function addCellPitch(cell, type, number) {
        if (!cell[type])
            cell[type] = [];

        cell[type].push(number);
    }

    function makeRuns(bases, runs, callback) {
        // Require valid order of runs
        for (var r in runs) {
            bases[runs[r] + 1] = bases[runs[r]];
            callback(bases[runs[r]], runs[r] + 1);
            bases[runs[r]] = null;
        }
    }

    function updateCells() {
        var lastState = {};

        self.storage.forEach(['inning', 'state', 'pitch'], {
            inning: function (o) {
                if (o.i <= currentState.inning)
                    return;

                currentBases = [null, null, null, null];
            },

            state: function (o) {
                if (o.i*1000+o.s <= currentState.inning*1000+currentState.state)
                    return;

                currentBases[0] = o.state.batter;
                createNextCell = true;
            },

            pitch: function (o) {
                var base = o.base;
                var pitch = o.pitch;
                var state = o.state;
                var inning = o.inning;

                if (!pitch)
                    return;

                if (o.i*1000000+o.s*1000+o.p <= currentState.inning*1000000+currentState.state*1000+currentState.pitch)
                    return;

                lastState.inning = o.i;
                lastState.state = o.s;
                lastState.pitch = o.p;

                // TODO: Fix this creator
                var cell = getCell(state.offence, state.batter, o.i);
                cell.inuse = true;
                createNextCell = false;


                var batterCell;

                if (pitch.type == 'ball' || pitch.type == 'strike' || pitch.type == 'foul') {
                    var type = pitch.type == 'foul'? 'strike' :  pitch.type;
                    addCellPitch(cell, type, pitch.counter.total);
                }

                if (pitch.type == 'out') {
                    cell.result = pitch.type2;
                    if (pitch.fielders)
                        cell.result += ' ' + pitch.fielders.join('-');

                    var batters = pitch.batters || [0];

                    for (var i in batters) {
                        batterCell = getCell(state.offence, currentBases[batters[i]], o.i);
                        batterCell.out = (state.outs || 0) + (+i) + 1;
                        currentBases[batters[i]] = null;
                    }

                    cell.coordinates = pitch.coordinatesHit;
                }

                if (pitch.type == 'hit') {
                    cell.result = pitch.type2;
                }

                if (pitch.type == 'ball' && pitch.counter.ball == 4) {
                    cell.result = 'BB';
                }

                if (pitch.coordinatesHit) {
                    cell.coordinates = {
                        x: pitch.coordinatesHit.x / 700,
                        y: pitch.coordinatesHit.y / 340
                    }
                }

                for (var b in base){
                    if (base[b].id == o.s*100+ o.p){
                        makeRuns(currentBases, base[b].runs, function (batter, b) {
                            batterCell = getCell(state.offence, batter, o.i);
                            batterCell.base = b;
                        });
                    }
                }
            }
        });

        $.extend(currentState, lastState);
    }

    function getNormalizedTable(team) {
        var normalized = {
            innings: [],
            cells: []
        };

        var c = 0;
        var lastInning = -1;
        for (var i = 0; i <= currentState.inning; i++) {
            var inning = {
                inning: i + 1,
                columns: 0,
                notadded: true
            };

            if (!scorePadTable[team])
                break;

            if (!scorePadTable[team][i])
                break;

            for (var b = 0; b < 9; b++) {
                normalized.cells[b] = normalized.cells[b] || [];

                for (var cell in scorePadTable[team][i][b+1]) {
                    if (+cell + c >= currentViewColumn && +cell + c < currentViewColumn + VIEW_COLUMN_COUNT) {
                        if (inning.notadded) {
                            normalized.innings.push(inning);
                            delete inning.notadded;
                        }

                        normalized.cells[b].push(scorePadTable[team][i][b+1][cell]);

                        lastInning = i;
                    }
                }
            }

            inning.columns = scorePadTable[team][i].column + 1;
            c += inning.columns;
        }

        for (; c < currentViewColumn + VIEW_COLUMN_COUNT; c++) {
            lastInning++;
            normalized.innings.push({
                inning: lastInning + 1,
                columns: 1
            });

            for (var b = 0; b < 9; b++) {
                normalized.cells[b] = normalized.cells[b] || [];
                normalized.cells[b].push({});
            }
        }

        return normalized;
    }

    function createCellUi(cell) {
        var $cell = $('<div class="ui-scorepad-cell" base="'+(cell.base || 0)+'">');
        $cell.append($('<div type="result">').text(cell.result || ''));
        if (cell.out && cell.out>0)
            $cell.append($('<div type="out">').text(cell.out));

        if (cell.strike){
            var $strike = $('<div type="strike">');
            for(var i in cell.strike.slice(0,2)){
                $strike.append($("<span>").text(cell.strike[i]));
            }
            $cell.append($strike);
        }

        if (cell.ball){
            var $ball = $('<div type="ball">');
            for(var i in cell.ball.slice(0,3)){
                $ball.append($("<span>").text(cell.ball[i]));
            }
            $cell.append($ball);
        }

        return $cell;
    }

    function updateUi(team) {
        var normalized = getNormalizedTable(team);
        var $currentScorePad = $scorePad[team];
        // .js-scorepad-innings
        // .js-scorepad-inning
        // .js-scorepad-cell
        // .js-scorepad-batter

        var $innings = $('.js-scorepad-innings', $currentScorePad);
        var $batters = $('.js-scorepad-batter', $currentScorePad);

        $innings.children('.js-scorepad-inning').remove();
        $batters.children('.js-scorepad-cell').remove();

        for (var i in normalized.innings) {
            var inning = normalized.innings[i];
            $innings.append($('<th class="js-scorepad-inning">')
                .attr('colspan', inning.columns)
                .text(inning.inning));
        }

        for (var b = 0; b < 9; b++) {
            var $batter = $('.js-scorepad-batter[batter="' + (b + 1) + '"]', $currentScorePad);
            var rowspan = $batter.length;
            $batter = $batter.eq(0);
            for (var c = 0; c < VIEW_COLUMN_COUNT; c++) {
                $batter.append($('<td class="js-scorepad-cell">')
                    .attr('rowspan', rowspan)
                    .append(createCellUi(normalized.cells[b][c])));
            }
        }
    }

    function updateNavigators(){
        $('.js-scorepad-button-next').hide();
        $('.js-scorepad-button-prev').hide();

        // columnsCounter.visitor becouse visitor starts in each inning
        if (currentViewColumn < columnsCounter.visitor - VIEW_COLUMN_COUNT)
            $('.js-scorepad-button-next').show();

        if (currentViewColumn > 0){
            $('.js-scorepad-button-prev').show();
        }
    }

    $('.js-scorepad-button-next').click(function () {
        if (currentViewColumn < columnsCounter.visitor - VIEW_COLUMN_COUNT) {
            currentViewColumn++;
            updateUi('visitor');
            updateUi('home');
            updateNavigators();
        }
    });

    $('.js-scorepad-button-prev').click(function () {
        if (currentViewColumn > 0) {
            currentViewColumn--;
            updateUi('visitor');
            updateUi('home');
            updateNavigators();
        }
    });

    /** @type StorageController */
    self.storage = null;


    self.update = function () {
        updateCells();
        updateUi('visitor');
        updateUi('home');
        updateNavigators();
    };

    self.restore = function () {
        resetGlobals();
        self.update();
    };
}