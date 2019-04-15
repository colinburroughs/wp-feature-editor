<?php

namespace Feature_Editor\Admin;

use Hobo\Framework\Settings;
use Hobo\Framework\Util;

class Feature_Editor_Settings extends Settings
{
    public function __construct($plugin)
    {
        parent::__construct($plugin);

        $icon_description = '<i class="dashicons dashicons-nametag"></i> ';
        $icon_frontend = '<i class="dashicons dashicons-desktop"></i> ';
        $icon_backend = '<i class="dashicons dashicons-feedback"></i> ';
        $icon_privacy = '<i class="dashicons dashicons-lock"></i> ';
        $icon_plugin = '<i class="dashicons dashicons-admin-plugins"></i> ';
        $icon_filter = '<i class="dashicons dashicons-filter"></i> ';
        $icon_setting = '<i class="dashicons dashicons-admin-settings"></i> ';
        $icon_heart = '<i class="dashicons dashicons-heart"></i> ';
        $icon_clock = '<i class="dashicons dashicons-clock"></i> ';
        $icon_rss = '<i class="dashicons dashicons-rss"></i> ';
        $icon_dismiss = '<i class="dashicons dashicons-dismiss"></i> ';
        $icon_media = '<i class="dashicons dashicons-format-image"></i> ';
        $random_token = Util::random_alphanumeric(5);

        $this->settings = array(
            array(
                'id' => 'section_front_end_settings',
                'title' => $icon_frontend . ' Front End Features',
                'callback' => NULL,
                'class' => 'disabler-settings',
                'settings' => array(
                    'desc' => array('title' => $icon_description . 'Description', 'render' => array($this, 'render_empty'), 'help' => '<strong>These are settings are changes on the front end. These are the things that affect what your site looks like when other people visit.</strong>'),
                    'smartquotes' => array('title' => $icon_setting . 'Disable Smart Quotes', 'render' => array($this, 'render_switch'), 'help' => 'Disable Texturisation -- smart quotes (a.k.a. curly quotes), em dash, en dash and ellipsis.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'capitalp' => array('title' => $icon_setting . 'Disable Auto-Correction', 'render' => array($this, 'render_switch'), 'help' => 'Disable auto-correction of WordPress capitalisation.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'autop' => array('title' => $icon_setting . 'Disable Paragraphs', 'render' => array($this, 'render_switch'), 'help' => 'Disable paragraphs (i.e. &lt;p&gt; tags) from being automatically inserted in your posts.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'emoji' => array('title' => $icon_setting . 'Disable Emoji', 'render' => array($this, 'render_switch'), 'help' => 'Disable Emoji support.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'dashicons' => array('title' => $icon_setting . 'Disable Dashicons', 'render' => array($this, 'render_switch'), 'help' => 'Disable Dashicon support.
<br/><em>Note: Ignored in admin. Dashicon support is required for logged in users when the admin bar is active. We will always include Dashicon support for logged in users if your admin bar is active, regardless of this setting.</em>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'shortlink' => array('title' => $icon_setting . 'Disable Shortlink', 'render' => array($this, 'render_switch'), 'help' => 'Disable shortlink.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'embed' => array('title' => $icon_setting . 'Disable Embeds', 'render' => array($this, 'render_switch'), 'help' => 'Disable embeds.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'restlink' => array('title' => $icon_setting . 'Disable REST Link', 'render' => array($this, 'render_switch'), 'help' => 'Disable rest link.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'xfnlink' => array('title' => $icon_setting . 'Disable XFN Profile Link', 'render' => array($this, 'render_switch'), 'help' => 'Disable XFN (XHTML Friends Network) Profile Link.
<br/><em>Note: This link may be hardcoded in the theme header and not dynamically generated.</em>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'jquerymigrate' => array('title' => $icon_setting . 'Remove jQuery Migrate', 'render' => array($this, 'render_switch'), 'help' => 'Disable JQuery migrate.
<br/><em>Note: Ignored in admin. This may break your frontend javascript.</em>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'adminbar' => array('title' => $icon_setting . 'Remove Admin Bar', 'render' => array($this, 'render_switch'), 'help' => 'Disable the logged in user admin bar from the front end.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'adminbarlogo' => array('title' => $icon_setting . 'Remove Admin Bar WordPress Logo', 'render' => array($this, 'render_switch'), 'help' => 'Removes the admin bar WordPress logo.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'loginshake' => array('title' => $icon_setting . 'Disable Failed Login Shake', 'render' => array($this, 'render_switch'), 'help' => 'Disable the failed login form shake.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'asyncscripts' => array('title' => $icon_setting . 'Asynchronous Script Loads', 'render' => array($this, 'render_switch'), 'help' => 'Performs script loads asynchronously.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'asyncscripthandles' => array('title' => $icon_setting . 'Asynchronous Script Handles', 'render' => array($this, 'render_standard_text_area'), 'render_args' => ['rows' => 2], 'help' => '<br/>Comma separated list of WordPress enqueued script handles.
<br/><em>Specify "all" to apply to all script handles.</em>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_standard_text_field')),
                    'deferscripts' => array('title' => $icon_setting . 'Defer Script Execution', 'render' => array($this, 'render_switch'), 'help' => 'Defer execution of scripts until the HTML document has been fully parsed.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'deferscripthandles' => array('title' => $icon_setting . 'Defer Script Handles', 'render' => array($this, 'render_standard_text_area'), 'render_args' => ['rows' => 2], 'help' => '<br/>Comma separated list of WordPress enqueued script handles.
<br/><em>Specify "all" to apply to all script handles.</em>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_standard_text_field')),
                )
            ),
            array(
                'id' => 'section_back_end_settings',
                'title' => $icon_backend . 'Back End Features',
                'callback' => NULL,
                'class' => 'disabler-settings',
                'settings' => array(
                    'desc' => array('title' => $icon_description . 'Description', 'render' => array($this, 'render_empty'), 'help' => '<strong>Back end settings affect how WordPress runs. Nothing here will break your install, but some turn off non-desirable functionality.</strong>'),
                    'selfping' => array('title' => $icon_setting . 'Disable Self Pings', 'render' => array($this, 'render_switch'), 'help' => 'Disable self pings (i.e. trackbacks/pings from your own domain).', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'norss' => array('title' => $icon_rss . 'Disable RSS Feeds', 'render' => array($this, 'render_switch'), 'help' => 'Disable all RSS feeds.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'xmlrpc' => array('title' => $icon_setting . 'Disable XML-RPC', 'render' => array($this, 'render_switch'), 'help' => 'Disable XML-RPC.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'authrest' => array('title' => $icon_setting . 'Authenticate REST', 'render' => array($this, 'render_switch'), 'help' => 'Calls to REST API must be made by an authenticated user.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'autosave' => array('title' => $icon_setting . 'Disable Post Auto-Saving', 'render' => array($this, 'render_switch'), 'help' => 'Disable auto-saving of posts.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'postrevisions' => array('title' => $icon_setting . 'Disable Post Revisions', 'render' => array($this, 'render_switch'), 'help' => 'Disable post revisions.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'pagerevisions' => array('title' => $icon_setting . 'Disable Page Revisions', 'render' => array($this, 'render_switch'), 'help' => 'Disable page revisions.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'crondisable' => array('title' => $icon_clock . 'Disable WordPress Cron', 'render' => array($this, 'render_switch'), 'help' => 'Disable WordPress cron.
<br/><strong>wp-cron.php</strong> is the WordPress task scheduler that takes care of things like checking for updates and publishing scheduled posts. It runs on every single page load.
<br/>You may be better off setting up <strong>wp-cron.php</strong> as a real operating system Cron job.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field'))
                )
            ),
            array(
                'id' => 'section_privacy_settings',
                'title' => $icon_privacy . 'Privacy Features',
                'callback' => NULL,
                'class' => 'disabler-settings',
                'settings' => array(
                    'desc' => array('title' => $icon_description . 'Description', 'render' => array($this, 'render_empty'), 'help' => '<strong>These settings help obfuscate information about your blog to the world, including wordpress.org.</strong>'),
                    'version' => array('title' => $icon_setting . 'Disable Version Printing', 'render' => array($this, 'render_switch'), 'help' => 'Disable WordPress from printing its version in page headers (only seen via View Source).', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'assetversion' => array('title' => $icon_setting . 'Disable Version Printing On Script & CSS', 'render' => array($this, 'render_switch'), 'help' => 'Disable WordPress from printing the script and css version (only seen via View Source).
<br/>This will affect browser caching of script and css assets.
<br/><em>Note: Ignored in admin.</em>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'nourl' => array('title' => $icon_setting . 'Disable URL Information', 'render' => array($this, 'render_switch'), 'help' => 'Disable WordPress from sending your URL information when checking for updates.', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'readme' => array('title' => $icon_setting . 'Delete &quot;<em>readme.html</em>&quot; and &quot;<em>license.txt</em>&quot; Files', 'render' => array($this, 'render_switch'), 'help' => 'Delete the readme.html and license.txt files that are distributed with WordPress from <em>' . ABSPATH . '</em>.
<br/><a href="' . site_url('license.txt?' . $random_token) . '">' . site_url('license.txt') . '</a>
<br/><a href="' . site_url('readme.html?' . $random_token) . '">' . site_url('readme.html') . '</a>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field'))
                )
            ),
            array(
                'id' => 'section_heartbeat_settings',
                'title' => $icon_heart . 'Heartbeat',
                'callback' => NULL,
                'class' => 'disabler-settings',
                'settings' => array(
                    'desc' => array('title' => $icon_description . 'Description', 'render' => array($this, 'render_empty'), 'help' => '<strong>Tweak WordPress heartbeat features.</strong>'),
                    'hbdisable' => array('title' => $icon_heart . 'Disable Heartbeat', 'render' => array($this, 'render_switch'), 'help' => 'Disable heartbeat.
<br/><em>By disabling Heartbeat completely, you may disrupt the functionality of some features in WordPress.</em>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'hbautostart' => array('title' => $icon_heart . 'Heartbeat Autostart', 'render' => array($this, 'render_switch'), 'help' => 'Should the heartbeat automatically start?', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'hbfrequency' => array('title' => $icon_heart . 'Heartbeat Frequency', 'render' => array($this, 'render_slider'), 'render_args' => ['step' => 5, 'min' => 15, 'max' => 300], 'help' => '<div style="padding-top: 8px;">The frequency in seconds at which the heart beats.</div>', 'sanitize' => array($this, 'sanitize_numeric_field'), 'validate' => array($this, 'validate_standard_numeric_field'), 'validate_args' => ['type' => 'INT', 'min' => 15, 'max' => 300])
                )
            ),
            array(
                'id' => 'section_adblock_settings',
                'title' => $icon_dismiss . 'Ad Blocker Detection',
                'callback' => NULL,
                'class' => 'disabler-settings',
                'settings' => array(
                    'adblock' => array('title' => $icon_setting . 'Detect Ad Blocker', 'render' => array($this, 'render_switch'), 'help' => 'Detect the use of an Ad Blocker?', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'adblockdelayopen' => array('title' => $icon_setting . 'Ad Blocker Notification Delay', 'render' => array($this, 'render_slider'), 'render_args' => ['step' => 5, 'min' => 0, 'max' => 60], 'help' => '<div style="padding-top: 8px;">The delay in seconds before the Ad Blocker notification panel is displayed after the window load event fires.</div>', 'sanitize' => array($this, 'sanitize_numeric_field'), 'validate' => array($this, 'validate_standard_numeric_field'), 'validate_args' => ['type' => 'INT', 'min' => 0, 'max' => 60]),
                    'adblockoverlaycolor' => array('title' => $icon_setting . 'Ad Blocker Overlay Colour', 'help' => 'The overlay colour of the Ad Blocker notification panel.', 'render' => array($this, 'render_colorpicker'), 'render_args' => ['alpha' => TRUE, 'default' => 'rgba(0,0,0,0.85)'], 'sanitize' => array($this, 'sanitize_color_field'), 'validate' => array($this, 'validate_color')),
                    'adblockbgcolor' => array('title' => $icon_setting . 'Ad Blocker Background Colour', 'help' => 'The background colour of the Ad Blocker notification panel.', 'render' => array($this, 'render_colorpicker'), 'render_args' => ['alpha' => FALSE, 'default' => '#ffffff'], 'sanitize' => array($this, 'sanitize_color_field'), 'validate' => array($this, 'validate_color')),
                    'adblockbtncolor' => array('title' => $icon_setting . 'Ad Blocker Button Colour', 'help' => 'The colour of the main button in the Ad Blocker notification panel.', 'render' => array($this, 'render_colorpicker'), 'render_args' => ['alpha' => FALSE, 'default' => '#ff9d47'], 'sanitize' => array($this, 'sanitize_color_field'), 'validate' => array($this, 'validate_color')),
                    'adblockimg' => array('title' => $icon_media . 'Ad Blocker Image', 'help' => '<br/>This image will be displayed in the Ad Blocker notification panel.', 'render' => array($this, 'render_select_media'), 'sanitize' => array($this, 'sanitize_numeric_field'), 'validate' => array($this, 'validate_standard_numeric_field')),
                    'adblockpriheader' => array('title' => $icon_setting . 'Ad Blocker Main Header Message', 'help' => '<br/>The primary Ad Blocker header displayed in the notification panel.<br/><em>HTML tags are allowed.</em>', 'render' => array($this, 'render_standard_text_field'), 'sanitize' => array($this, 'sanitize_no_script'), 'validate' => array($this, 'validate_standard_text_field')),
                    'adblockprimsg' => array('title' => $icon_setting . 'Ad Blocker Main Message', 'help' => '<br/>The primary Ad Blocker message displayed in the notification panel.<br/><em>HTML tags are allowed.</em>', 'render' => array($this, 'render_standard_text_area'), 'sanitize' => array($this, 'sanitize_no_script'), 'validate' => array($this, 'validate_standard_text_field')),
                    'adblockpribtn' => array('title' => $icon_setting . 'Ad Blocker Main Button', 'help' => '<br/>The primary Ad Blocker notification panel button.', 'render' => array($this, 'render_standard_text_field'), 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_standard_text_field')),
                    'adblockpriclose' => array('title' => $icon_setting . 'Ad Blocker Close Text', 'help' => '<br/>The primary Ad Blocker notification panel close text.', 'render' => array($this, 'render_standard_text_field'), 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_standard_text_field')),
                    'adblocksecmsg' => array('title' => $icon_setting . 'Ad Blocker Secondary Message', 'help' => '<br/>The secondary Ad Blocker message displayed in the notification panel.<br/><em>HTML tags are allowed.</em>', 'render' => array($this, 'render_standard_text_area'), 'sanitize' => array($this, 'sanitize_no_script'), 'validate' => array($this, 'validate_standard_text_field')),
                    'adblocksecbtn' => array('title' => $icon_setting . 'Ad Blocker Secondary Button', 'help' => '<br/>The secondary Ad Blocker notification panel button.', 'render' => array($this, 'render_standard_text_field'), 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_standard_text_field')),
                )
            ),
            array(
                'id' => 'section_plugin_settings',
                'title' => $icon_plugin . 'Plugin Filters',
                'callback' => NULL,
                'class' => 'disabler-settings',
                'settings' => array(
                    'desc' => array('title' => $icon_description . 'Description', 'render' => array($this, 'render_empty'), 'help' => '<strong>Decrease page load times by filtering out plugin loads on pages where they are not required.
<br/><em>Filtering is disabled in the admin section.</em></strong>'),
                    'pluginfiltersdebug' => array('title' => $icon_setting . 'Display Debug Message', 'render' => array($this, 'render_switch'), 'help' => 'Displays a debug message on your site showing the result of the plugin filter operation.
<br/><strong><em>Useful for testing and debugging. Only displayed when not in the admin section. Do not have this set to "Yes" on your production site.</em></strong>', 'sanitize' => 'sanitize_text_field', 'validate' => array($this, 'validate_true_false_field')),
                    'pluginfilters' => array('title' => $icon_filter . 'Filter Parameters', 'render' => array($this, 'render_plugin_filters'), 'sanitize' => array($this, 'sanitize_plugin_filters'), 'validate' => array($this, 'validate_plugin_filters'))
                )
            )
        );

        // Disable plugin filtering if WPMU_PLUGIN_DIR does not exist.
        if (!$this->get_plugin()->get_wpmu_plugin_dir_ok()) {
            $index = array_search('section_plugin_settings', array_column($this->settings, 'id'));
            $this->settings[$index]['settings'] = array(
                'desc' => array('title' => $icon_description . 'Description', 'render' => array($this, 'render_empty'), 'help' => '<strong>PLUGIN FILTERING IS DISABLED - ' . WPMU_PLUGIN_DIR . ' NOT FOUND.</strong>')
            );
        }
    }

    public function render_plugin_filters(array $args): void
    {
        $plugins = get_plugins();
        $active_plugins = get_option('active_plugins');

        echo '<style>';
        echo '.table-tight td { border-bottom: 1px solid black; }';
        echo '.table-inner td { border-bottom: 0px }';
        echo '</style>';
        echo '<table class="table-tight">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Plugin Name</th>';
        echo '<th style="width:auto">Filter Activation Rule</th>';
        echo '<th>Page: URL Regular Expression Match<br/>Ajax: Action Regular Expression Match</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Build this plugin identifier and ensure we do not permit filtering.
        $plugin_identifier = pathinfo($this->get_plugin()->get_filename());
        $plugin_identifier = basename($plugin_identifier['dirname']) . '/' . $plugin_identifier['basename'];

        foreach ($active_plugins as $plugin_file) {
            if ($plugin_file === $plugin_identifier) {
                continue;
            }
            $plugin_name = $plugins[$plugin_file]['Name'];
            $plugin_display_name = sprintf('%s <small><em>v%s</em></small>', $plugin_name, $plugins[$plugin_file]['Version']);
            echo '<tr>';
            echo '<td>';
            echo $plugin_display_name;
            echo '</td>';
            echo '<td style="text-align: center;">';
            $switch_value = isset($args[1]['switch'][$plugin_file]) ? $args[1]['switch'][$plugin_file] : -1;
            $name = $this->get_plugin()->get_option_group() . '[pluginfilters][switch][' . $plugin_file . ']';
            $count = 0;
            foreach ([-1 => 'Filtering<br/>Off', 1 => 'Active<br/>On', 0 => 'Inactive<br/>On'] as $value => $label) {
                $id = chr(97 + $count) . '[' . $plugin_file . ']';
                echo '<input style="display: none" class="hobo-checkbox" type="radio" value="' . $value . '" name="' . $name . '" id="' . $id . '"' . ($switch_value === $value ? ' checked' : '') . '><label class="hobo-button-label" for="' . $id . '"><span>' . $label . '</span></label>';
                $count++;
            }
            echo '</td>';
            echo '<td>';
            $page_regexp_value = isset($args[1]['regexp'][$plugin_file]['page']) ? $args[1]['regexp'][$plugin_file]['page'] : '';
            $ajax_regexp_value = isset($args[1]['regexp'][$plugin_file]['ajax']) ? $args[1]['regexp'][$plugin_file]['ajax'] : '';
            echo '<table class="table-inner">';
            echo '<td>Page</td><td>';
            $this->render_standard_text_area(['pluginfilters][regexp][' . $plugin_file . '][page]', $page_regexp_value, 'render_args' => ['rows' => 2]]);
            echo '</td></tr>';
            echo '<tr><td>Ajax</td><td>';
            $this->render_standard_text_area(['pluginfilters][regexp][' . $plugin_file . '][ajax]', $ajax_regexp_value, 'render_args' => ['rows' => 2]]);
            echo '</td></tr></table>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    /**
     * @param array $value
     *
     * @return array
     */
    public function sanitize_plugin_filters(array $value): array
    {
        foreach ($value['switch'] as $plugin_file => &$switch_value) {
            $switch_value = intval($switch_value);
        };
        foreach ($value['regexp'] as $plugin_file => &$regexp_value) {
            $regexp_value['page'] = sanitize_text_field($regexp_value['page']);
            $regexp_value['ajax'] = sanitize_text_field($regexp_value['ajax']);
        };
        return $value;
    }

    /**
     * @param string $id
     * @param        $existing
     * @param array  $value
     * @param array  $args
     * @param array  $values
     *
     * @return array
     */
    public function validate_plugin_filters(string $id, $existing, array $value, array $args, array $values): array
    {
        $debug_key = $id . 'debug';
        $debug = $values[$debug_key] === '1';
        if ($existing !== $value || $this->get_plugin()->get_setting($debug_key) !== $debug) {
            $current_user = wp_get_current_user();
            $now = date('Y-m-d H:i:s');
            $plugin_name = $this->get_plugin()->get_name();
            $must_use_file = $this->get_plugin()->get_must_use_file();
            $must_use_plugin_file_content = <<<EOT
<?php
/**
 * Description: Disables plugins based on regular expression pattern matching of \$_SERVER['REQUEST_URI'] or AJAX \$_REQUEST['action'] value.
 *
 * This file was automatically generated by the $plugin_name plugin on $now by $current_user->user_login.
 */

use Hobo\Framework\Plugin_Disable;
use Hobo\Framework\Plugin_Disable_Config;
use Hobo\Framework\Plugin_Disable_Container;

\$plugin_disable = new Plugin_Disable([

EOT;
            foreach ($value['regexp'] as $plugin_file => $regexp_value) {
                $switch_value = $value['switch'][$plugin_file];
                if ($switch_value > -1) {
                    $page = 'NULL';
                    if (!empty($regexp_value['page'])) {
                        $page = sprintf("new Plugin_Disable_Config('%s', Plugin_Disable_Config::%s)", $regexp_value['page'], $switch_value === 1 ? 'ACTIVE_ON' : 'INACTIVE_ON');
                    }
                    $ajax = 'NULL';
                    if (!empty($regexp_value['ajax'])) {
                        $ajax = sprintf("new Plugin_Disable_Config('%s', Plugin_Disable_Config::%s)", $regexp_value['ajax'], $switch_value === 1 ? 'ACTIVE_ON' : 'INACTIVE_ON');
                    }
                    if (!is_null($page) || !is_null($ajax)) {
                        $must_use_plugin_file_content .= sprintf("    '%s' => new Plugin_Disable_Container(%s, %s),%s", $plugin_file, $page, $ajax, PHP_EOL);
                    }
                }
            };
            $must_use_plugin_file_content .= '], ' . ($debug ? 'TRUE' : 'FALSE') . ');' . PHP_EOL;

            $wpmu_plugin_dir_ok = $this->get_plugin()->get_wpmu_plugin_dir_ok();
            if (!$wpmu_plugin_dir_ok) {
                if (is_writable(WP_CONTENT_DIR)) {
                    $wpmu_plugin_dir_ok = mkdir(WPMU_PLUGIN_DIR, 0755);
                } else {
                    $wpmu_plugin_dir_ok = FALSE;
                    $write_error = '';
                    $write_error .= '<p>Unable to automatically create the &quot;Must-Use&quot; plugin  <code>~' . $must_use_file . '</code> file.</p><p>Your <code>' . WP_CONTENT_DIR . '</code> directory is not <a href="https://wordpress.org/support/article/changing-file-permissions/" target="_blank">writable</a>.</p>';
                    $write_error .= '<p>Amend file permissions on <code>' . WP_CONTENT_DIR . '</code>, and create the writable sub-directory <code>' . WPMU_PLUGIN_DIR . '</code> directory.</p>';
                    $write_error .= '<p>Then create the <code>' . WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . $must_use_file . '</code> file with the following content:</p>';
                    $write_error .= '<textarea  readonly="readonly" name="rules_txt" rows="7" style="width:100%; padding:11px 15px;">' . $must_use_plugin_file_content . '</textarea>';
                    $this->add_settings_error($id . '_err', NULL, $write_error);
                }
            }

            if ($wpmu_plugin_dir_ok) {
                $must_use_file = WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . $must_use_file;
                if (@file_get_contents($must_use_file) !== $must_use_plugin_file_content) {
                    $file_written = file_put_contents($must_use_file, $must_use_plugin_file_content);
                    if ($file_written === FALSE) {
                        $this->add_settings_error($id . '_file', NULL, sprintf('Error - Unable to write to %s.', $must_use_file));
                    } else {
                        $this->add_settings_update($id . '_file', NULL, sprintf('Updated - Successfully updated "Must-Use" file %s.', $must_use_file));
                    }
                }
            }
        }

        $this->report_setting_changed($id, $existing, $value);
        return $value;
    }

}
