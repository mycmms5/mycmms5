<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Select File to IMPORT{/t}</h1>
<form action='{$SCRIPT_NAME}'>
<input type="hidden" name="STEP" value="1">
<input type="hidden" name="IMPORT" value="<?PHP echo $import_path; ?>"/>
<input type="hidden" name="EXPORT" value="<?PHP echo $export_path; ?>"/>
<p>Select the file you want to import (between brackets, you see the action)&nbsp</br>
If nothing is indicated, you cannot import the data!
<p><i>Imported files must be in {$import_path}.</i></p>
</p>
<select name="EXPORTFILE_ACTION">
{foreach from=$actions item=action}
    <option value='{$action.FILENAME}:{$action.ACTION}'>{$action.FILENAME} <b>{$action.ACTION}</b></option>
{/foreach}    
</select><BR>
<input type="submit" name="STEP1" value="{t}IMPORT{/t}"/>
</form>
</body>
</html>