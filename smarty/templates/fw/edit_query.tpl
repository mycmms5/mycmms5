<h1 class="DEBUG">System Administration</h1>
<form action='edit_query.php' method='post'>
<input type='hidden' name='qry_name' value='{$smarty.session.query_name}'>
<table width="700">
<tr><td>SQL DDL: </td>
    <td><textarea name="sql_query" cols="150" rows="5">{$SQL_RAW}</textarea></td></tr>
<tr><td colspan="2"><input type='submit' name='save'></td></tr>
</table>
</form>
