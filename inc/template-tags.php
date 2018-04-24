<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Kickoff
 */

if ( ! function_exists( 'bs3entry_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function bs3entry_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( ' %s', 'post date', 'strapped' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( ' %s', 'post author', 'strapped' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on"><i class="fa fa-calendar" aria-hidden="true"></i>' . $posted_on . '</span><span class="byline"><i class="fa fa-user" aria-hidden="true"></i> ' . $byline . '</span>'; // WPCS: XSS OK.

  if ( 'post' === get_post_type() ) {
    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( esc_html__( ', ', 'strapped' ) );
    if ( $categories_list && bs3entry_categorized_blog() ) {
      printf( '<span class="cat-links"><i class="fa fa-folder-open" aria-hidden="true"></i> ' . esc_html__( ' %1$s', 'strapped' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }
  }

  if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
    echo '<span class="comments-link"><i class="fa fa-comments" aria-hidden="true"></i> ';
    /* translators: %s: post title */
    comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'strapped' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
    echo '</span>';
  }

}
endif;

if ( ! function_exists( 'bs3entry_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function bs3entry_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'strapped' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-tags" aria-hidden="true"></i> ' . esc_html__( ' %1$s', 'strapped' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'strapped' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link alignright">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function bs3entry_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'bs3entry_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'bs3entry_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so bs3entry_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so bs3entry_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in bs3entry_categorized_blog.
 */
function bs3entry_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'bs3entry_categories' );
}
add_action( 'edit_category', 'bs3entry_category_transient_flusher' );
add_action( 'save_post',     'bs3entry_category_transient_flusher' );


/**
 * Editing the Tag Widget
 */
function my_widget_tag_cloud_args( $args ) {
  $args['largest'] = 11;
  $args['smallest'] = 11;
  $args['unit'] = 'px';
  return $args;
}
add_filter( 'widget_tag_cloud_args', 'my_widget_tag_cloud_args' );