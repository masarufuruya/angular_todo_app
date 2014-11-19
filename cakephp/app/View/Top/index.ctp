<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Habbit</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <?php echo $this->Html->css('habbit'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0/angular.min.js"></script>
    <?php echo $this->Html->script('index'); ?>
    <?php echo $this->Html->script('moment'); ?>
  </head>
  <body ng-app="HabbitApp">
    <div class="container">
      <div ng-controller="HabbitListCtrl">
        <div id="AddForm" class="row">
          <form ng-submit="addTodo()">
            <div id="AddInputBox" class="form-group">
              <div class="col-sm-11">
                <input type="text"  ng-model="name" class="form-control" />
              </div>
            </div>
          </form>
          <div class="col-sm-1">
            <button ng-click="addTodo()" class="btn btn-primary">追加</button>
          </div>
        </div>

        <div id="HabbitList">
          <div id="HabbitListLoading" ng-show="isTodoListLoading == true">
            <?php echo $this->Html->image('loading-circle.gif'); ?>
          </div>
          <div id="HabbitListContent" ng-show="isTodoListLoading == false">
            <!-- 登録されているタスク一覧 -->
            <div id="allTodo">
              <h2>登録されている習慣一覧</h2>
              <table class="table table-striped table-bordered">
                    <div id="CompleteAlert" ng-show="allTodos.length == 0" class="alert alert-warning" role="alert">今日の習慣は全て達成しました！</div>
                    <tr ng-show="allTodos.length > 0">
                        <th>完了</th>
                        <th>習慣名</th>
                        <th></th>
                    </tr>
                    <tr ng-show="allTodos.length > 0" ng-repeat="todo in allTodos">
                        <td class="col-sm-1"><input type="checkbox" ng-click="toggleIsDone($index)" ng-model="todo.isDone" width="10px"></td>
                        <td class="col-sm-10" ng-click="toCanEdit($index)">
                          <span ng-model="todo.label" ng-show="todo.isEdit == false">{{todo.message}}</span>
                          <input type="text" ng-blur="updateTodo($index)" ng-model="todo.message" ng-mouseleave="toNotEdit($index)" ng-show="todo.isEdit == true" class="form-control">
                        </td>
                        <td class="col-sm-1">
                          <button class="btn btn-danger" ng-click="deleteTodo($index)">削除</button>
                        </td>
                    </tr>
              </table>
            </div>
            <!-- 完了したタスク一覧 -->
            <div class="done-todo" ng-repeat="doneTodo in doneTodos">
                <h2>{{doneTodo[0].done_timestamp | date:'yyyy-MM-dd'}}に完了した習慣一覧</h2>
                <table class="table table-striped table-bordered">
                  <tr>
                      <th>習慣名</th>
                  </tr>
                  <tr ng-repeat="todo in doneTodo">
                      <td class="col-sm-12">
                        <span ng-model="doneTodo.label">{{todo.message}}</span>
                      </td>
                  </tr>
                </table>              
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>


