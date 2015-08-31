<table>
<tr><th>{t}Source_Text{/t}</th><th>{t}en_GB{/t}</th><th>{t}fr_FR{/t}</th><th>{t}nl_NL{/t}</th></tr>
{foreach from=$gettexts item=gettext}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$gettext.source}</td>
    <td>{$gettext.en}</td>
    <td>{$gettext.fr}</td>
    <td>{$gettext.nl}</td>
{/foreach}
</table>
</body>
</html>