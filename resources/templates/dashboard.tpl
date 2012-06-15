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
                Smokers
            </li>
            <li data-theme="e">
                <a href="#page1" data-transition="slide">
                    [S] Don Bauer
                </a>
            </li>
            <li data-theme="c">
                <a href="#page1" data-transition="slide">
                    [N] Eric Johnson
                </a>
            </li>
        </ul>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>