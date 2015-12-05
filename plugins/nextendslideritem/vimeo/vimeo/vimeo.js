(function ($, scope, undefined) {

    if(typeof scope.vimeoplayers == "undefined"){
        scope.vimeoplayers = [];
        $.getScript('http://a.vimeocdn.com/js/froogaloop2.min.js', function() {
            for(var i = 0; i < scope.vimeoplayers.length; i++){
                ssInitVimeoPlayer(scope.vimeoplayers[i]);
            }
            scope.vimeoplayers = [];
        });
    
        function ssInitVimeoPlayer(arr){
            var nodeid = arr[0], 
                node = $("#"+nodeid),
                id = nodeid+'player',
                sliderid = arr[1], 
                slider = $("#"+sliderid), 
                parent = node.closest(".smart-slider-layer"),
                autoplay = parseInt(node.data('autoplay')),
                reset = parseInt(node.data('reset'));
            var regExp = /http:\/\/(?:www\.|player\.)?(vimeo|youtube)\.com\/(?:embed\/|video\/)?(.*?)(?:\z|$|\?)/;
            var code = node.data('vimeocode')+'';
            var match = code.match(regExp);
            if (match&&match[2]){
                code = match[2];
            }
            
            var playerel = njQuery('<iframe id="'+id+'" src="//player.vimeo.com/video/'+code+'?api=1&player_id='+id+'&autoplay='+autoplay+'&title='+node.data('title')+'&byline='+node.data('byline')+'&portrait='+node.data('portrait')+'&color='+node.data('color')+'&loop='+node.data('loop')+'" width="400" height="225" style="position: absolute; top:0; left: 0; width: 100%; height: 100%;" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
            node.replaceWith(playerel);
            
            var player = $f(playerel[0]);
            player.addEvent("ready", function() {
                var p = playerel.closest(".smart-slider-canvas");
                if(autoplay){
                    if(p.hasClass("smart-slider-slide-active")){
                        player.api("play");
                    }else{
                        player.api("play");
                        setTimeout(function(){
                            player.api("pause");
                        }, 200);
                    }
                };
                player.addEvent("play", function(){
                    slider.trigger("ssplaystarted");
                });
                
                if(autoplay){
                    p.on("ssanimatelayersin", function(){
                        slider.trigger("ssplaystarted");
                        player.api("play");
                        if(reset) player.api("seekTo", 0);
                    });
                }
                p.siblings(".smart-slider-canvas").on("ssanimatelayersin", function(){
                    player.api("paused", function (value, player_id) {
                        if(!value){
                            slider.trigger("ssplayended");
                            player.api("pause");
                            if(reset) player.api("seekTo", 0);
                        }
                    });
                });
                player.addEvent("finish", function(){
                    slider.trigger("ssplayended");
                });
            });
        }
    }
                
    scope.ssCreateVimeoPlayer = function(playerid, sliderid){
        if(typeof(window.Froogaloop) == 'undefined'){
            scope.vimeoplayers.push([playerid, sliderid]);
        }else{
            $(document).ready(function() {
                ssInitVimeoPlayer([playerid, sliderid]);
            });
        }
    }
})(njQuery, window);