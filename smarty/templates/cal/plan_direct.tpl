
<html>
<head>
<title>Reference</title>
<script type="text/javascript">
function reload() {    
    window.location.assign("cal.php?date={$smarty.cookies.DAY}"); 
} 
setTimeout("reload();", 2);
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h2>Resulting ...</h2>
<ul>
<li>{$cookies.WO}</li>
<li>{$cookies.DAY}</li>
<li>{$cookies.TECH}</li>
</ul>
</body>
</html>


