<?php get_header(); ?>
<div id="container">
<div class="content">
  <h1>页面未找到！-------->404</h1>
  <p>页面不存在---->Page No Found</p>
  <p>系统在 <span id="secondsDisplay">3</span> 秒钟之后带你返回首页。</p>
  <p>Will return front page in<span id="secondsDisplay">3</span> seconds</p>
</div>
<script type="text/javascript">  
  var i = 3;  
  var intervalid;  
    intervalid = setInterval("fun()", 1000);  
    function fun() {  
          if (i == 0) {  
                  window.location.href = "<?php echo home_url(); ?>";  
                        clearInterval(intervalid);  
                      }  
  document.getElementById("secondsDisplay").innerHTML = i;  
  i--;   
    }  
</script>
</div><!--end div container-->
<?php get_footer(); ?>