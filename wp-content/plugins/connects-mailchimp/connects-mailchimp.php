<?php
/**
* Plugin Name: Connects - Mailchimp Addon
* Plugin URI:
* Description: Use this plugin to integrate Mailchimp with Connects.
* Version: 2.0.3.3
* Author: Brainstorm Force
* Author URI: https://www.brainstormforce.com/
* License: http://themeforest.net/licenses
*/

if(!class_exists('Smile_Mailer_Mailchimp')) {
    class Smile_Mailer_Mailchimp {
        private $slug;
        private $setting;
        function __construct(){

            add_action( 'wp_ajax_get_mailchimp_data', array( $this,'get_mailchimp_data' ));
            add_action( 'wp_ajax_update_mailchimp_authentication', array( $this,'update_mailchimp_authentication' ));
            add_action( 'admin_init', array( $this, 'enqueue_scripts' ) );
            add_action( 'wp_ajax_disconnect_mailchimp', array( $this, 'disconnect_mailchimp' ));
            add_action( 'wp_ajax_mailchimp_add_subscriber', array( $this, 'mailchimp_add_subscriber' ));
            add_action( 'wp_ajax_nopriv_mailchimp_add_subscriber', array( $this, 'mailchimp_add_subscriber' ));

            $this->setting  = array(
                'name' => 'Mailchimp',
                'parameters' => array( 'api_key' ),
                'where_to_find_url' => 'http://kb.mailchimp.com/accounts/management/about-api-keys',
                'logo_url' => plugins_url('images/logo.png', __FILE__)
            );
            $this->slug = 'mailchimp';
        }

        /**
         * Function Name: enqueue_scripts
         * Function Description: Add custon scripts
         * @since 1.0
         */

        function enqueue_scripts() {
            if( function_exists( 'cp_register_addon' ) ) {
                cp_register_addon( $this->slug, $this->setting );
            }
            wp_register_script( $this->slug.'-script', plugins_url('js/'.$this->slug.'-script.js', __FILE__), array('jquery'), '1.1', true );
            wp_enqueue_script( $this->slug.'-script' );
            add_action( 'admin_head', array( $this, 'hook_css' ) );
        }

        /**
         * Function Name: hook_css
         * Function Description: Adds background style script for mailer logo.
         * @since 1.0
         */
        function hook_css() {
            if( isset( $this->setting['logo_url'] ) ) {
                if( $this->setting['logo_url'] != '' ) {
                    $style = '<style>table.bsf-connect-optins td.column-provider.'.$this->slug.'::after {background-image: url("'.$this->setting['logo_url'].'");}.bend-heading-section.bsf-connect-list-header .bend-head-logo.'.$this->slug.'::before {background-image: url("'.$this->setting['logo_url'].'");}</style>';
                    echo $style;
                }
            }
        }

        /**
        * retrieve mailer info
        * @since 1.0
        */
        function get_mailchimp_data(){

            if ( ! current_user_can( 'access_cp' ) ) {
                die(-1);
            }

            $isKeyChanged = false;

            $connected = false;
            ob_start();
            $mc_api = get_option($this->slug.'_api');

            if( $mc_api != '' ) {

                $request = $this->get_lists( $mc_api );

                if( isset( $request->status ) ) {
                    if( $request->status == 'error' && $request->code == 104  ) {
                        $formstyle = '';
                        $isKeyChanged = true;
                    }
                } else {
                    $formstyle = 'style="display:none;"';
                }

            } else {
                $formstyle = '';
            }
            ?>
            <div class="bsf-cnlist-form-row" <?php echo $formstyle; ?>>
                <label for="cp-list-name" ><?php _e( $this->setting['name'] . " API Key", "smile" ); ?></label>
                <input type="text" autocomplete="off" id="<?php echo $this->slug; ?>_api_key" name="<?php echo $this->slug; ?>-auth-key" value="<?php echo esc_attr( $mc_api ); ?>"/>
            </div>

            <div class="bsf-cnlist-form-row <?php echo $this->slug; ?>-list">
                <?php
                if( $mc_api != '' && !$isKeyChanged ) {
                    $mc_lists = $this->get_mailchimp_lists( $mc_api );

                    if( !empty( $mc_lists ) ){
                        $connected = true;
                    ?>
                    <label for="<?php echo $this->slug; ?>-list"><?php echo __( "Select List", "smile" ); ?></label>
                        <select id="<?php echo $this->slug; ?>-list" class="bsf-cnlist-select" name="<?php echo $this->slug; ?>-list">
                        <?php
                        foreach($mc_lists as $id => $name) {
                        ?>
                        <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <?php
                    } else {
                    ?>
                        <label for="<?php echo $this->slug; ?>-list"><?php echo __( "You need at least one list added in " . $this->setting['name'] . " before proceeding.", "smile" ); ?></label>
                    <?php
                    }
                }
                ?>
            </div>

            <div class="bsf-cnlist-form-row">
                <?php if( $mc_api == "" ) { ?>
                    <button id="auth-<?php echo $this->slug; ?>" class="button button-secondary auth-button" disabled><?php _e( "Authenticate " . $this->setting['name'], "smile" ); ?></button><span class="spinner" style="float: none;"></span>
                <?php } else {
                        if( $isKeyChanged ) {
                ?>
                    <div id="update-<?php echo $this->slug; ?>" class="update-mailer" data-mailerslug="<?php echo $this->setting['name']; ?>" data-mailer="<?php echo $this->slug; ?>"><span><?php _e( "Your credentials seems to be changed.</br>Use different '". $this->setting['name'] ."' credentials?", "smile" ); ?></span></div><span class="spinner" style="float: none;"></span>
                <?php
                        } else {
                ?>
                    <div id="disconnect-<?php echo $this->slug; ?>" class="button button-secondary" data-mailerslug="<?php echo $this->setting['name']; ?>" data-mailer="<?php echo $this->slug; ?>"><span><?php _e( "Use different '".$this->setting['name']."' account?", "smile" ); ?></span></div><span class="spinner" style="float: none;"></span>
                <?php
                        }
                ?>
                <?php } ?>
            </div>

            <?php
            $content = ob_get_clean();

            $result['data'] = $content;
            $result['helplink'] = esc_url( $this->setting['where_to_find_url'] );
            $result['isconnected'] = $connected;
            echo json_encode($result);
            exit();

        }

        /**
         * Get lists 
         * @param  string $api_key
         * @return array
         * @since 2.0.3.1
         */
        function get_lists( $api_key ) {

            $data = array();
            $dash_position = strpos( $api_key, '-' );

            if( $dash_position !== false ) {
                $api_url = 'https://' . substr( $api_key, $dash_position + 1 ) . '.api.mailchimp.com/3.0/';
            } else {
                return false;
            }

            $method = 'lists';
            $data['apikey'] = $api_key;
            $url = $api_url . $method;
           
            $list_opts = array(
                    'headers' => array(
                        'Content-Type' => 'application/json',
                        'Authorization' => 'apikey ' . $api_key
                    ),
                    'body' => array()
             );

            $response = wp_remote_get( $url, $list_opts );

            // test for wp errors
            if( is_wp_error( $response ) ) {

                print_r(json_encode(array(
                    'status' => "error",
                    'message' => "HTTP Error: " . $response->get_error_message()
                )));
                exit();
            }

            $body = wp_remote_retrieve_body( $response );
            $request = json_decode( $body );

            return $request;
        }

        /**
        * Add subscriber to mailchimp
        * @since 1.0
        */
        function mailchimp_add_subscriber() {

            $ret = true;
            $data = array();
            $email_status = false;
            $style_id = isset( $_POST['style_id'] ) ? esc_attr( $_POST['style_id'] ) : '';

            if( $style_id !=='' ){
                check_ajax_referer( 'cp-submit-form-'.$style_id );
            }

            $api_key = get_option( 'mailchimp_api' );
            $contact = array_map( 'sanitize_text_field', wp_unslash( $_POST['param'] ) );
            $list_id = isset( $_POST['list_id'] ) ? esc_attr( $_POST['list_id'] ) : '';

            $contact['source'] = ( isset( $_POST['source'] ) ) ? esc_attr( $_POST['source'] ) : '';
            $msg = isset( $_POST['message'] ) ? $_POST['message'] : __( 'Thanks for subscribing. Please check your mail and confirm the subscription.', 'smile' );

            $optinvar   = get_option( 'convert_plug_settings' );
            $d_optin    = isset( $optinvar['cp-double-optin'] ) ? $optinvar['cp-double-optin'] : 1;
            $redirect  = isset( $_POST['redirect'] ) ? true : false;

            if ( is_user_logged_in() && current_user_can( 'access_cp' ) ) {
                $default_error_msg = __( 'THERE APPEARS TO BE AN ERROR WITH THE CONFIGURATION.', 'smile' );
            } else {
                $default_error_msg = __( 'THERE WAS AN ISSUE WITH YOUR REQUEST. Administrator has been notified already!', 'smile' );
            }

            //    Check Email in MX records
            if( isset( $contact['email'] ) ) {
                $email_status = ( !( isset( $_POST['only_conversion'] ) ? true : false ) ) ? apply_filters('cp_valid_mx_email', $contact['email'] ) : false;
            }

            if( isset( $contact['email'] ) && $email_status ) {

                if( function_exists( "cp_add_subscriber_contact" ) ){
                    $isuserupdated = cp_add_subscriber_contact( '', $contact );
                }

                if ( !$isuserupdated ) {  // if user is updated don't count as a conversion
                    // update conversions
                    smile_update_conversions($style_id);
                }

                if( isset( $contact['email'] ) ) {

                    $status = 'success';
                    $merge_arr = array();
                    unset( $contact['source'] );

                    foreach( $contact as $key => $p ) {
                        if( $key != 'email' && $key != 'user_id' && $key != 'date' ){
                            $merge_arr[$key] = $p;
                        }
                    }

                    if( $d_optin == 0 ) {
                        $user_status = 'subscribed';
                    } else {
                        $user_status = 'pending';
                    }

                    $email = $contact['email'];

                    $data = array(
                        'email_address' => $email,
                        'status'        => $user_status
                    );

                    if( !empty($merge_arr) ) {
                        $data['merge_fields']  = $merge_arr;
                    }

                    $json_data = $data;

                    $opts = array(
                        'headers' => array(
                            'Content-Type' => 'application/json',
                            'Authorization' => 'apikey ' . $api_key
                        ),
                        'body' => $json_data
                    );

                    $apiKeyParts = explode( '-', $api_key );
                    $shard = $apiKeyParts[1];
                    $debug_data = get_option( 'convert_plug_debug' );
                    $sub_def_action = isset( $debug_data['cp-post-sub-action'] ) ? $debug_data['cp-post-sub-action'] : 'process_success';
                    $existingUser = false;
                    $updateUser = false;

                    $req_url = 'https://' . $shard .'.api.mailchimp.com/3.0/lists/'.$list_id.'/members/'. md5($email);

                    $result = wp_remote_get( $req_url, $opts );
                    $response_arr = json_decode($result['body']);
                   
                    if( isset( $response_arr->status ) && ( $response_arr->status == 'subscribed' || $response_arr->status == 'pending' ) ) { // already subscribed

                        $existingUser = true;

                        // update user data
                        if ( $sub_def_action != 'process_success' ) {

                            if( $redirect ) {
                                $ret = false;
                                $status = 'error';
                                $msg = $default_error_msg;
                            }
                            
                            //  Show message for already subscribed users
                            $msg = ( $optinvar['cp-default-messages'] ) ? isset( $optinvar['cp-already-subscribed']) ? stripslashes( $optinvar['cp-already-subscribed'] ) : __( 'Already Subscribed!', 'smile' ) : __( 'Already Subscribed!', 'smile' );

                        } else {
                            $updateUser = true;
                        }
                    }

                    if( !$existingUser || ( $existingUser && $updateUser ) ) {

                        if( $existingUser ) {
                            $data['status'] = 'subscribed';
                        }
                        
                        $json_data = json_encode($data);

                        $opts = array(
                            'headers' => array(
                                'Content-Type' => 'application/json',
                                'Authorization' => 'apikey ' . $api_key
                            ),
                            'body' => $json_data
                        );  

                        $opts['method'] = 'PUT';

                        $req_url = 'https://' . $shard .'.api.mailchimp.com/3.0/lists/'.$_POST['list_id'].'/members/'. md5($email);

                        $result = wp_remote_post( $req_url, $opts );
                        $errorMsg = '';

                        if( $result['response']['code'] != 200 ) {
                            $ret = false;
                            $status = 'error';
                            $msg = $default_error_msg;
                        }else if( $existingUser && $updateUser ){
                            $status = 'success';
                            $ret = true;
                            $msg = ( $optinvar['cp-default-messages'] ) ? isset( $optinvar['cp-already-subscribed']) ? stripslashes( $optinvar['cp-already-subscribed'] ) : __( 'Already Subscribed!', 'smile' ) : __( 'Already Subscribed!', 'smile' );
                        }
                    }

                    // check for detailed error message in body
                    if( isset($result['response']) ) {
                        $code = isset( $result['response']['code'] ) ? $result['response']['code'] : false;

                        if ( isset($code) && $code !== 200 && $code !== 400 ) { // skip user already subscribed case
                                
                            $status = 'error';
                            $msg = $default_error_msg;
                            $error_message = json_decode( $result['body'] );
                            $errorMsg = isset($error_message->detail) ? $error_message->detail : '';
                        }
                    }

                }
            } else {
                if( isset( $_POST['only_conversion'] ) ? true : false ) {
                    // update conversions
                    $status = 'success';
                    smile_update_conversions( $style_id );
                    $ret = true;
                } else if( isset( $contact['email'] ) ) {
                    $msg = ( isset( $_POST['msg_wrong_email']  )  && $_POST['msg_wrong_email'] !== '' ) ? $_POST['msg_wrong_email'] : __( 'Please enter correct email address.', 'smile' );
                    $status = 'error';
                    $ret = false;
                } else if( !isset( $contact['email'] ) ) {
                    $msg  = $default_error_msg;
                    $errorMsg = __( 'Email field is mandatory to set in form.', 'smile' );
                    $status = 'error';
                }
            }

            if ( is_user_logged_in() && current_user_can( 'access_cp' ) ) {
                $detailed_msg = $errorMsg;
            } else {
                $detailed_msg = '';
            }

            if( $detailed_msg !== '' && $detailed_msg !== null ) {
                $page_url = isset( $_POST['cp-page-url'] ) ? esc_url( $_POST['cp-page-url'] ) : '';

                // notify error message to admin
                if( function_exists('cp_notify_error_to_admin') ) {
                    $result   = cp_notify_error_to_admin($page_url);
                }
            }

            if( isset( $_POST['source'] ) ) {
                return $ret;
            } else {
                print_r(json_encode(array(
                    'action' => ( isset( $_POST['message'] ) ) ? 'message' : 'redirect',
                    'email_status' => $email_status,
                    'status' => $status,
                    'message' => $msg,
                    'detailed_msg' => $detailed_msg,
                    'url' => ( isset( $_POST['message'] ) ) ? 'none' : esc_url( $_POST['redirect'] ),
                )));

                exit();
            }
        }

        /**
        * Authentication
        * @since 1.0
        */
        function update_mailchimp_authentication(){

            if ( ! current_user_can( 'access_cp' ) ) {
                die(-1);
            }

            $api_key = isset( $_POST['authentication_token'] ) ? sanitize_text_field( $_POST['authentication_token'] ) : '';
            $mc_lists = array();
            $html = $query = '';

            if( $api_key == "" ) {
                print_r( json_encode(array(
                    'status' => "error",
                    'message' => __( "Please provide valid API Key for your ".$this->setting['name']." account.", "smile" )
                )));
                exit();
            }

            ob_start();

            $request = $this->get_lists( $api_key );

            if( isset( $request->status ) ) {
                if( $request->status == 'error' && $request->code == 104  ) {
                    print_r(json_encode(array(
                        'status' => "error",
                        'message' => $request->error
                    )));
                    exit();
                }
            }

            $lists = $request->lists;

            if( count( $lists ) < 1 ) {
                print_r(json_encode(array(
                    'status' => "error",
                    'message' => __( "You have zero lists in your " . $this->setting['name'] . " account. You must have at least one list before integration." , "smile" )
                )));
                exit();
            }
            ?>

            <?php
            if( count( $lists ) > 0 ) {
            ?>
                <label for="<?php echo $this->slug; ?>-list"><?php _e( "Select List", "smile" ); ?></label>
                <select id="<?php echo $this->slug; ?>-list" class="bsf-cnlist-select" name="<?php echo $this->slug; ?>-list">
                
                    <?php foreach($lists as $offset => $list) { ?>
                        <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                    
                        <?php $query .= $list->id.'|'.$list->name.',';
                            $mc_lists[$list->id] = $list->name;
                        ?>

                    <?php } ?>
                </select>
            <?php } else { ?>
                <label for="<?php echo $this->slug; ?>-list">
                    <?php echo __( "You need at least one list added in " . $this->setting['name'] . " before proceeding.", "smile" ); ?>
                </label>
            <?php } ?>

            <div class="bsf-cnlist-form-row">
                <div id="disconnect-<?php echo $this->slug; ?>" class="disconnect-mailer" data-mailerslug="<?php echo $this->slug; ?>" data-mailer="<?php echo $this->setting['name']; ?>">
                    <span>
                        <?php _e( "Use different '".$this->setting['name']."' account?", "smile" ); ?>
                    </span>
                </div>
                <span class="spinner" style="float: none;"></span>
            </div>
            <?php
            $html .= ob_get_clean();

            update_option( $this->slug.'_api', $api_key );
            update_option( $this->slug.'_lists', $mc_lists );

            print_r(json_encode(array(
                'status' => "success",
                'message' => $html
            )));

            exit();
        }

        /**
        * Disconnect mailchimp
        * @since 1.0
        */
        function disconnect_mailchimp(){
            delete_option( 'mailchimp_api' );
            delete_option( 'mailchimp_lists' );

            $smile_lists = get_option('smile_lists');
            if( !empty( $smile_lists ) ){
                foreach( $smile_lists as $key => $list ) {
                    $provider = $list['list-provider'];
                    if( strtolower( $provider ) == strtolower( $this->slug ) ){
                        $smile_lists[$key]['list-provider'] = "Convert Plug";
                        $contacts_option = "cp_" . $this->slug . "_" . preg_replace( '#[ _]+#', '_', strtolower( $list['list-name'] ) );
                        $contact_list = get_option( $contacts_option );
                        $deleted = delete_option( $contacts_option );
                        $status = update_option( "cp_connects_" . preg_replace( '#[ _]+#', '_', strtolower( $list['list-name'] ) ), $contact_list );
                    }
                }
                update_option( 'smile_lists', $smile_lists );
            }
            print_r(json_encode(array(
                'message' => "disconnected",
            )));
            exit();
        }


        /**
         * Function Name: get_mailchimp_lists
         * Function Description: Get Mailchimp list
         * @since 1.0
         */
        function get_mailchimp_lists( $api_key = '' ) {
            if( $api_key != '' ) {
                $data = array();

                $opts = array(
                    'headers' => array(
                        'Content-Type' => 'application/json',
                        'Authorization' => 'apikey ' . $api_key
                    ),
                    'body' => array()
                );

                $apiKeyParts = explode( '-', $api_key);
                $shard = $apiKeyParts[1];

                $req_url = 'https://' . $shard .'.api.mailchimp.com/3.0/lists/?count=100';

                $response = wp_remote_get( $req_url, $opts );

                // test for wp errors
                if( is_wp_error( $response ) ) {
                    return array();
                    exit;
                }

                $body = wp_remote_retrieve_body( $response );
                $request = json_decode( $body );
                if( isset( $request->status ) ) {
                    if( $request->status == 'error' && $request->code == 104 ){
                        return array();
                    }
                } else {
                    $lists = $request->lists;
                    $mc_lists = array();
                    if( count( $lists ) > 0 ) {
                        foreach($lists as $offset => $list) {
                            $mc_lists[$list->id] = $list->name;
                        }
                    }
                    return $mc_lists;
                }
            }
            return array();
        }
    }
    new Smile_Mailer_Mailchimp;
}

?>
