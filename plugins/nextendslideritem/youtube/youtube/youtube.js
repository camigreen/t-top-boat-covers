//#|full|#
(function ($, scope, undefined) {

    if(typeof scope.youtubeplayers == "undefined"){
        scope.youtubeplayers = [];
        var tag = document.createElement("script");
        tag.src = "//www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName("script")[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        var loaded = scope.onYouTubeIframeAPIReady = function() {
            for(var i = 0; i < scope.youtubeplayers.length; i++){
                ssInitYoutubePlayer(scope.youtubeplayers[i]);
            }
            scope.youtubeplayers = [];
        }
        
        $(window).load(loaded);
    
        function ssInitYoutubePlayer(arr){
            var node = arr[0], 
                sliderid = arr[1], 
                player = $("#"+node),
                parent = player.closest(".smart-slider-layer"),
                reset = parseInt(player.data('reset')),
                cover = parseInt(player.data('cover')),
                mute = parseInt(player.data('mute')),
                autoplay = parseInt(player.data("autoplay"));
                
            var vars = {
                enablejsapi: 1,
                origin: window.location.protocol+"//"+window.location.host,
                autoplay: 0,
                theme: player.data("theme"),
                modestbranding: 1,
                wmode: "opaque",
                rel: player.data("related"),
                vq: player.data("vq"),
                controls: parseInt(player.data("controls")),
                showinfo: parseInt(player.data("showinfo")),                
                loop: parseInt(player.data("loop"))
            };
            if(vars.loop){
                vars.playlist = player.data("youtubecode");
            }
            
            var p = player.closest(".smart-slider-canvas");
            
            if(+(navigator.platform.toUpperCase().indexOf('MAC')>=0 && navigator.userAgent.search("Firefox") > -1))
                vars.html5 = 1;
            var playerobj = new YT.Player(player.attr("id"), {
                videoId: player.data("youtubecode"),
                wmode: 'opaque',
                playerVars: vars,
                events: {
                    onReady: function(){
                    
                        if(mute){
                            if(playerobj && playerobj.mute) playerobj.mute();
                        }
                        
                        parent.closest(".smart-slider-canvas").on("ssoutanimationstart", function(){
                            if(playerobj && playerobj.pauseVideo) playerobj.pauseVideo();
                        });
                        
                        if(autoplay){
                            if(p.hasClass("smart-slider-slide-active")){
                                $("#"+sliderid).trigger("ssplaystarted");
                                playerobj.playVideo();
                            }
                            p.on("ssanimatelayersin", function(){
                                playerobj.playVideo();
                                if(reset) playerobj.seekTo(0, true);
                                $("#"+sliderid).trigger("ssplaystarted");
                            });
                        }
                    },
                    onStateChange: function(state){
                        switch(state.data){
                            case YT.PlayerState.PLAYING:
                                $("#"+sliderid).trigger("ssplaystarted");
                                break;
                            //case YT.PlayerState.PAUSED:
                            case YT.PlayerState.ENDED:
                                $("#"+sliderid).trigger("ssplayended");
                                break;
                        }
                    }
                }
            });
            var player = $("#"+node);
            player.css("display", "block").prev().css("display", "none");
            if(cover){
                var container = player.parent(),
                    ratio = 16/9;
                // resize handler updates width, height and offset of player after resize/init
                var resize = function() {
                    var width = container.width(),
                        pWidth, // player width, to be defined
                        height = container.height(),
                        pHeight // player height, tbd;
        
                    // when screen aspect ratio differs from video, video must center and underlay one dimension
        
                    if (width / ratio < height) { // if new video height < window height (gap underneath)
                        pWidth = Math.ceil(height * ratio); // get new player width
                        player.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
                    } else { // new video width < window width (gap to right)
                        pHeight = Math.ceil(width / ratio); // get new player height
                        player.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2}); // player height is greater, offset top; reset left
                    }
        
                }

                
                resize();
                
                window[sliderid+'-onresize'].push(resize);
            }
        }
    }
                
    scope.ssCreateYouTubePlayer = function(playerid, sliderid){
        if(typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined'){
            scope.youtubeplayers.push([playerid, sliderid]);
        }else{
            $(document).ready(function() {
                ssInitYoutubePlayer([playerid, sliderid]);
            });
        }
    }
})(njQuery, window);