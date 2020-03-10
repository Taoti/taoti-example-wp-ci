<?php
// use Modules\CTA;


// Critical CSS for the default page template
// taoti_enqueue_critical_css( get_template_directory().'/styles/css/critical/page-critical.min.css' );


get_header();

the_post();
?>



<div class="content">
	<div class="l-container content-inner">

		<h1 class="page-title"><?php the_title(); ?></h1>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>

	</div><!-- END .content-inner -->
</div><!-- END .content -->



<?php
get_footer();
