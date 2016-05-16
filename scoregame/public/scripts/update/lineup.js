$(window).ready(function(){
    function isDHSelected(){
        var isDH = false;
        $('.js-defense-position').each(function () {
            isDH = isDH || $('option:selected',this).text() == 'DH';
        });
        return isDH;
    }

    function removePlayer() {
        $(this).parent().remove();

        updateSelectedPlayerMarks();
        updateSelectedPositionMarks();
        updatePlayerNumbers();
    }

    function addPlayer(){
        var $parent = $(this).parent();
        var $last = $parent.children('.ui-gray-player').last();

        if ($last.size() == 0)
            $last = $parent.children('h2');

        var $new = $('.js-player-template').children().clone();
        $new.children('.js-batter-position').val($parent.attr('batter'));
        $new.children('.ui-remove-substitution').click(removePlayer);
        $new.children('.js-defense-position').change(changeDefensePosition);
        $new.find('.js-select-player').change(function(){
            updateSelectedPlayerMarks();
            updatePlayerNumbers();
        });
        $new.insertAfter($last);

        updateSelectedPlayerMarks();
        updateSelectedPositionMarks();
        updatePlayerNumbers();

        return false;
    }

    function changeDefensePosition(){
        if (isDHSelected()){
            if ($pitcherContainer == null){
                createPitcherContainer();
            }
        } else {
            if ($pitcherContainer) {
                $pitcherContainer.remove();
                $pitcherContainer = null;
            }
        }

        updateSelectedPositionMarks();
    }

    function addPitcherPlayer(){
        addPlayer.apply(this);
        //$(this).parent().find('.js-defense-position').last().children().each(function(){
        //    if ($(this).text() != 'P')
        //        $(this).remove();
        //});
        return false;
    }

    function createPitcherContainer(){
        var $last = $('.js-player-container[batter="9"]');
        var $new = $last.clone();
        var $h2 = $('h2',$new).text('Pitcher');
        $('.ui-gray-player',$new).remove();

        $('.ui-remove-substitution',$new).click(removePlayer);
        $('.js-enter-substitution',$new).click(addPitcherPlayer);

        $new.attr('batter',10).insertAfter($last);

        $('.js-enter-substitution',$new).click();
        $pitcherContainer = $new;
    }

    function updateSelectedPlayerMarks(){
        var selectedValues = {};
        $('.js-player-container .js-select-player').each(function(i){
            $this = $(this);
            selectedValues[$this.val()] = true;
        });

        $('.js-player-container .js-select-player option').removeAttr("occupied");
        for(var v in selectedValues){
            $('.js-player-container .js-select-player option[value="'+v+'"]').attr("occupied",1);
        }
    }

    function updateSelectedPositionMarks(){
        var selectedValues = {};
        $('.js-player-container .js-defense-position').each(function(i){
            $this = $(this);
            selectedValues[$this.val()] = true;
        });

        $('.js-player-container .js-defense-position option').removeAttr("occupied");
        for(var v in selectedValues){
            $('.js-player-container .js-defense-position option[value="'+v+'"]').attr("occupied",1);
        }
    }

    function updatePlayerNumbers(){
        var $playerNumber = $('.js-player-container .js-input-player-number');
        $('.js-player-container .js-select-player').each(function(i){
            $this = $(this);
            var id = $this.val();
            $playerNumber.eq(i).val(G.playerNumbers[id]);
        });
    }

    var $pitcherContainer = $('.js-player-container[batter="10"]');
    if ($pitcherContainer.size() == 0)
        $pitcherContainer = null;


    $('.js-enter-substitution').each(function(){
        if ($(this).parent().attr('batter') == 10){
            $(this).click(addPitcherPlayer);
        }else{
            $(this).click(addPlayer);
        }
    });

    $('.js-defense-position').change(changeDefensePosition);
    $('.js-select-player').change(function(){
        updateSelectedPlayerMarks();
        updatePlayerNumbers();
    });
    $('.ui-remove-substitution').click(removePlayer);

    $('.ui-menu').find('a').click(function(){
        $('form')
            .append(
                $('<input type="hidden" name="redirect">')
                    .val($(this).attr('href')))
            .submit();
        return false;
    });

    updateSelectedPlayerMarks();
    updateSelectedPositionMarks();
    updatePlayerNumbers();
});