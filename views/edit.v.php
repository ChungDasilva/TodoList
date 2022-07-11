<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
</head>
<body>
    <div class="col-md-4 offset-md-4 ">
        <div class="card-body nopadmar top_height">
        <div class="add_list adds bg_white">
            <form method="POST" action="/tasks/<?php echo $data->id ?>/edit" accept-charset="UTF-8" class="form" id="main_input_box">
            <div class="form-group">
                <label for="task_description">Work Name: </label>
                <input class="form-control" id="task_description" required="required" name="name" type="text" value="<?php echo $data->name ?>">
            </div>
            <div class="form-group">
                <label for="task_deadline">Starting Date: </label>
                <input class="form-control datepicker" id="task_deadline" data-date-format="YYYY/MM/DD" required="required" autocomplete="off" name="start" type="text" value="<?php echo $data->start ?>">
            </div>
            <div class="form-group">
                <label for="task_deadline">Ending Date: </label>
                <input class="form-control datepicker" id="task_deadline" data-date-format="YYYY/MM/DD" required="required" autocomplete="off" name="end" type="text" value="<?php echo $data->end ?>">
            </div>
            <div class="form-group">
                <label for="task_deadline">Status: </label>
                <select class="form-select" aria-label="Default select example" name="status" id="status"> 
                    <option value="Planning">Planning</option>
                    <option value="Doing">Doing</option>
                    <option value="Complete">Complete</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary add_button">
                Update Task
            </button>
            </form>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        var status = "<?= $data->status; ?>";
        document.getElementById('status').value = status;
    </script>
</body>
</html>