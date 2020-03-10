<?php
// use Modules\CTA;


// Critical CSS for the 404 page template
// taoti_enqueue_critical_css( get_template_directory().'/styles/css/critical/page-critical.min.css' );


get_header();
?>



<div class="content">
	<div class="l-container content-inner">

		<?php
		// NOTE
		// This theme sets up customizer options for the 404 page title and content. Check Appearance > Customize, or go to a 404 page and click Customize in the admin bar.
		// Check inc/customizer.php for more info.
		$page_title = get_theme_mod( 'jp_404_page_title', 'Not Found (404)' );
		$content    = get_theme_mod( 'jp_404_content', 'The content you were looking for could not be found.' );
		?>
		<h1 class="page-title js-customizer-404Title"><?php echo $page_title; ?></h1>

		<div class="entry-content js-customizer-404Content">
			<?php echo $content; ?>
		</div>

	</div><!-- END .content-inner -->
</div><!-- END .content -->



<?php
get_footer();
