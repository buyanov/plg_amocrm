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
	protected $doc;

	public function __construct($subject, array $config)
	{
		$this->doc = JFactory::getDocument();

		parent::__construct($subject, $config);
	}

	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{

		$regex = "/\\[amocrm ([^\\]]*)\\]/mi";

		$article->text = preg_replace_callback($regex, array($this, "_replace"), $article->text);

		return true;
	}

	protected function _replace($code)
	{
		if (is_array($code) && !empty($code) && isset($code[1]))
		{
			$amo_forms_params = JUtility::parseAttributes($code[1]);
			return '<script>var amo_forms_params = ' . json_encode($amo_forms_params) . ';</script>'
				.'<script src="https://forms.amocrm.ru/forms/assets/js/amoforms.js" async="async" id="amoforms_script"></script>';
		}
		else
		{
			return 'Ошибка плагина!';
		}
	}
}
