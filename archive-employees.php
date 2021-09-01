<?php
    /**
     * Archive page display for the employees
     */
    get_header();
?>
<h1>Employee Archives</h1>
<?php
    while(have_posts()):
        the_post();
        echo '<a href="'.get_the_permalink().'">'.get_the_title().'</a><br>';
    endwhile;
?>
<?php
    get_footer();