<?php

  namespace AcfBetterSearch\Admin;

  class Notice
  {
    public function __construct()
    {
      add_action('admin_head',    [$this, 'showAjaxUrl']);
      add_action('admin_notices', [$this, 'showAdminNotice']);
      add_action('admin_notices', [$this, 'showAdminError']);

      add_action('admin_init',                       [$this, 'hideNoticeByDefault']);
      add_action('wp_ajax_acf_better_search_notice', [$this, 'hideNotice']);
    }

    /* ---
      Show notice
    --- */

    public function showAjaxUrl()
    {
      ?>
        <script>
          (function() {
            window.acfbsAjaxUrl = '<?= admin_url('admin-ajax.php'); ?>';
          })();
        </script>
      <?php
    }

    public function showAdminNotice()
    {
      if (get_option(ACFBS_NOTICE, false) === false) {
        $this->saveNoticeExpires();
        return;
      }

      if ((get_option(ACFBS_NOTICE, 0) >= time()) || (get_current_screen()->id != 'dashboard')) {
        return;
      }

      require_once ACFBS_PATH . 'resources/components/notice/thanks.php';
    }

    public function showAdminError()
    {
      if (function_exists('acf_get_setting')) return;

      require_once ACFBS_PATH . 'resources/components/notice/acf.php';
    }

    /* ---
      Turn off notice
    --- */

    public function hideNoticeByDefault()
    {
      if (get_option(ACFBS_NOTICE, false) !== false) return;

      $expires = strtotime('+ 1 week');
      $this->saveNoticeExpires($expires);
    }

    public function hideNotice()
    {
      $isPermanent = isset($_POST['is_permanently']) && $_POST['is_permanently'];
      $expires     = strtotime($isPermanent ? '+10 years' : '+ 1 month');

      $this->saveNoticeExpires($expires);
    }

    public function saveNoticeExpires($expires = 0)
    {
      $expires = $expires ? $expires : strtotime('+ 1 week');

      if (get_option(ACFBS_NOTICE, false) !== false) update_option(ACFBS_NOTICE, $expires);
      else add_option(ACFBS_NOTICE, $expires);
    }
  }