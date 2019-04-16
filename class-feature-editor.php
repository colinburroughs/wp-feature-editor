<?php
/**
 * @wordpress-plugin
 * Plugin Name:   WP Feature Editor
 * Plugin URI:    https://www.hobo.co.uk
 * Description:   A simple plugin to toggle Wordpress features on and off, filter out plugin loads on pages where they are not required, detect ad blocker.
 * Version:       0.0.0
 * Author:        Hobo Digital Ltd
 * Author URI:    https://www.hobo.co.uk
 */

use Hobo\Framework\Plugin;
use Hobo\Framework\Singleton;

class Feature_Editor_Plugin extends Plugin
{
    private $_must_use_file = NULL;
    private $_wpmu_plugin_dir_ok = FALSE;

    function __construct()
    {
        parent::__construct();
        $this->_wpmu_plugin_dir_ok = file_exists(WPMU_PLUGIN_DIR);

        add_action('plugins_loaded', array($this, 'wordpress_plugins_loaded'));
        add_action('init', array($this, 'wordpress_init'));
    }

    /**
     * @return bool
     */
    public function get_wpmu_plugin_dir_ok(): bool
    {
        return $this->_wpmu_plugin_dir_ok;
    }

    /**
     * @return string
     */
    public function get_must_use_file(): string
    {
        if (is_null($this->_must_use_file)) {
            $this->_must_use_file = '~' . pathinfo($this->get_filename())['basename'];
        }
        return $this->_must_use_file;
    }

    public function get_setting_defaults(): array
    {
        return array(
            // Frontend settings
            'smartquotes' => FALSE,
            'capitalp' => FALSE,
            'autop' => FALSE,
            'emoji' => FALSE,
            'dashicons' => FALSE,
            'shortlink' => FALSE,
            'embed' => FALSE,
            'restlink' => FALSE,
            'xfnlink' => FALSE,
            'jquerymigrate' => FALSE,
            'adminbar' => FALSE,
            'adminbarlogo' => FALSE,
            'loginshake' => FALSE,
            'asyncscripts' => FALSE,
            'asyncscripthandles' => '',
            'deferscripts' => FALSE,
            'deferscripthandles' => '',

            // Backend settings
            'selfping' => FALSE,
            'norss' => FALSE,
            'xmlrpc' => FALSE,
            'authrest' => FALSE,
            'autosave' => FALSE,
            'postrevisions' => FALSE,
            'pagerevisions' => FALSE,
            'crondisable' => FALSE,

            // Privacy settings
            'version' => FALSE,
            'assetversion' => FALSE,
            'nourl' => FALSE,
            'readme' => FALSE,

            // Heartbeat settings
            'hbdisable' => FALSE,
            'hbfrequency' => 30,
            'hbautostart' => TRUE,

            // Adblock detection settings
            'adblock' => FALSE,
            'adblockdelayopen' => 5,
            'adblockoverlaycolor' => 'rgba(0,0,0,0.85)',
            'adblockbgcolor' => '#ffffff',
            'adblockimg' => '',
            'adblockpriheader' => 'Hey, can we talk?',
            'adblockprimsg' => 'Our website is made possible by displaying unobtrusive online advertisements to our visitors. Please consider supporting us by disabling your ad blocker.',
            'adblockpribtn' => 'Disable Ad Blocker',
            'adblockpriclose' => 'Sorry, I\'ll do it next time I promise',
            'adblockbtncolor' => '#ff9d47',
            'adblocksecmsg' => 'Please support us by whitelisting us in your ad blocker.',
            'adblocksecbtn' => 'I\'ve done it!',

            // Plugin settings
            'pluginfiltersdebug' => FALSE,
            'pluginfilters' => ['switch' => [], 'regexp' => []]
        );
    }

