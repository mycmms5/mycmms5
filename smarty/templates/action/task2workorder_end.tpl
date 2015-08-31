<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
{if $new eq "on"}
    <h1 class="action">{t}Work Order Generated{/t}</h1>
    <p>{t}Generated new Workorder{/t}&nbsp;{$wonum}&nbsp;{t}based on TASK{/t}&nbsp;{$tasknum}</p>
{else}
    <h1 class="action">{t}Copied Task to Workorder{/t}</h1>
    <p>{t}Deleting existing WO data from{/t}&nbsp;{$wonum}&nbsp;{t}and filling with task data from TASK{/t}&nbsp;{$tasknum}</p>
{/if}
{if $error eq "OK"}
    <p><div class="success">{t}Operation successfully ended{/t}</div></p>
{else}
    <p><div class="error">{$error}</div></p>
{/if}
</body>
</html>