<?php
class Todo extends AppModel {
	public $name = 'Todo';

	// 完了日時別にタスクを分割した配列を返す
	public function divideTodoDoneDate($todos)
	{
		$result = array();
		foreach($todos as $todo) {
			// タスクの完了日を取得
			$done_date = date('Y-m-d', strtotime($todo['Todo']['done_date']));
			// まだ保存されていなければ配列を初期化
			if (empty($result[$done_date])) {
				$result[$done_date] = array();
			}
			array_push($result[$done_date], $todo['Todo']);
		}
		return $result;
	}

}
