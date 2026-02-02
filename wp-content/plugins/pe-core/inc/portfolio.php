<?php

// Our custom post type function
function create_posttype() {
    

}

// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

/*
* Creating a function to create our CPT
*/
 
function portfolio_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Portfolio', 'Post Type General Name', 'pe-core' ),
        'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'pe-core' ),
        'menu_name'           => __( 'Portfolio', 'pe-core' ),
        'parent_item_colon'   => __( 'Parent Portfolio', 'pe-core' ),
        'all_items'           => __( 'All Projects', 'pe-core' ),
        'view_item'           => __( 'View Project', 'pe-core' ),
        'add_new_item'        => __( 'Add New Project', 'pe-core' ),
        'add_new'             => __( 'Add New', 'pe-core' ),
        'edit_item'           => __( 'Edit Project', 'pe-core' ),
        'update_item'         => __( 'Update Project', 'pe-core' ),
        'search_items'        => __( 'Search Project', 'pe-core' ),
        'not_found'           => __( 'Not Found', 'pe-core' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'pe-core' ),
  
    );
     
// Set other options for Custom Post Type
    
        $port_slug = 'portfolio';
    
    if (class_exists('Redux')) {
        
         $option = get_option('pe-redux');
        
        if (! empty ($option['portfolio-slug'])) {
        
        $port_slug = $option['portfolio-slug'];
    }
        
    }
    
     
    $args = array(
        'label'               => __( 'portfolio', 'pe-core' ),
        'description'         => __( 'Portfolio projects', 'pe-core' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'work-types' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
        'rewrite'=> array(
            'slug'=> $port_slug
        )
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'portfolio', $args );

}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'portfolio_post_type', 0 );
 
//create a custom taxonomy name it "type" for your posts
function crunchify_create_deals_custom_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ), 
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Categories' ),
  ); 	
 
  register_taxonomy('project-categories' ,array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_rest'      => true, // Needed for tax to appear in Gutenberg editor.
    'query_var' => true,
    'rewrite' => array( 'slug' => 'category' ),
  ));
}

// Let us create Taxonomy for Custom Post Type
add_action( 'init', 'crunchify_create_deals_custom_taxonomy', 0 );


function alioth_add_cpt_support() {
    
    //if exists, assign to $cpt_support var
	$cpt_support = get_option( 'elementor_cpt_support' );
	
	//check if option DOESN'T exist in db
	if( ! $cpt_support ) {
	    $cpt_support = [ 'page', 'post', 'portfolio' ]; //create array of our default supported post types
	    update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
	}
	
	//if it DOES exist, but portfolio is NOT defined
	else if( ! in_array( 'portfolio', $cpt_support ) ) {
	    $cpt_support[] = 'portfolio'; //append to array
	    update_option( 'elementor_cpt_support', $cpt_support ); //update database
	}
	
	//otherwise do nothing, portfolio already exists in elementor_cpt_support option
}
add_action( 'after_switch_theme', 'alioth_add_cpt_support' );



