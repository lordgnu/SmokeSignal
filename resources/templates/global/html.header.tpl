<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <!-- Apple Specific Web-App Settings -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <link rel="apple-touch-icon" href="/images/webAppIcon.png" />
        <link rel="apple-touch-startup-image" href="/images/launch.png" />
        
        <title>SmokeBuddy</title>
        <link rel="stylesheet" href="/css/jqm.css" />
        <link rel="stylesheet" href="/css/my.css" />
        {*
        <link rel="stylesheet" href="/css.jqm.swipe.css" />
        *}
        
        <script src="/js/jq.js"></script>
        <script type="text/javascript">
        {literal}
        $(document).bind("mobileinit", function(){
        	//apply overrides here
        	$.mobile.loadingMessageTextVisible = false;
        	$.mobile.loadingMessage = "Loading...";
        	$.mobile.defaultPageTransition = "slide";
        	
        	// Bind to page before change
        	$(document).bind('pagebeforechange', function(event, data){
        		data.options.reloadPage = true;
        	});
        });

        $('#dashboard').live('pageinit', function(event){
            console.log('Dashboard Init!');
        });
        {/literal}
        </script>
        <script src="/js/jqm.js"></script>
        </script>
    </head>
    <body>