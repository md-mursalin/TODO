<?php
session_start();
include('config/database.php');
include('config/tasks.php');
$obj = new Tasks;

if(isset($_POST['submit'])) {
    $task = $_POST['task'];
    $id = $_POST['id'];
    $created_at = $updated_at = date("Y-m-d H:i:s");

    if(!empty($id)) {
        $sql = "UPDATE todolists set task = '".$task."', updated_at = '".$updated_at."' where id = ".$id;
        $res = $obj->executeQuery($sql);
        if($res) {
            $_SESSION['success'] = "Task has been update successfully";
        }
        else {
            $_SESSION['error'] = "Something went wrong, please try again later";
        }
    }
    else {
        $sql = "INSERT INTO todolists (task, created_at, updated_at) VALUES ('".$task."', '".$created_at."', '".$updated_at."')";
        $res = $obj->executeQuery($sql);

        if($res) {
            $_SESSION['success'] = "Task has been created successfully";
        }
        else {
            $_SESSION['error'] = "Something went wrong, please try again later";
        }
    }

    session_write_close();
    header("LOCATION:front.php");
}

//Get all Tasks
$tasks = $obj->getAllTasks();

//Get Task
$editing = false;
if(isset($_GET['action']) && $_GET['action']  === 'edit') {
    $taskData = $obj->getTask($_GET['id']);
    $editing = true;
}

//Delete Task
if(isset($_GET['action']) && $_GET['action']  === 'delete') {
    $sql = "DELETE FROM todolists WHERE id = ".$_GET['id'];
    $res = $obj->executeQuery($sql);
    if($res) {
        $_SESSION['success'] = "Task has been deleted successfully";
    }
    else {
        $_SESSION['error'] = "Something went wrong, please try again later";
    }

    session_write_close();
    header("LOCATION:front.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../../css/assets/fontawesome/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css"/>
    <title>Todo List </title>
</head>
<body>

<div class="container">
    <div id="newtask">
        <?php include('include/alert.php') ?>


        <h3>Todo List App</h3>
        <form action="front.php" method="post" id="taskform">
            <input type="hidden" name="id" value="<?php if($editing) { echo $taskData['id']; } ?>"  >
            <input type="text" name="task" id="task" placeholder="Task to be done..." value="<?php if($editing) { echo $taskData['task']; } ?>" />
            <button type="submit" name="submit" id="add"><?php if($editing) { echo "Update"; } else { echo "Add" ; } ?></button>
        </form>
    </div>

    <div id="tasks">
        <?php
        if(!empty($tasks)) {
            foreach($tasks as $t) {
                ?>
                <div class="task">
                    <span><?php echo $t['task'] ?></span>
                    <a href="front.php?action=edit&id=<?php echo $t['id'] ?>" class="edit button">Edit<i class="fa fa-edit"></i></a>
                    <a onclick="return confirm('Do you want to delete this record?')" href="front.php?action=delete&id=<?php echo $t['id'] ?>" class="delete button">Del<i class="fa fa-trash-alt"></i></a>
                </div>
            <?php }} ?>
    </div>
</div>

<script src="assets/js/app.js"></script>
</body>
</html>
