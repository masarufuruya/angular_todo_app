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
			// DBからタスク一覧を取得してjsonで返す
			$todo_list = $this->Todo->find('all');
			$response = array();
			foreach ($todo_list as $todo) {
				$todo['Todo']['isEdit'] = false;
				array_push($response, $todo['Todo']);
			}
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

		}

		// DELETEの場合はタスクを削除
		if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
			$delete_id = $id;
			$this->Todo->delete($delete_id);
		}
	}
}