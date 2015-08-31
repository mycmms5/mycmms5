<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Select File{/t}</h1>
<form action='{$SCRIPT_NAME}'>
<input type="hidden" name="STEP" value="1">
<input type="hidden" name="IMPORT" value="{$import_path}"/>
<select name="IMPORTFILE_ACTION">
{foreach from=$actions item=action}
    <option value='{$action.FILENAME}:{$action.ACTION}'><b>{$action.FILENAME}</b> ({$action.ACTION})</option>
{/foreach}    
</select><BR>
<input type="submit" name="STEP1" value="{t}IMPORT{/t}"/>
</form>
</body>
</html>