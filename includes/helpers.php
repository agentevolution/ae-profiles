<?php

/**
 * Shows default image if genesis_image() returns false
 */
function agentevo_image($size="thumbnail") {

	if ($size == "medium") {
		$dimensions = "-300x300";
	} elseif ($size == "large") {
		$dimensions = "-640x640";
	} else {
		$dimensions = "-150x150";
	}

	if ( genesis_get_image( array( 'size' => $size ) ) ) {
		return genesis_get_image( array( 'size' => $size, 'attr' => array('class' => 'size-' . $size) ) );
	} else {
		return '<img class="thumbnail no-prev" src="https://s3.amazonaws.com/ae-plugins/shared/images/default-thumb' . $dimensions  . '.png" alt="no preview available" />';
	}
}


/**
 * Shows default image if get_the_post_thumnail() returns false
 *
 * If no post thumbnail is found the default thumbnail will be
 * resized to match the dimensions of the $size parameter
 * using inline CSS.
 */
function agentevo_get_image($pid, $size="thumbnail") {

	if ($size == "medium") {
		$dimensions = "-300x300";
	} elseif ($size == "large") {
		$dimensions = "-640x640";
	} else {
		$dimensions = "-150x150";
	}

	$sizes = genesis_get_additional_image_sizes();

	foreach( $sizes as $name => $dims ) {
		if ( $size == $name ) {
			$dimensions = '-' . $dims["width"] . 'x' . $dims["height"];
			$custom_size_width = $dims["width"];
			$custom_size_height = $dims["height"];
		}
	}

	// return the post thumbnail if it exists
	if ( false != get_the_post_thumbnail($pid, $size) ) {
		return get_the_post_thumbnail($pid, $size);
	}

	// return the s3 hosted default thumbnail if the dimenions of the custom image size match available default thumb dimensions
	if ( in_array($dimensions, array('-150x150', '-300x300', '-640x640')) ) {
		return '<img class="thumbnail no-prev" src="https://s3.amazonaws.com/ae-plugins/shared/images/default-thumb' . $dimensions  . '.png" alt="no preview available" />';
	}

	// return the default thumbnail and size it with css according to the dimensions
	return '<img class="thumbnail no-prev" src="https://s3.amazonaws.com/ae-plugins/shared/images/default-thumb-300x300.png" alt="no preview available" style="width:' . $custom_size_width . 'px; height:' . $custom_size_height . 'px;" />';
}

/**
 * Returns true if the queried taxonomy is a taxonomy of the given post type
 */
function ae_is_taxonomy_of($post_type) {
	$taxonomies = get_object_taxonomies($post_type);
	$queried_tax = get_query_var('taxonomy');

	if ( in_array($queried_tax, $taxonomies) ) {
		return true;
	}

	return false;
}

function agentevo_linked_title() {
	return sprintf('<a href="%s">%s</a>', get_permalink(), get_the_title());
}