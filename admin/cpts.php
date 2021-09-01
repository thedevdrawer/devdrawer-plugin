<?php
//generatewp.com

/**
 * Create custom post type called Employees
 */
function create_employees() {
	$labels = array(
		'name'                  => _x( 'Employees', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Employee', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Employees', 'text_domain' ),
		'name_admin_bar'        => __( 'Employee', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Employee', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-users',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'employees', $args );
}

/**
 * Create archive page
 */
function employees_archive($archive_template){
	global $post;
	if(is_post_type_archive('employees')):
		$archive_template = plugin_dir_path( dirname( __FILE__ ) ).'archive-employees.php';
	endif;
	return $archive_template;
}

/**
 * Create single page
 */
function employees_single($single_template){
	global $post;
	if($post->post_type == 'employees'):
		$single_template = plugin_dir_path( dirname( __FILE__ ) ).'single-employees.php';
	endif;
	return $single_template;
}

/**
* Create [employees] shortcode
**/
function employees( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'count' => -1,
	  		),
	  	$atts ) 
	);
	$query = new WP_Query(
        array(
            'post_type' => 'employees',
            'post_status' => 'publish',
			'posts_per_page' => $count,
			'orderby' => 'rand'
        )
	);
	$str = '';
    while ($query->have_posts()) {
        $query->the_post();
        $str .= '<a href="'.get_the_permalink().'">'.get_the_title().'</a><br>';
    }
    wp_reset_query();
    return $str;
}
add_shortcode('employees', 'employees');

/**
 * Create custom meta boxes
 */
function employees_register_meta() {
    add_meta_box( 'employee-information', 'Employee Information', 'employees_meta_callback', 'employees' );
}
add_action( 'add_meta_boxes', 'employees_register_meta' );

function employees_meta_callback( $post ) {
    include plugin_dir_path( __FILE__ ).'/cmb/employees.php';
}

/**
 * Save custom meta box values
 */
function employees_save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'employee_title',
        'employee_hire_date',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
}
add_action( 'save_post', 'employees_save_meta_box' );

/**
 * Add New columns to custom post type
 */
add_filter( 'manage_employees_posts_columns', 'set_custom_edit_employees_columns' );
function set_custom_edit_employees_columns($columns) {
	unset( $columns['categories'] );
	unset( $columns['tags'] );	
	$columns = array(
		'cb' => 'cb',
		'title'=>'Title',
		'employee_title' => 'Employee Title',
		'employee_hire_date' => 'Hire Date',
		'date' => 'Date'
	);

    return $columns;
}

add_action( 'manage_employees_posts_custom_column' , 'custom_employees_column', 10, 2 );
function custom_employees_column( $column, $post_id ) {
    switch ( $column ) {

        case 'employee_title' :
            echo get_post_meta( $post_id , 'employee_title' , true ); 
            break;

		case 'employee_hire_date' :
			$date = get_post_meta( $post_id , 'employee_hire_date' , true );
			if($date != NULL):
				echo date('m/d/Y', strtotime($date));
			endif;
            break;

    }
}

/**
 * Sort columns
 */
add_filter( 'manage_edit-employees_sortable_columns', 'employees_sortable_columns');
function employees_sortable_columns( $columns ) {
	$columns['employee_title'] = 'employee_title';
	$columns['employee_hire_date'] = 'employee_hire_date';
	return $columns;
}