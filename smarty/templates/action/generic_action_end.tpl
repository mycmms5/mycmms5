{debug}
<html>
<head>
<title>Action END</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<style type="text/css">
div {
    width: 50%;
    margin: 0 auto;    
}
div.message {
    background-color: lightgreen;
}
div.error {
    background-color: red;
}
</style>
</head>
<body>
<div class="message">{$message}</div>
<div class="error">{$errors}</div>
<a href="{$result}">Check results</a>
</body>
</html>