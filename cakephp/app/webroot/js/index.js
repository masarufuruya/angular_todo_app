var habbitApp = angular.module('HabbitApp', []);

habbitApp.controller('HabbitListCtrl', function ($scope, $timeout, $http) {

     $http({method: 'GET', url: '/top/todos'}).
       success(function(data, status, headers, config) {
         // レスポンスが有効の場合に、非同期で呼び出されるコールバックです。
         $scope.todos = data;
       }).
       error(function(data, status, headers, config) {
         // エラーが発生、またはサーバからエラーステータスが返された場合に、
         // 非同期で呼び出されます。
     });

     $scope.addHabbit = function() {
          if ($scope.name !== '') {
               $scope.todos.push({"message": $scope.name, "done": false, "isEdit": false});

               var parameter = {'message':$scope.name};
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
          $scope.todos[index].isEdit = true;
     };
     $scope.toNotEdit = function(index) {
          // デフォルトだとmouseroverの処理が早いので、0.3秒遅延させる
          $timeout(function() {
               $scope.todos[index].isEdit = false;
          }, 300);

          // タスク名が空ではない場合、ラベルに表示する
          if ($scope.todos[index].message !== '') {
               $scope.todos[index].label = $scope.todoMessage;
          }
     };

     $scope.deleteTodo = function(index) {

          var deleteTodo = $scope.todos[index];

          $http({
               method : 'DELETE',
               url : '/top/todo/' + deleteTodo.id,
          }).success(function(data, status, headers, config) {

          }).error(function(data, status, headers, config) {
               //失敗
          });

          $scope.todos.splice(index, 1);
     };
});


