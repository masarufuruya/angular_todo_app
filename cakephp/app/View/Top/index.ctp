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
  </head>
  <body ng-app="HabbitApp">
    <div class="container">
      <div ng-controller="HabbitListCtrl">
        <div id="addForm" class="row">
          <form ng-submit="addTodo()">
            <div id="AddInputBox" class="form-group">
              <div class="col-sm-10">
                <input type="text"  ng-model="name" class="form-control" />
              </div>
            </div>
          </form>
          <div class="col-sm-2">
            <button ng-click="addTodo()" class="btn btn-primary">追加</button>
          </div>
        </div>

        <div id="HabbitList">
          <table class="table table-striped">
              <tr>
                  <th></th>
                  <th>ToDo</th>
                  <th></th>
              </tr>
              <tr ng-repeat="todo in todos">
                  <td class="col-sm-1"><input type="checkbox" ng-model="todo.done" width="10px"></td>
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
      </div>
    </div>
  </body>
</html>


