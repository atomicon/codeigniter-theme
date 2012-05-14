<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Theme_example extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//load helpers
		$this->load->helper( array('url', 'cookie'));

		//load theme spark
		$this->load->spark('theme/1.0.0');

		//try to get the theme from the cookie
		$theme = get_cookie('theme');
		if (in_array($theme, array('default', 'skeleton')))
		{
			//got a valid theme... set it
			$this->theme->set_theme($theme);
		}
	}

	public function index()
	{
		//message cookie?
		$message = get_cookie('message');
		if ($message)
		{
			//yes... add message to the theme
			$this->theme->add_message($message, 'success');

			//wipe the cookie
			set_cookie('message', null, null);
		}
		//load the theme_example view
		$this->theme->view('theme_example');
	}

	public function switch_theme($theme)
	{
		//set the cookie with the theme
		set_cookie('theme', $theme, 60*60*24*365);

		//set the message cookie
		set_cookie('message', 'Theme switched to: '.$theme , 60*60*24*365);

		//and redirect to the controller
		redirect('theme_example');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */