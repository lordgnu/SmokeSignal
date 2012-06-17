<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <!-- Apple Specific Web-App Settings -->
        <link rel="apple-touch-icon" href="http://smoke.crouchingllama.org/images/webAppIcon.png" />
        <link rel="apple-touch-startup-image" href="http://smoke.crouchingllama.org/images/webAppSplash.png" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        
        <title>SmokeBuddy</title>
        <link rel="stylesheet" href="/css/jqm.css" />
        <link rel="stylesheet" href="/css/my.css" />
        <style>
            /* App custom styles */
        </style>
        <script src="/js/jq.js"></script>
        <script type="text/javascript">
        $(document).bind("mobileinit", function(){
        	//apply overrides here
        	$.mobile.loadingMessageTextVisible = false;
        	$.mobile.loadingMessage = "Loading...";
        });
        </script>
        <script src="/js/jqm.js"></script>
    </head>
    <body>