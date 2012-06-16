<div data-role="page" id="register">
    {include file='global/jqm.header.tpl'}
    <div data-role="content">
        <h3>Notification Methods</h3>
        <!-- List Goes Here -->
        
        <h3>Add Method</h3>
        <form method="post" action="/settings/submit">
            <!-- Email or SMS Number -->
            <div data-role="fieldcontain">
                <label for="address">E-Mail or Phone #</label>
                <input type="text" name="address" id="address" data-mini="true" />
            </div>
            
            <!-- Type -->
            <div data-role="fieldcontain">
                <fieldset data-role="controlgroup" data-mini="true">
                    <legend>Type of Notification:</legend>
                        <input type="radio" name="type" id="radio-choice-1" value="email" checked="checked" />
                        <label for="radio-choice-1">E-Mail</label>

                        <input type="radio" name="type" id="radio-choice-2" value="att"  />
                        <label for="radio-choice-2">SMS (AT&amp;T)</label>

                        <input type="radio" name="type" id="radio-choice-3" value="verizon"  />
                        <label for="radio-choice-3">SMS (Verizon)</label>
                </fieldset>
            </div>
        </form>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>