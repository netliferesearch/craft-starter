<?php
namespace Craft;

class HttpReqPlugin extends BasePlugin
{
	private $_name = 'HTTP Request';
	private $_developer = 'Tcheu!';
	private $_developerUrl = 'http://tcheu.be';
	private $_version = '1.0';

	public function getName()
	{
		return Craft::t( $this->_name );
	}

	public function getVersion()
	{
		return $this->_version;
	}

	public function getDeveloper()
	{
		return $this->_developer;
	}

	public function getDeveloperUrl()
	{
		return $this->_developerUrl;
	}
}