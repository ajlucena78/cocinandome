<?php
	require_once 'GmailOath.php';
	
	class GoogleMail
	{
		private $consumer_key = 'cocinandome.es';
		private $consumer_secret = 'a4r80wWU73ujlTUx2-WT69x6';
		private $callback;
		private $emails_count = 500;
		private $error;
		private $argarray;
		private $debug;
		
		public function login($urlVuelta)
		{
			if (!isset($_SESSION))
			{
				session_start();
			}
			$this->callback = $urlVuelta;
			$oauth = new GmailOath($this->consumer_key, $this->consumer_secret, $this->argarray, $this->debug
					, $this->callback);
			$getcontact = new GmailGetContacts();
			$access_token = $getcontact->get_request_token($oauth, false, true, true);
			if (!$access_token)
			{
				return false;
			}
			$_SESSION['oauth_token'] = $access_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $access_token['oauth_token_secret'];
			header('Location:https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token='
					. $oauth->rfc3986_decode($access_token['oauth_token']));
			exit();
		}
		
		public function get_emails($urlVuelta = null)
		{
			if (!isset($_GET['oauth_token']) or !$_GET['oauth_token'])
			{
				return false;
			}
			if (!isset($_SESSION))
			{
				session_start();
			}
			$this->callback = $urlVuelta;
			$oauth = new GmailOath($this->consumer_key, $this->consumer_secret, $this->argarray, $this->debug
					, $this->callback);
			$getcontact_access = new GmailGetContacts();
			$request_token = $oauth->rfc3986_decode($_GET['oauth_token']);
			$request_token_secret = $oauth->rfc3986_decode($_SESSION['oauth_token_secret']);
			$oauth_verifier = $oauth->rfc3986_decode($_GET['oauth_verifier']);
			$contact_access = $getcontact_access->get_access_token($oauth, $request_token, $request_token_secret
					, $oauth_verifier, false, true, true);
			$access_token = $oauth->rfc3986_decode($contact_access['oauth_token']);
			$access_token_secret = $oauth->rfc3986_decode($contact_access['oauth_token_secret']);
			$contacts = $getcontact_access->GetContacts($oauth, $access_token, $access_token_secret, false, true
					, $this->emails_count);
			$emails = Array();
			if (is_array($contacts))
			{
				foreach($contacts as $k => $a)
				{
					$final = end($contacts[$k]);
					foreach($final as $email)
					{
						if (isset($email["address"]))
						{
							$emails[] = $email["address"];
						}
					}
				}
			}
			return $emails;
		}
		
		public function error()
		{
			return $this->error;
		}
	}