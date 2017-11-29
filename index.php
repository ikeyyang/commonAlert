<?php
include 'functions.php';

$o=$_GET['o'];
$source=$_GET['source'];
$part = $_GET['thirdPlat'];

if(!isMobile()){
	header("location:".$o);exit;
}

if($source=='taobao' || $source=='tmall' || $part=='taobao' || $part=='tmall'){
	$url = str_replace(array('http://','https://'),'taobao://',$o);
}else if($source=='mamabbs'){
	$url = 'mamabbs://www.ci123.com?push_type=3&push_id=0&push_url='.urlencode($o);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title></title>
<style>
html,body{width:100%;height:100%;overflow:hidden;margin:0;padding:0;}
body{background:rgba(0,0,0,0.5);}
.load{50px;height:50px;top:40%;position:absolute;left:42%;}
.wechat{width:100%; height:100%;font-size:18px;color:#fff; box-sizing:border-box;padding:50px;}
</style>
</head>

<body>
<?php if(isWX()){?>
<div class="wechat">请点击右上角"..."<br />选择在浏览器中打开!</div>
<?php
exit;
} else if($source=='mamabbs' && isMobile()) {?>
<div style="padding:20px; color:#fff;font-size:18px;">如果没有直接打开“妈妈社区app”，<br />请先<span style="text-decoration:underline;color:red;" onclick="window.location='http://baby.ci123.com/yunqi/m/down.php?from=weixin_act'">下载妈妈社区</span>然后刷新当前页面。</div>
<script>
window.location.href='<?php echo $url;?>';
</script>
<?php
echo '</body></html>';
exit;
}
?>
<div class="load"><img src="load.png" width="50"/></div>
<script>
 function openApp(url, onSuccess, onFail){
    var last = Date.now();
 
	//iframe open app
    var ifr = document.createElement('IFRAME');
    ifr.src = url;
    ifr.style.position = 'absolute';
    ifr.style.left = '-1000px';
    ifr.style.top = '-1000px';
    ifr.style.width = '1px';
    ifr.style.height = '1px';

    //3s check
    ifr.style.webkitTransition = 'all 3s';
    document.body.appendChild(ifr);
    setTimeout(function(){
        ifr.addEventListener('webkitTransitionEnd', function(){
            document.body.removeChild(ifr);
            if(Date.now() - last < 5000){
                if(typeof onFail === 'function'){
                    onFail();
                }
            } else if(typeof onSuccess === 'function') {
                onSuccess();
            }
        }, false);
        ifr.style.left = '-10px';
    }, 0);
};

openApp('<?php echo $url;?>', function(){
	<?php 
	//调用成功关闭app	
	if(isYun()){?>
	window.jsbinder.closeAction();
	<?php	
	} else if(isMama()){?>
	window.location='ios:mamabbs_closeWebview';
	<?php } ?>
	}, 
	function(){window.location.href='<?php echo $o;?>'})
</script>
</body>
</html>
