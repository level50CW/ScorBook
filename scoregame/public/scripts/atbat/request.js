function RequestController(){
    var self = this;

    function post(method, data, callback){
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


    self.setGameStatus = function(status, callback){
        post('gamestatus', {status:status},callback);
    };

    self.getGameStatus = function(callback){
        get('gamestatus', callback);
    };

    self.storeState = function(callback){
        post('storage', {
            storage: JSON.stringify(self.storage.getData())
        },callback);
    };

    self.restoreState = function(callback){
        get('storage',function(obj){
            obj = JSON.parse(obj.storage);
            self.storage.setData(obj);
            callback();
        });
    };
}