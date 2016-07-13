<?php
/**
 * The template for displaying project message list, mesage form in single project
 */
global $post, $user_ID;
$date_format = get_option('date_format');
$time_format = get_option('time_format');

$query_args = array('type' => 'message', 'post_id' => $post->ID , 'paginate' => 'load', 'order' => 'DESC', 'orderby' => 'date' );
/**
 * count all reivews
*/
$total_args = $query_args;
$all_cmts   = get_comments( $total_args );

/**
 * get page 1 reviews
*/
$query_args['number'] = 10;//get_option('posts_per_page');
$comments = get_comments( $query_args );

$total_messages = count($all_cmts);
$comment_pages  =   ceil( $total_messages/$query_args['number'] );
$query_args['total'] = $comment_pages;
$query_args['text'] = __("Load older message", ET_DOMAIN);

$messagedata = array();
$message_object = Fre_Message::get_instance();

?>
<div class="project-workplace-details workplace-details">
    <div class="row">
        <div class="col-md-8 message-container">
        	<div class="work-place-wrapper">
                <?php if($post->post_status != 'complete') { ?>
            	<form class="form-group-work-place-wrapper form-message">
                	<div class="form-group-work-place file-container"  id="apply_docs_container">
                        <span class="et_ajaxnonce" id="<?php echo wp_create_nonce( 'file_et_uploader' ) ?>"></span>
                    	<a href="#" class="avatar-employer">
                            <?php echo get_avatar($user_ID, '33') ?>
                        </a>
                        <div class="content-chat-wrapper">
                        	<div class="triangle"></div>
                            <a href="#" class="attack attach-file" id="apply_docs_browse_button"><i class="fa fa-paperclip"></i></a>
                            <textarea name="comment_content" class="content-chat"></textarea>
                            <input type="submit" name="submit" value="<?php _e( "Send" , ET_DOMAIN ); ?>" class="submit-chat-content">
                            <input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" />
                        </div>
                        <ul class="file-attack apply_docs_file_list" id="apply_docs_file_list">
                        </ul>
                    </div>
                </form>
                <?php } ?>
                <ul class="list-chat-work-place">
                    <?php 
                    foreach ($comments as $key => $message) { 
                        $convert = $message_object->convert($message);
                        $messagedata[] = $convert;
                    ?>
                	<li class="message-item" id="comment-<?php echo $message->comment_ID; ?>">
                    	<div class="form-group-work-place">
                            <a href="#" class="avatar-employer">
                                <?php echo $message->avatar; ?>
                            </a>
                            <div class="content-chat-wrapper">
                                <div class="triangle"></div>
                                <div class="content-chat fixed-chat">
                                <?php echo $convert->comment_content; ?>
                                <?php echo $convert->file_list; ?>
                                </div>
                                <div class="date-chat">
                                <?php 
                                    echo $message->message_time;
                                ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
                <?php if($comment_pages > 1) { ?>
                <div class="paginations-wrapper" >
                    <?php ae_comments_pagination( $comment_pages, $paged ,$query_args );   ?>
                </div>
                <?php } ?>
                <?php echo '<script type="json/data" class="postdata" > ' . json_encode($messagedata) . '</script>'; ?>
            </div>
        </div>
        <?php if(!et_load_mobile()) { ?>
        <div class="col-md-4 workplace-project-details">
        	<div class="content-require-project">
                <?php 
                if(fre_access_workspace($post)) {
                    echo '<a style="font-weight:600;" href="'.get_permalink( $post->ID ).'">
                            <i class="fa fa-arrow-left"></i> '.__("Back To Project Page", ET_DOMAIN).
                        '</a>';
                }
                ?>
                <h4><?php _e('Project description:',ET_DOMAIN);?></h4>
                <?php the_content(); ?>

            </div>
        </div>
        <?php } ?>
    </div>
</div>
