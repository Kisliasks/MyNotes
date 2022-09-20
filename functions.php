<?php 



function get_user_id() {

    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }

    $stmt = $db->prepare('SELECT `user_id` FROM users WHERE `user_name` = ?');
    $stmt->execute(array($_SESSION['user_name']));

    while($row = $stmt->fetch()) {
        $user_id = $row['user_id'];

    }
    
    return $user_id;


}


function select_notes() {

    $text_style = '';
    
    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }
    
    
    $stmt = $db->prepare('SELECT notes_text, `time`, notes_id FROM notes_tab WHERE `user_id` = ? ORDER BY notes_id DESC');
    $stmt->execute(array(get_user_id()));

    while($row = $stmt->fetch()) {

        $notes_text = $row['notes_text'];
        $timer = $row['time'];
        $note_id = $row['notes_id'];

        
        $d = new DateTime(); 
        $d->format('Y-m-d');


        if($timer == $d->format('Y-m-d')) {
            $timer = 'Today';
            $text_style = 'text-success';

            echo  <<<DELIMETER
        
    
            <div class="col-12 border-top border-bottom py-5" data-aos="fade" data-aos-delay="200">
              <div class="row align-items-stretch">
                <div class="col-md-2 text-white mb-3 mb-md-0 $text_style"><span class="h4">$timer</span></div>
                <div class="col-md-9">
                  <h2 class="text-white-text-break" >$notes_text</h2>
                  
                   
                </div>
                <a class='btn' id='btn_delete' href='delete_note_all.php?note_id={$note_id}'><i class="fas fa-trash-alt"></i></a>
               
              </div>
            </div>
                      
   DELIMETER; 
           
} elseif( $timer < $d->format('Y-m-d') ) {

            $timer = 'Time is Up';
            $text_style = 'text-warning';

            echo  <<<DELIMETER
        
    
            <div class="col-12 border-top border-bottom py-5" data-aos="fade" data-aos-delay="200">
              <div class="row align-items-stretch">
                <div class="col-md-2 text-white mb-3 mb-md-0 $text_style"><span class="h4">$timer</span></div>
                <div class="col-md-9">
                  <h2 class="text-white-text-break" >$notes_text</h2>
                                  
                </div>
                <a class='btn' id='btn_delete' href='delete_note_all.php?note_id={$note_id}'><i class="fas fa-trash-alt"></i></a>
               
              </div>
            </div>
             
           
   DELIMETER; 

        } else {  

        if(($timer > $d->format('Y-m-d')) && ($timer != $d->format('Y-m-d')) ) {
            
            $text_style = '';


            echo  <<<DELIMETER
        
    
            <div class="col-12 border-top border-bottom py-5" data-aos="fade" data-aos-delay="200">
              <div class="row align-items-stretch">
                <div class="col-md-2 text-white mb-3 mb-md-0 $text_style"><span class="h4">$timer</span></div>
                <div class="col-md-9">
                  <h2 class="text-white-text-break" >$notes_text</h2>
                  
                   
                </div>
                <a class='btn' id='btn_delete' href='delete_note_all.php?note_id={$note_id}'><i class="fas fa-trash-alt"></i></a>
               
              </div>
            </div>
                    
   DELIMETER; 
        }

    }       

 }

}


function select_notes_today() {

    $text_style = '';
    
    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }
    
    $d = new DateTime(); 
    $today = $d->format('Y-m-d');
    
    $stmt = $db->prepare('SELECT notes_text, `time`, notes_id FROM notes_tab WHERE `user_id` = ? AND `time` = ? ORDER BY notes_id DESC');
    $stmt->execute(array(get_user_id(), $today));

    while($row = $stmt->fetch()) {

        $notes_text = $row['notes_text'];
        $timer = $row['time'];
        $note_id = $row['notes_id'];

             
        if($timer == $today) {
            $timer = 'Today';
            $text_style = 'text-success';
         
        }

        echo  <<<DELIMETER
                
         <div class="col-12 border-top border-bottom py-5" data-aos="fade" data-aos-delay="200">
           <div class="row align-items-stretch">
             <div class="col-md-2 text-white mb-3 mb-md-0 $text_style"><span class="h4">$timer</span></div>
             <div class="col-md-9">
               <h2 class="text-white-text-break" >$notes_text</h2>
                              
             </div>
             <a class='btn' id='btn_delete' href='delete_note_today.php?note_id={$note_id}'><i class="fas fa-trash-alt"></i></a>
            
           </div>
         </div>        
         
DELIMETER; 
        
    }

}


function select_notes_time_is_up() {

    $text_style = '';
    
    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }
    
    $d = new DateTime(); 
    $today = $d->format('Y-m-d');
    
    $stmt = $db->prepare('SELECT notes_text, `time`, notes_id FROM notes_tab WHERE `user_id` = ? AND (`time` < ?) ORDER BY notes_id DESC');
    $stmt->execute(array(get_user_id(), $today));

    while($row = $stmt->fetch()) {

        $notes_text = $row['notes_text'];
        $timer = $row['time'];
        $note_id = $row['notes_id'];

        
        if($timer < $today) {
            $timer = 'Time is Up';
            $text_style = 'text-warning';
        }


        echo  <<<DELIMETER
               
         <div class="col-12 border-top border-bottom py-5" data-aos="fade" data-aos-delay="200">
           <div class="row align-items-stretch">
             <div class="col-md-2 text-white mb-3 mb-md-0 $text_style"><span class="h4">$timer</span></div>
             <div class="col-md-9">
               <h2 class="text-white-text-break" >$notes_text</h2>
                            
             </div>
             <a class='btn' id='btn_delete' href='delete_note_tiu.php?note_id={$note_id}'><i class="fas fa-trash-alt"></i></a>
            
           </div>
         </div>
        
DELIMETER; 
        
    }

}



