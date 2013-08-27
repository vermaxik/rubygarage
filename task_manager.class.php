<?php

Class Task_manager {
    
    var $localhost = "localhost";
    var $db_user = "root";
    var $db_pass = "";
    var $db_name = "garage";
    var $base_domain = "http://ruby";
    var $encypt = "rg"; // значение для  доп. шифрования пароля в куках
    var $user_id;
    
    public function db()    {
        mysql_connect($this->localhost, $this->db_user, $this->db_pass);
        mysql_select_db($this->db_name);
    }
    
    
    public function getTaskList($project_id) {
        if(empty($project_id))  {
            return FALSE;
        }
        if(is_array($project_id)) {
            $sql_project = 'WHERE p.project_id IN ('.implode(",", $project_id).')';
        } else {
            $sql_project = "WHERE p.project_id = '{$project_id}'";
        }
            
        $task_lisk_query = mysql_query("SELECT p.project_id, p.project_name, t.task_name, t.task_id, t.status FROM project p LEFT JOIN tasks t ON (t.project_id=p.project_id) {$sql_project} ORDER by p.project_id asc, t.task_id asc");
        $task_list = array ();
        while($c = mysql_fetch_assoc($task_lisk_query))   {
            $task_list[$c['project_id']][$c['project_name']][] = $c;
        }
        
        return ($task_list) ? $task_list : false;
    }
    
    
    /**
     * @param int: $current_project_id - айди который нужно поменять
     * @param string: $name - имя на которое меняем
     * @param array: $project_id - массив адишников, которые пренадлежат данному юзеру
     * 
     */
    public function editProject($current_project_id, $name, $project_id) {
        if(empty($current_project_id))  {
            return FALSE;
        }
        $name = htmlspecialchars(trim($name));
        $name = mysql_real_escape_string($name);
        
        if(empty($project_id))  {
            $project_id = 0;
        }
        if(is_array($project_id)) {
            $sql_project = 'project_id IN ('.implode(",", $project_id).') and';
        } else {
            $sql_project = "project_id = '{$project_id}' and ";
        }
        

        $project_query = mysql_query("select count(*) as count from project where {$sql_project} project_name='{$name}'") or die(mysql_error());
        $project_assoc = mysql_fetch_assoc($project_query);
        if($project_assoc['count'] == "0") {
            mysql_query("update project set project_name='{$name}' where project_id = '{$current_project_id}' ");
        }
    }
    public function addProject($name, $project_id)   {
        
        if(empty($project_id))  {
            $project_id = 0;
        }
        if(is_array($project_id)) {
            $sql_project = 'project_id IN ('.implode(",", $project_id).') and';
        } else {
            $sql_project = "project_id = '{$project_id}' and ";
        }
        
        $name = htmlspecialchars(trim($name));
        $name = mysql_real_escape_string($name);
        $project_query = mysql_query("select count(*) as count from project where {$sql_project} project_name='{$name}'") or die(mysql_error());
        $project_assoc = mysql_fetch_assoc($project_query);
        if($project_assoc['count'] == "0") {
            
            $project_query = mysql_query("INSERT INTO project(project_name) values('{$name}')");
            $last_insert = mysql_insert_id();
            if($project_query) {
                $user_info = $this->checkCookie();
                mysql_query("INSERT INTO access values('".$user_info['user_info']['user_id']."', '".$last_insert."')");
            }
        }
    }
    
    public function editTask($task_id, $task_name) {
        if(empty($task_id))  {
            return FALSE;
        }
        $task_id = intval($task_id);
        $task_name = htmlspecialchars(trim($task_name));
        $task_name = mysql_real_escape_string($task_name);
        
        mysql_query("UPDATE tasks SET task_name = '{$task_name}' WHERE task_id = '{$task_id}' LIMIT 1 ");
    }
    
    public function addTask($project_id, $task_name)    {
        $task_name = htmlspecialchars(trim($task_name));
        $task_name = mysql_real_escape_string($task_name);
        $project_id = intval($project_id);
        mysql_query("INSERT INTO tasks(project_id,task_name) VALUES('{$project_id}','{$task_name}')");
    }
    
    /**
     * @param name - имя пользователя
     * @param login - логин пользователя
     * @param passwd - пароль
     * @param email - false
     * @return int : 1 - ok, 0 - mysql error, 2 - login exist
     * 
     * 
    */
    public function addUser($name, $login, $passwd, $mail = false) {
        
        $name = htmlspecialchars(trim($name));
        $login = mysql_real_escape_string(trim($login));
        //$mail = htmlspecialchars(trim($mail));
        $passwd = md5(trim($passwd));

        $check_user_query = mysql_query("SELECT count(*) as count FROM users WHERE login='$login'");
        $check_user_assoc = mysql_fetch_assoc($check_user_query);
        
        if($check_user_assoc['count'] == 0) {
            $add_user_query= mysql_query("INSERT INTO users(login,passwd,name) VALUES('{$login}','{$passwd}','{$name}')");
            return ($add_user_query)  ? 1 : 0 ;
        } 
        else {
            return 2;
        }
        
        
    }
    
    /**
     * @param login - логин пальзоватлея
     * @param passwd - пароль пользователя
     * @return int: 1 - ok - logon, 0 - show form
     * 
     * 
    */
    public function checkUser($login, $passwd) {
        $task_name = htmlspecialchars(trim($task_name));
        $login = mysql_real_escape_string(trim($login));
        $passwd = md5(trim($passwd));

        $check_user_query = mysql_query("SELECT count(*) as count FROM users WHERE login='$login' AND passwd = '$passwd'");
        $check_user_assoc = mysql_fetch_assoc($check_user_query);
        return ($check_user_assoc['count'] > 0) ? 1 : 0 ;
       
    }
    
    public function checkCookie($login = false, $passwd = false) {
            if(empty($login) && empty($passwd)) {
                return $this->checkUserFromCookie($_COOKIE['login'],$_COOKIE['passwd']);
            } else {
                $this->setCookie($login, $passwd);
                return $this->checkUserFromCookie($_COOKIE['login'],$_COOKIE['passwd']);
            }
     
    }
    
    private function setCookie($login, $passwd) {
        $login = base64_encode($this->encypt.$login); // добавим сложности
        $passwd = base64_encode($this->encypt.md5($passwd)); // добавим сложности
        setcookie ("login", $login, time()+86400, "/");
        setcookie ("passwd", $passwd, time()+86400, "/");
    }
    
    private function checkUserFromCookie($login, $passwd) {
        $login = base64_decode($login);
        $login = explode($this->encypt, $login);
        $login = $login[1];
        
        $passwd = base64_decode($passwd);
        $passwd = explode($this->encypt, $passwd);
        $passwd = $passwd[1];

        $check_user_query = mysql_query("SELECT count(*) as count, user_id, name FROM users WHERE login='$login' AND passwd = '$passwd'") or die(mysql_error());
        $check_user_assoc = mysql_fetch_assoc($check_user_query);
        $count = ($check_user_assoc['count'] > 0) ? 1 : 0 ;
        if($count == 0) {
            return 0; 
        } else {

            mysql_query("UPDATE users SET date_log='".date("Y-m-d H:i:s")."' WHERE login='$login' AND passwd = '$passwd'");
            $user_access_query = mysql_query("SELECT project_id FROM access WHERE user_id = '{$check_user_assoc['user_id']}'");
            $project_id = array();
            while($c = mysql_fetch_assoc($user_access_query))   {
                $project_id[] = $c['project_id'];
            }
            $ui = array (
                    'user_info' => array(
                        "user_id" => $check_user_assoc['user_id'],
                        "user_name" => $check_user_assoc['name'],
                        ),
                    'project_id' => $project_id
                    );
            return $ui;
        }
        
    }
    
    public function  destroyCookie() {
        setcookie ("login", "", time()+3600, "/");
        setcookie ("passwd", "", time()+3600, "/");
    }
    
    public function get_user_id($user_id) {
    return $this->user_id = $user_id;
    }
    
    public function delProject($project_id) {
        if(empty($project_id)) {
            return FALSE;
        }
        
        $project_id = intval($project_id);
        $pd_query = mysql_query("delete from project where project_id = '{$project_id}'");
        if($pd_query) {
            mysql_query("delete from tasks where project_id = '{$project_id}'"); // удаляем задания
            mysql_query("delete from access where project_id = '{$project_id}'"); // чистим доступ
        }
    }
    
    public function setTaskStatus($task_id) {
        if(empty($task_id)) {
            return FALSE;
        }
        
        $task_id = intval($task_id);
        $task_query = mysql_query("select status from tasks where task_id = '{$task_id}' ");
        $task_result = mysql_fetch_assoc($task_query);
        if($task_result['status'] == "0") {
            mysql_query("update tasks set status = '1' where task_id = '{$task_id}'  ");
        } else {
            mysql_query("update tasks set status = '0' where task_id = '{$task_id}'  ");
        }
    }
    
    public function delTask($task_id) {
        if(empty($task_id)) {
            return FALSE;
        }
        
        $task_id = intval($task_id);
        
        mysql_query("delete from tasks where task_id = '{$task_id}'");
    }

    
}



