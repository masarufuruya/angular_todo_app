var habbitApp = angular.module('HabbitApp', []);

habbitApp.controller('HabbitListCtrl', function ($scope, $timeout, $http) {

      // Todoリストローディング
      $scope.isTodoListLoading = true;

      $http({method: 'GET', url: '/top/todos'}).
        success(function(data, status, headers, config) {
          // 登録されている全タスク
          $scope.allTodos = data.allTodos;
          // 完了しているタスク
          $scope.doneTodos = data.doneTodos;
          $scope.isTodoListLoading = false;
        }).
        error(function(data, status, headers, config) {
         // エラーが発生、またはサーバからエラーステータスが返された場合に、
         // 非同期で呼び出されます。
          $scope.isTodoListLoading = false;
        });

      $scope.addTodo = function() {
          if ($scope.name !== '') {
               var name = $scope.name;
               $scope.name = '';

               $scope.allTodos.push({"message": name, "isDone": false, "isEdit": false});

               var parameter = {'message':name};
               $http({
                    method : 'POST',
                    url : '/top/todo',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                    data: $.param(parameter)
               }).success(function(data, status, headers, config) {

               }).error(function(data, status, headers, config) {
                    //失敗
               });
          }
      };

      $scope.toCanEdit = function(index) {
          $scope.allTodos[index].isEdit = true;
      };
      $scope.toNotEdit = function(index) {
          // デフォルトだとmouseroverの処理が早いので、0.3秒遅延させる
          $timeout(function() {
               $scope.allTodos[index].isEdit = false;
          }, 300);

          // タスク名が空ではない場合、ラベルに表示する
          if ($scope.allTodos[index].message !== '') {
               $scope.allTodos[index].label = $scope.todoMessage;
          }
      };

      // タスクの完了を切り替えるメソッド
      // まだ完了時の実装のみ
      $scope.toggleIsDone = function(index) {
          // 今回完了したタスク
          var toDoneTodo = $scope.allTodos[index];

          // サーバー側を更新
          var parameter = {'message':toDoneTodo.message,'isDone':true};

          $http({
               method : 'PUT',
               url : '/top/todo/',
               headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
               data: $.param(parameter)
          }).success(function(data, status, headers, config) {
               // 処理は無し
          }).error(function(data, status, headers, config) {
               //失敗
          });          

          // 一覧から削除
          $scope.allTodos.splice(index, 1);
          // Todo: 現在時刻を取得するようにする
          var currentDate = '2014-11-19';
          var doneTodo = $scope.doneTodos[currentDate];
          // 今回完了したタスクを追加する
          doneTodo.push(toDoneTodo);
      }

      $scope.updateTodo = function(index) {
          var updateTodo = $scope.allTodos[index];
          var parameter = {'id':updateTodo.id,'message':updateTodo.message};

          $http({
               method : 'PUT',
               url : '/top/todo/',
               headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
               data: $.param(parameter)
          }).success(function(data, status, headers, config) {

          }).error(function(data, status, headers, config) {
               //失敗
          });
      };

      $scope.deleteTodo = function(index) {

          var deleteTodo = $scope.allTodos[index];

          $http({
               method : 'DELETE',
               url : '/top/todo/' + deleteTodo.id,
          }).success(function(data, status, headers, config) {

          }).error(function(data, status, headers, config) {
               //失敗
          });

          $scope.allTodos.splice(index, 1);
      };
});


