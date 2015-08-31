<div class="CVS">{$version}</div>
{if $smarty.session.PDO_ERROR}
<div class="error">DATABASE ERROR:&nbsp{$smarty.session.PDO_ERROR}</div>
{/if}
{foreach from=$errors item=error}
<div class='error'>{$error}</div>
{/foreach}
</body>
</html>
