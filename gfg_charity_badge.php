<?php
  /*
  Plugin Name: Goals for Giving Charity Badge
  Plugin URI: http://charities.goalsforgiving.com
  Description: Show your support for a charity with this badge and ribbon
  Author: Charley Radcliffe
  Version: 0.2
  Author URI: http://www.goalsforgiving.com
  */

if ( !class_exists("gfg_badge") ) {
  class gfg_badge {
    public function __construct() {
      register_activation_hook( __FILE__, array( &$this, 'install' ) );
      register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );
      register_uninstall_hook( __FILE__, 'uninstall' );
      add_action( 'admin_menu', array(get_class(), 'admin_options' ) );
      add_action( 'wp_footer', array(get_class(), 'badge_display' ) );
    }
    public function install() {
      add_option('gfg_badge_charity', 'demo');
      add_option('gfg_badge_type', 'badge');
      add_option('gfg_badge_side', 'right');
      add_option('gfg_badge_position', 'fixed');
      add_option('gfg_badge_show', 'show');
    }

    public function deactivate() {
      // remove stuff
    }

    public function uninstall() {

    }

    public function badge_admin() {
      include('gfg_badge_admin.php');
    }

    public function admin_options() {
      add_options_page(
        "GfG Badge Settings",
        "GfG Badge Settings",
        "administrator",
        "gfg-badge-settings",
        (array(get_class(),"badge_admin"))
      );
    }

    public function badge_display() {

      $show = get_option('gfg_badge_show');
      if ( $show != 'show' ) {
        return;
      }

      $slug = get_option('gfg_badge_charity');
      $side = get_option('gfg_badge_side');
      $position = get_option('gfg_badge_position');
      $type = get_option('gfg_badge_type');

      $url = "http://charities.goalsforgiving.com/oembed?";
      $url .= "type=" . $type;
      $url .= "&slug=" . $slug;
      $url .= "&side=" . $side;
      $url .= "&position=" . $position;
      $url .= "&maxwidth=0&maxheight=0";

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $widget = curl_exec($ch);
      curl_close($ch);

      $widget = json_decode($widget, true);
      echo $widget['html'];

    }
  }
}

$gfg_badge = new gfg_badge;

?>