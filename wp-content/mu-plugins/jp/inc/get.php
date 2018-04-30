<?php
namespace JP;

class Get
{

	/**
	// TODO: make fallback customizable in the backend of Wordpress.
	* Get image data for a given attachment ID.
	* The returned array is like the array returned by ACF for image arrays. It contains the original file's filename, width, height, and an array of sizes, plus srcset info.
	* Returns an array of image information, a fallback if no image is set, or boolean false if there is no fallback or post_thumbnail.
	* @method image_array
	* @param  string	$attachment_id	Aan attachment ID for an image.
	* @param  boolean	$use_fallback	Choose whether to use a fallback image if none is found.
	* @return mixed		Image data array or boolean false
	*/
	public static function image_array( $attachment_id, $use_fallback=false ){
		$return = false;

		// Get the array of data for the uplaods directory.
		$uploads = wp_upload_dir();

		// Get a post object for the featured image.
		$attachment_post = get_post($attachment_id);

		// Get the srcset string
		// $attachment_srcset = wp_get_attachment_image_srcset( $attachment_id, $size );

		// Get the metadata array for the featured image.
		$metadata = wp_get_attachment_metadata($attachment_id);

		// Assuming the metadata was found...
		if( $metadata ){

			// Instantiate the array that will be returned. I start it with all the keys just to make it easier to look at what sort of data will be available. This is meant to match the array returned by ACF's get_field() (when the field is an Image field and returns an array).
			$new_array = [
				'ID' => '',
				'id' => '',
				'title' => '',
				'filename' => '',
				'url' => '',
				'alt' => '',
				'author' => '',
				'description' => '',
				'caption' => '',
				'name' => '',
				'date' => '',
				'modified' => '',
				'mime_type' => '',
				'type' => '',
				'icon' => '',
				'width' => '',
				'height' => '',
				'srcset' => '',
				'sizes' => [],
			];

			// From this point we're just going through each key to set the value. Most values come from the metadata array and the post object.
			$new_array['ID'] = $attachment_id;
			$new_array['id'] = $attachment_id;

			$new_array['title'] = $attachment_post->post_title;

			// The 'file' string contains the uploads folder structure, but we only want to keep the filename itself. E.g., $metadata['file'] might be '2017/06/1080.jpg', but we only want the '1080.jpg' part.
			$filename = $metadata['file'];
			$last_slash = strrpos( $filename, '/' );
			if( $last_slash!==false ){
				$filename = substr( $filename, $last_slash+1 );
			}
			$new_array['filename'] = $filename;

			$new_array['url'] = $uploads['baseurl'].'/'.$metadata['file'];

			$new_array['alt'] = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

			$new_array['author'] = $attachment_post->post_author;

			$new_array['description'] = $attachment_post->post_content;

			$new_array['caption'] = $attachment_post->post_excerpt;

			$new_array['name'] = $attachment_post->post_name;

			$new_array['date'] = $attachment_post->post_date;

			$new_array['modified'] = $attachment_post->post_modified;

			$new_array['mime_type'] = $attachment_post->post_mime_type;

			// I think 'type' is the field type from ACF. Since the featured image is always going to be an image, I just hardcode it here.
			$new_array['type'] = 'image';

			$new_array['icon'] = wp_mime_type_icon( $attachment_post->post_mime_type );

			$new_array['width'] = $metadata['width'];

			$new_array['height'] = $metadata['height'];

			$new_array['srcset'] = wp_get_attachment_image_srcset( $attachment_id, 'full', $metadata );

			// Assuming the uploads folder items are stored in year/month folders, we need to know what that year/month folder is for this image. This would be part of the string in $metadata['file']. If the year/month is found in the filename, then save that as a prefix to use later.
			$prefix = '';
			if( $last_slash!==false ){
				$prefix = substr( $metadata['file'], 0, $last_slash+1 );
			}

			// Use the data from $metadata['sizes'] to populate the $new_array['sizes'] array. The year/month folder structure is not included here as part of the filenames, but since we just figured out what $prefix is, we can use that to build the file URLs.
			foreach( $metadata['sizes'] as $size_name => $size_data ){
				$new_array['sizes'][$size_name] = $uploads['baseurl'].'/'.$prefix.$size_data['file'];
				$new_array['sizes'][$size_name.'-width'] = $size_data['width'];
				$new_array['sizes'][$size_name.'-height'] = $size_data['height'];
				$new_array['sizes'][$size_name.'-srcset'] = wp_get_attachment_image_srcset( $attachment_id, $size_name );
			}

			// Save the new array we just built.
			$return = $new_array;

		}

		return $return;

	}

	/**
	// TODO: make fallback customizable in the backend of Wordpress.
	* Get the given post's featured image data.
	* The returned array is like the array returned by ACF for image arrays. It contains the original file's filename, width, height, and an array of sizes.
	* Returns an array of image information, a fallback if no image is set, or boolean false if there is no fallback or post_thumbnail.
	* @method featuredImage
	* @param  string	$post_ID	A post ID that has a featured image.
	* @param  boolean	$use_fallback	Choose whether to use a fallback image if none is found.
	* @return mixed		Image data array or boolean false
	*/
	public static function featured_image_array( $post_ID=false, $use_fallback=false ){
		$return = false;

        if( $post_ID===false ){
            global $post;
            $post_ID = $post->ID;
        }

        $fallback = false;
        if( $use_fallback ){
        	// fallback here
        }

		// Make sure the post has a feautred image.
		if( has_post_thumbnail($post_ID) ){

			// Save the featured image ID for later use.
			$attachment_id = get_post_thumbnail_id($post_ID);

			$return = Get::image_array($attachment_id);

		}

		return $return;
    }



