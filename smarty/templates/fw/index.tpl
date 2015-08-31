<!DOCTYPE html>
<html>
<head>
<title>{$page_title}</title>
<meta http-equiv="Content-Type" content="text/html;" />
<script type="javascript">
window.name = "MYCMMS";
</script>
</head>
<frameset cols="*" rows="65px,*" framespacing="0" border="0"  bordercolor="#000000" >
<frame class="title" src="_main/{$title}?nav={$settings.nav}" name="title" scrolling="no" frameborder="0" bgcolor="5961a0">

<frameset cols="200,*" rows="*" framespacing="0" border="0" bordercolor="#000000">
<frame src="./_main/nav.php" name="nav" id="nav" frameborder="0" border="0"  marginwidth="5" marginheight="20"/>
<frame src="./_main/list.php?query_name={$query}" name="maintmain" id="maintmain" marginwidth="5"  marginheight="20" frameborder="0"/>
</frameset>

</frameset>
</html>