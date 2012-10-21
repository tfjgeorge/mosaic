$(document).ready(function() {
    var cont_left = $("#content").position().left;
    var jsonTab = new Array();
    var document_x, document_y;
    var current_video;

    $(document).mousemove(function(e){
        document_x = e.pageX;
        document_y = e.pageY;
    });
    
    $("#img_coord").mousemove(function(e) {
        console.log('x: '+e.pageX);
        console.log('y: '+e.pageY);
        var x = e.pageX;
        var y = e.pageY;

        var x_offset = this.offsetLeft;
        var y_offset = this.offsetTop;

        $('#cadre').css({'top':parseInt(y/32)*32,'left':parseInt(x/32)*32+5});
        current_video = jsonTab[parseInt((y - y_offset)/32)][parseInt((x - x_offset)/32)];
    });

    $('#cadre').mousemove(function(e){
        var x = e.pageX;
        var y = e.pageY;

        setTimeout(function() {
            if (x == document_x && y == document_y) {
                $('#thumb img').css('margin-top',-current_video['position']*120);
                $('#thumb img').attr('src',current_video['image_url']);
                $('#thumb').css({'top':y-60,'left':x-80});
            }
        },150);
    });
    
    /*coordonnées*/
    $("#thumb img").click(function(e){
        $.fancybox({href: "http://www.dailymotion.com/embed/video/"+current_video['video_id']+"?autoPlay=1", type: 'iframe', closeEffect: 'none', width: '700', height: '393'})
    });

    $.ajax({
        type: "GET",
        dataType: "json",
        url: "output.json",
        success: function(data){
           jsonTab = data;
        }
    });
    
    $("#reduire").click(function(e) {
            var navWidth, navHeight;
            if (self.innerWidth != undefined)
            {
                navWidth = self.innerWidth;
                navHeight = self.innerHeight;
            } else {
                navWidth = document.documentElement.clientWidth;
                navHeight = document.documentElement.clientHeight;
            }
         
            $(this).css({
                "height": navHeight
            });
            $.fancybox({href: "output.jpeg", type: 'image', closeEffect: 'none', height: navHeight});
            $(this).css({
                "height": 'auto'
            });
    });
    
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
