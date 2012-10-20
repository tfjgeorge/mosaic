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
                <input class="search" name="search" type="search" placeholder="Entrez un mot-clef" />
                <input class="submit_search" name="submit_search" type="submit" />
            </div>
        </div>
        <div id="content">
            <input class="input_file" type="file" name="fichier" />
            
            <div class="img" id="img_div">
                <div id="cadre"></div>
                <div id="thumb"><img class="miniature" src="" /></div>
                <img id="img_coord" src="output.jpeg" />
            </div>
        </div>
    </body>
</html>