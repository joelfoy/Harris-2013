<h3><a href="#" class="toggle-buttton">-</a>Create tracking links</h3>
<div>
<form action="" method="post" enctype="application/x-www-form-urlencoded" id="frm-settings">
  <table width="100%" border="0" class="options" cellspacing="0" cellpadding="0">
    <tr class="<?php echo $validation['campaign_url']; ?>">
      <td width="25%"><label for="campaign_url">Website url*</label></td>
      <td width="40%"><input type="input" value="<?php echo $campaign_url ?>" id="campaign_url" name="campaign_url" /></td>
      <td class="extra small" width="35%">e.g. http://www.mywebsite.be/article/4.html</td>
    </tr>
    <tr class="<?php echo $validation['campaign_source']; ?>">
      <td width="25%"><label for="campaign_source">Campaign source*</label></td>
      <td width="40%"><input type="input" value="<?php echo $campaign_source ?>" id="campaign_source" name="campaign_source" /></td>
      <td class="extra small" width="35%">referrer: google, citysearch, newsletter4</td>
    </tr>
    <tr class="<?php echo $validation['campaign_medium']; ?>">
      <td><label for="campaign_medium">Campaign medium*</label></td>
      <td><input name="campaign_medium" id="campaign_medium" value="<?php echo $campaign_medium ?>"></td>
      <td class="extra small">marketing medium: cpc, banner, email</td>
    </tr>
    <tr>
      <td><label for="campaign_term">Campaign Term</label></td>
      <td><input name="campaign_term" id="campaign_term" value="<?php echo $campaign_term ?>"></td>
      <td class="extra small">identify the paid keywords</td>
    </tr>
    <tr>
      <td><label for="campaign_content">Campaign Content</label></td>
      <td><input name="campaign_content" id="campaign_content" value="<?php echo $campaign_content ?>"></td>
      <td class="extra small">use to differentiate ads</td>
    </tr>
    <tr class="<?php echo $validation['campaign_name']; ?>">
      <td><label for="campaign_name">Campaign Name*</label></td>
      <td><input name="campaign_name" id="campaign_name" value="<?php echo $campaign_name ?>"></td>
      <td class="extra small">product, promo code, or slogan</td>
    </tr>
    <tr>
      <td><input style="width: 100px;" type="submit" value="Generate" class="button-primary" tabindex="5" id="generate" name="generate"></td>
      <td colspan="2"><input name="campaign_result_field" id="campaign_result_field" value="<?php echo $campaign_result; ?>"></td>
    </tr>
  </table>
  </form>
</div>
<h3><a href="#" class="toggle-buttton">+</a>What is campaign tracking</h3>
<div style="display: none">
  <p>Tagging your online ads is an important prerequisite to allowing Google Analytics to show you which marketing activities are really paying off.</p>
  <table cellspacing="5" cellpadding="0" border="0" class="outline2">
    <!--DWLayoutTable-->
    <tbody>
      <tr>
        <td width="201"><p>Campaign Source (utm_source)</p></td>
        <td width="666">Required. Use <strong>utm_source</strong> to identify a
          search
          engine, newsletter name, or other source. <br>
          <em>Example</em>: <font face="Courier New, Courier, mono">utm_source=google</font></td>
      </tr>
      <tr>
        <td><p>Campaign Medium (utm_medium)</p></td>
        <td> Required. Use <strong>utm_medium</strong> to identify a
          medium
          such as email or cost-per-
          click. <br>
          <em>Example</em>: <font face="Courier New, Courier, mono">utm_medium=cpc</font></td>
      </tr>
      <tr>
        <td><p>Campaign Term (utm_term)</p></td>
        <td> Used for paid search. Use <strong>utm_term</strong> to note the keywords for this ad. <br>
          <em>Example</em>: <font face="Courier New, Courier, mono">utm_term=running+shoes</font></td>
      </tr>
      <tr>
        <td><p>Campaign Content (utm_content)</p></td>
        <td> Used for A/B testing and
          content-targeted
          ads. Use <strong>utm_content</strong> to differentiate ads or links that point to the
          same URL. <br>
          <em>Examples</em>: <font face="Courier New, Courier, mono">utm_content=logolink</font> <em>or</em><font face="Courier New, Courier, mono"> utm_content=textlink</font></td>
      </tr>
      <tr>
        <td><p>Campaign Name (utm_campaign)</p></td>
        <td> Used for keyword analysis. Use <strong>utm_campaign </strong>to identify a specific product promotion or strategic campaign. <br>
          <em>Example</em>: <font face="Courier New, Courier, mono">utm_campaign=spring_sale</font></td>
      </tr>
    </tbody>
  </table>
</div>
