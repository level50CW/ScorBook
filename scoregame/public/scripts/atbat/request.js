function RequestController(){
    var self = this;

    function post(method, data, callback){
        callback = callback || function(){};
        $.ajax({
            type: "POST",
            url : G.baseUrl+"/ajax/atbat/"+method,
            data : {
                _token: G.token,
                _id: G.gameId,
                data: data
            },
            dataType: 'json',
            success : callback,
            error: function(xhr,status, message){
                console.error(status, message);
            }
        });
    }

    function get(method, callback){
        callback = callback || function(){};
        $.ajax({
            type: "GET",
            url : G.baseUrl+"/ajax/atbat/"+method,
            data : {
                _token: G.token,
                _id: G.gameId
            },
            dataType: 'json',
            success : callback,
            error: function(xhr,status, message){
                console.error(status, message);
            }
        });
    }

    self.register = function(controller){
        controller.request = self;
    };

    self.setGameStatus = function(status, callback){
        post('gamestatus', {status:status},callback);
    };

    self.getGameStatus = function(callback){
        get('gamestatus', callback);
    };


    self.setGameInning = function(inning, callback){
        post('lastinning', {inning:inning},callback);
    };


    self.setStorage = function(data,callback){
        post('storage', {
            storage: JSON.stringify(data)
        },callback);
    };

    self.getStorage = function(callback){
        get('storage',function(obj){
            obj = JSON.parse(obj.storage);
            callback(obj);
        });
    };
}