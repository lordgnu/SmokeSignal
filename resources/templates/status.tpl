<div data-role="page" id="status">
    {include file='global/jqm.header.tpl'}
    <div data-role="content" style="padding: 15px">
        <ul data-role="listview" data-divider-theme="a" data-inset="true">
            <li data-role="list-divider" role="heading">
                Change My Status
            </li>
            <li data-theme="e">
                <a href="/status/not-smoking" data-transition="slide">
                    <img src="/images/not-smoking-128.png" />
                    <h3>Not Smoking</h3>
                    <p>Updates Status.</p>
                </a>
            </li>
            <li data-theme="c">
                <a href="/status/smoking" data-transition="slide">
                    <img src="/images/smoking-128.png" />
                    <h3>Smoking</h3>
                    <p>Notifies Buddies!</p>
                </a>
            </li>
            <li data-theme="b">
                <a href="/status/away" data-transition="slide">
                    <img src="/images/away-128.png" />
                    <h3>Away</h3>
                    <p>Disables Notifications.</p>
                </a>
            </li>
        </ul>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>