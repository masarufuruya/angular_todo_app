<?php
class Task extends AppModel
{
	// 完了日時別にタスクを分割した配列を返す
	public function divideTaskDoneDate($tasks)
	{
		$result = array();
		foreach($tasks as $task) {
			// タスクの完了日を取得
			$done_date = date('Y-m-d', strtotime($task['Task']['done_date']));
			// まだ保存されていなければ配列を初期化
			if (empty($result[$done_date])) {
				$result[$done_date] = array();
			}
			array_push($result[$done_date], $task['Task']);
		}
		return $result;
	}

}
