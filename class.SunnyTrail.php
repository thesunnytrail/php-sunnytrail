<?php
/**
 * SunnyTrail
 *
 * Handles theSunnyTrail.com API requests
 *
 */
class SunnyTrail
{
	/**
	 * Stores the api root url
	 *
	 * @var string
	 */
	private $_api_url = 'https://api.thesunnytrail.com/messages';

	/**
	 * Stores the client user agent information
	 *
	 * @var string
	 */
	private $_user_agent = 'SunnyTrail API Client 1.0 CURL PHP';
	
	/**
	 * Stores the developer api key
	 *
	 * @var string
	 */
	private $_key;

	/**
	 * Stores the raw response of the call
	 *
	 * @var string
	 */
	private $_result = null;


	/**
	 * Default constructor
	 *
	 * @param string $key The developer key
	 */
	public function __construct($key)
	{
		$this->_key = $key;
	}
	
	/**
	 * The function processes an API call
	 */
	public function addEvent($params)
	{
		$p['message'] = (string) json_encode($params);

		$result = $this->post_request($p);

		$this->_result = $result;
		return $this->_result;
	}

	/**
	 * This function does the actual API call
	 *
	 * @param array $params The method parameters
	 * @return string The server response
	 */
	protected function post_request($params)
	{
		// add the api key to the request
		$params['apikey'] = $this->_key;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_api_url);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->_user_agent);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_HEADER, array('Content-Length: ' . strlen(http_build_query($params))));
		curl_setopt($ch, CURLOPT_REFERER, '');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		$response = curl_exec($ch);

		if (!empty($response) && !curl_errno($ch))
		{
			$info = curl_getinfo($ch);
			//print_r($info);
			if (in_array($info['http_code'], array(200, 201, 202)))
			{
				return true;
			}
		}
		else
		{
			return 'Curl error: (' . curl_error($ch) . ')';
		}

		curl_close($ch);
		
		return false;
	}
}
