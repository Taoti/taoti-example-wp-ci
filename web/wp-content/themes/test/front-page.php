<?php
// use Modules\CTA;


### Critical CSS for the front page template
taoti_enqueue_critical_css( get_template_directory().'/styles/css/critical/front-page-critical.min.css' );


get_header();
?>



<div class="l-container content">
    <div class="l-text-column content-inner">

        <?php
        // $labels = get_post_type_labels( array() );
        // echo "<pre>"; var_dump($labels); echo "</pre>";
        ?>

    </div><!-- END .content-inner -->
</div><!-- END .content -->



<?php
get_footer();
