<?php

class Theme
{
    /**
     * Protected variables
     */
    protected $_ci       = NULL;    //codeigniter instance
    protected $_config   = array(); //the theme config
    protected $_content  = '';      //the content (filled by the view/theme function)
    protected $_data     = array(); //the data (variables passed to the theme and views)
    protected $_messages = array(); //messages to display

    /**
     * Theme::__construct()
     * @return void
     */
    function __construct()
    {
    	//get the CI instance
    	$this->_ci = &get_instance();

		//get the config
        $this->_config = config_item('theme');

		//set the theme
        $this->set_theme($this->_config['theme']);
    }

	/**
     * Theme::set_theme()
     *
     * Sets the theme
     *
     * @param string $theme The theme
     * @return void
     */
    function set_theme($theme = 'default')
    {
    	$this->set_config('theme', $theme);

    	$functions = $this->config('path').$this->config('theme').'/functions.php';
    	if (file_exists($functions))
    	{
    		include($functions);
    	}
    }

	/**
     * Theme::set_layout()
     *
     * Sets the layout for the current theme (default: index => index.php)
     *
     * @param string $layout The layout for the theme
     * @return void
     */
    function set_layout($layout = 'index')
    {
    	$path = $this->config('path').$this->config('theme').'/'.$layout.'.php';
    	if (!file_exists($path))
    	{
    		$layout = 'index';
    	}
    	$this->set_config('layout', $layout);
    }

	/**
     * Theme::add_message()
     *
     * Adds a message to the queue
     *
     * @param string $message The message to display
     * @param string $type Can be anything: info,success,error,warning
     * @return void
     */
    function add_message($message, $type = 'info')
    {
    	$this->_messages[] = array(
    		'message' => $message,
    		'type'    => $type,
		);
    }

	/**
     * Theme::set_messages()
     *
     * Sets all messages (handy for flash ops)
     *
     * @param array $messages Messages to be set
     * @return void
     */
    function set_messages($messages)
    {
   		$messages = is_array($messages) ? $messages : array();
   		$this->_messages = $messages;
    }

	/**
     * Theme::clear_messages()
     *
     * Removes all messages
     *
     * @return void
     */
    function clear_messages()
    {
    	$this->_messages = array();
    }

    /**
     * Theme::config()
     *
     * Returns an item from the config array
     *
     * @param string $name
     * @param bool $default (optional: FALSE)
     * @return mixed or $default if not found
     */
    function config($name, $default = FALSE)
    {
        return isset($this->_config[$name]) ? $this->_config[$name] : $default;
    }

    /**
     * Theme::set_config()
     *
     * Sets an item in the config array
     * e.g. $this->theme->set_config('theme', 'other_theme');
     *
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    function set_config($name, $value)
    {
        $this->_config[$name] = $value;
    }

    /**
     * Theme::get()
     *
     * Gets an item from the data array
     * e.g. $this->theme->get('current_user');
     *
     * @param string $name The value to get
     * @param bool $default (optional: FALSE)
     * @return mixed or $default if not found
     */
    function get($name, $default = FALSE)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : $default;
    }

    /**
     * Theme::set()
     *
     * Sets an item in the data array
     * e.g. $this->theme->set('current_user', $this->user);
     *
     * @param string $name The item to set
     * @param mixed $value The value to set
     * @return void
     */
    function set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    /**
     * Theme::messages()
     *
     * Returns an unordered list (HTML) for the message or
     * the message array. depending on the $html variable
     *
     * @param bool $html Return it as html? (false=array)
     * @return string(html) or array
     */
    function messages($html = TRUE)
    {
        if (!$html)
        {
        	return $this->_messages;
        }

        $html  = '';
        $html .= '<ul class="messages">';
        foreach($this->_messages as $message)
        {
        	$html .= sprintf('<li class="%s">%s</li>', $message['type'], $message['message']);
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * Theme::content()
     *
     * Returns the content variable (filled by the view/theme function)
     *
     * @return string
     */
    function content()
    {
        return $this->_content;
    }

    /**
     * Theme::view()
     *
     * Loads the view just as CI would normally do and
     * passed it to the theme function wrapping the view into the theme
     *
     * @param string $view The view to load
     * @param array $data The data array to pass to the view
     * @param bool $return (optional) Return the output?
     * @return void or the HTML
     */
    function view($view, $data = array(), $return = false)
    {
        $data    = is_array($data) ? $data : array();
        $data    = array_merge($this->_data, $data);
        $content = $this->partial($view, $data, true);
        return $this->render($content, $return);
    }

    /**
     * Theme::render()
     *
     * Wraps the theme around the $content
     *
     * @param string $content Raw HTML content
     * @param bool $return (optional) Return the output?
     * @return void or HTML
     */
    function render($content, $return = false)
    {
        $this->_content = $content;

        extract($this->_data);

        $theme = $this->config('path') . $this->config('theme') . '/' . $this->config('layout') . '.php';
        if (!file_exists($theme))
        {
            show_error('Make sure you configurate your theme <small>(did you copy the <u>themes</u> folder to your root?)</small><br><br>'.$theme.' not found.');
        }

        ob_start();

        include ($theme);
        $html = ob_get_contents();

        ob_end_clean();

        $html = preg_replace_callback('~((href|src)\s*=\s*[\"\'])([^\"\']+)~i', array($this, '_replace_url'), $html);
        $html = str_replace('{template_url}', $this->config('url') . $this->config('theme'), $html);

        if ($return)
        {
            return $html;
        }
        get_instance()->output->set_output($html);
    }

    /**
     * Theme::partial()
     *
     * Loads the view just as CI except this function will look
     * first into the theme's subdir 'views' to find the view
     *
     * @param string $view The view to load
     * @param array $data The data array to pass to the view
     * @param bool $return (optional) Return the output?
     * @return void or the HTML
     */
    function partial($view, $data = array(), $return = false)
    {
        $data = is_array($data) ? $data : array();
        $data = array_merge($this->_data, $data);

        $path = $this->config('path') . $this->config('theme') . '/views/' . $view . '.php';
        if (file_exists($path))
        {
            extract($data);
            ob_start();
            include ($path);
            $output = ob_get_contents();
            ob_end_clean();
        }
        else
        {
            $output = get_instance()->load->view($view, $data, TRUE);
        }

        if ($return)
        {
            return $output;
        }

        echo $output;
    }

    /**
     * Theme::_replace_url()
     *
     * @param mixed $x
     * @return
     */
    private static function _replace_url($x)
    {
        $url = isset($x[3]) ? strtolower($x[3]) : '';
        if (strpos($url, 'http') !== 0 &&
            strpos($url, 'mailto') !== 0 &&
            strpos($url, '/') !== 0 &&
            strpos($url, '#') !== 0 &&
            strpos($url, '{') !== 0)
        {
            $url = '{template_url}/' . $url;
        }
        return isset($x[1]) ? ($x[1] . $url) : $url;
    }
}
