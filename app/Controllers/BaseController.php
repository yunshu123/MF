<?php
namespace App\Controllers;

use Mphp\Controller;

class BaseController extends Controller
{
	protected $domain;

	public function __construct()
	{
		$lang = filter($_GET['lang'], 'zh_CN');
		set_localization(I18N."Locale", 'message', $lang, 'UTF-8');
	}
}