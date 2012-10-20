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
        $.fancybox({href: "http://www.dailymotion.com/embed/video/"+current_video['video_id']+"?autoPlay=1", type: 'iframe', closeEffect: 'none'})
    });

    $.ajax({
        type: "GET",
        dataType: "json",
        url: "output.json",
        success: function(data){
           jsonTab = data;
        }
    });
    
});
