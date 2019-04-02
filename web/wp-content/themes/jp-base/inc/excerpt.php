<?php

### Set which post types are using the page builder. This helps generate excerpts when the_content() isn't used, or is used in conjunction with the_page_builder().
function taoti_get_post_types_with_page_builder(){

    $post_types_with_page_builder = [
		'post',
		'page',
	];

    return $post_types_with_page_builder;
}


### Whenever a post is saved, and if that post type uses the page builder, save the HTML output of the page builder in a post meta option. This acts as a sort of cache for the page builder contents, and can be used to generate excerpts.
function taoti_store_page_builder_output( $post_id, $post, $update ){

	$post_types_with_page_builder = taoti_get_post_types_with_page_builder();

	if( in_array( get_post_type($post_id), $post_types_with_page_builder ) ){
		global $post;
		$post = get_post( $post_id );
		setup_postdata( $post );

        // Get the output of the page builder.
        ob_start();
            the_page_builder();
		    $page_content = ob_get_clean();

		// Save the output to a post meta key so it can be easily retrieved later, like when generating an excerpt.
		update_post_meta( $post_id, 'taoti_page_builder_output', $page_content );

		wp_reset_postdata();
	}

}
add_action( 'save_post', 'taoti_store_page_builder_output', 10, 3 );




### Makes sure that when get_the_excerpt() is used, the content in the page builder is used as a backup to generate the excerpt, since the default content editor is not used for pages.
function taoti_extend_excerpt( $excerpt, $post ) {

	$post_types_with_page_builder = taoti_get_post_types_with_page_builder();

    // Make sure this has a page builder, and also that the excerpt is blank.
	if( in_array( get_post_type($post), $post_types_with_page_builder ) && !$excerpt ){

        // Get the page builder contents and strip all the tags, excerpts aren't supposed to have HTML in them.
        $page_content = get_post_meta( $post->ID, 'taoti_page_builder_output', true );

        if( $page_content ){
            $stripped_content = trim( wp_strip_all_tags( $page_content, true ) );
    		$excerpt = wp_trim_words( $stripped_content, jp_custom_excerpt_length() );
        }

	}

	return $excerpt;
}
add_filter( 'get_the_excerpt', 'taoti_extend_excerpt', 10, 2 );