    public function wordpress_plugins_loaded()
    {
        /* HEARTBEAT SETTINGS */
        if ($this->get_setting('hbdisable') === TRUE) {
            add_action('admin_enqueue_scripts', function () {
                wp_deregister_script('heartbeat');
            }, 99);
            add_action('wp_enqueue_scripts', function () {
                wp_deregister_script('heartbeat');
            }, 99);
        } else {
            add_filter('heartbeat_settings', function ($settings) {
                $settings['interval'] = $this->get_setting('hbfrequency');
                $settings['autostart'] = $this->get_setting('hbautostart');
                return $settings;
            });
        }

        /* CRON */
        if ($this->get_setting('crondisable') === TRUE) {
            remove_action('init', 'wp_cron');
        }

        /* ADBLOCKER DETECTION */
        if ($this->get_setting('adblock') === TRUE && !isset($_COOKIE['hobo-ad-blocker'])) {
            add_action('wp_enqueue_scripts', function () {
                wp_enqueue_script('hobo-adblock-detect', $this->get_plugin_url() . 'js/detectAdblock.min.js', array(), $this->get_asset_version(), TRUE);
                wp_enqueue_style('hobo-adblock-detect', $this->get_plugin_url() . 'css/detectAdblock.min.css', array(), $this->get_asset_version());
                wp_localize_script('hobo-adblock-detect', 'hobo_adblock_detect', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'delay' => ($this->get_setting('adblockdelayopen') * 1000)
                ));
                add_action('wp_footer', function () {
                    $icon = get_site_icon_url();
                    $blog_title = get_bloginfo();
                    $overlay_color = $this->get_setting('adblockoverlaycolor');
                    $bg_color = $this->get_setting('adblockbgcolor');
                    $btn_color = $this->get_setting('adblockbtncolor');
                    $primary_header = $this->get_setting('adblockpriheader');
                    $primary_msg = $this->get_setting('adblockprimsg');
                    $primary_btn = $this->get_setting('adblockpribtn');
                    $primary_close = $this->get_setting('adblockpriclose');
                    $secondary_msg = $this->get_setting('adblocksecmsg');
                    $secondary_btn = $this->get_setting('adblocksecbtn');
                    $image = wp_get_attachment_image_src($this->get_setting('adblockimg'), 'full');
                    echo <<<EOT
<div id="uklqfrjjcysfnmi-overlay" style="background-color: $overlay_color">
    <div id="uklqfrjjcysfnmi-popup-wrapper" style="background-color: $bg_color">
        <div style="margin:5px;display: flex;align-items: center;">
            <div class="uklqfrjjcysfnmi-popup-side" style="background: url($image[0]);background-size: cover;width: $image[1]px; height: $image[2]px;"></div>
        </div>
        <div class="uklqfrjjcysfnmi-popup">
            <div class="uklqfrjjcysfnmi-popup-content uklqfrjjcysfnmi-main">
                <div class="uklqfrjjcysfnmi-popup-main-content uklqfrjjcysfnmi-popup-main-content--front">
                    <h1 class="uklqfrjjcysfnmi-popup-title"><span class="uklqfrjjcysfnmi-header-icon" title="A message from $blog_title"><img src="$icon"/></span>$primary_header</h1>
                    <p class="uklqfrjjcysfnmi-popup-text">$primary_msg</p>
                    <div><a href="#" class="uklqfrjjcysfnmi-button uklqfrjjcysfnmi-button-disable" style="background: $btn_color">$primary_btn</a></div>
                </div>
                <div class="uklqfrjjcysfnmi-popup-text"><a href="#" class="uklqfrjjcysfnmi-close-popup">$primary_close</a></div>
            </div>
            <div class="uklqfrjjcysfnmi-popup-content uklqfrjjcysfnmi-choices" style="display: none;">
                <div class="uklqfrjjcysfnmi-popup-main-content">
                    <div class="uklqfrjjcysfnmi-popup-text"></div>
                    <div class="uklqfrjjcysfnmi-popup-help  uklqfrjjcysfnmi-popup-text">$secondary_msg</div>
                    <div><a href="#" class="uklqfrjjcysfnmi-button uklqfrjjcysfnmi-close-popup" style="background: $btn_color">$secondary_btn</a></div>
                </div>
                <div class="uklqfrjjcysfnmi-back" title="Back">‹ <span class="uklqfrjjcysfnmi-back-text">Back</span></div>
            </div>
        </div>
    </div>
</div>
EOT;
                });
            });
        }

