<?php
class TopController extends AppController
{
	public $uses = array('Todo');

	public function index()
	{

	}

	// タスク一覧を扱うリソース
	public function todos()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';

		// GETのみタスク一覧を返す
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$response = array();

			// 現在登録されているタスクの一覧
			$conditions = array('isDone' => 0);
			$all_todos = $this->Todo->find('all', compact('conditions'));
			$response['allTodos'] = array();
			// ビューへ返す形式に整形
			foreach ($all_todos as $todo) {
				$todo['Todo']['isEdit'] = false;
				array_push($response['allTodos'], $todo['Todo']);
			}

			// 完了タスク一覧
			$done_todos = $this->Todo->find('all', array('conditions' => array('isDone' => 1)));
			// 完了日付ごとのタスク一覧に分割して保存
			$response['doneTodos'] = $this->Todo->divideTodoDoneDate($done_todos);

			return json_encode($response);
		} else {
			return false;
		}
	}

	// タスク単体を扱うリソース
	public function todo($id = null)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';

		// GETの場合はタスク単体を取得
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// ここに処理
		}

		// POSTの場合はタスクを追加
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (empty($this->data) || empty($this->data['message'])) {
				return false;
			}

			$existd_todo = $this->Todo->find('first', array('conditions' => array('message' => $this->data['message'])));

			if (empty($existd_todo)) {
				$this->Todo->create();
				$this->Todo->save(array('message' => $this->data['message']));
			} else {
				// 同じタスクが存在する場合はリダイレクト
				$this->redirect('/top/index');
			}
		}

		// PUTの場合はタスクを更新
		if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
			if (empty($this->data)) {
				return false;
			}

			// 完了のステータスの更新処理の場合
			if (!empty($this->data['isDone'])) {

				$existd_todo = $this->Todo->find('first', array('conditions' => array('message' => $this->data['message'])));
				$this->Todo->id = $existd_todo['Todo']['id'];
				$this->Todo->save(array('done_date' => date('Y-m-d'), 'done_timestamp' => (int)microtime(true) * 1000, 'isDone' => 1));
				return false;
			}

			// タスク内容の更新処理の場合
			if (!empty($this->data['message'])) {
				$existd_todo = $this->Todo->find('first', array('conditions' => array('id' => $this->data['id'])));
				$this->Todo->id = $existd_todo['Todo']['id'];
				$this->Todo->save(array('message' => $this->data['message']));
			}
		}

		// DELETEの場合はタスクを削除
		if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
			$delete_id = $id;
			$this->Todo->delete($delete_id);
		}
	}
}
