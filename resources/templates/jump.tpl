<div data-role="page" id="dashboard">
    {include file='global/jqm.header.tpl'}
    <div data-role="content" style="padding: 15px">
        <h3>Changes Applied</h3>
        
        <p>Changes were appied successfully!</p>
        
        <p>Smoke Buddy is redirecting you back to the dashboard</p>
        
        
    </div>
    {include file='global/jqm.footer.tpl'}
</div>
<script type="text/javascript">
{literal}
setTimeout(function(){
	$('a').attr('href', '{/literal}{$jumpURL}{literal}').trigger('click'));
}, 750);
{/literal}
</script>