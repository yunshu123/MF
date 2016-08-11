<?php
use MF\Controller;
use MF\View;
use MF\Model;

class IndexController extends BaseController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

//		测试Redis
//		$redis = \MF\Cache::getInstance('redis', ['database'=>4]);
//		$redis->set('name', "my framework");
//		echo $redis->get('name');
//		$redis->clear();
		//获取最新的技术文章
		$data = PostModel::model()->getLatestPost([1, 3, 17, 18, 21], 10);

		//获取最新的娱乐文章
//		$data = PostModel::model()->getLatestPost([43, 44, 45, 46], 10);

//		$data = ['lastest_tec'=>$lastest_tec, 'lastest_ent'=>$lastest_ent];

		//使用socketlog调试
//		slog_config();

//		$id = filter($_GET['id'], 0, 'intval');
//		$data = PostModel::model()->getPostById($id);
		$this->ajaxReturn($data);

//		MF\Libraries\Log::getInstance(LOG_PATH)->log('app_', print_r(debug_backtrace(),1));
//		MF\Libraries\Log::getInstance(LOG_PATH)->log('app_', print_r(get_included_files(),1));

//		dump(debug_backtrace());
//		api_log(DEBUG, 0, 'debug message!!');
//		api_log(ERROR, 10001, 'error message!!');
//		api_log(STAT, 10001, 'error message!!');

		//I18N
		echo _('HELLO_WORLD');

		//		$data['name'] = 'yunshu';
//		$data['age'] = 25;
//		return View::make('index.index')->with('data', $data);
	}

	public function sayHello()
	{
		echo 'hello world!!';
	}

	public function http()
	{
		$data = (new \MF\Libraries\Curl())->get('http://www.sina.com');
		var_dump($data);
	}
}