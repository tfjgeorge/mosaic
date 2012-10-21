<!DOCTYPE html>
<html>
    <head>
        <!--CSS-->
        <link rel="stylesheet" href="_css/style.css" />
        <link rel="stylesheet" href="fancybox/jquery.fancybox.css" type="text/css" media="screen" />
        
        <!--JS-->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="_js/zoom.js"></script>
        <script type="text/javascript" src="fancybox/jquery.fancybox.pack.js"></script>
        
        <!--META-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            
    </head>
    <body>
        <div id="top_header_expanded">
            <div id="top_header">
                <h1>Mozaïk</h1>
                <a href="../index.php"><p class="button_create">Accueil</p></a>
                <p class="button_demo" style="display:none;"><a href="#">Demo</a></p>
            </div>
        </div>
        <div id="content">
            <div id="full_image">
                <img id="img_coord" src="output.jpeg" />
            </div>
            <div id="zoomed_image">
                <img id="img_zoomed" src="output.jpeg" />
                <div id="cadre"></div>
            </div>
            <div id="thumb">
                <div id="thumb_img">
                    <img />
                </div>
            </div>
        </div>
    </body>
</html>