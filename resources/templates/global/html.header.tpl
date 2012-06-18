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
        <link rel="stylesheet" href="/css.jqm.swipe.css" />
        
        {literal}
        <script src="/js/jq.js"></script>
        <script type="text/javascript">
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
        </script>
        <script src="/js/jqm.js"></script>
        <script src="/js/jqm.swipe.js"></script>
        <script type="text/javascript">
        $(document).bind('pageinit', function(){
        	// Attach Swipe to Delete Plugin to Status
        	$('ul.swipeMe li').swipeDelete({
        		btnTheme: 'e',
        		btnLabel: 'Remove',
        		btnClass: 'aSwipeBtn',
        		click: function(e) {
        			e.preventDefault();
        			var url = $(e.target).attr('href');
        			// var url = $(this).parents('li').attr('rel');
        			
        			console.log(url);
        			
        			/*
        			$.post(url, function(data){console.log(data)});
        			*/
        		}
        	});
        });
        </script>
        {/literal}
    </head>
    <body>