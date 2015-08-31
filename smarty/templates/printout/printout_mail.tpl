{$wo.WONUM} - REPORT: {$wo.REPORT} ({$wo.ASSIGNEDTECH}) - <i>{$wo.REPORT_AX}
{t}DBFLD_TASKDESC{/t}: {$wo.TASKDESC}
{t}DBFLD_EQNUM{/t}: {$wo.DESCRIPTION} (CLMCHID:{$wo.EQNUM})
{t}DBFLD_ORIGINATOR{/t}: (CLID){$wo.ORIGINATOR}
{$wo.NAME}
{$wo.ADDRESS}
{$wo.POSTCODE}
{$wo.PHONE}

DATUM: {$wo.SCHEDSTARTDATE}

Opmerkingen/Remarques: 
{$wo.TEXTS_A}
Technische Info
{$wo.TEXTS_B}

{foreach item=spare from=$spares}
{$spare.MAPICS} : {$spare.DESCRIPTION} / {$spare.QTYREQD}
{/foreach}
EOF MESSAGE