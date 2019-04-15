<?php

namespace Feature_Editor\Admin;

use Hobo\Framework\Plugin_Admin;

class Feature_Editor_Admin extends Plugin_Admin
{

    public function __construct($plugin)
    {
        parent::__construct($plugin);
    }

    // ======================================================================
    // ADMIN MENU
    // ======================================================================
    public function admin_menu(): void
    {
        $this->set_is_options_general(TRUE);
        $title = $this->get_plugin()->get_plugin_data()['Name'];
        add_options_page($title . ' Settings', $title, 'manage_options', $this->get_plugin()->get_settings_slug(), array($this, 'mvc_action_settings'));
    }

    // ======================================================================
    // MVC ACTIONS
    // ======================================================================
    public function mvc_action_settings()
    {
        parent::mvc_action_settings();
        $this->view('settings');
    }

}
