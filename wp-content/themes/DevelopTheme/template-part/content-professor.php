<?php if(! defined('ABSPATH')) exit;  //Exit if accessed directly ?>

<div class="col-12 col-sm-9 col-md-3 my-4 mx-2 mx-sm-3 mx-md-2">
    <div class="professor-container position-relative p-4 border rounded" style='background-image: url("<?php the_post_thumbnail_url(); ?>")'>
        <div class="post-overlay d-flex justify-content-center align-items-end">
            <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
            <span class="ms-2 mb-2 text-center read-more"><a class='text-primary' href="<?php the_permalink() ?>">Read More <i class="fa-solid fa-arrow-right"></i></a></span>
        </div>
    </div>
</div>