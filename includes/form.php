<?php
/**
 * Widget forms.
 *
 * @package    PCHC_Employee_Recognitions
 * @since      0.1.0
 * @author     Chris Violette
 * @copyright  Copyright (c) 2018, PCHC
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */
?>

<div class="pchcer__form">
  <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">
			<?php _e( 'Title', 'pchc_employee_recognitions' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	</p>

  <p>
		<label for="<?php echo $this->get_field_id( 'title_url' ); ?>">
			<?php _e( 'Title URL', 'pchc_employee_recognitions' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title_url' ); ?>" name="<?php echo $this->get_field_name( 'title_url' ); ?>" type="text" value="<?php echo esc_url( $instance['title_url'] ); ?>" />
	</p>

  <p>
		<label for="<?php echo $this->get_field_id( 'limit' ); ?>">
			<?php _e( 'Number of posts to show', 'pchc_employee_recognitions' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" step="1" min="-1" value="<?php echo (int)( $instance['limit'] ); ?>" />
    <small><?php _e( 'Use -1 to show all posts', 'pchc_employee_recognitions' ); ?></small>
	</p>

  <p>
		<label for="<?php echo $this->get_field_id( 'offset' ); ?>">
			<?php _e( 'Offset', 'pchc_employee_recognitions' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="number" step="1" min="0" value="<?php echo (int)( $instance['offset'] ); ?>" />
		<small><?php _e( 'The number of posts to skip', 'pchc_employee_recognitions' ); ?></small>
	</p>

  <div class="pchcer-multiple-check-form">
    <label>
      <?php _e( 'Limit to Category', 'pchc_employee_recognitions' ); ?>
    </label>
    <ul>
      <?php foreach( pchcer_cats_list() as $category ) : ?>
        <li>
          <input type="checkbox" value="<?php echo (int) $category->term_id; ?>" id="<?php echo $this->get_field_id( 'category' ) . '-' . (int) $category->term_id; ?>" name="<?php echo $this->get_field_name( 'category' ); ?>[]" <?php checked( is_array( $instance['category'] ) && in_array( $category->term_id, $instance['category'] ) ); ?> />
  					<label for="<?php echo $this->get_field_id( 'category' ) . '-' . (int) $category->term_id; ?>">
  						<?php echo esc_html( $category->name ); ?>
  					</label>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="pchcer-multiple-check-form">
    <label>
      <?php _e( 'Limit to Detpartment/Location', 'pchc_employee_recognitions' ); ?>
    </label>
    <ul>
      <?php foreach( pchcer_cats_list('department') as $department ) : ?>
        <li>
          <input type="checkbox" value="<?php echo (int) $department->term_id; ?>" id="<?php echo $this->get_field_id( 'department' ) . '-' . (int) $department->term_id; ?>" name="<?php echo $this->get_field_name( 'department' ); ?>[]" <?php checked( is_array( $instance['department'] ) && in_array( $department->term_id, $instance['department'] ) ); ?> />
  					<label for="<?php echo $this->get_field_id( 'department' ) . '-' . (int) $department->term_id; ?>">
  						<?php echo esc_html( $department->name ); ?>
  					</label>
          </li>
      <?php endforeach; ?>
    </ul>
  </div>

</div>
