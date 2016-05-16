$(function(){
    var result = {};

    var requestController = new RequestController();
    var storageController = new StorageController();
    var scorePadController = new ScorePadController({columnCount: 9});

    requestController.register(storageController);
    storageController.register(scorePadController);

    storageController.restoreState(function(){
        scorePadController.restore();
    });
});
