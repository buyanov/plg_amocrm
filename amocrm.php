<?php

/*------------------------------------------------------------------------
# plg_amocrm
# ------------------------------------------------------------------------
# author &nbsp; &nbsp;Buyanov Danila - Saity74 Ltd.
# copyright Copyright (C) 2012 - 2016 saity74.ru. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.saity74.ru
# Technical Support: &nbsp; http://saity74.ru/amocrm.html
# Admin E-mail: info@saity74.ru
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

class plgContentAmocrm extends JPlugin
{

	/**
	 * Object of JDocument
	 *
	 * @var    JDocument
	 */
	protected $doc;

	/**
	 * Object of JApplication
	 *
	 * @var    JApplication
	 */
	protected $app;

	/**
	 * Code replace flag
	 *
	 * @var    boolean
	 */
	protected $is_replace = false;

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An optional associative array of configuration settings.
	 *                             Recognized key values include 'name', 'group', 'params', 'language'
	 *                             (this list is not meant to be comprehensive).
	 *
	 */
	public function __construct($subject, array $config)
	{
		$this->doc = JFactory::getDocument();

		parent::__construct($subject, $config);
	}

	/**
	 * Plugin that insert AmoCRM script into content
	 *
	 * @param   string   $context   The context of the content being passed to the plugin.
	 * @param   mixed    &$article  An object with a "text" property
	 * @param   mixed    $params    Additional parameters. See {@see PlgContentContent()}.
	 * @param   integer  $page      Optional page number. Unused. Defaults to zero.
	 *
	 * @return  boolean	True on success.
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{

		if ($this->app->isAdmin())
		{
			return true;
		}

		// Regular expression for replace [code]
		$regex = "/\\[amocrm ([^\\]]*)\\]/mi";

		// Use is_replace flag for replace all [code] includes
		$article->text = preg_replace_callback($regex, array($this, "_replace"), $article->text);

		return true;
	}

	/**
	 * @param   array  $code
	 *
	 * @return  string
	 */
	protected function _replace($code)
	{
		// Check the output data from preg_replace
		if (!$this->is_replace && is_array($code) && !empty($code) && isset($code[1]))
		{
			// Parse AmoCRM config
			$amo_forms_params = JUtility::parseAttributes($code[1]);

			// Check AmoCRM params
			if (isset($amo_forms_params['id']) && isset($amo_forms_params['hash']))
			{
				// Create script string
				$js = '<script>var amo_forms_params = '	. json_encode($amo_forms_params) . '</script>'
					. '<script src="https://forms.amocrm.ru/forms/assets/js/amoforms.js" async="async" id="amoforms_script"></script>';

				// Set replace flag
				$this->is_replace = true;

				return $js;
			}
		}

		// delete [code]
		return '';
	}
}
