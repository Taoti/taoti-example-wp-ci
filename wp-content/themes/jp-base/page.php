<?php
// use Modules\CTA;

get_header();

the_post();
?>



<div class="l-container content">
    <div class="l-text-column content-inner">

        <h1 class="page-title"><?php the_title(); ?></h1>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

    </div><!-- END .content-inner -->
</div><!-- END .content -->



<?php
get_footer();
