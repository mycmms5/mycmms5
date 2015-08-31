<html>
<head>
<title>REFRESH</title>
<script type="text/javascript">
// window.onunload=refreshParent;
function refreshParent() {
    window.opener.location.reload();    
    alert("Closing Refresh - Refreshing Plan window");
    self.close();
}
</script>
</head>
<body>
Information:<p>
<ul>
<li>LOGIN:&nbsp;{$smarty.session.user}</li>
<li><ul>WORK
        <li>ID:     {$smarty.request.id}</li>
        <li>TECH:&nbsp;&nbsp;{$smarty.request.user}</li>
        <li>DATE:&nbsp;&nbsp;{$smarty.request.date}</li>
        </ul></li>
<li><ul>PLAN
        <li>{$smarty.cookies.DAY}</li>
        </ul></li>    
</ul>
</body>
</html>