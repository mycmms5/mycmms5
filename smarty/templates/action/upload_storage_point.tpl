<html>
<head>
<title>Upload Storage Point</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="ACTION">Uploaded {$store_path}</h1>
<ul>
<li>Content check: {$md5}</li>
<li>Storage path: {$sha1}</li>
{if !$upload_errors.exists}
<li><div class="error">ERROR file was not successfully uploaded</div></li>
{if !$upload_errors.move}
    <li><div class="error">ERROR during upload</div></li>
{/if}
{if !$upload_errors.mkdir}
    <li><div class="error">ERROR while creating directory</div></li>
{/if}
{/if}
</ul>

<div class="error">{$smarty.session.PDO_ERROR}</div>

</body>
</html>