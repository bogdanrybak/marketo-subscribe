<?php
/**
* Marketo subscribe settings page
*/
class MarketoSubscribeSettings
{
	
	private $options;

	function MarketoSubscribeSettings()
	{
		add_action('admin_menu', array( $this, 'add_settings_page'));
		add_action('admin_init', array( $this, 'page_init'));
	}

	function add_settings_page()
	{
		add_options_page(
			'Marketo Subscribe Settings', // page title
			'Marketo Subscribe', // displayed menu item name
			'manage_options', // permission flag (admin)
			'marketo-subscribe-settings', // url slug
			array( $this, 'create_settings_page')); // function below to use for generating the page
	}

	function create_settings_page()
	{
		// load up the options
        $this->options = get_option( 'marketo_credentials_option' );
		?>
		<div>
			<?php screen_icon(); ?>
			<h2>Marketo Subscribe Settings</h2>
			<form action="options.php" method="post">
			<?php
                // This prints out all hidden setting fields
                settings_fields( 'marketo_credentials_group' );   
                do_settings_sections( 'marketo-subscribe-settings' );
                submit_button(); 
            ?>
			</form>
		</div>

		<?php
	}

	/**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'marketo_credentials_group', // Option group
            'marketo_credentials_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'marketo_credentials', // ID
            'Marketo Credentials', // Title
            array( $this, 'print_section_info' ), // Callback
            'marketo-subscribe-settings' // Page
        );  

        add_settings_field(
            'user_id', // ID
            'User ID', // Title 
            array( $this, 'user_id_callback' ), // Callback
            'marketo-subscribe-settings', // Page
            'marketo_credentials' // Section
        );      

        add_settings_field(
            'encryption_key', 
            'Encryption Key', 
            array( $this, 'encryption_key_callback' ), 
            'marketo-subscribe-settings', 
            'marketo_credentials'
        );

        add_settings_field(
            'soap_url', 
            'SOAP Endpoint URL', 
            array( $this, 'soap_endpoint_callback' ), 
            'marketo-subscribe-settings', 
            'marketo_credentials'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        foreach($input as $key => $value) {
        	$new_input[$key] = sanitize_text_field($value);
        }

        return $new_input;
    }

    public function print_section_info()
    {
    	print '<p>Please fill the following fields by consulting your Marketo admin page &rarr; Integration &rarr; SOAP API</p>';
    }

    /*
    / Callbacks
    */
    public function user_id_callback()
    {
        printf(
            '<input type="text" id="user_id" name="marketo_credentials_option[user_id]" value="%s" />',
            isset( $this->options['user_id'] ) ? esc_attr( $this->options['user_id']) : ''
        );
    }

    public function encryption_key_callback()
    {
        printf(
            '<input type="text" id="encryption_key" name="marketo_credentials_option[encryption_key]" value="%s" />',
            isset( $this->options['encryption_key'] ) ? esc_attr( $this->options['encryption_key']) : ''
        );
    }

    public function soap_endpoint_callback()
    {
        printf(
            '<input type="text" id="soap_endpoint" name="marketo_credentials_option[soap_endpoint]" value="%s" />',
            isset( $this->options['soap_endpoint'] ) ? esc_attr( $this->options['soap_endpoint']) : ''
        );
    }
}
?>