<input type="text" class="text" id="{$NAME}" name="{$NAME}" value="{$VALUE}"/>
<img src='../images/calendar.gif' id="trigger_{$NAME}"/>
<script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "{$NAME}",
        trigger    : "trigger_{$NAME}",
        onSelect   : function() { this.hide() },
        weekNumbers: true,
        showTime   : true,
        dateFormat : "%Y-%m-%d %H:%M"
      });
//]]></script>