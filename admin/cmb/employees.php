<div class="employee-information">
    <style scoped>
        .employee-information{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .employee-information .field{
            display: contents;
        }
    </style>
    <p class="meta-options field">
        <label for="employee_title">Title</label>
        <input id="employee_title" type="text" name="employee_title" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'employee_title', true ) ); ?>">
    </p>
    <p class="meta-options field">
        <label for="employee_hire_date">Hire Date</label>
        <input id="employee_hire_date" type="date" name="employee_hire_date" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'employee_hire_date', true ) ); ?>">
    </p>
</div>