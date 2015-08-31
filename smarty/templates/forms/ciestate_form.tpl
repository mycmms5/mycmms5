<html>
<head>
<title></title>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<style type="text/css">
td.GENLEDGER {
    font-size: 18px;
    text-align: right;
    background-color: lightgrey;
}
td.PROFIT {
    font-size: 18px;
    text-align: right;
    background-color: green;
}
td.LOSS {
    font-size: 18px;
    text-align: right;
    background-color: red;
}
th.GENLEDGER {
    text-align: left;
}
th.INVESTMENT {
    text-align: left;
    background-color: cyan;
}
th.TOTAL {
    text-align: left;
    background-color: orange;
}
th.SUBTOTAL {
    text-align: left;
    background-color: yellow;    
}
</style>
</head>
<body>
<h1 class="action">{t}Company Status{/t} - {$YEAR} (calculated:{$smarty.now|date_format:'%Y-%m-%d'})</h1>
<table width="1000" align="center">
<tr><th colspan="2">Expenses</th><th colspan="2">Revenues</th></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=612030&YEAR={$YEAR}">612030</a>: GC Office</th><td class="GENLEDGER">{$ciestatus.GC_Office|string_format:'%.2f'}</td>
    <th class="GENLEDGER"><a href="logbook_detail.php?GL=700210001&YEAR={$YEAR}">700210001</a>: STORK</th><td class="GENLEDGER">{$ciestatus.Sales_STORK|string_format:"%.2f"}</td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=612031&YEAR={$YEAR}">612031</a>: GC IT</th><td class="GENLEDGER">{$ciestatus.GC_IT|string_format:'%.2f'}</td>
    <th class="GENLEDGER"><a href="logbook_detail.php?GL=700210002&YEAR={$YEAR}">700210002</a>: DEMB</th><td class="GENLEDGER">{$ciestatus.Sales_DEMB|string_format:"%.2f"}</td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=612032&YEAR={$YEAR}">612032</a>: GC Publicity</th><td class="GENLEDGER">{$ciestatus.GC_Publicity|string_format:'%.2f'}</td>
    <th class="GENLEDGER"><a href="logbook_detail.php?GL=700210003&YEAR={$YEAR}">700210003</a>: REMACLE</th><td class="GENLEDGER">{$ciestatus.Sales_REMACLE|string_format:"%.2f"}</td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=612041&YEAR={$YEAR}">612041</a>: GC Documentation</th><td class="GENLEDGER">{$ciestatus.GC_Documentation|string_format:'%.2f'}</td>
    <th class="GENLEDGER"><a href="logbook_detail.php?GL=700210004&YEAR={$YEAR}">700210004</a>: DESTROOPER</th><td class="GENLEDGER">{$ciestatus.Sales_DESTROOPER|string_format:"%.2f"}</td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=612081&YEAR={$YEAR}">612081</a>: AUTO brandstof</th><td class="GENLEDGER">{$ciestatus.AUTO_FUEL|string_format:'%.2f'}</td>
    <th class="TOTAL"><a href="logbook_detail.php?GL=70021%&YEAR={$YEAR}">700210*</a>: Sales</th><td class="GENLEDGER">{$ciestatus.SALES|string_format:"%.2f"}</td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=612082&YEAR={$YEAR}">612082</a>: AUTO onderhoud</th><td class="GENLEDGER">{$ciestatus.AUTO_MAINT|string_format:'%.2f'}</td>
    <td colspan="2"></td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=612083&YEAR={$YEAR}">612083</a>: AUTO verzekering/tax</th><td class="GENLEDGER">{$ciestatus.AUTO_INS|string_format:'%.2f'}</td>
    <td colspan="2"></td></tr>
<tr><th class="SUBTOTAL"><a href="logbook_detail.php?GL=61208%&YEAR={$YEAR}">61208%</a>: AUTO</th><td class="GENLEDGER">{$ciestatus.AUTO|string_format:'%.2f'}</td>
    <td colspan="2"></td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=612060&YEAR={$YEAR}">612060</a>: ADIC</th><td class="GENLEDGER">{$ciestatus.ADIC|string_format:"%.2f"}</td>
    <td colspan="2"></td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=613060&YEAR={$YEAR}">613060</a>: HDP / CARITAS</th><td class="GENLEDGER">{$ciestatus.HDP|string_format:"%.2f"}</td>
    <td colspan="2"></td></tr>
<!--
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=614040&YEAR={$YEAR}">614040</a>: Insurances (RC Pro)</th><td class="GENLEDGER">{$ciestatus.Insurances|string_format:'%.2f'}</td>
    <td colspan="2"></td></tr>
-->
<tr><th class="GENLEDGER">615001:</br><a href="http://www.mycmms.be">Website</a></th><td class="GENLEDGER">{$ciestatus.PC_WEB|string_format:'%.2f'}</td>
    <td colspan="2"></td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=615030&YEAR={$YEAR}">615030</a>: Software Maintenance/Upgrades</br>NuSphere, Premiumsoft</th><td class="GENLEDGER">{$ciestatus.PC_SW|string_format:'%.2f'}</td>
    <td colspan="2"></td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=615040&YEAR={$YEAR}">615040</a>: RC Pro</th><td class="GENLEDGER">{$ciestatus.INSPRO|string_format:'%.2f'}</td>
    <td colspan="2"></td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=615050&YEAR={$YEAR}">615050</a>: EPI</th><td class="GENLEDGER">{$ciestatus.EPI|string_format:'%.2f'}</td><td colspan="2"></td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=610%&YEAR={$YEAR}">610%</a>: Locaux, Electricité, GSM, INTERNET</th><td class="GENLEDGER">{$ciestatus.GC_FORFAIT|string_format:'%.2f'}</td><td colspan="2"></td></tr>

<tr><th class="TOTAL">COSTS</th><td class="GENLEDGER">{$ciestatus.COSTS|string_format:'%.2f'}</td><td colspan="2"></td></tr>
<tr><th class="GENLEDGER"><a href="logbook_detail.php?GL=1400%&YEAR={$YEAR}">Investments 1400</a></th><td class="GENLEDGER">{$ciestatus.Investments|string_format:'%.2f'}</td><td colspan="2"></td></tr>
<tr><th class="TOTAL"><a href="logbook_amortisation.php">AMORTISATION</a></th><td class="GENLEDGER">{$ciestatus.AMORTISATION|string_format:'%.2f'}</td>
    <th class="TOTAL">Company Result</th>{if $ciestatus.RESULT ge 0}<td class="PROFIT">{$ciestatus.RESULT|string_format:'%.2f'}</td>{/if}
                           {if $ciestatus.RESULT lt 0}<td class="LOSS">{$ciestatus.RESULT|string_format:'%.2f'}</td>{/if} </tr>
</table>
<div class="information"><p><a {$wiki}>MediaWIKI</a></p></div>
</body>
</html>