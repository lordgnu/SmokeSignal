<div data-role="page" id="exire" data-url="/expire">
    {include file='global/jqm.header.tpl'}
    <div data-role="content" style="padding: 15px">
        <ul data-role="listview" data-divider-theme="a" data-inset="true">
            <li data-role="list-divider" role="heading">
                How Long Will You Be {$status}?
            </li>
            <li data-theme="b">
                <form action="/expire/submit" method="post">
                    {if $status == 'Smoking'}
                        <div data-role="fieldcontain">
	                        <!-- Show Slider -->
	                        <label for="minutes">Minutes</label>
	                        <input type="range" id="minutes" name="minutes" min="5" max="30" value="{$myData.timer}" data-highlight="true" data-role="slider" />
                        </div>
                    {else}
                        <!-- Show Days/Hours Picker -->
                        <div data-role="fieldcontain">
                            <!-- Hours -->
                            <label for="hours">Hours</label>
                            <input type="range" id="hours" name="hours" min="1" max="24" value="16" data-highlight="true" data-role="slider" />
                        </div>
                        
                        <div data-role="fieldcontain">
                            <!-- Days -->
                            <label for="days">Days</label>
                            <input type="range" id="days" name="days" min="0" max="30" value="0" data-highlight="true" data-role="slider" />
                        </div>
                    {/if}
                    
                    <!-- Submit -->
                    <input type="hidden" name="status" value="{$status}" />
                    <button type="submit" data-theme="a">Submit</button>
                </form>
            </li>
        </ul>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>