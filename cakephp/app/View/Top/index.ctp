<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Habbit</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <?php echo $this->Html->css('flat-ui.min'); ?>
    <?php echo $this->Html->css('habbit'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0/angular-route.min.js"></script>
    <?php echo $this->Html->script('index'); ?>
    <?php echo $this->Html->script('moment'); ?>
  </head>
  <body ng-app="HabbitApp">
      <div class="col-xs-12" style="padding:0px;margin-bottom:55px;">
        <nav class="navbar navbar-inverse navbar-embossed navbar-fixed-top" role="navigation" style="border-radius:0px;margin-bottom:5px;">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
              <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="#">Habbit</a>
          </div>
          <div class="collapse navbar-collapse" id="navbar-collapse-01">
            <ul class="nav navbar-nav navbar-left">
              <li><a href="https://www.facebook.com/masaru.furuya.1" target="_new">About Me</a></li>
             </ul>
          </div><!-- /.navbar-collapse -->
        </nav><!-- /navbar -->
      </div>
    <div class="container">
      <div ng-controller="HabbitListCtrl">
        <div id="AddForm" class="row">
          <form ng-submit="addTask()">
            <div id="AddInputBox" class="form-group">
              <div class="col-sm-11">
                <input type="text"  ng-model="name" class="form-control" />
              </div>
            </div>
          </form>
          <div class="col-sm-1">
            <button ng-click="addTask()" class="btn btn-primary">追加</button>
          </div>
        </div>

        <div id="HabbitList">
          <div id="HabbitListLoading" ng-show="isTaskListLoading == true">
            <?php echo $this->Html->image('loading-circle.gif'); ?>
          </div>
          <div id="HabbitListContent" ng-show="isTaskListLoading == false">
            <!-- 登録されているタスク一覧 -->
            <div id="allTask">
              <h2>登録されている習慣一覧</h2>
              <table class="table table-striped table-bordered">
                    <div id="CompleteAlert" ng-show="allTasks.length == 0" class="alert alert-warning" role="alert">今日の習慣は全て達成しました！</div>
                    <tr ng-show="allTasks.length > 0">
                        <th>完了</th>
                        <th>習慣名</th>
                        <th></th>
                    </tr>
                    <tr ng-show="allTasks.length > 0" ng-repeat="task in allTasks">
                        <td class="col-sm-1"><input type="checkbox" ng-click="toggleIsDone($index)" ng-model="task.isDone" width="10px"></td>
                        <td class="col-sm-10" ng-click="toCanEdit($index)">
                          <span ng-model="task.label" ng-show="task.isEdit == false">{{task.message}}</span>
                          <input type="text" ng-blur="updateTask($index)" ng-model="task.message" ng-mouseleave="toNotEdit($index)" ng-show="task.isEdit == true" class="form-control">
                        </td>
                        <td style="text-align:center;" class="col-sm-1">
                          <button class="btn btn-danger" ng-click="deleteTask($index)">削除</button>
                        </td>
                    </tr>
              </table>
            </div>
            <!-- 完了したタスク一覧 -->
            <div class="done-task" ng-repeat="doneTask in doneTasks">
                <h2>{{doneTask[0].done_timestamp | date:'yyyy-MM-dd'}}に完了した習慣一覧</h2>
                <table class="table table-striped table-bordered">
                  <tr>
                      <th>習慣名</th>
                  </tr>
                  <tr ng-repeat="task in doneTask">
                      <td class="col-sm-12">
                        <span ng-model="doneTask.label">{{task.message}}</span>
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


