<?php

namespace Feature_Editor;

use Hobo\Framework\Ajax;
use Hobo\Framework\AJAX_PRIVILEGE_TYPE;

class Feature_Editor_Ajax extends Ajax
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function get_action(): array
    {
        // Ajax action names array. [name => privileged (TRUE or FALSE or TRUE_FALSE)]
        $actions = array(
            'set_ad_blocker_cookie' => AJAX_PRIVILEGE_TYPE::TRUE_FALSE,
        );

        return $actions;
    }

    public function ajax_set_ad_blocker_cookie()
    {
        setcookie('hobo-ad-blocker', TRUE, NULL, '/', NULL, is_ssl(), TRUE);
        wp_send_json(['result' => 1], 200);
    }

}
