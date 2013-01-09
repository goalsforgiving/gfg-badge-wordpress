<?php

  if($_POST['gfg_badge_hidden'] == 'Y') {
    //Form data sent
    $gfgcharity = $_POST['gfg_badge_charity'];
    update_option('gfg_badge_charity', $gfgcharity);
    $gfgtype = $_POST['gfg_badge_type'];
    update_option('gfg_badge_type', $gfgtype);
    $gfgside = $_POST['gfg_badge_side'];
    update_option('gfg_badge_side', $gfgside);
    $gfgposition = $_POST['gfg_badge_position'];
    update_option('gfg_badge_position', $gfgposition);
    $gfgshow = $_POST['gfg_badge_show'];
    update_option('gfg_badge_show', $gfgshow);
    ?>
    <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
    <?php
  } else {
    //Normal page display
    $gfgcharity = get_option('gfg_badge_charity');
    $gfgtype = get_option('gfg_badge_type');
    $gfgside = get_option('gfg_badge_side');
    $gfgposition = get_option('gfg_badge_position');
    $gfgshow = get_option('gfg_badge_show');
  }

  $url = "http://donations.goalsforgiving.com/api/charities.json";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $json = curl_exec($ch);
  curl_close($ch);

  $charities = json_decode($json, true);

?>


<div class="wrap metabox-holder">
  <div class="postbox-container" style="width:42%">
    <form name="gfg_badge_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
      <input type="hidden" name="gfg_badge_hidden" value="Y">
      <div class="postbox">
        <?php echo "<h3 class='hndle'>" . __( 'Goals for Giving Badge Settings', 'gfg_badge_trdom' ) . "</h3>"; ?>
        <div class="inside">
          <table class="form-table">
            <tbody>
              <tr valign="top">
                <th scope="row">
                  <?php _e("Charity: " ); ?>
                </th>
                <td>
                  <select name="gfg_badge_charity">
                    <option></option>
                    <?php
                      foreach ( $charities as $charity ){
                        echo '<option value="'. $charity['slug'] . '" ';
                        echo $gfgcharity == $charity['slug'] ? 'selected="selected">'  : '>';
                        echo $charity['name'];
                        echo '</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th scope="row"><?php _e("Type: " ); ?></th>
                <td>
                  <input type="radio" id="gfg_badge_badge" name="gfg_badge_type" value="badge" <?php echo $gfgtype == 'badge' ? 'checked="checked"' : ''; ?>>
                  <label for="gfg_badge_badge">Badge</label>
                  <br>
                  <input type="radio" id="gfg_badge_ribbon" name="gfg_badge_type" value="ribbon" <?php echo $gfgtype == 'ribbon' ? 'checked="checked"' : ''; ?>>
                  <label for="gfg_badge_ribbon">Ribbon</label>
                </td>
              </tr>
              <tr>
                <th scope="row"><?php _e("Side: " ); ?></th>
                <td>
                  <input type="radio" id="gfg_badge_left" name="gfg_badge_side" value="left" <?php echo $gfgside == 'left' ? 'checked="checked"' : ''; ?>>
                  <label for="gfg_badge_left">Left</label>
                  <br>
                  <input type="radio" id="gfg_badge_right" name="gfg_badge_side" value="right" <?php echo $gfgside == 'right' ? 'checked="checked"' : ''; ?>>
                  <label for="gfg_badge_right">Right</label>
                </td>
              </tr>
              <tr>
                <th scope="row"><?php _e("Position: " ); ?></th>
                <td>
                  <input type="radio" id="gfg_badge_fixed" name="gfg_badge_position" value="fixed" <?php echo $gfgposition == 'fixed' ? 'checked="checked"' : ''; ?>>
                  <label for="gfg_badge_fixed">Fixed</label>
                  <br>
                  <input type="radio" id="gfg_badge_absolute" name="gfg_badge_position" value="absolute" <?php echo $gfgposition == 'absolute' ? 'checked="checked"' : ''; ?>>
                  <label for="gfg_badge_absolute">Absolute</label>
                </td>
              </tr>
              <tr>
                <th scope="row"><?php _e("Show/hide" ); ?></th>
                <td>
                  <input type="checkbox" id="gfg_badge_show" name="gfg_badge_show" value="show" <?php echo $gfgshow == 'show' ? 'checked="checked"' : ''; ?>>
                  <label for="gfg_badge_show">Show Badge</label>
                </td>
              </tr>
              <tr>
                <th scope="row"></th>
                <td>
                  <input type="submit" name="Submit" value="<?php _e('Save settings', 'gfg_badge_trdom' ) ?>" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</div>