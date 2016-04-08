<?php

class SqlUtils{
    public  $dbms= 'mysql' ;
    
    private $host = 'localhost';//数据库主机名
    
    private $dbName = 'workinfo'; //使用的数据库
     
    private $user = 'root';//数据库连接用户名
    
    private $pass = 'Mn234!';//对应的密码
    
    private $con;
    private $pdo;
    
//     private $user_name='root';
//     private $user_password='root';
    private $user_table='user';
    private $user_info='user_info';
    private $company='company';
    private $company_work="com_work";
    private $friend='friend';
    private $notice='notice';

    private $admin_name='admin';
    private $admin_pass='admin';
    private $admin_email='admin@123.com';

    private $complain='complain';
    
    
    function  __construct(){
        
        $create_user_info_table_sql="create table if not exists $this->user_info(id int primary key auto_increment,
real_name VARCHAR(64),w_name VARCHAR(64),w_space VARCHAR(64),s_space VARCHAR(64),s_name VARCHAR(64),
s_s_date DATE ,s_e_date DATE ,e_w_name VARCHAR(64),e_w_space VARCHAR(64),e_s_date DATE ,e_e_date DATE ,
languages VARCHAR(64),skills VARCHAR(64),degree VARCHAR(32),tel VARCHAR(16),u_id INT)";

        $create_user_table_sql="create table if not exists $this->user_table(id int primary key auto_increment,
user_name VARCHAR(64),password VARCHAR(64),email VARCHAR(64))";

        $create_company_table_sql="create table if not exists $this->company(id int primary key auto_increment,
com_name VARCHAR(64),password VARCHAR(64),email VARCHAR(64))";

        $create_company_work_table_sql="create table if not exists $this->company_work(id int primary key auto_increment,
email VARCHAR(64),w_name VARCHAR(64),description VARCHAR(255),tel VARCHAR(16),pub_date DATE ,c_id INT)";

        $create_friend_table_sql="create table if not exists $this->friend(id int primary key auto_increment,from_id INT ,
to_id INT ,comment VARCHAR(255),role_type INT,is_read INT)";

        $create_complain_table_sql="create table if not exists $this->complain(id int primary key auto_increment,
com_id INT ,u_id INT ,content VARCHAR(255),com_date DATE,is_done INT)";

        $create_notice_table_sql="create table if not exists $this->notice(id int primary key auto_increment,
from_id INT ,to_id INT ,content VARCHAR(255),com_date DATE,is_done INT)";




