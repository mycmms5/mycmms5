<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Select File{/t}</h1>
<form action='{$SCRIPT_NAME}'>
<input type="hidden" name="STEP" value="1">
<input type="hidden" name="IMPORT" value="<?PHP echo $import_path; ?>"/>
<input type="hidden" name="EXPORT" value="<?PHP echo $export_path; ?>"/>
<p>Select the file you want to export (between brackets, you see the action)&nbsp</br>
If nothing is indicated, you cannot export the data!
<p><i>Files will be exported into directory {$import_path}.</i></p>
<select name="EXPORTFILE_ACTION">
{foreach from=$actions item=action}
    <option value='{$action.FILENAME}:{$action.ACTION}'>{$action.FILENAME} {$action.ACTION}</option>
{/foreach}    
</select><BR>
<input type="submit" name="STEP1" value="{t}IMPORT{/t}"/>
</form>
</body>
</html>