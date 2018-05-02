<?php
/**
 * Various functions used by the plugin.
 *
 * @package    PCHC_Employee_Recognitions
 * @since      0.1.0
 * @author     Chris Violette
 * @copyright  Copyright (c) 2018, PCHC
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
* Sets up the default arguments.
*
* @since  0.1
*/
function pchcer_get_default_args() {
  $defaults = array(
    'title'             => esc_attr__( 'Employee Recognitions', 'pchcer' ),
    'title_url'         => '',

    'limit'             => 5,
    'offset'            => 0,
    'order'             => 'DESC',
    'orderby'           => 'date',
    'post_type'         => array( 'employee_recognition' ),
    'post_status'       => 'publish',
    'ignore_sticky'     => 1,
    'category'          => array(),
    'department'        => array(),
    'widget_more'       => true,
    'post_more'         => true,
    'before'            => '',
    'after'             => '',
  );

  // Allow plugins/themes developer to filter the default arguments.
  return apply_filters( 'pchcer_default_args', $defaults );
}

/**
 * The posts query.
 *
 * @since  0.1
 * @param  array  $args
 * @return array
 */
function pchcer_get_posts( $args = array() ) {

  // Query arguments
  $query = array(
    'offset'              => $args['offset'],
    'posts_per_page'      => $args['limit'],
    'orderby'             => $args['orderby'],
    'order'               => $args['order'],
    'post_type'           => $args['post_type'],
    'post_status'         => $args['post_status'],
  );

  // Add taxonomy query if category or department are set
  if( !empty( $args['category'] ) || !empty( $args['department'] ) ) {
    $query['tax_query'] = array(
      'relation' => 'AND',
    );
  }

  // Category query
  if ( !empty( $args['category'] ) ) {
    array_push( $query['tax_query'], array(
      'taxonomy' => 'employee_recognition_category',
      'terms' => $args['category'],
    ) );
  }

  // Department/Location query
  if ( !empty( $args['department'] ) ) {
    array_push( $query['tax_query'], array(
      'taxonomy' => 'department',
      'terms' => $args['department'],
    ) );
  }

  // Allow plugins/themes developer to filter the default query.
  $query = apply_filters( 'pchcer_default_query_arguments', $query );

  // Perform the query.
  $posts = new WP_Query( $query );

  return $posts;
}

/**
 * Generates the posts markup.
 *
 * @since 0.1
 * @param array $args
 * @return string|array The HTML for the posts.
 */
function pchcer_get_posts_markup( $args = array() ) {

  // Set up a default, empty variable
  $html = '';

  // Merge the input arguments and the defaults.
  $args = wp_parse_args( $args, pchcer_get_default_args() );

  // Extract the array to allow easy use of variables.
  extract( $args );

  // Allow devs to hook in stuff before the loop.
  do_action( 'pchcer_before_loop' );

  // Get the posts query.
  $posts = pchcer_get_posts( $args );

  if( $posts->have_posts() ) :
    $html .= '<div class="pchcer">';
      $html .= '<ul class="pchcer__posts">';

        while( $posts->have_posts() ) : $posts->the_post();
          $html .= '<li class="pchcer__post">';

            if( has_post_thumbnail() ) {
              $html .= '<a href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Read more: %s', 'pchcer' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark" class="pchcer__image-link">';
              $html .= get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'pchcer__image'));
              $html .= '</a>';
            }

            $html .= '<h4 class="pchcer__title"><a href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Read more: %s', 'pchcer' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">' . esc_attr( get_the_title() ) . '</a></h4>';

            $html .= '<time class="pchcer__timestamp" datetime="' . get_post_time('c', true) . '">';
            $html .= get_the_date('F Y');
            $html .= '</time>';

            $recCat = get_the_term_list( $post->ID, 'employee_recognition_category', '<li>', ', ', '</li>' );
            $recDept = get_the_term_list( $post->ID, 'department', '<li>', ', ', '</li>' );

            if( $recCat ) {
              $html .= '<ul class="pchcer__taxonomy pchcer__taxonomy--category">';
              $html .= $recCat;
              $html .= '</ul>';
            }

            if( $recDept ) {
              $html .= '<ul class="pchcer__taxonomy pchcer__taxonomy--department">';
              $html .= $recDept;
              $html .= '</ul>';
            }

            if( $post_more ) {
              $html .= '<a href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Read more: %s', 'pchcer' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark" class="pchcer__readmore">Read More <i class="fas fa-angle-right"></i></a>';
            }

          $html .= '</li>';

        endwhile;

      $html .= '</ul>';

      if( $widget_more && $title_url ) {
        $html .= '<a href="' . esc_url( $title_url ) . '" title="' . esc_attr__( $title ) . '" class="pchcer__widget-readmore"><i class="fas fa-heartbeat"></i> View More</a>';
      }

    $html .= '</div>';

  endif;

  // Restore original Post Data.
  wp_reset_postdata();

  // Allow devs to hook in stuff after the loop.
  do_action( 'pchcer_after_loop' );

  // Return the  posts markup.
  return wp_kses_post( $args['before'] ) . apply_filters( 'pchcer_markup', $html ) . wp_kses_post( $args['after'] );
}

/**
 * Display list of categories for widget.
 *
 * @since  0.2
 */
function pchcer_cats_list( $term = 'employee_recognition_category' ) {

	// Arguments
	$args = array(
		'number' => 99
	);

	// Allow dev to filter the arguments
	$args = apply_filters( 'pchcer_cats_list_args', $args );

	// Get the cats
	$cats = get_terms( $term, $args );

	return $cats;
}
