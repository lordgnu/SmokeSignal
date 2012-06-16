<div data-theme="a" data-role="header" data-position="fixed">
    <h3>{$headerText|default:'Smoke Buddy'}</h3>
    {if $showSettings === true}
    <a href="/settings" data-icon="gear" class="ui-btn-right" data-iconpos="notext">Settings</a>
    {/if}
</div>