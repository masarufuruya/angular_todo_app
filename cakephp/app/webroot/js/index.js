angular.module('HabbitApp', [])
  .controller('HabbitListCtrl', function ($scope, $timeout, $http, $filter) {
      // ローディング開始
      $scope.isTaskListLoading = true;

      // タスク一覧を取得
      // Todo: $resourceへ書換え
      $http({method: 'GET', url: '/tasks/'}).
        success(function(data, status, headers, config) {
          // 登録されている全タスク
          $scope.allTasks = data.allTasks;
          // 完了しているタスク
          $scope.doneTasks = data.doneTasks;
          // ローディング終了
          $scope.isTaskListLoading = false;
        }).
        error(function(data, status, headers, config) {
          // ローディング終了
          $scope.isTaskListLoading = false;
        });

      // タスクの追加
      $scope.addTask = function() {
          if ($scope.name !== '' && angular.isDefined($scope.name)) {
               var name = $scope.name;
               $scope.name = '';

               $scope.allTasks.push({"message": name, "isDone": false, "isEdit": false});

               var parameter = {'message':name};
               $http({
                    method : 'POST',
                    url : '/tasks/',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                    data: $.param(parameter)
               }).success(function(data, status, headers, config) {

               }).error(function(data, status, headers, config) {
                    //失敗
               });
          }
      };

      $scope.toCanEdit = function(index) {
          $scope.allTasks[index].isEdit = true;
      };
      $scope.toNotEdit = function(index) {
          // デフォルトだとmouseroverの処理が早いので、0.3秒遅延させる
          $timeout(function() {
               $scope.allTasks[index].isEdit = false;
          }, 300);

          // タスク名が空ではない場合、ラベルに表示する
          if ($scope.allTasks[index].message !== '') {
               $scope.allTasks[index].label = $scope.taskMessage;
          }
      };

      // タスクの完了を切り替えるメソッド
      // まだ完了時の実装のみ
      $scope.toggleIsDone = function(index) {
          // 今回完了したタスク
          var toDoneTask = $scope.allTasks[index];

          // サーバー側を更新
          var parameter = {'message':toDoneTask.message,'isDone':true};

          $http({
               method : 'PUT',
               url : '/tasks/',
               headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
               data: $.param(parameter)
          }).success(function(data, status, headers, config) {
               // 処理は無し
          }).error(function(data, status, headers, config) {
               //失敗
          });          

          // 一覧から削除
          $scope.allTasks.splice(index, 1);
          // 今日の日付を取得
          var currentDate = $filter('date')(new Date(), 'yyyy-M-d');
          // 完了したタスクを今日のタスク一覧へ追加
          var doneTask = $scope.doneTasks[currentDate];
          doneTask.push(toDoneTask);
      }

      $scope.updateTask = function(index) {
          var updateTask = $scope.allTasks[index];
          var parameter = {'id':updateTask.id,'message':updateTask.message};

          $http({
               method : 'PUT',
               url : '/tasks/',
               headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
               data: $.param(parameter)
          }).success(function(data, status, headers, config) {

          }).error(function(data, status, headers, config) {
               //失敗
          });
      };

      $scope.deleteTask = function(index) {

          var deleteTask = $scope.allTasks[index];
          var parameter = {'id':deleteTask.id};

          $http({
               method : 'DELETE',
               url : '/tasks/',
               headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
               data: $.param(parameter)               
          }).success(function(data, status, headers, config) {

          }).error(function(data, status, headers, config) {
               //失敗
          });

          $scope.allTasks.splice(index, 1);
      };
});


