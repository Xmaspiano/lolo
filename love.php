<?php
header("Content-Type: text/html; charset=utf-8");
include('includes/Core.php');

$imgURL = $BzlsHandle->getImgUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>戴小小破蛋日</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="./css/swiper.min.css">

	<script type="text/javascript">
    var isDesktop = navigator['userAgent'].match(/(ipad|iphone|ipod|android|windows phone)/i) ? false : true;
    var fontunit = isDesktop ? 20 : ((window.innerWidth > window.innerHeight ? window.innerHeight : window.innerWidth) / 320) * 10;
    document.write('<style type="text/css">' +
                   'html,body {font-size:' + (fontunit < 30 ? fontunit : '30') + 'px;}' +
                   (isDesktop ? '#welcome,#GameLayerBG,#GameScoreLayer.SHADE{position: absolute;}' :
                    '#welcome,#GameTimeLayer,#GameLayerBG,#GameScoreLayer.SHADE{position:fixed;}') +
                   '</style>');
    </script>
    
    <!-- Demo styles -->
    <style>
    html, body {
        position: relative;
        height: 100%;
    }
    body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color:#000;
        margin: 0;
        padding: 0;
    }    
    .swiper-container {
        width: 100%;
        height: 100%;
    }
    .parallax-bg {
        position: absolute;
        left: 0;
        top: 0;
        width: 130%;
        height: 100%;
        -webkit-background-size: cover;
        background-size: cover;
        background-position: center;
    }
    
    .swiper-slide .title {
        font-size: 41px;
        font-weight: 300;
    }
    
    .swiper-slide .subtitle {
        font-size: 21px;
    }
    
    .swiper-slide .text {
        font-size: 14px;
        max-width: 400px;
		padding: 7% 5% 0 20%;
        line-height: 1.3;
    }
    
    .swiper-slide .img {
        max-width:100%;
        max-height:100%;
        position: absolute;
        top:15%; 
		left:auto;  
    }
    
    .swiper-slide .photo {
/*         max-width:200%; */
		width:100%;
/*         height:100%; */
    }		
    
    @media screen and (max-width:636px){
	    .swiper-slide .img {
	        max-width:100%;
	        max-height:100%;
	        position: absolute;
	        top:15%; 
	        left:1%; 
	    }	
    }
    
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        color:black;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
/*         padding: 40px 60px; */
/*         background: #fff; */

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .swiper-container-v {
        background: #eee;
    }
    .swiper-pagination-bullet-v {
    	width:34px;
    	height:20px;
    	text-align:center;
    	line-height:20px;
    	font-size:12px;
    	color:#000;
    	opacity:1;
    	background:rgba(0,0,0,0.2);
    }
    .swiper-pagination-bullet-active{
    	color:#fff;
    	background:#007aff;
    }
    
    </style>
</head>
<body>
    <!-- Swiper -->
    <div class="swiper-container swiper-container-h">
    	<div class="parallax-bg" style="background-image:url(./img/cd.png)" data-swiper-parallax="-23%"></div>
        <div class="swiper-wrapper">
            <div class="swiper-slide" >
<!--                 <div class="title" data-swiper-parallax="-200">Slide 1</div> -->
<!--                 <div class="subtitle" data-swiper-parallax="-300">Subtitle</div> -->
                <div class="text" data-swiper-parallax-duration="1300" data-swiper-parallax="-300%">
                    <p>
                    	<font size="4" style="font-family: STKaiti;">
                    		<p>今天是个特别的日子,</p>
                    		<p>希望今后的每一天你都能开心</p>
                    		<p>生日快乐~</p>
                    	</font>
                    </p>
                </div>
            </div>
            
            <div class="swiper-slide" >
                <img class="img" src="img/shang.png"  data-swiper-parallax-duration="1300" data-swiper-parallax-x="0" data-swiper-parallax-y="130%" />
                <img class="img" src="img/zhong.png" data-swiper-parallax-duration="1300" data-swiper-parallax="-300%"/>
                <img class="img" src="img/xia.png" data-swiper-parallax-duration="1300" data-swiper-parallax-x="0" data-swiper-parallax-y="-130%" />
            </div>
            <div class="swiper-slide">
                <div class="text" data-swiper-parallax-duration="1300" data-swiper-parallax="-300%" style="padding: 10% 0 0 0;">
                    <p>
                    	<font size="4" style="font-family: STKaiti;">
                    		<p>我们总会不断的遇见一些人,</p>
                    		<p>也会不停的和一些人说再见,</p>
                    		<p>从陌生到熟悉,</p>
                    		<p>从熟悉再回陌生,</p>
                    		<p>从臭味相投到分道扬镳,</p>
                    		<p>从相见恨晚到不如不见....</p>
                    		<p>但总会留下一个,</p>
                    		<p>你我也许就是那一个</p>
                    		<p>生日快乐~</p>
                    	</font>
                    </p>
                </div>
            </div>
            <div class="swiper-slide" >
            	<iframe class="swiper-slide" src="./content/grid.html"  style="height: 100%;border: 0px;"></iframe>
            </div>
            <div class="swiper-slide" >
                <div class="swiper-container swiper-container-v">
                    <div class="swiper-wrapper">
                        <?php //foreach ($imgURL as $getURL){?>
                        <div class="swiper-slide">
                        	<iframe name ='iframes' class="swiper-slide" src="http://s.t.tt/5ag1wz" style="height: 100%;border: 0px;"></iframe>
                        	<!-- <img class="photo" src="<?php echo $getURL['url'];?>" />   -->
                        	<!-- style="background-image:url(<?php echo $getURL['url'];?>)"  -->
                        </div>
                        <?php //}?>
                        <div class="swiper-slide">
                        	<iframe name ='iframes' class="swiper-slide" src="http://s.t.tt/5ag1wz" style="height: 100%;border: 0px;"></iframe>
                        	<!-- <img class="photo" src="<?php echo $getURL['url'];?>" />   -->
                        	<!-- style="background-image:url(<?php echo $getURL['url'];?>)"  -->
                        </div>
                    </div>
                    <div class="swiper-pagination swiper-pagination-v"></div>
                </div>
            </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-h"></div>
    </div>

    <!-- Swiper JS -->
    <script src="./js/swiper.min.js"></script>
	<script src="./js/jquery-2.1.1.min.js"></script>
    <!-- Initialize Swiper -->
    
    <script>
    $('body').on('touchmove', function (event) {
    	event.preventDefault();
    });

//     $("iframe").contents().find("body").on('touchmove', function (event) {
//         event.preventDefault();
//     });
// 	alert( $("iframe").contents().find("body").html());

	$(function () {
	    var iframeWin = window.frames['iframes'];
	    $(iframeWin).load(function () {
	        $(iframeWin).contents().find('#body').on('touchmove', function (event) {
		        alert(111);
	        	event.preventDefault();
	        });
	    });
	});
	
    var swiperH = new Swiper('.swiper-container-h', {
        pagination: '.swiper-pagination-h',
        paginationClickable: true,
        effect: 'fade',
        parallax: true,
        spaceBetween: 50
    });
    
    var swiperV = new Swiper('.swiper-container-v', {
        pagination: '.swiper-pagination-v',
		paginationClickable: true,
        direction: 'vertical',
        spaceBetween: 50,
        paginationBulletRender: function (index, className) {
            return '<span class="' + className + ' swiper-pagination-bullet-v">' + (index + 1) + '</span>';
        }
    });

    function dd(index){
		var d = new Date();
		d.getDay();
    }
    </script>
</body>
</html>