<?php
/**
 * Plugin Name:        PCHC Employee Recognitions Widget
 * Plugin URI:         https://www.github.com/pixleight/p8-recent-posts
 * Description:        WordPress widget to display recent recipients of employee recognitions
 * Version:            0.2.0
 * Author:             Chris Violette
 * Author URI:         https://pixleight.com
 *
 * License:            GNU General Public License, version 2
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package    PCHC_Employee_Recognitions
 * @since      0.1
 * @author     Chris Violette
 * @copyright  Copyright (c) 2018, PCHC
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

class PCHC_Employee_Recognitions extends WP_Widget {

  /**
	 * Sets up the widgets.
	 *
	 * @since 0.1
	 */
  public function __construct() {

    /* Set up the widget options */
    $widget_options = array(
      'classname' => 'pchc-employee-recognitions-widget',
      'description' => __( 'Displays recent recipients of employee recognitions', 'pchcer' ),
      'customize_selective_refresh' => true
    );

    /* Register the widget */
    parent::__construct(
      'pchc_employee_recognitions',
      __( 'PCHC Employee Recognitions' , 'pchcer' ),
      $widget_options
    );
  }

  /**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1
	 */
  public function widget( $args, $instance ) {
    extract( $args );

    $posts = pchcer_get_posts_markup( $instance );

    $title = apply_filters( 'widget_title', $instance[ 'title' ]);
    $blog_title = get_bloginfo( 'name' );
    $tagline = get_bloginfo( 'description' );

    // Open the theme's widget wrapper
    echo $before_widget;

    // If both title and title url is not empty, display it.
    if ( ! empty( $instance['title_url'] ) && ! empty( $instance['title'] ) ) {
      echo $before_title . '<a href="' . esc_url( $instance['title_url'] ) . '" title="' . esc_attr( $instance['title'] ) . '">' . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . '</a>' . $after_title;

    // If the title not empty, display it.
    } elseif ( ! empty( $instance['title'] ) ) {
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
    }

    echo $posts;

    // Close the theme's widget wrapper
    echo $after_widget;
  }

  /**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1
	 */
  public function update( $new_instance, $old_instance ) {
    // Validate post_type submissions
		$name = get_post_types( array( 'public' => true ), 'names' );
		$types = array();
		foreach( $new_instance['post_type'] as $type ) {
			if ( in_array( $type, $name ) ) {
				$types[] = $type;
			}
		}
		if ( empty( $types ) ) {
			$types[] = 'post';
		}

		$instance                     = $old_instance;
    $instance['title']            = sanitize_text_field( $new_instance['title'] );
		$instance['title_url']        = esc_url_raw( $new_instance['title_url'] );
    $instance['limit']            = intval( $new_instance['limit'] );
    $instance['offset']           = intval( $new_instance['offset'] );

    $instance['category']         = $new_instance['category'];
    $instance['department']       = $new_instance['department'];

    $instance['widget_more']      = isset( $new_instance['widget_more'] ) ? (bool) $new_instance['widget_more'] : false;
    $instance['post_more']      = isset( $new_instance['post_more'] ) ? (bool) $new_instance['post_more'] : false;

    return $instance;
  }

  /**
  * Displays the widget control options in the Widgets admin screen.
  *
  * @since 0.1
  */
  public function form( $instance ) {
    // Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, pchcer_get_default_args() );

		// Extract the array to allow easy use of variables.
		extract( $instance );

    // Loads the widget form.
		include( PCHCER_INCLUDES . 'form.php' );
  }
}
