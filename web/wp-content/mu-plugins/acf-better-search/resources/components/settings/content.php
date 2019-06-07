<?php
  $fields     = apply_filters('acfbs_options_fields', []);
  $features   = apply_filters('acfbs_options_features', []);
  $config     = apply_filters('acfbs_config', []);
  $isLiteMode = (isset($config['lite_mode']) && $config['lite_mode']);
?>
<form method="post">
  <table class="widefat">
    <thead>
      <tr>
        <th colspan="2">
          <?= __('List of supported fields types:', 'acf-better-search'); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($fields as $key => $label) : ?>
        <tr>
          <td>
            <label for="acfbs_fields_<?= $key; ?>"><?= $label; ?></label>
          </td>
          <td>
            <input type="checkbox" id="acfbs_fields_<?= $key; ?>"
              name="acfbs_fields_types[]" value="<?= $key; ?>"
              <?= (isset($config['fields_types']) && in_array($key, $config['fields_types'])) ? 'checked' : ''; ?>
              <?= ($isLiteMode) ? 'disabled' : ''; ?>>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <table class="widefat">
    <thead>
      <tr>
        <th colspan="2">
          <?= __('Additional features:', 'acf-better-search'); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($features as $key => $label) : ?>
        <tr>
          <td>
            <label for="acfbs_feature_<?= $key; ?>"><?= $label; ?></label>
          </td>
          <td>
            <input type="checkbox" id="acfbs_feature_<?= $key; ?>"
              name="acfbs_features[]" value="<?= $key; ?>"
              <?= (isset($config[$key]) && $config[$key]) ? 'checked' : ''; ?>>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <input type="submit" class="button button-primary" name="acfbs_save"
    value="<?= __('Save Changes', 'acf-better-search'); ?>">
</form>