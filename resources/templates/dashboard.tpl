<div data-role="page" id="dashboard">
    {include file='global/jqm.header.tpl'}
    <div data-role="content" style="padding: 15px">
        <ul data-role="listview" data-divider-theme="a" data-inset="true">
            <li data-role="list-divider" role="heading">
                My Status
            </li>
            <li data-theme="e">
                <a href="/status" data-transition="slide">
                    <img src="/images/not-smoking-128.png" />
                    <h3>Don Bauer (Me)</h3>
                    <p>Not currently smoking</p>
                </a>
            </li>
        </ul>
        <ul data-role="listview" data-divider-theme="a" data-inset="true">
            <li data-role="list-divider" role="heading">
                Buddies
            </li>
            <li data-theme="e">
                <img src="/images/not-smoking-128.png" class="ul-li-icon" />
                Don Bauer
            </li>
            <li data-theme="c">
                <img src="/images/smoking-128.png" class="ul-li-icon" />
                Eric Johnson
            </li>
        </ul>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>