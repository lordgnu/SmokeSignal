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
                    <p>This will change your status to not smoking</p>
                </a>
            </li>
            <li data-theme="c">
                <a href="/status/smoking" data-transition="slide">
                    <img src="/images/smoking-128.png" />
                    <h3>Smoking</h3>
                    <p>This will notify your buddies that you are smoking unless you are changing it in response to a notification you recieved</p>
                </a>
            </li>
            <li data-theme="b">
                <a href="/status/away" data-transition="slide">
                    <img src="/images/away-128.png" />
                    <h3>Away</h3>
                    <p>This will disable notifications for a specified amount of time.  Usefull for working from home or vacation/sick days</p>
                </a>
            </li>
        </ul>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>