    /**
	// TODO: make work with the fallback from featured_image_array()
    * Get the given post's featured image as a URL.
    * Returns a string - the URL for the featured image of the given size, or the URL for the fallback image if not found, or false if something went wrong.
    * @param    string  $size       The image size you want to get back.
    * @param    mixed   $post_ID    The post ID of the post you want the featured image for.
    * @return   mixed   URL string or boolean false
    */
    public static function featured_image_url( $size='full', $post_ID=false ){

        if( !$post_ID ){
            global $post;
            $post_ID = $post->ID;
        }

        $array = self::featured_image_array($post_ID);

		$url = self::size_url($size, $array);

        return $url;

    }



	/**
    * Get an <img> HTML string from the image array that ACF returns with get_field(), or the array that Get::featured_image_array() returns. You can tell it which image size to use, add any classes you need, and add an id.
    * Returns an <img> HTML string, or false if something went wrong.
    * @param    array   image_array    The array that ACF returns when you run get_field() on an Image field.
    * @param    string  $size       	The image size you want to get back.
	* @param    array  $classes			An array of classes (strings) that will be added to the class attribute of the <img>.
	* @param    string  $id				The string to use in the id attribute of the <img>.
    * @return   mixed   an <img> HTML string, or boolean false
    */
	public static function image_html( $args=[] ){
		$defaults = [
			'image_array' => false,
			'size' => 'medium',
			'classes' => [],
			'id' => false,
		];

		extract( array_merge($defaults, $args) );

		$return = false;

		if( is_array($image_array) && isset($image_array['sizes'][$size]) ){
			$src = $image_array['sizes'][$size];
			$width = $image_array['sizes'][$size.'-width'];
			$height = $image_array['sizes'][$size.'-height'];
			$alt = $image_array['alt'];

			$class_att = ($classes)? ' class="'.implode(' ', $classes).'"' : '';

			$id_att = ($id)? ' id="'.$id.'"' : '';

			$html = '<img'.$id_att.$class_att.' src="'.$src.'" width="'.$width.'" height="'.$height.'" alt="'.$alt.'">';

			$return = $html;

		}

		return $return;

	}



	/**
    * Get the URL to a particular size for an image. Give it the size you want (defined in themefolder/inc/image-sizes.php) and give it the image array returned via ACF or Get::featured_image_array().
    * Returns a URL string to an image file, or false if something went wrong.
    * @param    string  $size			The image size you want to get back.
    * @param    array   image_array		The array that ACF returns when you run get_field() on an Image field, or when you use Get::featured_image_array().
    * @return   mixed   a URL string, or boolean false
    */
	public static function size_url( $size, $image_array=false ){
		$return = false;

		if( isset($image_array['sizes'][$size]) ){
			$return = $image_array['sizes'][$size];

		} elseif( $size==='full' && isset($image_array['url']) ){
			$return = $image_array['url'];

		}

		return $return;

	}



	/**
	* Output the current phone number as a link.
	* @param  array $options only used for html classes right now.
	* @return string formatted html anchor tag
	*/
	public static function phoneNumberLink($options = [])
	{

		static $defaults = [
			'classes' => [],
		];
		$merged = array_merge($defaults, $options);
		extract($merged);

		$classes[] = 'phone-number';

		$number = self::phoneNumber();
		$tel = self::phoneNumberTel();

		$html = false;
		if( $number && $tel ){
			$html = "<a class='".implode(' ', $classes)."' href='tel:$tel'>$number</a>";
		}

		return $html;
	}

	/**
	* Output the current phone number formatted for tel: in an anchor tag.
	* @param  array $options only used for country code.
	* @return string formatted html anchor tag
	*/
	public static function phoneNumberTel($options = [])
	{
		$number = self::phoneNumber();

		$tel = false;
		if($number){
			// Remove emdashes – periods and space characters.
			$tel = preg_replace("/[\s\.\–]/", '-', $number);
			// Remove Parens
			$tel = preg_replace("/[\(\)]/", "", $tel);
		}


		return $tel;
	}

	/**
	* Get the current phone number however it was entered into the field from the customizer settings.
	* @return string phone number
	*/
	public static function phoneNumber()
	{
		return get_theme_mod('jp_phone_number');
	}

	/**
	* Get the current address (with line breaks) from the customizer settings.
	* @return string address
	*/
	public static function address()
	{
		$address = get_theme_mod('jp_address');
		if($address){
			$address = nl2br($address);
		}
		return $address;
	}

	/**
	* Get the URL for a social media site from the customizer settings.
	* @param  string $site should be 'facebook' or 'twitter'
	* @return string URL
	*/
	public static function socialURL($site='facebook')
	{
		return get_theme_mod('jp_'.$site.'_url');
	}



} // END class Get
