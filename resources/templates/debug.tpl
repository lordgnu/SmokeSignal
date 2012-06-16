<div data-role="page" id="dashboard">
    {include file='global/jqm.header.tpl'}
    <div data-role="content" style="padding: 15px">
        <h3>Debug</h3>
        
        <strong>Cookie Dump</strong>
        <pre>{$cookieDump}</pre>
        
        <strong>DATA Dump</strong>
        <pre>{$dataDump}</pre>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>