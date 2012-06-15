<div data-role="page" id="register">
    {include file='global/jqm.header.tpl'}
    <div data-role="content" style="padding: 15px">
        <div data-role="collapsible-set">
	        <div data-role="collapsible" data-theme="a" data-content-theme="d" data-collapsed="false">
		        <h3>Already Registered?</h3>
		        <form method="post" action="/login">
			        <!-- Drop Down Here -->
			        <div data-role="fieldcontain">
	                    <label for="login-name" class="select">Organization:</label>
	                    <select name="login-name" id="login-name" data-native-menu="false" data-mini="true">
	                        <option>Don Bauer</option>
	                    </select>
	                </div>
	                
			        <!-- Pin Here -->
			        <div data-role="fieldcontain">
	                    <label for="login-pin">4-Digit PIN #:</label>
	                    <input type="text" name="login-pin" id="login-pin" data-mini="true" maxlength="4" />
	                </div>
	                
	                <button type="submit" data-theme="a" data-mini="true">Submit</button>
		        </form>
	        </div>
	        <div data-role="collapsible" data-theme="a" data-content-theme="d">
	            <h3>Register</h3>
	            <form method="post" action="/register/submit">
	                <!-- Organization -->
	                <div data-role="fieldcontain">
	                    <label for="orgnanization" class="select">Organization:</label>
	                    <select name="organization" id="orangization" data-native-menu="false" data-mini="true">
	                        <option>Charter Communications</option>
	                    </select>
	                </div>
	                
	                <!-- Name -->
	                <div data-role="fieldcontain">
	                    <label for="name">Full Name:</label>
	                    <input type="text" name="name" id="name" data-mini="true" />
	                </div>
	                
	                <!-- Pin Number -->
	                <div data-role="fieldcontain">
	                    <label for="pin">4-Digit PIN #:</label>
	                    <input type="text" name="pin" id="pin" data-mini="true" maxlength="4" />
	                </div>
	                
	                <!-- Smoke Timer -->
	                <div data-role="fieldcontain">
	                    <label for="timer">Smoke Timer (Minutes):</label>
	                    <input type="range" name="timer" id="timer" value="10" min="5" max="30" data-highlight="true" data-mini="true" />
	                </div>
	                
	                <!-- Submit -->
	                <button type="submit" data-theme="a" data-mini="true">Submit</button>
	                
	            </form>
	        </div>
        </div>
    </div>
    {include file='global/jqm.footer.tpl'}
</div>