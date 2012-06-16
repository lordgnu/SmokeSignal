<div data-role="page" id="dashboard">
    {include file='global/jqm.header.tpl'}
    <div data-role="content" style="padding: 15px">
        <ul data-role="listview" data-divider-theme="a" data-inset="true">
            <li data-role="list-divider" role="heading">
                My Status
            </li>
            <li data-theme="{$myTheme}">
                <a href="/status" data-transition="slide">
                    <img src="/images/{$myStatus}-128.png" />
                    <h3>{$myName} (Me)</h3>
                    <p>
                        {if $myStatus == 'smoking'}
                        Currently Smoking
                        {elseif $myStatus == 'away'}
                        Currently Away
                        {else}
                        Currently Not Smoking
                        {/if}
                    </p>
                </a>
            </li>
        </ul>
        <ul data-role="listview" data-divider-theme="a" data-inset="true">
            <li data-role="list-divider" role="heading">Buddies</li>
            {foreach $DATA.users as $user}
            <li data-theme="{$user.statusTheme}">
                <img src="/images/{$user.status}-22.png" class="ui-li-icon" />
                {$user.name}
                {if $user.name == $myData.name}(Me){/if}
            </li>
            {foreachelse}
            <li>No Buddies Registered Yet</li>
            {/foreach}
        </ul>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>