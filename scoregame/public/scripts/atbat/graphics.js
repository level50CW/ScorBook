function GraphicsController(){
    var self = this;
    var field = $('.js-field-canvas')[0];
    var context = field.getContext('2d');

    var positions = {
        'H': {x:350, y:194},
        '1B': {x:505, y:127},
        '2B': {x:350, y:85},
        '3B': {x:195, y:127},
        label1B: {x:451, y:179},
        labelHBP: {x:451, y:179},
        labelBB: {x:451, y:179},
        labelBK: {x:451, y:179},
        labelWP: {x:451, y:179},
        labelPB: {x:451, y:179},
        labelCI: {x:451, y:179},
        label2B: {x:389, y:94},
        label3B: {x:280, y:94},
        labelHR: {x:224, y:182},
        labelState: {x:30, y:200}
    };

    var corner = {
        'H': {x:350, y:212},
        '1B': {x:451, y:169},
        '3B': {x:258, y:173}
    };

    var lines = {
        '0': ['H', '1B'],
        '1': ['1B', '2B'],
        '2': ['2B', '3B'],
        '3': ['3B', 'H']
    };

    function drawLine(point1, point2, width, color){
        context.beginPath();
        context.moveTo(point1.x, point1.y);
        context.lineTo(point2.x, point2.y);
        context.lineWidth = width;
        context.strokeStyle = color;
        context.stroke();
    }

    function drawCircle(point, radius, color){
        context.beginPath();
        context.arc(point.x, point.y, radius, 0, 2 * Math.PI, false);
        context.fillStyle = color;
        context.fill();
        context.strokeStyle = color;
        context.stroke();
    }

    function drawLabel(point, text, size){
        size = size || 18;
        context.save();
        context.translate(0, 0);
        //context.textAlign = 'center';
        context.shadowColor = '#222';
        context.shadowBlur = 3;
        context.shadowOffsetX = 0;
        context.shadowOffsetY = 0;
        context.fillStyle = '#ADBEFF';
        context.font="bold "+size+"px sans-serif";
        context.fillText(text,point.x,point.y);
        context.restore();
    }

    function setStateLabel(text){
        $('.js-label-field').text(text);
    }

    function clear(){
        context.clearRect(0, 0, field.width, field.height);
        $('.js-label-field').text('');
    }

    function isHitValid(point){
        function line(axis,position){
            var x1 = corner[position][axis];
            var x2 = corner['H'][axis];
            return function(x){
                return (x-x1)/(x2-x1);
            }
        }

        var leftX = line('x','3B');
        var leftY = line('y','3B');
        var rightX = line('x','1B');
        var rightY = line('y','1B');

        return leftX(point.x)>leftY(point.y) &&
            rightX(point.x)>rightY(point.y);
    }

    self.drawRun = function(type){
        drawLine(positions[lines[type][0]],positions[lines[type][1]],4,'#ADBEFF');
    };

    self.drawHit = function(point, type){
        if (!isHitValid(point))
            return false;

        drawLine(positions['H'],point,1.5,'#ADBEFF');
        drawCircle(point, 2, '#ADBEFF');
        return true;
    };

    self.drawLabel = function(type){
        drawLabel(positions['label'+type],type);
    };

    self.drawStateLabel = function(type){
        setStateLabel(type);
    };

    self.clear = function(){
        clear();
    };

    return self;
}