function insert_notes($input) {

    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }


$stmt = $db->prepare('INSERT INTO notes_tab (notes_text, `time`, `user_id`) 
VALUES (?,?,?)');

$stmt->execute(array($input['notes_text'], $input['time'], get_user_id()));


}


function delete_note($note_id) {

    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }

    
    $sql = "DELETE FROM notes_tab WHERE notes_id=?";
    $stmt= $db->prepare($sql);
    $stmt->execute([$note_id]);  

}



function validate_form() {

    $input = array();
    $errors = array();

    $input['notes_text'] = trim($_POST['notes_text'] ?? ''); 
    $input['time'] = trim($_POST['time'] ?? ''); 

    if(!validateDate($input['time'])) {  // проверка корректности формата
        
        $d = new DateTime(); 
        $input['time'] = $d->format('Y-m-d');
        $errors[] = 'Неккоректный формат даты. Значения были преобразованы в "Today". Вводите значения в формате "гггг-мм-дд".';      
     }

     if($input['notes_text'] == '') {   // если строка пуста
        $input['notes_text'] = 'Пустая заметка';
    }
    
    if($input['time'] == '') {  // если строка пуста, вывести сегодняшний день
        $d = new DateTime(); 
        $input['time'] = $d->format('Y-m-d');
    }

    $d = new DateTime();     // проверка вводимой даты на актуальность

    if($input['time'] < $d->format('Y-m-d')) {  
       
        $errors[] = 'Нельзя вводить прошедшую дату. Значения были преобразованы в "Time is Up". Используйте значения только будущего или настоящего времени.';
    }
    
return array($input, $errors);

}


function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


function show_errors($errors = array()) {
    
    foreach ($errors as $error) {
        
        echo  <<<DELIMETER

        <div class="input-group" id="errors" >
            
                    <input type="text" aria-label="First name" class="form-control" id="" value='{$error}'>
            
           </div>

DELIMETER; 
    }
}

function redirect($location) {

    header("Location: $location");

}


function validate_form_log_in() {


    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }
    
        
        $errors = array();

        // В этой переменной устанавливается логическое значение true 
        // только в том случае, если предъявленный пароль подходит 
        $password_ok = false;
        $input['user_name'] = trim($_POST['user_name'] ?? ''); 
        $submitted_password = trim($_POST['user_password'] ?? '');

        $stmt = $db->prepare('SELECT user_password FROM users WHERE `user_name` = ?');
        $stmt->execute(array($input['user_name']));
        $row = $stmt->fetch();
        // Если в таблице отсутствует искомая строка, имя
        // пользователя не найдено ни в одной из строк таблицы 
        if ($row) {
                $password_ok = password_verify($submitted_password,$row['user_password']);          
        }
        if (! $password_ok) {
        $errors[] = 'Please enter a valid username and password.'; 
    }
        return array($errors, $input); 

}


function session_user_validate() {

    if (array_key_exists('user_name', $_SESSION)) {
       return $_SESSION['user_name'];
    } else {
       redirect("register");
    }
}

function userInSession() {

    // проверка, есть ли пользователь в сессии
    if (array_key_exists('user_name', $_SESSION)) {
        redirect("../index.php");
     } 
}



function user_register_validate() {

    $user_name = trim($_POST['user_name']);
    $email    = trim($_POST['email']);
    $user_password = trim($_POST['user_password']);


    $errors = array();
    $input = array(); 


    if(strlen($user_name) < 4){

        $errors[] = 'Введите больше четырех символов в поле "Имя пользователя".';
    }

    if(strlen($user_name) > 14){

        $errors[] = 'Имя пользователя не должно превышать 14 символов.';
    }

     if($user_name ==''){

        $errors[] = 'Поле имени пользователя не может быть пустым';
    }

    if(user_name_exists($user_name)) {

        $errors[] = 'Данное имя пользователя уже существует';
    }

    if($email ==''){

        $errors[] = 'Поле электронной почты не может быть пустым';
    }

    if (strpos($email, '@') === false) {
        $errors[] = 'Имя почтового ящика должно включать в себя символ "@".';
    }

    if(email_exists($email)) {
         $errors[] = 'Пользователь с данной электронной почтой уже зарегистрирован';
     }

    if($user_password == '') {

        $errors[] = 'Поле пароля не может быть пустым';
    }

    // если массив ошибок пуст, передать все значения в переменную $input 
    if(empty($errors)) {
       $input['user_name'] = $user_name;
       $input['email'] = $email;
       $input['user_password'] = $user_password;
    }

    return array($errors, $input);

} 


function user_name_exists($user_name) {

    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }

    $stmt = $db->prepare('SELECT `user_name` FROM users WHERE `user_name` = ?');
    $stmt->execute(array($user_name));
    $row = $stmt->fetch();
    

    if(!empty($row)) {
        return true;
    } else {
        return false;
    }

}


function email_exists($email) {

    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }

    $stmt = $db->prepare('SELECT email FROM users WHERE email = ?');
    $stmt->execute(array($email));
    $row = $stmt->fetch();
    

    if(!empty($row)) {
        return true;
    } else {
        return false;
    }

}


function user_register($input) {

    try {
        $db = new PDO('mysql:host=localhost;dbname=notes', 'root', '');
    } catch (PDOException $e) {
    
        print "Can't connect: ". $e->getMessage();
        exit();
    }

    $input['user_password'] = password_hash($input['user_password'], PASSWORD_BCRYPT, array('cost' => 10));

    $stmt = $db->prepare('INSERT INTO users (`user_name`, user_password, email) VALUES (?,?,?) ');
    $stmt->execute(array($input['user_name'], $input['user_password'], $input['email']));
    

}



 

?>