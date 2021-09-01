<?php
    /**
     * Single page display for the employees
     */
    get_header();
?>
<?php
    while(have_posts()):
        the_post();
        $title = esc_attr( get_post_meta( get_the_ID(), 'employee_title', true ) );
        $hire_date = esc_attr( get_post_meta( get_the_ID(), 'employee_hire_date', true ) );
        echo '<h1>'.get_the_title().'</h1>';
        echo the_content();
        echo 'Title: '.$title;
        echo '<br>';
        echo 'Hire Date: '.date('m/d/Y', strtotime($hire_date));
    endwhile;
?>
<?php
    get_footer();