<?php
// use Modules\CTA;


// Critical CSS for the main archive template
// taoti_enqueue_critical_css( get_template_directory().'/styles/css/critical/index-critical.min.css' );


get_header();
?>



<div class="archiveContent">
	<div class="l-container archiveContent-inner">

	<?php if ( have_posts() ) : ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<h2><?php the_title(); ?></h2>
			<div><?php the_excerpt(); ?></div>

		<?php endwhile; ?>

	<?php else : ?>

		<?php echo 'Not Found.'; ?>

	<?php endif; ?>

	</div><!-- END .archiveContent-inner -->
</div><!-- END .archiveContent -->



<?php
get_footer();
