<?php

function peProjectImage($id, $type)
{

    $option = get_option('pe-redux');
    $template_type = '';
    $imageClasses = '';
    $animation = '';
    $animationAttributes = '';

    global $wp_query;
    $postid = $wp_query->post->ID;


    if (get_post_type($postid) === 'portfolio') {

        if (get_field('video_provider', $id) == 'vimeo' || get_field('video_provider', $id) == 'youtube') {

            $animation = 'has-anim maskUp';
            $imageClasses = $animation;
            $animationAttributes = 'data-duration=1 data-delay=0';
        }

    }


    ?>
    <!-- Project Image -->
    <div class="project-image featured <?php echo esc_attr($imageClasses); ?>" <?php echo esc_attr($animationAttributes); ?>>

        <?php if (get_field('featured_image_type', $id) == 'image') {

            echo get_the_post_thumbnail($id);

        } else if ((get_field('featured_image_type', $id) == 'video')) { ?>

            <?php if (get_field('video_provider', $id) == 'self') { ?>

                    <!-- Pe Video -->
                    <div class="pe-video no-interactions p-self" data-controls="false">

                        <video autoplay muted playsinline loop class="pe-video-wrap">
                            <source src="<?php echo esc_url(get_field('self_video', $id)); ?>">
                        </video>

                    </div>
                    <!--/Pe Video -->

            <?php } else if (get_field('video_provider', $id) == 'vimeo') { ?>

                        <div class="pe-video n-vimeo no-interactions" data-controls="false" data-autoplay=true data-muted=true
                            data-loop=true>

                            <div class="p-video" data-plyr-provider="vimeo"
                                data-plyr-embed-id="<?php echo esc_attr(get_field('video_id', $id)) ?>"></div>

                        </div>


            <?php } else if (get_field('video_provider', $id) == 'youtube') { ?>

                            <div class="pe-video no-interactions p-youtube" data-controls="false" data-autoplay=true data-muted=true
                                data-loop=true>

                                <div class="pe-video-wrap" data-plyr-provider="youtube"
                                    data-plyr-embed-id="<?php echo esc_attr(get_field('video_id', $id)) ?>"></div>

                            </div>

            <?php }
        } ?>

    </div>
    <!--/Project Image -->

    <?php

}
function pe_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'pe_excerpt_length', 999);

function pe_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'pe_excerpt_more');


function add_google_maps_api_meta_tag()
{
    $api_key = get_option('elementor_google_maps_api_key');
    if (!empty($api_key)) {
        echo '<meta name="google-maps-api-key" content="' . esc_attr($api_key) . '">';
    }
}
add_action('wp_head', 'add_google_maps_api_meta_tag');
