{include file='html.header.tpl'}
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Smoke Buddy
                </h3>
            </div>
            <div data-role="content" style="padding: 15px">
                <div style="">
                    <img style="width: 100%;" src="http://rpmedia.ask.com/ts?u=/wikipedia/commons/thumb/2/2e/No_smoking_nuvola_.svg/50px-No_smoking_nuvola_.svg.png" />
                </div>
                <a data-role="button" data-transition="fade" data-theme="a" href="#page1" data-icon="check" data-iconpos="left">
                    I am going to smoke
                </a>
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
            <div data-theme="a" data-role="footer" data-position="fixed">
            </div>
        </div>
{include file='html.footer.tpl'}        