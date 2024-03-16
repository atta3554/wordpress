<?php if(!is_user_logged_in()) {
    wp_redirect(site_url('/'));
    exit;
} ?>
<?php get_header();?>
<?php $myNotes= new WP_QUERY(array('post_type'=> 'note', 'post_per_page'=> -1)) ?>


<?php while(have_posts()) :the_post(); pageBanner('', '', '');?>
    <div class="container" id='notes-container'>

        <div class="row my-5 justify-content-center">
            <div class="col-9 new-note-box d-flex flex-column rounded">
                <h2 class="my-2">Create a new Note</h2>
                <input type="text" class='note-title my-2' id="">
                <textarea class="note-body my-2"></textarea>
                <span class="submit-note my-2 w-25 text-center px-3 py-2 bg-danger text-white rounded" role='button'>Create Note</span>
            </div>
        </div>

        <div class="row ">
            <?php while($myNotes->have_posts()) : $myNotes->the_post(); ?>
                <div class="note-box border rounded mx-5 py-4 my-5 col-5 d-flex overflow-hidden flex-column" data-id='<?php the_ID(); ?>'>
                    <div class='d-flex px-3 justify-content-between align-items-center'>
                        <input readonly class='note-title px-3 py-2 my-3' type="text" value='<?php echo substr(esc_attr(get_the_title()), 9); ?>'>
                        <div class='d-flex'>
                            <span role="button" class="edit-note border rounded px-2 mx-2"><i class='fa fa-pencil me-2' aria-hidden="true"></i>Edit</span>
                            <span role="button" class="delete-note border rounded px-2 border-danger text-danger"><i class='fa fa-trash-o me-2' aria-hidden="true"></i>Delete</span>
                        </div>
                    </div>
                    <textarea readonly class='note-body p-3 w-100 overflow-auto'><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
                    <div class="row">
                        <div class="col-3">
                            <span class='cancel-note mx-auto my-2 bg-primary text-white text-center rounded py-2' role='button'>
                                <i class='fa fa-close me-2' aria-hidden='true'></i>Cancel
                            </span>
                        </div>
                        <div class="col-9">
                            <span class="error-message">your notes count has reached to Limit; please delete a note</span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endwhile; ?>

<div class="delete-note__alert-container">
    <div class="delete-note__alert-bg rounded">
        <h2 class='delete-note__alert-content'>your note deleted succesfully</h2>
    </div>
</div>

<?php get_footer() ?>
