<?php

define("SHORTCODE_CATEGORY", "UPH");

class EngineShortcode
{

	private $params_map = array();
	private $params_block = array();

	function __construct()
	{
		$this->SetParams();

		add_action( 'vc_before_init', array( $this, 'MappingBlock' ) );

		$this->RegisterShortcode( $this->params_map );

	}

	function SetParams()
	{
		$this->params_map = array(
			'sc 1' => array(
				'name' => 'shortcode test 1',
				'description' => 'ini adalah deskripsi dari shortcode 1',
				'base' => 'sc_1',
				'params' => array(
					array(
						"type" => "textfield",
	          "holder" => "div",
	          "class" => "",
	          "heading" => __( "Text", "my-text-domain" ),
	          "param_name" => "foo",
	          "value" => __( "Default param value", "my-text-domain" ),
	          "description" => __( "Description for foo param.", "my-text-domain" )
					)
				),
			),
		);

	}

	function MappingBlock() 
	{
		// print_r( $this->params_map );
		// die();
		foreach( $this->params_map as $sc ){
			extract( $sc );
			$this->RegisterToVCMap( $name, $description, $base, $params );
		}

	}

	/*
	 * RegisterToVCMap
	 * Register to vc_map()
	 *
	 * $name => name of shortcode
	 * $description => description of shortcode
	 * $base => name function for build shortcode
	 * params => parameters for shortcode
	 */
	function RegisterToVCMap( $name, $description, $base, $params ) 
	{
		vc_map(
			array(
				'name' => __($name, 'uph_text_domain'),
				'description' => __($description, 'uph_text_domain'),
				'category' => 'Content',
				'base' => $base,
				'content_element' => true,
				'params' => $params
			)
		);
	}



	/*
	 * register shortcode based on params map 
	 */
	function RegisterShortcode( $params_map )
	{
		if( !function_exists('vc_map_get_attributes' ) ):
			return;
		else:
			foreach( $params_map as $pm ){
				extract( $pm );
				add_shortcode( $base, array( $this, $base ) );
			}
		endif;
	}

	function sc_1( $atts, $content = null )
	{
		$atts = vc_map_get_attributes( 'sc_1', $atts );
		extract( $atts );
		ob_start();

		$out = ob_get_contents();
		if( ob_get_contents() ) ob_end_clean();
		return $out;
	}


}

new EngineShortcode();