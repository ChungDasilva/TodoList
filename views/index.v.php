<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<section class="vh-100" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-9 col-xl-7">
        <div class="card rounded-3">
          <div class="card-body p-4">

            <h4 class="text-center my-3 pb-3">To Do List</h4>
            <a href="tasks/create" class="btn btn-success">Create Task</a>
            <table class="table mb-4">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Work Name</th>
                  <th scope="col">Starting Date</th>
                  <th scope="col">Ending Date</th>
                  <th scope="col">Status</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $index => $task) { ?>
                  <tr>
                    <th scope="row"><?php echo $index+1 ?></th>
                    <td><?php echo $task->text ?></td>
                    <td><?php echo $task->start ?></td>
                    <td><?php echo $task->end ?></td>
                    <td><?php echo $task->status ?></td>
                    <td>
                      <a href="/tasks/<?php echo $task->id ?>/edit" type="button" class="btn btn-primary ms-1">Edit</a>
                      <a href="/tasks/<?php echo $task->id ?>/delete" type="button" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>