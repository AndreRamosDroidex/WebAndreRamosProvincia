<?php
/**
 * Checks if there are any additional rows to iterate when using a layout field.
 *
 * Please use this function in conjunction with the_row(), have_groups(), the_group() and sub-value
 * functions in order to have a proper loop. Example:
 *
 * <?php if( have_layout_rows( 'layout_blocks' ) ): ?>
 * 	<div class="layout">
 * 	<?php while( have_layout_rows( 'layout_blocks' ) ): the_row() ?>
 * 	<div class="layout-row">
 * 		<?php while( have_groups( 'layout_blocks' ) ): the_group() ?>
 * 			<div class="layout-column layout-column-<?php the_group_width() ?>">
 * 				<?php the_sub_value( 'title' ) ?>
 * 			</div>
 * 		<?php endwhile ?>
 * 	</div>
 * 	<?php endwhile ?>
 * 	</div>
 * <?php endif ?>
 *
 * @since 3.0
 *
 * @param string $name The name of the field whose value will be iterated.
 * @param mixed  $type The type of data the field is associated with.
 * @return bool        An indicator if there are any more rows to process.
 */
function have_layout_rows( $name, $type = null ) {
	$api = Ultimate_Fields\Data_API::instance();
	return $api->have_rows( $name, $type );
}

/**
 * Proceeds to the next row when looping a layout field.
 *
 * @since 3.0
 */
function the_layout_row() {
	$api = Ultimate_Fields\Data_API::instance();
	return $api->the_row();
}

/**
 * Returns the width of the current group when looping through layout fields.
 *
 * @since 3.0
 *
 * @return int The width of the group in columns.
 */
function get_group_width() {
	$api = Ultimate_Fields\Data_API::instance();
	return $api->get_group_width();
}

/**
 * Displays the width of the current group when looping through layout fields.
 *
 * @since 3.0
 */
function the_group_width() {
	$api = Ultimate_Fields\Data_API::instance();
	return $api->the_group_width();
}

/**
 * Initializes and prepares containers to be displayed in the front-end
 * through the uf_form() function.
 *
 * It's paramount to use this function before calling get_header(), as
 * this way the front-end forms may do any of the following:
 *
 * 1. Load all containers which are to be displayed.
 * 2. Enqueues scripts and styles.
 * 3. When a form is submitted, saves its data.
 * 4. Redirects the user when submitted.
 *
 * ... and much more.
 *
 * @since 3.0
 * @param mixed[] $args Arguments for displaying the containers/forms.
 */
function uf_head( $args = array() ) {
	return Ultimate_Fields\Pro\Form::instance()->head( $args );
}

/**
 * Displays forms in the front end when the moment is right.
 *
 * @see uf_head() - this function needs to be called before uf_form().
 * @since 3.0
 */
function uf_form() {
	return Ultimate_Fields\Pro\Form::instance()->form();
}
