<?php

?>
                            
<div class="uk-container uk-container-center">

            <h1>Upload</h1>

            <h2>On select</h2>

            <div class="uk-margin">

                <div class="uk-form-file">
                    <button class="uk-button">Select</button>
                    <input id="upload-select1" type="file">
                </div>

            </div>

            <h2>Drop area</h2>

            <div id="upload-drop" class="uk-placeholder uk-text-center">
                <i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i> Attach binaries by dropping them here or <a class="uk-form-file">selecting one<input id="upload-select2" type="file"></a>.
            </div>
            <div class="uploaded-files">
            </div>

            <div id="progressbar" class="uk-progress uk-hidden">
                <div class="uk-progress-bar" style="width: 0%;">0%</div>
            </div>

        </div>

        <script>
            jQuery(function($){
                var progressbar = $("#progressbar"),
                    bar         = progressbar.find('.uk-progress-bar'),
                    settings    = {
                    action: '/index.php?option=com_zoo&controller=account&task=upload&format=raw', // upload url
                    type: 'json',
                    loadstart: function() {
                        bar.css("width", "0%").text("0%");
                        progressbar.removeClass("uk-hidden");
                    },
                    progress: function(percent) {
                        percent = Math.ceil(percent);
                        bar.css("width", percent+"%").text(percent+"%");
                    },
                    allcomplete: function(response) {
                        bar.css("width", "100%").text("100%");
                        setTimeout(function(){
                            progressbar.addClass("uk-hidden");
                        }, 250);
                        console.log(response)
                        $('.uploaded-files').html();
                        $('.uploaded-files').append('<img src="'+response.file+'" height="100px" width="100px"/>')
                            .append('<input type="text" name="params[logo][path]" value="'+response.file+'"/>')
                            .append('<input type="text" name="params[logo][uuid]" value="'+response.UUID+'"/>');
                        alert("Upload Completed")
                    }
                };
                $.UIkit.uploadSelect($("#upload-select1"), settings);
                $.UIkit.uploadSelect($("#upload-select2"), settings);
                $.UIkit.uploadDrop($("#upload-drop"), settings);
            });
        </script>