<?php
class DevDrawer {
    protected $version;
    public function __construct() {
        if ( defined( 'DevDrawer_Version' ) ) {
			$this->version = DevDrawer_Version;
		} else {
			$this->version = '1.0.0';
		}
    }

    public function run() {
        if ( is_admin() ){
            // this code will only run for the admin
        }
        $this->frontend_setup();
    }

    public function get_version() {
		return $this->version;
    }
    
    public function frontend_setup() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/cpts.php';
        add_action( 'init', 'create_employees', 0 );
        add_filter( 'single_template', 'employees_single');
        add_filter( 'template_include', 'employees_archive');
    }
}