        /* Remove JQuery migrate. */
        if ($this->get_setting('jquerymigrate') === TRUE) {
            add_filter('wp_default_scripts', function (&$scripts) {
                if (!is_admin() && isset($scripts->registered['jquery'])) {
                    $script = $scripts->registered['jquery'];
                    if ($script->deps) {
                        $script->deps = array_diff($script->deps, array('jquery-migrate'));
                    }
                }
            });
        }

        /**
         * Remove the XFN link
         *
         * For more information about XFN relationships and examples concerning their use, see the:
         * http://gmpg.org/xfn/
         * @return bool
         */
        if ($this->get_setting('xfnlink') === TRUE) {
            add_filter('avf_profile_head_tag', function () {
                return FALSE;
            });
        }

    }

    public function wordpress_init()
    {
        /* FRONT END SETTINGS */
        /* Texturisation */
        if ($this->get_setting('smartquotes') === TRUE) {
            remove_filter('comment_text', 'wptexturize');
            remove_filter('the_content', 'wptexturize');
            remove_filter('the_excerpt', 'wptexturize');
            remove_filter('the_title', 'wptexturize');
            remove_filter('the_content_feed', 'wptexturize');
        }

        /* Disable Capital P in WordPress auto-correct */
        if ($this->get_setting('capitalp') === TRUE) {
            remove_filter('the_content', 'capital_P_dangit');
            remove_filter('the_title', 'capital_P_dangit');
            remove_filter('comment_text', 'capital_P_dangit');
        }

        /* Remove the <p> from being automagically added in posts */
        if ($this->get_setting('autop') === TRUE) {
            remove_filter('the_content', 'wpautop');
        }

        /* Remove emoji */
        if ($this->get_setting('emoji') === TRUE) {
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action('admin_print_scripts', 'print_emoji_detection_script');
            remove_action('admin_print_styles', 'print_emoji_styles');
            remove_filter('the_content_feed', 'wp_staticize_emoji');
            remove_filter('comment_text_rss', 'wp_staticize_emoji');
            remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
            add_filter('tiny_mce_plugins', function ($plugins) {
                if (is_array($plugins)) {
                    return array_diff($plugins, array('wpemoji'));
                } else {
                    return array();
                }
            });
            add_filter('wp_resource_hints', function ($urls, $relation_type) {
                if ('dns-prefetch' === $relation_type) {
                    $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2.2.1/svg/');
                    $urls = array_diff($urls, array($emoji_svg_url));
                }
                return $urls;
            }, 10, 2);
            add_filter('emoji_svg_url', '__return_false');
        }

        /* Remove logged in user admin bar. */
        if ($this->get_setting('adminbar') === TRUE) {
            add_filter('show_admin_bar', '__return_false');
        }

        if ($this->get_setting('adminbarlogo') === TRUE) {
            add_action('wp_before_admin_bar_render', function () {
                global $wp_admin_bar;
                $wp_admin_bar->remove_menu('wp-logo');
            });
        }

        /* Remove failed login form shake. */
        if ($this->get_setting('loginshake') === TRUE) {
            add_action('login_head', function () {
                remove_action('login_head', 'wp_shake_js', 12);
            });
        }

        /* Asynchronous script loads. */
        if ($this->get_setting('asyncscripts') === TRUE) {
            $async_handles = array_map('trim', explode(',', $this->get_setting('asyncscripthandles')));
            add_filter('script_loader_tag', function ($tag, $handle) use (&$async_handles) {
                if (in_array('all', $async_handles)) {
                    return str_replace(' src', ' async src', $tag);
                } else {
                    foreach ($async_handles as $index => $async_handle) {
                        if ($handle === $async_handle) {
                            $tag = str_replace(' src', ' async src', $tag);
                            unset($async_handles[$index]);
                            break;
                        }
                    }
                }
                return $tag;
            }, 10, 2);
        }

        /* Defer script execution. */
        if ($this->get_setting('deferscripts') === TRUE) {
            $defer_handles = array_map('trim', explode(',', $this->get_setting('deferscripthandles')));
            add_filter('script_loader_tag', function ($tag, $handle) use (&$defer_handles) {
                if (in_array('all', $defer_handles)) {
                    return str_replace(' src', ' defer src', $tag);
                } else {
                    foreach ($defer_handles as $index => $defer_handle) {
                        if ($handle === $defer_handle) {
                            $tag = str_replace(' src', ' defer src', $tag);
                            unset($defer_handles[$index]);
                            break;
                        }
                    }
                    return $tag;
                }
            }, 10, 2);
        }

        /* Remove Dashicon support */
        if ($this->get_setting('dashicons') === TRUE) {
            add_action('wp_enqueue_scripts', function () {
                if (!is_admin()) {
                    if ($this->get_setting('adminbar') === FALSE && !is_user_logged_in()) {
                        wp_dequeue_style('dashicons');
                        wp_deregister_style('dashicons');
                    }
                }
            });
        }

        /* Remove shortlink */
        if ($this->get_setting('shortlink') === TRUE) {
            remove_action('wp_head', 'wp_shortlink_wp_head');
            remove_action('template_redirect', 'wp_shortlink_header', 11);
        }

        /* Remove the rest link */
        if ($this->get_setting('restlink') === TRUE) {
            remove_action('wp_head', 'rest_output_link_wp_head');
            remove_action('template_redirect', 'rest_output_link_header', 11);
        }

        /* Disable embeds */
        if ($this->get_setting('embed') === TRUE) {
            global $wp;
            $wp->public_query_vars = array_diff($wp->public_query_vars, array('embed',));
            remove_action('rest_api_init', 'wp_oembed_register_route');
            remove_action('wp_head', 'wp_oembed_add_discovery_links');
            remove_action('wp_head', 'wp_oembed_add_host_js');
            remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
            remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
            add_filter('embed_oembed_discover', '__return_false');
            add_filter('tiny_mce_plugins', function ($plugins) {
                return array_diff($plugins, array('wpembed'));
            });
            add_filter('rewrite_rules_array', function ($rules) {
                foreach ($rules as $rule => $rewrite) {
                    if (FALSE !== strpos($rewrite, 'embed=true')) {
                        unset($rules[$rule]);
                    }
                }
                return $rules;
            });
        }

        /* BACK END SETTINGS */
        /* Disable Self Pings */
        if ($this->get_setting('selfping') === TRUE) {
            add_action('pre_ping', function (&$links) {
                $home = get_option('home');
                foreach ($links as $l => $link) {
                    if (0 === strpos($link, $home)) {
                        unset($links[$l]);
                    }
                }
            });
        }

        /* No RSS */
        if ($this->get_setting('norss') === TRUE) {
            add_action('do_feed', array($this, 'kill_rss'), 1);
            add_action('do_feed_rdf', array($this, 'kill_rss'), 1);
            add_action('do_feed_rss', array($this, 'kill_rss'), 1);
            add_action('do_feed_rss2', array($this, 'kill_rss'), 1);
            add_action('do_feed_atom', array($this, 'kill_rss'), 1);
        }

        /* XML RPC */
        if ($this->get_setting('xmlrpc') === TRUE) {
            add_filter('xmlrpc_enabled', '__return_false');
            add_filter('wp_headers', function ($headers) {
                unset($headers['X-Pingback']);
                return $headers;
            });
            add_filter('pings_open', '__return_false', 9999);
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wlwmanifest_link');
        }

        /* REST */
        if ($this->get_setting('authrest') === TRUE) {
            add_filter('rest_authentication_errors', function ($result) {
                if (!empty($result)) {
                    return $result;
                }
                if (!is_user_logged_in()) {
                    return new WP_Error('rest_not_authenticated', 'Only authenticated users can access the REST API.', array('status' => 401));
                }
                return $result;
            });
        }

        /* Post Auto Saves */
        if ($this->get_setting('autosave') === TRUE) {
            add_action('wp_print_scripts', function () {
                wp_deregister_script('autosave');
            });
        }

        /* Post Revisions */
        if ($this->get_setting('postrevisions') === TRUE) {
            remove_action('pre_post_update', 'wp_save_post_revision');
        }

        /* Page Revisions */
        if ($this->get_setting('pagerevisions') === TRUE) {
            remove_post_type_support('page', 'revisions');
        }

        /* PRIVACY SETTINGS */
        /* Remove WordPress version from header */
        if ($this->get_setting('version') === TRUE) {
            remove_action('wp_head', 'wp_generator');
        }

        /* Hide blog URL from Wordpress 'phone home' */
        if ($this->get_setting('nourl') === TRUE) {
            add_filter('http_headers_useragent', function ($user_agent, $url) {
                global $wp_version;
                return 'WordPress/' . $wp_version;
            }, 10, 2);
        }

        /* Remove version from script/css query string. */
        if ($this->get_setting('assetversion') === TRUE && !is_admin()) {
            add_filter('script_loader_src', array($this, 'remove_version_from_query_string'), 15);
            add_filter('style_loader_src', array($this, 'remove_version_from_query_string'), 15);
        }

        /* Remove readme.html. */
        if ($this->get_setting('readme') === TRUE) {
            if (file_exists(ABSPATH . 'readme.html')) {
                unlink(ABSPATH . 'readme.html');
            }
            if (file_exists(ABSPATH . 'license.txt')) {
                unlink(ABSPATH . 'license.txt');
            }
        }

    }

    public function kill_rss()
    {
        wp_die('No feeds available.');
    }

    function remove_version_from_query_string($src)
    {
        $output = preg_split("/(&ver|\?ver)/", $src);
        return $output[0];
    }

    public function activation()
    {
        if (!$this->_wpmu_plugin_dir_ok) {
            if (is_writable(WP_CONTENT_DIR)) {
                $this->_wpmu_plugin_dir_ok = mkdir(WPMU_PLUGIN_DIR, 0755);
            }
        }
        if (!$this->_wpmu_plugin_dir_ok) {
            trigger_error('The "Must-Use" plugin folder ' . WPMU_PLUGIN_DIR . ' does not exist, and I was unable to create it. Please manually create this folder with -rwxr-xr-x (755) permissions and activate the plugin again. Plugin filtering is currently disabled.', E_USER_WARNING);
        }
    }

    public function deactivation()
    {
        $must_use_file = realpath(WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . $this->get_must_use_file());
        if (file_exists($must_use_file)) {
            if (!unlink($must_use_file)) {
                trigger_error('Cannot delete the "Must-Use" plugin file ' . $must_use_file . '. Please manually delete this file.', E_USER_WARNING);
            }
        }
    }

    public function uninstall()
    {
        delete_option($this->get_option_group());
    }

    public function get_cache_prefix(): string
    {
        return '';
    }

    public function cache_output()
    {
        return FALSE;
    }

}

$feature_editor_plugin = Singleton::get_instance('Feature_Editor_Plugin');
$feature_editor_template_redirect = Singleton::get_instance('Feature_Editor\Feature_Editor_Template_Redirect', [$feature_editor_plugin]);
$disabler_ajax = Singleton::get_instance('Feature_Editor\Feature_Editor_Ajax');
