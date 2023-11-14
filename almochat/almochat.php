<?php
/**
 * @package almochat
 */
/*
 Plugin Name: Almo Chat
 Plugin URI: https://www.almochat.com
 Description: AI-powered Chatbot solution that helps businesses automate customer interactions to manage issue resolutions, feedback collection, and more.
 Version: 1.0.0
 Author: almochat
 License: GPLv2 or later
 Text Domain: almochat
 */

 if ( ! defined( 'ABSPATH' ) ) {
    die; // Die if accessed directly
}

// Register a function to add an admin menu page
add_action( 'admin_menu', 'chatbot_plugin_admin_menu' );

function chatbot_plugin_admin_menu() {
    add_menu_page( 'Chatbot Plugin Settings', 'Almo Chat', 'manage_options', 'chatbot-plugin-settings', 'chatbot_plugin_settings_page' );
}

// Display the plugin settings page
function chatbot_plugin_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_POST['chatbot_id'] ) ) {
        // Save the chatbot ID
        update_option( 'chatbot_id', sanitize_text_field( $_POST['chatbot_id'] ) );
        echo '<div class="notice notice-success"><p>Chatbot ID has been saved!</p></div>';
    }

    $chatbot_id = get_option( 'chatbot_id' );

    ?>
    <div class="wrap">
        <h1>Almo Chatbot Details</h1>
        <form method="post" action="" onsubmit="return checkBoxValidation();">
    <label id="label-chatbot_id" for="chatbot_id">Chatbot ID:</label>
    <input type="text" name="chatbot_id" id="chatbot_id" value="<?php echo esc_attr( $chatbot_id ); ?>" required><br><br>
    <input type="checkbox" name="accept_terms" id="accept_terms">
    <label id="label-accept-terms" for="accept_terms">I hereby consent to display the "Powered by Almo" attribution on my chatbot interface. Additionally, I agree to utilize the provided Almo chat hyperlink for the purpose of embedding the chatbot into my website via an iframe.</label><br><br>
    <input type="submit" class="button button-primary" style='margin-top:10px;width:150px;font-size:14px;height:40px;' value="Save">
</form>
<div id="error-message"></div>
    </div>
    <script type="text/javascript">
 function checkBoxValidation() {
   if (!document.getElementById('accept_terms').checked) {
     document.getElementById('error-message').innerHTML = "*It is mandatory to accept the above terms in order to integrate the AlmoChat chatbot on the website.";
     return false;
   } else {
     return true;
   }
}
</script>
    <style>
        #chatbot_id{
            width: 300px;
        }
        #label-chatbot_id{
            font-size:14px;
            font-weight:500;
        }
        #error-message{
            color:red;
            font-size:14px;
            margin-top:20px
        }
        #label-accept-terms{
            font-size:14px;
            font-weight:500;
        }
        form{
            width:75%;
            margin-top:30px;
        }
    </style>
    <?php
}


function chatbot_plugin_add_iframe() {
    $chatbot_id = get_option( 'chatbot_id' );
    $image_path = plugin_dir_url(__FILE__) .'assets/Almo-logo.png';

    if ( ! empty( $chatbot_id ) ) {
        echo '<div id="chatbot-container">';
        echo '<iframe id="chatbot-iframe" src="https://www.almochat.com/chatbot/' . $chatbot_id . '" style="position: fixed;"></iframe></div>';
             //image on click toggles the chatbot visibility
        echo '<img id="chatbot-toggle" src="' . $image_path . '" alt="Image" />';
        }
    }


function chatbot_plugin_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script('chatbot_plugin_script', plugin_dir_url(__FILE__) . 'assets/script.js', array( 'jquery' ), '1.0', true );
}
function chatbot_plugin_enqueue_styles() {
    wp_enqueue_style( 'chatbot-plugin-styles', plugin_dir_url( __FILE__ ) . 'assets/styles.css' );
}

    
// Embed the chatbot iframe at the bottom of the website, style and script
add_action( 'wp_footer', 'chatbot_plugin_add_iframe' );
add_action('wp_enqueue_scripts', 'chatbot_plugin_enqueue_scripts');
add_action( 'wp_enqueue_scripts', 'chatbot_plugin_enqueue_styles' );
