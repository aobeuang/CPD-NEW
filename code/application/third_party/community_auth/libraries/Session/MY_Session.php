<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Session extends CI_Session {

	public $pre_regenerated_session_id = NULL;
	public $regenerated_session_id     = NULL;

	public function __construct(array $params = [])
	{
		parent::__construct($params);
	}

	// ------------------------------------------------------------------------

	/**
	 * Configuration
	 *
	 * Handle input parameters and configuration defaults
	 *
	 * @param	array	&$params	Input parameters
	 * @return	void
	 */
	protected function _configure(&$params)
	{
		$expiration = config_item('sess_expiration');

		if (isset($params['cookie_lifetime']))
		{
			$params['cookie_lifetime'] = (int) $params['cookie_lifetime'];
		}
		else
		{
			$params['cookie_lifetime'] = ( ! isset($expiration) && config_item('sess_expire_on_close'))
				? 0 : (int) $expiration;
		}

		/**
		 * Begin modification for remember me ---------------------------
		 */
		$CI =& get_instance();

		// If on login the user chose the remember me option, or already has the cookie
		$remember_me = ( 
			$CI->input->post('remember_me') OR 
			isset( $_COOKIE[ $CI->config->item('remember_me_cookie_name') ] ) 
		) ? TRUE : FALSE;

		if( $CI->config->item('allow_remember_me') && $remember_me )
		{
			$params['cookie_lifetime'] = $CI->config->item('remember_me_expiration');
		}
		/**
		 * End modification for remember me ------------------------------
		 */

		isset($params['cookie_name']) OR $params['cookie_name'] = config_item('sess_cookie_name');
		if (empty($params['cookie_name']))
		{
			$params['cookie_name'] = ini_get('session.name');
		}
		else
		{
			ini_set('session.name', $params['cookie_name']);
		}

		isset($params['cookie_path']) OR $params['cookie_path'] = config_item('cookie_path');
		isset($params['cookie_domain']) OR $params['cookie_domain'] = config_item('cookie_domain');
		isset($params['cookie_secure']) OR $params['cookie_secure'] = (bool) config_item('cookie_secure');

		session_set_cookie_params(
			$params['cookie_lifetime'],
			$params['cookie_path'],
			$params['cookie_domain'],
			$params['cookie_secure'],
			TRUE // HttpOnly; Yes, this is intentional and not configurable for security reasons
		);

		if (empty($expiration))
		{
			$params['expiration'] = (int) ini_get('session.gc_maxlifetime');
		}
		else
		{
			$params['expiration'] = (int) $expiration;
			ini_set('session.gc_maxlifetime', $expiration);
		}

		$params['match_ip'] = (bool) (isset($params['match_ip']) ? $params['match_ip'] : config_item('sess_match_ip'));

		isset($params['save_path']) OR $params['save_path'] = config_item('sess_save_path');

		$this->_config = $params;

		// Security is king
		ini_set('session.use_trans_sid', 0);
		ini_set('session.use_strict_mode', 1);
		ini_set('session.use_cookies', 1);
		ini_set('session.use_only_cookies', 1);
		ini_set('session.hash_function', 1);
		ini_set('session.hash_bits_per_character', 4);
		
		//  for php 7
		$this->_configure_sid_length();
	}

	
	// ------------------------------------------------------------------------
	
	/**
	 * Configure session ID length
	 *
	 * To make life easier, we used to force SHA-1 and 4 bits per
	 * character on everyone. And of course, someone was unhappy.
	 *
	 * Then PHP 7.1 broke backwards-compatibility because ext/session
	 * is such a mess that nobody wants to touch it with a pole stick,
	 * and the one guy who does, nobody has the energy to argue with.
	 *
	 * So we were forced to make changes, and OF COURSE something was
	 * going to break and now we have this pile of shit. -- Narf
	 *
	 * @return	void
	 */
	protected function _configure_sid_length()
	{
		if (PHP_VERSION_ID < 70100)
		{
			$hash_function = ini_get('session.hash_function');
			if (ctype_digit($hash_function))
			{
				if ($hash_function !== '1')
				{
					ini_set('session.hash_function', 1);
				}
	
				$bits = 160;
			}
			elseif ( ! in_array($hash_function, hash_algos(), TRUE))
			{
				ini_set('session.hash_function', 1);
				$bits = 160;
			}
			elseif (($bits = strlen(hash($hash_function, 'dummy', false)) * 4) < 160)
			{
				ini_set('session.hash_function', 1);
				$bits = 160;
			}
	
			$bits_per_character = (int) ini_get('session.hash_bits_per_character');
			$sid_length         = (int) ceil($bits / $bits_per_character);
		}
		else
		{
			$bits_per_character = (int) ini_get('session.sid_bits_per_character');
			$sid_length         = (int) ini_get('session.sid_length');
			if (($bits = $sid_length * $bits_per_character) < 160)
			{
				// Add as many more characters as necessary to reach at least 160 bits
				$sid_length += (int) ceil((160 % $bits) / $bits_per_character);
				ini_set('session.sid_length', $sid_length);
			}
		}
	
		// Yes, 4,5,6 are the only known possible values as of 2016-10-27
		switch ($bits_per_character)
		{
			case 4:
				$this->_sid_regexp = '[0-9a-f]';
				break;
			case 5:
				$this->_sid_regexp = '[0-9a-v]';
				break;
			case 6:
				$this->_sid_regexp = '[0-9a-zA-Z,-]';
				break;
		}
	
		$this->_sid_regexp .= '{'.$sid_length.'}';
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Session regenerate
	 *
	 * Legacy CI_Session compatibility method
	 *
	 * @param	bool	$destroy	Destroy old session data flag
	 * @return	void
	 */
	public function sess_regenerate($destroy = FALSE)
	{
		$this->pre_regenerated_session_id = $this->session_id;

		$_SESSION['__ci_last_regenerate'] = time();
		session_regenerate_id($destroy);

		$this->regenerated_session_id = $this->session_id;

		return $this->session_id;
	}

	// ------------------------------------------------------------------------
}

/* End of file MY_Session.php */
/* Location: /community_auth/libraries/Session/MY_Session.php */