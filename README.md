# wp-feature-editor
A simple WordPress plugin to toggle and configure WordPress features.

This plugin relies on the Hobo Framework at https://github.com/colinburroughs/wp-hobo-framework

<h5>Front End Features<h5>
<ul>
<li>Disable Smart Quotes (a.k.a. curly quotes), em dash, en dash and ellipsis.
<li>Disable auto-correction of WordPress capitalisation.
<li>Disable paragraphs (i.e. &lt;p&gt; tags) from being automatically inserted in your posts.
<li>Disable Emoji.
<li>Disable Dashicons.
<li>Disable Shortlink.
<li>Disable Embeds.
<li>Disable REST Link.
<li>Disable XFN (XHTML Friends Network) Profile Link. <i>Note: This link may be hardcoded in the theme header and not dynamically generated.</i>
<li>Disable JQuery migrate. <i>Note: Ignored in admin. This may break your frontend javascript.</i>
<li>Remove Admin Bar.
<li>Remove Admin Bar WordPress Logo.
<li>Disable Failed Login Shake.
<li>Asynchronous Script Loads. Performs script loads asynchronously.
<li>Defer Script Execution. Defer execution of scripts until the HTML document has been fully parsed.
</ul>

<h5>Back End Features<h5>
<ul>
<li>Disable Self Pings (i.e. trackbacks/pings from your own domain).
<li>Disable RSS Feeds.
<li>Disable XML-RPC.
<li>Authenticate REST. Calls to REST API must be made by an authenticated user.
<li>Disable Post Auto-Saving.
<li>Disable Post Revisions.
<li>Disable Page Revisions.
<li>Disable WordPress Cron.
</ul>

<h5>Privacy Features<h5>
<ul>
<li>Disable Version Printing.
<li>Disable Version Printing On Script & CSS. <i>Note: This will affect browser caching of script and css assets. Ignored in admin.</i>
<li>Disable URL Information. Disable WordPress from sending your URL information when checking for updates.
<li>Delete "readme.html" and "license.txt" Files.
</ul>

<h5>Heartbeat<h5>
<ul>
<li>Disable Heartbeat. <i>Note: By disabling Heartbeat completely, you may disrupt the functionality of some features in WordPress.</i>
<li>Heartbeat Autostart.	
<li>Heartbeat Frequency.
</ul>

<h5>Ad Blocker Features</h5>
<ul>
<li>Ad blocker detection.
<li>Configurable popup panel.
</ul>

<h5>Filterable Plugins</h5>
<ul>
<li>Regular expression filterable plugin capability via "must-use" plugin file. Disable plugins on certain pages or for certain requests.
</ul> 
