$(document).ready(function() {
    var cont_left = $("#content").position().left;
    var jsonTab = new Array();

    function place_elements() {
        var height = parseInt($('#content').css('height'));
        var ratio = parseInt($('#img_zoomed').css('width')) / parseInt($('#img_zoomed').css('height'));
        var width = parseInt(height / (3/4 + 1/ratio));
        $('#full_image').css({width: width});
        $('#zoomed_image').css({left: width});

        var zoomed_div_height = parseInt($('#zoomed_image').css('height'));
        var zoomed_div_width = parseInt($('#zoomed_image').css('width'));
        $('#cadre').css({'margin-left': -10000 + zoomed_div_width / 2 - 48, 'margin-top': -10000 + zoomed_div_height / 2 - 48});

        $('#thumb').css({top:parseInt($('#full_image img').css('height')),width: width})
        $('#thumb_img').css({top:parseInt((parseInt($('#thumb').css('height'))-120)/2),left: parseInt((parseInt($('#thumb').css('width'))-160)/2)})
    }

    $(window).resize(function(){ place_elements(); });

    $('#img_coord').mousemove(function(e) {
        var x = e.pageX - this.offsetLeft;
        var y = e.pageY - this.offsetTop - 46;

        var zoomed_div_height = parseInt($('#zoomed_image').css('height'));
        var zoomed_div_width = parseInt($('#zoomed_image').css('width'));

        var zoomed_image_height = parseInt($('#img_zoomed').css('height'));
        var zoomed_image_width = parseInt($('#img_zoomed').css('width'));

        var small_image_height = parseInt($('#img_coord').css('height'));
        var small_image_width = parseInt($('#img_coord').css('width'));

        $('#img_zoomed').css({'margin-top':zoomed_div_height / 2 - y / small_image_height * zoomed_image_height ,'margin-left': zoomed_div_width / 2 - x / small_image_width * zoomed_image_width  });
        var video = jsonTab[parseInt(y / small_image_height *  zoomed_image_height / 32)][parseInt(x / small_image_width *  zoomed_image_width / 32)];
        $('#thumb img').attr('src',video['image_url']);
        $('#thumb img').css('margin-top',-video['position']*120);

    });

    $('#img_coord').click(function(e) {
        var x = e.pageX - this.offsetLeft;
        var y = e.pageY - this.offsetTop - 46;

        var zoomed_image_height = parseInt($('#img_zoomed').css('height'));
        var zoomed_image_width = parseInt($('#img_zoomed').css('width'));

        var small_image_height = parseInt($('#img_coord').css('height'));
        var small_image_width = parseInt($('#img_coord').css('width'));

        var video = jsonTab[parseInt(y / small_image_height *  zoomed_image_height / 32)][parseInt(x / small_image_width *  zoomed_image_width / 32)];

        $.fancybox({href: "http://www.dailymotion.com/embed/video/"+video['video_id']+"?autoPlay=1", type: 'iframe', closeEffect: 'none', width: '700', height: '393'});
    });

    $.ajax({
        type: "GET",
        dataType: "json",
        url: "output.json",
        success: function(data) {
           jsonTab = data;
        }
    });

    setTimeout(place_elements,500);
    
    $(".button_create").click(function(e) {
            $.fancybox({content: '<form action="download_images.php" method="post" enctype="multipart/form-data">'
                       +'<p style="font-size:13px; display:inline;">Tag Dailymotion : </p>'
                       +'<input class="search" name="search" type="search" placeholder="Entrez un mot-clef" />'
                       +'</br><input type="hidden" name="MAX_FILE_SIZE" value="122097152" />'
                       +'<p style="font-size:13px; display:inline;">Fichier à traiter :</p>'
                       +'<input class= "search" type="file" name="fichier" style="padding-left:10px;" value=""/>'
                       +'</br><p style="text-align:center;"><input id="submit_search" class="submit_search" name="submit_search" type="submit" style="text-align:center;" /></p>'
                       +'', type: 'html', closeEffect: 'none', width: '500', height: '300'});
    });

});
