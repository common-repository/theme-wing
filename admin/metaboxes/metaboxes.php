<?php
/**
 * Include functions and hooks required for rendering meta boxes
 *
 * @package Theme Wing
 * @since 1.0.0
 */
if( ! function_exists( 'theme_wing_services_meta_box' ) ) :
    /**
     * Add post meta for "Services" cusmtom post
     * 
     * 
     * @package Theme Wing
     * @since 1.0.0
     */ 
    function theme_wing_services_meta_box () {
        add_meta_box( 'theme-wing-services-meta-box', esc_html__( 'Service Detail Information', 'theme-wing' ), 'theme_wing_services_meta_html', array( 'tw-services' ) );
    }
endif;

if( ! function_exists( 'theme_wing_services_meta_html' ) ) :
    /**
     * Callback function for services post meta
     * 
     * echos the meta html
     */ 
    function theme_wing_services_meta_html( $post ) {
        // Create our nonce field.
        wp_nonce_field( 'theme_wing_post_meta_nonce' , 'theme_wing_post_meta_services_nonce' );

        // default value set for services sub title.
        if( !metadata_exists( 'post', $post->ID, 'service_sub_title' ) ) {
            update_post_meta( $post->ID, 'service_sub_title', esc_html__( 'Add services sub title', 'theme-wing' ) );
        }
        $service_sub_title = get_post_meta( $post->ID, 'service_sub_title', true );
        $service_sub_title = ( $service_sub_title ) ? $service_sub_title : esc_html__( 'Add services sub title', 'theme-wing' );

        // default value set for services description.
        if( !metadata_exists( 'post', $post->ID, 'service_description' ) ) {
            update_post_meta( $post->ID, 'service_description', '' );
        }
        $service_description = get_post_meta( $post->ID, 'service_description', true );
        $service_description = ( $service_description ) ? $service_description : '';

        // default value set for services icon.
        if( !metadata_exists( 'post', $post->ID, 'service_icon' ) ) {
            update_post_meta( $post->ID, 'service_icon', 'fas fa-cogs' );
        }
        $service_icon = get_post_meta( $post->ID, 'service_icon', true );
        $service_icon = ( $service_icon ) ? $service_icon : 'fas fa-cogs';
    ?>
        <div class="theme-wing-meta-box-wrap theme-wing-services-meta-box">
            <div class="theme-wing-meta-field meta-text-field">
                <label for="service_sub_title" class="meta-field-title"><?php echo esc_html__( 'Service Sub Title', 'theme-wing' ); ?></label>
                <div class="meta-field">
                    <input type="text" name="service_sub_title" value="<?php echo esc_html( $service_sub_title ); ?>"/>
                </div>
            </div>
            <div class="theme-wing-meta-field meta-textarea-field">
                <label for="service_description" class="meta-field-title"><?php echo esc_html__( 'Short Description', 'theme-wing' ); ?></label>
                <p class="meta-field-description"><?php echo esc_html__( 'Add few lines describing your service.', 'theme-wing' ); ?></p>
                <div class="meta-field">
                    <textarea name="service_description" id="theme-wing-service-description"><?php echo esc_html( $service_description ); ?></textarea>
                </div>
            </div>
            <div class="theme-wing-meta-field meta-icon-picker-field">            
                <?php $icons_list = theme_wing_get_fontawesome_icons(); ?>
                <label class="meta-field-title"><?php echo esc_html__( 'Service Icon', 'theme-wing' ); ?></label>
                <p class="meta-field-description"><?php echo esc_html__( 'Choose the icons from dropdown for service', 'theme-wing' ); ?></p>
                <div class="icon-holder">
                    <div class="icon-header">
                        <div class="active-icon"><i class="<?php echo esc_attr( $service_icon ); ?>"></i></div>
                        <div class="icon-list-trigger"><i class="fas fa-angle-down"></i></div>
                    </div>
                    <div class="search-field" style="display:none;">
                        <input type="text" placeholder="<?php echo esc_html__( 'Type keyword to search social icon', 'theme-wing' ); ?>">
                    </div>
                    <div class="icons-list" style="display:none;">
                        <?php
                            foreach( $icons_list as $icon ) :
                            ?>
                                <i class="<?php echo esc_attr( $icon ); ?> <?php if( $icon === $service_icon ) echo 'selected'; ?>"></i>
                            <?php
                            endforeach;
                        ?>
                    </div>
                    <input name="service_icon" type="hidden" value="<?php echo esc_attr( $service_icon ); ?>"/>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if( ! function_exists( 'theme_wing_services_save_meta_data' ) ) :
    /**
     * Saves the meta data for services post type
     * 
     * @return
     */ 
    function theme_wing_services_save_meta_data( $post_id ) {
        if ( ! isset( $_POST['theme_wing_post_meta_services_nonce'] ) || ! wp_verify_nonce( $_POST['theme_wing_post_meta_services_nonce'], 'theme_wing_post_meta_nonce' ) ) return;

        // Check if user has permissions to save data...
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

        // Check auto save
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        //* Check if not a revision...
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        if ( isset( $_POST [ 'service_icon' ] ) ) {
            update_post_meta( $post_id, 'service_icon', sanitize_text_field( $_POST[ 'service_icon' ] ) );
        }

        if ( isset( $_POST[ 'service_description' ] ) ) {
            update_post_meta( $post_id, 'service_description', sanitize_text_field( $_POST[ 'service_description' ] ) );
        }

        if ( isset ( $_POST[ 'service_sub_title' ] ) ) {
            update_post_meta( $post_id, 'service_sub_title', sanitize_text_field( $_POST[ 'service_sub_title' ] ) );
        }
    }
    add_action( 'save_post', 'theme_wing_services_save_meta_data' );
endif;

if( ! function_exists( 'theme_wing_team_meta_box' ) ) :
    /**
     * Add post meta for "Teams" cusmtom post
     * 
     * 
     * @package Theme Wing
     * @since 1.0.0
     */ 
    function theme_wing_team_meta_box () {
        add_meta_box( 'theme-wing-teams-meta-box', esc_html__( 'Teams Detail Information', 'theme-wing' ), 'theme_wing_team_meta_html', array( 'tw-team' ) );
    }
endif;

if( ! function_exists( 'theme_wing_team_meta_html' ) ) :
    /**
     * Callback function for team post meta
     * 
     * echos the meta html
     */ 
    function theme_wing_team_meta_html( $post ) {
        // Create our nonce field.
        wp_nonce_field( 'theme_wing_post_meta_nonce' , 'theme_wing_post_meta_team_nonce' );

        // default value set for team designation.
        if( !metadata_exists( 'post', $post->ID, 'team_designation' ) ) {
            update_post_meta( $post->ID, 'team_designation', esc_html__( 'Developer & Head of Office', 'theme-wing' ) );
        }
        $team_designation = get_post_meta( $post->ID, 'team_designation', true );
        $team_designation = ( $team_designation ) ? $team_designation : esc_html__( 'Developer & Head of Office', 'theme-wing' );

        // default value set for team member about summary.
        if( !metadata_exists( 'post', $post->ID, 'team_about' ) ) {
            update_post_meta( $post->ID, 'team_about', '' );
        }
        $team_about = get_post_meta( $post->ID, 'team_about', true );
        $team_about = ( $team_about ) ? $team_about : '';

        // default value set for team social media icons.
        if( !metadata_exists( 'post', $post->ID, 'team_social_medias' ) ) {
            update_post_meta( $post->ID, 'team_social_medias', json_encode( array( array( 
                    'social_icon'   =>  'fab fa-linkedin-in',
                    'social_icon_url'   =>  ''
                )))
            );
        }
        $team_social_medias = get_post_meta( $post->ID, 'team_social_medias', true );
        $team_social_medias = ( $team_social_medias ) ? $team_social_medias : json_encode( array( array( 
                    'social_icon'   =>  'fab fa-linkedin-in',
                    'social_icon_url'   =>  ''
                ))
            );
    ?>
        <div class="theme-wing-meta-box-wrap theme-wing-team-meta-box">
            <div class="theme-wing-meta-field meta-text-field">
                <label for="team_designation" class="meta-field-title"><?php echo esc_html__( 'Designation of team member', 'theme-wing' ); ?></label>
                <div class="meta-field">
                    <input type="text" id="theme-wing-team-designation" name="team_designation" value="<?php echo esc_html( $team_designation ); ?>"/>
                </div>
            </div>
            <div class="theme-wing-meta-field meta-textarea-field">
                <label for="team_about" class="meta-field-title"><?php echo esc_html__( 'About team member', 'theme-wing' ); ?></label>
                <p class="meta-field-description"><?php echo esc_html__( 'Add summary about team member.', 'theme-wing' ); ?></p>
                <div class="meta-field">
                    <textarea name="team_about" id="theme-wing-team-about"><?php echo esc_html( $team_about ); ?></textarea>
                </div>
            </div>
            <div class="theme-wing-meta-field meta-repeater-control">
                <label for="team_social_medias" class="meta-field-title"><?php esc_html_e( 'Team Memeber Social Media Connections', 'theme-wing' ); ?></label>
                <?php
                    $team_social_medias = json_decode( $team_social_medias );
                    if( $team_social_medias ) :
                        foreach( $team_social_medias as $social_key => $social_item ) :
                            $social_icon = $social_item->social_icon;
                            $social_icon_url = $social_item->social_icon_url
                    ?>
                            <div class="repeater-item">
                                <div class="repeater-item-field theme-wing-meta-field meta-icon-picker-field">
                                    <?php $icons_list = theme_wing_get_fontawesome_icons(); ?>
                                    <label class="meta-field-title"><?php echo esc_html__( 'Social Icon', 'theme-wing' ); ?></label>
                                    <p class="meta-field-description"><?php echo esc_html__( 'Choose the icons from dropdown', 'theme-wing' ); ?></p>
                                    <div class="icon-holder">
                                        <div class="icon-header">
                                            <div class="active-icon"><i class="<?php echo esc_attr( $social_icon ); ?>"></i></div>
                                            <div class="icon-list-trigger"><i class="fas fa-angle-down"></i></div>
                                        </div>
                                        <div class="search-field" style="display:none;">
                                            <input type="text" placeholder="<?php echo esc_html__( 'Type keyword to search social icon', 'theme-wing' ); ?>">
                                        </div>
                                        <div class="icons-list" style="display:none;">
                                            <?php
                                                foreach( $icons_list as $icon ) :
                                                ?>
                                                    <i class="<?php echo esc_attr( $icon ); ?><?php if( $icon === $social_icon ) echo ' selected'; ?>"></i>
                                                <?php
                                                endforeach;
                                            ?>
                                        </div>
                                        <input name="social_icon" class="repeater-field-single-meta-value" data-key="social_icon" type="hidden" value="<?php echo esc_attr( $social_icon ); ?>"/>
                                    </div>
                                </div>
                                <div class="repeater-item-field meta-url-field">
                                    <label class="meta-field-title" for="<?php echo esc_attr(  'team_social_medias[' .$social_key. ']' ); ?>"><?php echo esc_html__( 'Social Icon Url', 'theme-wing' ); ?></label>
                                    <div class="meta-field">
                                        <input class="repeater-field-single-meta-value" type="url" data-key="social_icon_url" name="<?php echo esc_attr(  'team_social_medias[' .$social_key. ']' ); ?>" value="<?php echo esc_url( $social_icon_url ); ?>">
                                    </div>
                                </div>
                                <span class="add-item dashicons dashicons-plus-alt"></span><span class="remove-item dashicons dashicons-minus" <?php if( $social_key < 1 ) echo 'style="display:none;"'; ?>></span>
                            </div>
                    <?php
                        endforeach;
                    endif;
                ?>
                <input class="repeater-field-meta-value" type="hidden" name="team_social_medias" value="<?php echo esc_attr( json_encode( $team_social_medias ) ); ?>">
            </div>
        </div>
        <?php
    }
endif;

if( ! function_exists( 'theme_wing_team_save_meta_data' ) ) :
    /**
     * Saves the meta data for team post type
     * 
     * @return
     */
    function theme_wing_team_save_meta_data( $post_id ) {
        if ( ! isset( $_POST['theme_wing_post_meta_team_nonce'] ) || ! wp_verify_nonce( $_POST['theme_wing_post_meta_team_nonce'], 'theme_wing_post_meta_nonce' ) ) return;

        // Check if user has permissions to save data...
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

        // Check auto save
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        //* Check if not a revision...
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        if ( isset( $_POST[ 'team_designation' ] ) ) {
            update_post_meta( $post_id, 'team_designation', sanitize_text_field( $_POST[ 'team_designation' ] ) );
        }

        if ( isset ( $_POST[ 'team_about' ] ) ) {
            update_post_meta( $post_id, 'team_about', sanitize_text_field( $_POST[ 'team_about' ] ) );
        }

        if ( isset ( $_POST[ 'team_social_medias' ] ) ) {
            update_post_meta( $post_id, 'team_social_medias', sanitize_text_field( $_POST[ 'team_social_medias' ] ) );
        }
    }
    add_action( 'save_post', 'theme_wing_team_save_meta_data' );
endif;


if( ! function_exists( 'theme_wing_pricing_meta_box' ) ) :
    /**
     * Add post meta for "Pricing" cusmtom post
     * 
     * 
     * @package Theme Wing
     * @since 1.0.0
     */ 
    function theme_wing_pricing_meta_box () {
        add_meta_box( 'theme-wing-pricing-meta-box', esc_html__( 'Pricing Detail Information', 'theme-wing' ), 'theme_wing_pricing_meta_html', array( 'tw-pricing' ) );
    }
    add_action( 'add_meta_boxes', 'theme_wing_pricing_meta_box' );
endif;

if( ! function_exists( 'theme_wing_pricing_meta_html' ) ) :
    /**
     * Callback function for team post meta
     * 
     * echos the meta html
     */ 
    function theme_wing_pricing_meta_html( $post ) {
        // pricing featured meta
        if( ! metadata_exists( 'post', $post->ID, 'pricing_type' ) ) {
            update_post_meta( $post->ID, 'pricing_type', esc_html( 'regular' ) );
        }
        $pricing_type = get_post_meta( $post->ID, 'pricing_type', true );

        // pricing price currency meta
        if( ! metadata_exists( 'post', $post->ID, 'pricing_currency' ) ) {
            update_post_meta( $post->ID, 'pricing_currency', esc_html( '$' ) );
        }
        $pricing_currency = get_post_meta( $post->ID, 'pricing_currency', true );

        // pricing price meta
        if( ! metadata_exists( 'post', $post->ID, 'pricing_price' ) ) {
            update_post_meta( $post->ID, 'pricing_price', esc_html( '0.00' ) );
        }
        $pricing_price = get_post_meta( $post->ID, 'pricing_price', true );

        // pricing plan
        if( ! metadata_exists( 'post', $post->ID, 'pricing_plan' ) ) {
            update_post_meta( $post->ID, 'pricing_plan', esc_html( 'month' ) );
        }
        $pricing_plan = get_post_meta( $post->ID, 'pricing_plan', true );

        // pricing features
        if( ! metadata_exists( 'post', $post->ID, 'pricing_features' ) ) {
            update_post_meta( $post->ID, 'pricing_features', json_encode( array( array( 'feature' => esc_html__( 'Unlimited Storage', 'theme-wing' ) ) ) ) );
        }
        $pricing_features = get_post_meta( $post->ID, 'pricing_features', true );

        // pricing button label
        if( ! metadata_exists( 'post', $post->ID, 'pricing_button_label' ) ) {
            update_post_meta( $post->ID, 'pricing_button_label', esc_html__( 'Choose Plan', 'theme-wing' ) );
        }
        $pricing_button_label = get_post_meta( $post->ID, 'pricing_button_label', true );

        // pricing button url
        if( ! metadata_exists( 'post', $post->ID, 'pricing_button_url' ) ) {
            update_post_meta( $post->ID, 'pricing_button_url', '' );
        }
        $pricing_button_url = get_post_meta( $post->ID, 'pricing_button_url', true );
        // Create our nonce field.
        wp_nonce_field( 'theme_wing_post_meta_nonce' , 'theme_wing_post_meta_pricing_nonce' );
        ?>
            <div class="theme-wing-meta-box-wrap theme-wing-pricing-meta-box">
                <div class="theme-wing-meta-field">
                    <label for="pricing_type" class="meta-field-title"><?php esc_html_e( 'Pricing type', 'theme-wing' ); ?></label>
                    <select name="pricing_type" class="meta-field">
                        <option value="regular" <?php selected( $pricing_type, 'regular' ); ?>><?php esc_html_e( 'Regular', 'theme-wing' ); ?></option>
                        <option value="featured" <?php selected( $pricing_type, 'featured' ); ?>><?php esc_html_e( 'Featured', 'theme-wing' ); ?></option>
                        <option value="popular" <?php selected( $pricing_type, 'popular' ); ?>><?php esc_html_e( 'Popular', 'theme-wing' ); ?></option>
                    </select>
                </div>
                <div class="theme-wing-meta-field">
                    <label for="pricing_currency" class="meta-field-title"><?php esc_html_e( 'Currency', 'theme-wing' ); ?></label>
                    <div class="meta-field">
                        <input type="text" name="pricing_currency" value="<?php echo esc_attr( $pricing_currency ); ?>">
                    </div>
                </div>
                <div class="theme-wing-meta-field">
                    <label for="pricing_price" class="meta-field-title"><?php esc_html_e( 'Price', 'theme-wing' ); ?></label>
                    <div class="meta-field">
                        <input type="number" name="pricing_price" value="<?php echo esc_attr( $pricing_price ); ?>">
                    </div>
                </div>
                <div class="theme-wing-meta-field">
                    <label for="pricing_plan" class="meta-field-title"><?php esc_html_e( 'Plan period', 'theme-wing' ); ?></label>
                    <div class="meta-field">
                        <input type="text" name="pricing_plan" value="<?php echo esc_attr( $pricing_plan ); ?>">
                    </div>
                </div>

                <div class="theme-wing-meta-field meta-repeater-control">
                    <label for="pricing_features" class="meta-field-title"><?php esc_html_e( 'Features', 'theme-wing' ); ?></label>
                    <div class="meta-field">
                        <?php
                        // $pricing_features = json_encode( array( array( 'feature' => esc_html__( 'Unlimited Storage', 'theme-wing' ) ) ) );
                            $pricing_features = json_decode( $pricing_features );
                            if( $pricing_features ) :
                                foreach( $pricing_features as $pricing_feature_key => $pricing_feature ) :
                            ?>
                                    <div class="repeater-item feature-item">
                                        <input class="repeater-field-single-meta-value" data-key="feature" type="text" name="<?php echo esc_attr(  'pricing_features[' .$pricing_feature_key. ']' ); ?>" value="<?php echo esc_attr( $pricing_feature->feature ); ?>"><span class="add-item dashicons dashicons-plus-alt"></span><span class="remove-item dashicons dashicons-minus" <?php if( $pricing_feature_key < 1 ) echo 'style="display:none;"'; ?>></span>
                                    </div>
                            <?php
                                endforeach;
                            endif;
                        ?>
                        <input class="repeater-field-meta-value" type="hidden" name="pricing_features" value=<?php echo esc_attr( json_encode( $pricing_features ) ); ?>>
                    </div>
                </div>
                <div class="theme-wing-meta-field">
                    <label for="pricing_button_label" class="meta-field-title"><?php esc_html_e( 'Button label', 'theme-wing' ); ?></label>
                    <div class="meta-field">
                        <input type="text" name="pricing_button_label" value="<?php echo esc_attr( $pricing_button_label ); ?>">
                    </div>
                </div>
                <div class="theme-wing-meta-field">
                    <label for="pricing_button_url" class="meta-field-title"><?php esc_html_e( 'Button url', 'theme-wing' ); ?></label>
                    <div class="meta-field">
                        <input type="url" name="pricing_button_url" value="<?php echo esc_attr( $pricing_button_url ); ?>">
                    </div>
                </div>
            </div>
        <?php
    }
endif;

if( ! function_exists('theme_wing_pricing_meta_data_save') ) :
    /**
     * Save pricing meta data
     * 
     */  
    function theme_wing_pricing_meta_data_save( $post_id ) {
        if ( ! isset( $_POST['theme_wing_post_meta_pricing_nonce'] ) || ! wp_verify_nonce( $_POST['theme_wing_post_meta_pricing_nonce'], 'theme_wing_post_meta_nonce' ) ) return;

            // Check if user has permissions to save data...
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

        // Check auto save
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        //* Check if not a revision...
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        if( isset ( $_POST['pricing_type'] ) ) {
            update_post_meta( $post_id, 'pricing_type', sanitize_text_field( $_POST['pricing_type'] ) );
        }

        if( isset ( $_POST['pricing_currency'] ) ) {
            update_post_meta( $post_id, 'pricing_currency', sanitize_text_field( $_POST['pricing_currency'] ) );
        }

        if( isset( $_POST['pricing_price'] ) ) {
            update_post_meta( $post_id, 'pricing_price', sanitize_text_field( $_POST['pricing_price'] ) );
        }

        if( isset( $_POST['pricing_plan'] ) ) {
            update_post_meta( $post_id, 'pricing_plan', sanitize_text_field( $_POST['pricing_plan'] ) );
        }

        if( isset( $_POST['pricing_features'] ) ) {
            update_post_meta( $post_id, 'pricing_features', sanitize_text_field( $_POST['pricing_features'] ) );
        }

        if( isset( $_POST['pricing_button_label'] ) ) {
            update_post_meta( $post_id, 'pricing_button_label', sanitize_text_field( $_POST['pricing_button_label'] ) );
        }

        if( isset( $_POST['pricing_button_url'] ) ) {
            update_post_meta( $post_id, 'pricing_button_url', sanitize_url( $_POST['pricing_button_url'] ) );
        }
    }
    add_action( 'save_post', 'theme_wing_pricing_meta_data_save' );
endif;

if ( !function_exists( 'theme_wing_projects_meta_box' ) ) :
    /**
     * Add post meta for "Projects" Custom post
     * 
     * @package Theme Wing
     * @since 1.0.0
     */
    function theme_wing_projects_meta_box () {
        add_meta_box( 'theme-wing-projects-meta-box', esc_html__( 'Project Detail Information', 'theme-wing' ), 'theme_wing_project_meta_html', array( 'tw-projects' ) );
    }
    add_action( 'add_meta_boxes', 'theme_wing_projects_meta_box' );
endif;

if ( !function_exists( 'theme_wing_project_meta_html' ) ) :
    /**
     * Callback function for porjects post meta
     * 
     * echos the meta html
     */
    function theme_wing_project_meta_html( $post ) {
        // Create our nonce field
        wp_nonce_field( 'theme_wing_post_meta_nonce', 'theme_wing_post_meta_project_nonce' );

        // Default value set for Projects sub title
        if( !metadata_exists( 'post', $post->ID, 'project_sub_title' ) ) {
            update_post_meta( $post->ID, 'project_sub_title', esc_html__( 'Business Solution', 'theme-wing' ) );
        }
        $project_sub_title = get_post_meta( $post->ID, 'project_sub_title', true );
        $project_sub_title = ( $project_sub_title ) ? $project_sub_title : esc_html__( 'Business Solution', 'theme-wing' );

        //default value set for Projects Description
        if( !metadata_exists( 'post', $post->ID, 'project_description' ) ) :
            update_post_meta( $post->ID, 'project_description', '' );
        endif;
        $project_description = get_post_meta( $post->ID, 'project_description', true );
        $project_description = ( $project_description ) ? $project_description : '';
        ?>
        <div class="theme-wing-meta-box-wrap theme-wing-projects-meta-box">
            <div class="theme-wing-meta-field meta-text-field">
                <label for="project_sub_title" class="meta-fiield-title"><?php echo esc_html__( 'Project Sub Title', 'theme-wing' ); ?></label>
                <div class="meta-field">
                    <input type="text" id="theme-wing-projects-sub-title" name="project_sub_title" value="<?php echo esc_html( $project_sub_title ); ?>" />
                </div>
            </div>
            <div class="theme-wing-meta-field meta-textarea-field">
                <label for="project_description" class="meta-field-title"><?php echo esc_html__( 'Project Description', 'theme-wing' ); ?></label>
                <p class="meta-field-description"><?php echo esc_html__( 'Add summary about project.', 'theme-wing' ); ?></p>
                <div class="meta-field">
                    <textarea name="project_description" id="theme-wing-team-about"><?php echo esc_html( $project_description ); ?></textarea>
                </div>
            </div>
        </div>
    <?php
    }
endif;

if ( ! function_exists( 'theme_wing_project_save_meta_data' ) ) :
    /**
     * Saves the meta data for projects post type
     * 
     * @return
     */
    function theme_wing_project_save_meta_data( $post_id ) {
        if ( ! isset( $_POST['theme_wing_post_meta_project_nonce'] ) || !wp_verify_nonce( $_POST['theme_wing_post_meta_project_nonce'], 'theme_wing_post_meta_nonce' ) ) return;

        // Check if user has permissions to save data...
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

        // Check auto save
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        //* Check if not a revision...
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        if ( isset( $_POST['project_sub_title'] ) ) {
            update_post_meta( $post_id, 'project_sub_title', sanitize_text_field( $_POST[ 'project_sub_title' ] ) );
        }

        if ( isset( $_POST['project_description'] ) ) {
            update_post_meta( $post_id, 'project_description', sanitize_text_field( $_POST[ 'project_description' ] ) );
        }
    }
    add_action( 'save_post', 'theme_wing_project_save_meta_data' );
endif;