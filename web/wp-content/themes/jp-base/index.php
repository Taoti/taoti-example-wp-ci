<?php
// use Modules\CTA;

get_header();
?>



<div class="l-container content">
    <div class="l-text-column content-inner">

    <?php if( have_posts() ): ?>

        <?php while( have_posts() ): the_post(); ?>

    		<h2><?php the_title(); ?></h2>
    		<div><?php the_content(); ?></div>

        <?php endwhile; ?>

    <?php else: ?>

        <?php echo 'Not Found.'; ?>

    <?php endif; ?>

    </div><!-- END .content-inner -->
</div><!-- END .content -->



<?php
get_footer();
