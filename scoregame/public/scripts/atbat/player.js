function PlayerController() {
    var self = this;

    var runners;

    resetGlobals();

    function resetGlobals() {
        runners = {};
    }


    self.storage = null;


    self.getInningPlayers = function (team, type, inning) {
        if (!G.lineups[team] || !G.lineups[team][type] || inning < 0) {
            return null;
        }

        // state can have undefined params!!
        var state = self.storage.getState();
        // get params with defaults
        var bases = (self.storage.getBaseState() || {}).bases || [];
        var outs = state.outs || 0;
        var defence = state.defence || "home";

        var isDefense = defence == team;
        var isOffence = !isDefense;

        var res = [];
        var k = 0;
        for (k in G.lineups[team][type]) {
            if (G.lineups[team][type][k].subOrder == 0)
                res.push(G.lineups[team][type][k]);
        }

        for (k in res) {
            var player = res[k];
            var substitutions = [];

            // TODO: Rewrite substitutions
            if (type == 'batters') {
                if (isOffence) {
                    substitutions = _.filter(G.lineups[team][type], function (b) {
                        return b.subOrder > 0 &&
                            b.inning <= inning &&
                            b.batter == player.batter &&
                            (   b.position == 'PH' ||
                                bases.indexOf(b.batter) != -1 && b.position == 'PR' ||
                                b.position != 'PH' && b.position != 'PR') &&
                            (   b.position == 'P' && (
                            b.inningOuts > 0 && team == 'home' ||
                            b.inning < inning) ||
                            b.position != 'P');
                    });
                }
                if (isDefense) {
                    substitutions = _.filter(G.lineups[team][type], function (b) {
                        return b.subOrder > 0 &&
                            b.inning <= inning &&
                            b.batter == player.batter &&
                            b.position != 'PH' && b.position != 'PR'
                    });
                }
            } else {

                if (isOffence) {
                    substitutions = _.filter(G.lineups[team][type], function (b) {
                        return b.subOrder > 0 && b.inning <= inning && b.position == player.position
                    });
                }

                if (isDefense) {
                    substitutions = _.filter(G.lineups[team][type], function (b) {
                        return b.subOrder > 0 &&
                            b.inning <= inning && b.position == player.position &&
                            (   b.position == 'P' && (
                            b.inningOuts <= outs ||
                            b.inning < inning) ||
                            b.position != 'P')
                    });
                }
            }

            res[k] = _.last(substitutions) || res[k];
        }

        return res;
    };

    self.getPlayers = function (team, type) {
        if (!G.lineups[team] || !G.lineups[team][type]) {
            return null;
        }

        var res = [];
        var k = 0;
        for (k in G.lineups[team][type]) {
            res.push(G.lineups[team][type][k]);
        }

        return res;
    };

    self.getInningLineup = function (team, inning) {
        return {
            type: G.lineups[team].type,
            name: G.lineups[team].name,
            batters: self.getInningPlayers(team, 'batters', inning),
            fielders: self.getInningPlayers(team, 'fielders', inning),
            pitchers: self.getInningPlayers(team, 'pitchers', inning),
            getPlayer: function (id, type) {
                return self.getPlayer(id, type);
            }
        };
    };

    self.getPlayer = function (id, type) {
        return _.find(G.lineups['visitor'][type], function (b) {
                return b.id == id
            }) ||
            _.find(G.lineups['home'][type], function (b) {
                return b.id == id
            });
    };


    self.register = function (controller) {
        controller.players = self;
    }
}