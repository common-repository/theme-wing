<?php
/**
 * Custom Repeater Field Custom Posts
 * 
 * @since 1.0.0
 * @package Theme Wing
 */
class Theme_Wing_Custom_Repeater extends \WP_Customize_Control {
    //Arguments passed to this class
    private $args;

    //Default values passed when control is registered
    private $defaults;

    //Row label key value
    private $row_label;

    //Add new button label
    private $add_new_label;

    /**
     * Main Function
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this -> args = $args;
        $this -> row_label = $args ['row_label'];
        $this -> add_new_label = $args ['adD_new_label'];
        parent::__construct( $manager, $id, $args );
        $this -> defaults = $this -> setting -> default;
    }

    /**
     * Enqueue Scripts
     */
    function enqueue() {
        wp_enqueue_style( 'theme_wing_repeater', THEME_WING_URI . '/admin/metaboxes/repeater/repeater.css', array(), THEME_WING_VERSION, 'all' );
        wp_enqueue_script( 'theme_wing_reater', THEME_WING_URI . '/admin/metaboxes/repeater/repeater.js', array( 'jQuery' ), THEME_WING_VERSION, true );
    }

    /**
     * For The Structure
     */
    public function render_content() {
        $fields = json_decode( json_encode( $this->args['fields'] ) );
        $control_values = $this->values();
        $control_values = ( ! empty( $control_values ) ) ? json_decode( $control_values ) : json_decode( json_encode( array( $fields ) ) );
        $item_count = 1;
        ?>

        <div class="theme-wing-repeater-control">
            <label for="customize-control-title"><?php echo esc_html( $this->label ); ?> </label>
            <?php if ( $this->description ) { ?>
                <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php } ?>
            <div class="theme-wing-repeater-control-inner">
            <?php foreach( $control_values as $control_value_key => $control_value ) : ?>
                    <div class="theme-wing-repeater-item <?php if( $control_value->item_option === 'show' ) : echo 'visible'; else : echo 'not-visible'; endif; ?>">
                        <div class="item-heading-wrap">
                            <span class="display-icon dashicons dashicons-<?php if( $control_value->item_option === 'show' ) : echo 'visibility'; else : echo 'hidden'; endif; ?>"></span>
                            <h2 class="item-heading"><?php echo esc_html( $this->row_label ); ?></h2>
                            <span class="sortable-icon dashicons dashicons-menu-alt2"></span>
                        </div>
                        <div class="item-control-fields">
                            <?php
                                foreach( $fields as $field_key => $field_val ) :
                                    if( $field_key != 'item_option' ) {
                                        $this->render_control( $field_key, $field_val, $control_value );
                                    } else {
                                        echo '<input type="hidden" class="repeater-field-value-holder" data-default="' .esc_attr($field_val). '" data-key="' .esc_attr( $field_key ). '" value="' .esc_attr( $control_value->$field_key ). '">';
                                    }
                                endforeach;
                            ?>
                                <div class="remove-item" <?php if( $item_count == 1 ) echo 'style="display:none;"'; ?>>
                                    <?php echo esc_html__( 'Remove field', 'theme-wing' ); ?>
                                </div>
                        </div>
                    </div>
                <?php $item_count++; endforeach; ?>
                <div class="buttons-wrap">
                    <button class="add-new-item"><span class="dashicons dashicons-plus"></span><?php echo esc_html( $this->add_new_label ); ?></button>
                    <input type="hidden" class="repeater-control-value-holder" <?php echo esc_attr( $this->link() ); ?> value="<?php echo esc_attr( $control_values ); ?>"/>
                </div>
            </div>
        </div>
        <?php
    }
}

