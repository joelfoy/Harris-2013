<h3><a href="#" class="toggle-buttton">-</a>Settings</h3>

<div>

<?php if(isset($settings_success) && $settings_success){ ?>
	<div class="success">Changes have been successfully saved.</div>
<?php } ?>

	<form action="" method="post" enctype="application/x-www-form-urlencoded" id="frm-settings">
  <table width="100%" border="0" class="options" cellspacing="0" cellpadding="0">
    <tr class="<?php echo $validation['track_code']; ?>">
      <td><label for="track_code">Tracking code</label></td>
      <td><input name="track_code" id="track_code" value="<?php echo $track_code; ?>"></td>
      <td class="extra small">You Google Analytics tracking code. e.g. UA-XXXXXXX-X</td>
    </tr>
    <tr>
      <td width="25%"><label for="track_outbound">Outbound link tracking</label></td>
      <td width="40%"><input type="checkbox" value="true" <?php if($track_outbound == "true") echo 'checked="checked"'; ?> id="track_outbound" name="track_outbound" /></td>
      <td class="extra small" width="35%">Track links that redirect a visitor to another website</td>
    </tr>
    <tr>
      <td><label for="track_mailto">Mailto tracking</label></td>
      <td><input type="checkbox" value="true" <?php if($track_mailto == "true") echo 'checked="checked"'; ?>" id="track_mailto" name="track_mailto" /></td>
      <td class="extra small">Track when a user clicks a mailto link</td>
    </tr>
    <tr>
      <td><label for="track_download">Download tracking</label></td>
      <td><input type="checkbox" value="true" <?php if($track_download == "true") echo 'checked="checked"'; ?> id="track_download" name="track_download" /></td>
      <td class="extra small">Track when a user downloads a file. The file types that get tracked can be specified below.</td>
    </tr>
    <tr>
      <td><label for="track_download_ext">Download tracking</label></td>
      <td><input name="track_download_ext" id="track_download_ext" value="<?php echo $track_download_ext; ?>"></td>
      <td class="extra small">The file types that you want to track. Separate the entries with a comma.</td>
    </tr>
    <tr>
      <td colspan="3"><input type="submit" value="Save Changes" class="button-primary" name="save-settings"></td>
    </tr>
  </table>
  </form>
</div>
  
<h3><a href="#" class="toggle-buttton">-</a>Adsense Link</h3>
<div>
<?php if(isset($adsense_success) && $adsense_success){ ?>
	<div class="success">Changes have been successfully saved.</div>
<?php } ?>
	<p>Default your adsense account is not linked with your analytics account. If you want to enable it you configure Google analytics, so that it receives adsense data and then check the box below.</p>
    <form action="" method="post" enctype="application/x-www-form-urlencoded" id="frm-adsense">
  <table width="100%" border="0" class="options" cellspacing="0" cellpadding="0">
    <tr>
      <td width="25%"><label for="track_adsense">Adsense tracking</label></td>
      <td width="40%"><input type="checkbox" value="true"  <?php if($track_adsense == "true") echo 'checked="checked"'; ?> id="track_adsense" name="track_adsense" /></td>
      <td class="extra small" width="35%">This way you can view your adsense income in Google Analytics</td>
    </tr>
    <tr>
      <td colspan="3"><input type="submit" value="Save Changes" class="button-primary" name="save-adsense"></td>
    </tr>
  </table>
  </form>
</div>
