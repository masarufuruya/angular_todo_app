<?php
// タスクを扱うAPIコントローラー
class TasksController extends AppController
{
	// タスクモデルを読み込む
	public $uses = array('Task');

	// タスク一覧の取得
	public function index()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';

		$response = array();

		// 完了していないタスク一覧を取得
		$conditions = array('isDone' => 0);
		$all_tasks = $this->Task->find('all', compact('conditions'));
		$response['allTasks'] = array();

		// ビューへ返す形式に整形
		foreach ($all_tasks as $task) {
			$task['Task']['isEdit'] = false;
			array_push($response['allTasks'], $task['Task']);
		}

		// 完了したタスクの一覧を時間毎に分割して保存
		$done_tasks = $this->Task->find('all', array('conditions' => array('isDone' => 1)));
		$response['doneTasks'] = $this->Task->divideTaskDoneDate($done_tasks);

		return json_encode($response);
	}

	// タスク単体の取得
	public function view()
	{
		// 未実装
	}

	// タスクの追加
	public function add()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';

		// リクエストが空、またはタスク内容が空の場合はエラーを返す
		if (empty($this->data) || empty($this->data['message'])) {
			return json_encode(array('response' => false, 'message' => 'empty request data, or empty message'));
		}

		// タスクを新規作成する
		$this->Task->create();
		$this->Task->save(array('message' => $this->data['message']));
	}

	// タスクの更新
	public function edit() {
		$this->autoRender = false;
		$this->layout = 'ajax';

		// リクエストデータが無い場合エラーを返す
		if (empty($this->data)) {
			return json_encode(array('response' => false, 'message' => 'empty request data'));
		}

		// タスクの完了フラグの更新の場合
		if (!empty($this->data['isDone'])) {
			// 投稿内容から既存のタスクを取得
			$existd_task = $this->Task->find('first', array('conditions' => array('message' => $this->data['message'])));
			$this->Task->id = $existd_task['Task']['id'];
			// angularのdateフィルターはミリ秒タイムスタンプを引数に受け取るため
			// 完了日時をミリ秒単位で保存。小数点以下は切り捨て
			$this->Task->save(array('done_date' => date('Y-m-d'), 'done_timestamp' => (int)microtime(true) * 1000, 'isDone' => 1));
			return false;
		}

		// タスク内容の更新の場合
		if (!empty($this->data['message'])) {
			// タスク内容を更新
			$existd_task = $this->Task->find('first', array('conditions' => array('id' => $this->data['id'])));
			$this->Task->id = $existd_task['Task']['id'];
			$this->Task->save(array('message' => $this->data['message']));
		}
	}

	// タスクの削除
	public function delete()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';

		$delete_id = $this->data['id'];
		$this->Task->delete($delete_id);
	}
}