//
//        $create_type_table_sql="create table if not exists $this->type(id int primary key auto_increment,type_name VARCHAR(64),status int)";
//        $create_product_type_table_sql="create table if not exists $this->product_type(id int primary key auto_increment,t_id int,p_id int)";
//        $create_hirer_table_sql="create table if not exists $this->hirer(id int primary key auto_increment,hirer_name VARCHAR(64),gendar VARCHAR(8),content VARCHAR(255),header_img_name VARCHAR(32),u_id int,t_id int)";
//        $create_finder_table_sql="create table if not exists $this->finder(id int primary key auto_increment,finder_name VARCHAR(64),gendar VARCHAR(8),ability VARCHAR(255),header_img_name VARCHAR(32),u_id int,t_id int)";
//
        
        
        $dsn = "$this->dbms:host=$this->host; dbname=$this->dbName";
        $create_data_dase_sql="CREATE DATABASE if not exists $this->dbName";
        
        $this->con=mysqli_connect($this->host, $this->user, $this->pass);
       
        if($this->con){
            if(!mysqli_select_db($this->con, $this->dbName)){
                mysqli_query($this->con, $create_data_dase_sql);
        
            }


            mysqli_select_db($this->con, $this->dbName);
            mysqli_query($this->con, $create_user_table_sql);
            mysqli_query($this->con, $create_user_info_table_sql);
            mysqli_query($this->con, $create_company_table_sql);
            mysqli_query($this->con, $create_company_work_table_sql);
            mysqli_query($this->con, $create_complain_table_sql);
            mysqli_query($this->con, $create_friend_table_sql);
            mysqli_query($this->con, $create_notice_table_sql);

            //首次进入还需要插入图书数据
            //初始化一个PDO对象，就是创建了数据库连接对象 $dbh:
            $this->pdo = new PDO($dsn, $this->user, $this->pass,array(PDO::ATTR_PERSISTENT=>true));
            //如果此时还没有admin，创建一个admin
            //初始化用户名为admin,密码为admin
            $query="select * from user where user_name='$this->admin_name' and password='".sha1($this->admin_pass)."'";

            $res=$this->pdo->query($query);

            if($res->rowCount() < 1)
             {
                 $res=$this->pdo->prepare("insert into user(user_name,password,email) values(?,?,?)");
                 $res->bindParam(1,$this->admin_name);
                 $res->bindParam(2,sha1($this->admin_pass));
                 $res->bindParam(3,$this->admin_email);

                 $res->execute();

             }
        }
        else{
            echo"<h2>创建数据库和表失败!";
        }
        
    }

    //删除用户
    function  delete($u_id){



        $query="delete from $this->user_info where u_id=?";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1,$u_id);
        $result->execute();

        $query="delete from $this->friend where from_id= ? or to_id=?";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1,$u_id);
        $result->bindParam(2,$u_id);

        if($result->execute()){

            $query="delete from $this->user where id= ?";
            $result=$this->pdo->prepare($query);
            $result->bindParam(1, $u_id);
            $result->execute();
        }


    }

    //删除公司
    function  delete_com($c_id){

        $query="delete from $this->company_work where c_id=?";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1,$c_id);
        $result->execute();


        $query="delete from $this->friend where from_id= ? or to_id=?";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1,$c_id);
        $result->bindParam(2,$c_id);
        if($result->execute()){

            $query="delete from $this->company where id= ?";
            $result=$this->pdo->prepare($query);
            $result->bindParam(1, $c_id);
            $result->execute();
        }


    }

    //添加用户
    function  insert_user($strlist){
        $query="insert into user (user_name,password,email) values (?,?,?)";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1, $strlist[0]);
        $result->bindParam(2, sha1($strlist[1]));
        $result->bindParam(3, $strlist[2]);
        return $result->execute();
    }

    //添加公司
    function  insert_company($strlist){
        $query="insert into $this->company (com_name,password,email) values (?,?,?)";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1, $strlist[0]);
        $result->bindParam(2, sha1($strlist[1]));
        $result->bindParam(3, $strlist[2]);
        return $result->execute();
    }

    //添加求职者信息
    function  insert_user_info($strlist){
        $query="insert into $this->user_info(real_name,w_name,w_space,s_space,s_name,s_s_date,s_e_date,e_w_name,
e_w_space,e_s_date,e_e_date,languages,skills,degree,tel,u_id) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1, $strlist[0]);
        $result->bindParam(2, $strlist[1]);
        $result->bindParam(3, $strlist[2]);
        $result->bindParam(4, $strlist[3]);
        $result->bindParam(5, $strlist[4]);
        $result->bindParam(6, date("Y-m-d",strtotime($strlist[5])));
        $result->bindParam(7, date("Y-m-d",strtotime($strlist[6])));
        $result->bindParam(8, $strlist[7]);
        $result->bindParam(9, $strlist[8]);
        $result->bindParam(10, date("Y-m-d",strtotime($strlist[9])));
        $result->bindParam(11, date("Y-m-d",strtotime($strlist[10])));
        $result->bindParam(12, $strlist[11]);
        $result->bindParam(13, $strlist[12]);
        $result->bindParam(14, $strlist[13]);
        $result->bindParam(15, $strlist[14]);
        $result->bindParam(16, $strlist[15]);

        $result->execute();
    }

    //添加公司发布的职位信息
    function  insert_com_work($strlist){
        $query="insert into $this->company_work(email,w_name,description,tel,pub_date,c_id) values (?,?,?,?,?,?)";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1, $strlist[0]);
        $result->bindParam(2, $strlist[1]);
        $result->bindParam(3, $strlist[2]);
        $result->bindParam(4, $strlist[3]);
        $result->bindParam(5, date("Y-m-d",strtotime($strlist[4])));
        $result->bindParam(6, $strlist[5]);

        $result->execute();
    }

    //举报公司
    function insert_complain($strlist){
        $query="insert into $this->complain(com_id,u_id,content,com_date,is_done) values (?,?,?,?,?)";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1, $strlist[0]);
        $result->bindParam(2, $strlist[1]);
        $result->bindParam(3, $strlist[2]);
        $result->bindParam(4, date("Y-m-d",strtotime($strlist[3])));
        $result->bindParam(5, $strlist[4]);

        $result->execute();
    }

    //添加好友
    function add_friend($strlist){


        $query="insert into $this->friend(from_id,to_id,role_type,comment,is_read) values (?,?,?,?,?)";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1, $strlist[0]);
        $result->bindParam(2, $strlist[1]);
        $result->bindParam(3, $strlist[2]);
        $result->bindParam(4, $strlist[3]);
        $result->bindParam(5, $strlist[4]);

        $result->execute();

    }


    function agree_add_friend($strlist){
        $query="select * from $this->friend f where f.from_id=$strlist[0] and f.to_id=$strlist[1] and f.role_type=2";
        $res=$this->pdo->query($query);
        if($res->rowCount()>0){

            $query="update $this->friend f set f.comment=?,is_read =? where f.from_id=? and f.to_id=? and f.role_type=?";
            $result=$this->pdo->prepare($query);
            $result->bindParam(1, $strlist[3]);
            $result->bindParam(2, $strlist[4]);
            $result->bindParam(3, $strlist[0]);
            $result->bindParam(4, $strlist[1]);
            $result->bindParam(5, $strlist[2]);

            $result->execute();

            $is_read=1;
            $query="update $this->friend f set f.is_read=? where f.from_id=? and f.to_id=? and f.role_type=?";
            $result=$this->pdo->prepare($query);
            $result->bindParam(1, $is_read);
            $result->bindParam(2, $strlist[1]);
            $result->bindParam(3, $strlist[0]);
            $result->bindParam(4, $strlist[2]);
            $result->execute();

        }
        else{
            $query="insert into $this->friend(from_id,to_id,role_type,comment,is_read) values (?,?,?,?,?)";
            $result=$this->pdo->prepare($query);
            $result->bindParam(1, $strlist[0]);
            $result->bindParam(2, $strlist[1]);
            $result->bindParam(3, $strlist[2]);
            $result->bindParam(4, $strlist[3]);
            $result->bindParam(5, $strlist[4]);
        }

        $result->execute();
    }

    //删除好友
    function delete_friend($strlist){
            $query="delete from $this->friend where ((from_id=? and to_id=?) or (from_id=? and to_id=?)) and role_type=?";
            $result=$this->pdo->prepare($query);
            $result->bindParam(1, $strlist[0]);
            $result->bindParam(2, $strlist[1]);
            $result->bindParam(3, $strlist[1]);
            $result->bindParam(4, $strlist[0]);
            $result->bindParam(5, $strlist[2]);
            $result->execute();
    }

    //登录验证
    function query_login($name,$password,$type){
        $query="select * from";
        switch($type){
            case 1:
                if($name==$this->admin_name && $password==$this->admin_pass) {
                    $query = $query . " user u where u.user_name='" . $this->admin_name . "' and u.password='" . sha1($this->admin_pass) . "'";
                    $res=$this->pdo->query($query);
                    if($res->rowCount()>0){
                        $user=$res->fetch();
                        setcookie('user_name',$user['user_name'],time()+3600);
                        setcookie('user_id',$user['id'],time()+3600);
                        setcookie('role_type',$type,time()+3600);
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else{
                    return false;
                }
                break;
            case 2:
                $query=$query." user u where u.user_name='".$name."' and u.password='".sha1($password)."'";
                break;
            case 3:
                $query=$query." company u where u.com_name='".$name."' and u.password='".sha1($password)."'";
                break;
        }
//        echo $query;
//        exit;
        $res=$this->pdo->query($query);
        if($res->rowCount() > 0){
            $user=$res->fetch();
            setcookie('user_name',$user['user_name'],time()+3600);
            setcookie('user_id',$user['id'],time()+3600);
            setcookie('role_type',$type,time()+3600);
            return true;
        }
        else {
            return false;
        }
    }

    //根据查询进入
    function query_by_type($u_id,$type,$key){
        $result=array();
        switch($type){
            //管理员登录
            case 1:
                //投诉信息，普通用户，公司用户显示
                $result['user']=$this->query_user();
                $result['com']=$this->query_company();
                $result['complain']=$this->query_complain();

                break;
            //普通用户
            case 2:
                //已经好友，推荐好友，消息
                $result['fri']=$this->query_friend($u_id,2);
                $result['not_fri']=$this->query_re_friend($u_id);
                $result['job']=$this->query_job($key);
                $result['c_u']=$this->query_com_notice($u_id);
                break;
            //公司用户
            case 3:
                //已经好友，消息
                $result['fri']=$this->query_friend($u_id,3);
                $result['user']=$this->query_user_by_key($key);
                $result['u_c']=$this->query_us_notice($u_id);
                break;

        }
        return $result;
    }

    //查询用户发给公司的消息

    function query_us_notice($u_id){
        $query="select * from $this->notice n where n.to_id=$u_id and n.is_done=0";
        $res=$this->pdo->query($query);

        $query="update $this->notice n set n.is_done=1 where n.to_id=$u_id and n.is_done=0";
        $result=$this->pdo->prepare($query);
        $done=1;
        $is_done=0;
        $result->bindParam(1,$done);
        $result->bindParam(1,$u_id);
        $result->bindParam(1,$is_done);
        $result->execute();
        return $res;
    }

    //查询公司发来的消息
    function query_com_notice($u_id){
        $query="select * from $this->notice n where n.to_id=$u_id and n.is_done=0";
        $res=$this->pdo->query($query);


        $query="update $this->notice n set n.is_done=1 where n.to_id=$u_id and n.is_done=0";
        $result=$this->pdo->prepare($query);
        $done=1;
        $is_done=0;
        $result->bindParam(1,$done);
        $result->bindParam(1,$u_id);
        $result->bindParam(1,$is_done);
        $result->execute();

        return $res;
    }

    //查询已经好友
    function query_friend($u_id,$role_type){
        $query="select f0.*,u0.* from user u0,$this->friend f0,(select max(f.id) as id from user u,$this->friend f where f.to_id=$u_id and role_type=$role_type and f.from_id =u.id group by f.to_id) as f1 where f0.id=f1.id and f0.from_id =u0.id ";

//        echo $query;
//        exit;
        $res=$this->pdo->query($query);

        return $res;

    }

    //查询推荐好友
    function query_re_friend($u_id){
        $query="select ui3.* from (select ui.* from $this->user_info ui,(select ui1.u_id,ui1.s_name from $this->user_info ui1 where ui1.u_id=$u_id group by ui1.s_name)
as ui2 where locate(ui2.s_name,ui.s_name) > 0 and ui.u_id!=$u_id group by ui.u_id) as ui3 where not EXISTS (select * from $this->friend f where ui3.u_id = f.to_id and f.from_id=$u_id and f.role_type=2)";

//        echo $query;
//        exit;
        $res=$this->pdo->query($query);
        return $res;
    }

    //查询消息
    function query_notice($to_id,$from_id,$role_type,$is_read){

        $query="select f.* from $this->friend f where f.to_id=$to_id and f.from_id=$from_id and f.role_type=$role_type
 and f.is_read=$is_read order by f.id";

        $res=$this->pdo->query($query);

        $read=1;
        $query="update $this->friend f set f.is_read =? where f.to_id =? and f.from_id=? and f.role_type=? and f.is_read=?";
        $result=$this->pdo->prepare($query);
        $result->bindParam(1,$read);
        $result->bindParam(2,$to_id);
        $result->bindParam(3,$from_id);
        $result->bindParam(4,$role_type);
        $result->bindParam(5,$is_read);
        $result->execute();

        return $res;
    }

    //查询工作
    function  query_job($key){
        $query="select * from $this->company_work c where c.w_name like '%$key%'";
        $res=$this->pdo->query($query);
        return $res;
    }
    //公司查询求职者
    function  query_user_by_key($key){
        $query="select * from $this->user_info u where u.w_name like '%$key%'";
        $res=$this->pdo->query($query);
        return $res;
    }
    //查询普通用户信息
    function query_user(){
        $query="select * from user where user_name !='admin' and password !='".sha1('admin')."'";
        $res=$this->pdo->query($query);
        $result=array();
        foreach($res as $r){
            $result[$r['id']]=$r;
        }
        return $result;
    }

    //查询公司用户信息
    function query_company(){
        $query="select * from $this->company";
        $res=$this->pdo->query($query);
        $result=array();
        foreach($res as $r){
            $result[$r['id']]=$r;
        }
        return $result;
    }

    //查询投诉信息
    function query_complain(){
        $query="select * from $this->complain where is_done=0 ORDER BY com_date";
        $res=$this->pdo->query($query);


        $query="update $this->complain c set c.is_done=? where is_done=?";
        $result=$this->pdo->prepare($query);
        $is_done_cur=1;
        $is_done_before=0;
        $result->bindParam(1,$is_done_cur);
        $result->bindParam(2,$is_done_before);
        $result->execute();

        return $res;
    }

    //根据工作id查询工作信息
    function query_job_by_id($id){
        $query="select * from $this->company_work where id=$id";
        $res=$this->pdo->query($query);
        return $res;
    }
    //查询用户信息
    function query_user_info($u_id){
        $query="select * from $this->user_info where u_id=$u_id";
        $res=$this->pdo->query($query);
        return $res;
    }

    //公司给求职者发消息

    function insert_notice($strlist){
        $query="insert into $this->notice(from_id,to_id,content,com_date,is_done) VALUES (?,?,?,?,?)";
        $result=$this->pdo->prepare($query);

        $result->bindParam(1,$strlist[0]);
        $result->bindParam(2,$strlist[1]);
        $result->bindParam(3,$strlist[2]);
        $result->bindParam(4,date("Y-m-d",strtotime($strlist[3])));
        $result->bindParam(5,$strlist[4]);
        $result->execute();
    }

}

?>
