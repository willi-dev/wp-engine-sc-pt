<?php

define("SHORTCODE_CATEGORY", "UPH");

class EngineShortcode
{

	private $params_map = array(
		'sc 1' => array(),
		'sc 2' => array(),
	);
	private $params_block = array();

	function __construct()
	{
		// $this->SetParams();
		add_action('init', array( $this, 'MappingBlock' ) );
		
	}

	function SetParams()
	{
		$this->params_map = array(
			'sc 1' => array(),
			'sc 2' => array(),
		);
	}

	function MappingBlock() 
	{
		foreach( $this->params_map as $sc ){
			extract( $sc );
			$this->RegisterToVCMap( $name, $description, $base, $params );
		}
	}

	/*
	 * RegisterToVCMap
	 */
	function RegisterToVCMap( $name, $description, $base, $params ) 
	{
		vc_map(
			array(
				'name' => $name,
				'description' => $description,
				'category' => SHORTCODE_CATEGORY,
				'base' => $base,
				'content_element' => true,
				'params' => $params
			)
		);
	}

}