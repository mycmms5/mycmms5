<!--
$Id: _calendar2.tpl,v 1.3 2013/04/17 06:17:07 werner Exp $
$Source: /var/www/cvs/mycmms40/mycmms40/smarty/templates/_calendar2.tpl,v $
$Log: _calendar2.tpl,v $
Revision 1.3  2013/04/17 06:17:07  werner
Inserted CVS variables Id,Source and Log

Revision 1.2  2013/04/17 06:12:36  werner
Inserted CVS variables Id,Source and Log
-->
<input type="text" class="text" id="{$NAME}" name="{$NAME}" value="{$VALUE}"/>
<img src='../images/calendar.gif' id="trigger_{$NAME}"/>
<script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "{$NAME}",
        trigger    : "trigger_{$NAME}",
        onSelect   : function() { this.hide() },
        weekNumbers: true,
        showTime   : false,
        dateFormat : "%Y-%m-%d"
      });
//]]></script>