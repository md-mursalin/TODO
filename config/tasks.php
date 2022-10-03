<?php
    class Tasks extends Database {
        
        //insert data
        public function executeQuery($sql) {
            $res = $this->connect()->query($sql);
            if($res)
                return true;
            else
                return false;
        }

        //get all tasks
        public function getAllTasks() {
            $sql = "select * from todolists order by id desc";
            $result = $this->connect()->query($sql);

            $data = array();
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            return $data;
        }

        //get a task
        public function getTask($id) {
            $sql = "select * from todolists where id = ".$id;
            $result = $this->connect()->query($sql);

            $data = array();
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data = $row;
                }
            }
            return $data;
        }




    }
