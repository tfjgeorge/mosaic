$(document).ready(function() {
    var cont_left = $("#content").position().left;
    var jsonTab = new Array();
    $("imga").hover(function() {
        // hover in
        $(this).parent().parent().css("z-index", 1);
        $(this).animate({
           height: "500",
           width: "500",
           left: "-=50",
           top: "-=50"
        }, "medium");
        $("<img class='play_button' src='_img/play.png' />").insertAfter(this);
        $(this).dequeue();
        $(this).click(function(){
            $(this).each(function(){
                $(".play_button").remove();
                var current_image = $(this);
                current_image.replaceWith('<iframe frameborder="0" width="480" height="276" src="http://www.dailymotion.com/embed/video/'+video+'?autoPlay=1"></iframe>')
                });
        });
    }, function() {
        // hover out
        $(this).parent().parent().css("z-index", 0);
        $(this).animate({
            height: "32",
            width: "32",
            left: "+=50",
            top: "+=50"
        }, "medium");
        $(".play_button").remove();
        $(this).dequeue();
    });
    $(".img").each(function(index) {
        var left = (index * 160) + cont_left;
        $(this).css("left", left + "px");
    });
    
    /*coordonnées*/
    $("#img_coord").click(function(e){
        var x = e.pageX - this.offsetLeft;
        var y = e.pageY - this.offsetTop;
        var video = jsonTab[parseInt(y/32)][parseInt(x/32)];
        $.fancybox.open({href: "http://www.dailymotion.com/embed/video/"+video+"?autoPlay=1", type: 'iframe'})});
    
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "output.json",
        success: function(data){
           jsonTab = data;
            }
    });
    
});
