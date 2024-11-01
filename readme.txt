=== TinyFeed ===
Contributors: jpiche
Tags: ajax, identi.ca, twitter, widget
Requires at least: 2.8.0
Tested up to: 3.0.4
Stable tag: 2.0.1

TinyFeed is a Wordpress widget which loads a microblog status feed via Ajax.

== Description ==

TinyFeed is a Wordpress widget which loads a microblog status feed via Ajax. It is currently restricted to microblogs with Twitter-compatible APIs, so only Twitter and Identi.ca.

I wrote it for one reason: I think the default RSS feed Wordpress plugin is lame. I didn't like PHP retrieving the feed and having the page wait to load because of it. Even though it caches the feed, for frequently updated feeds it just doesn't make sense. Loading the feed via Ajax shaved seconds off of my page load time. I was so immensely happy with it that I decided to widgetize it and share it.

The current release of the widget is also the first, so there may be a few bugs to work out. But I also use this personally, so it should be stable enough for normal use.

== Frequently Asked Questions ==

= This uses AJAX, will this work in old versions of Internet Explorer? =

The AJAX framework TinyFeed uses is [jQuery](http://jquery.com/ "The Write Less, Do More, JavaScript Library") which works with Internet Explorer 6 and above and Firefox 2 and above, which should be sufficient for most audiences.

= The feed pulled from the microblog service is sent directly to the client without any caching, should I worry about bandwidth? =

Probably not. If your site receives more traffic than the microblogging service, then you might need to be worried, but if your site has more traffic than Twitter or Identi.ca, then you probably have other issues too.

= How do I theme TinyFeed? =

The `tinyfeed.css` file included in the distribution provides a commented framework for theming the widget however you would like.

= What timezone is the timestamp of the status in? =

The time is calculated using the user's timezone.

= Why does the status time not use AM/PM? =

Because I haven't coded it in yet. I hope to soon include options for how to display the timestamp.

= How is TinyFeed licensed? =

TinyFeed is copyright [Joseph Piché](http://jpiche.com/), but is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

== Installation ==

1. Upload the `tinyfeed` plugin directory to your `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in Wordpress
1. Drag & drop any TinyFeed widgets where you want via the 'Appearance' -> 'Widgets' admin page
1. Enter in the required info for each instance of TinyFeed

== Changelog ==

= 2.0.1 =
* Fixing version number

= 2.0 =
* Rewrite; the plugin is now more efficient and plays nicer with other plugins

= 1.2 =
* Cleaned up the distribution files; still getting used to Wordpress plugin hosting

= 1.1 =
* Fixed timestamp display in IE
* Status URLs work now

= 1.0 =
* Initial release
