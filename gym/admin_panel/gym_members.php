<?php

require "database.php";

interface Select{
     public function SelectXY();
}

interface Read{
    public function Read();
}


class Members extends Database  implements Select,Read{

    public $id;
    public $name;
    public $lastName;
    public $email;
    public $memberID;
    public $trainer;

    function AddMember($name,$lastName,$email,$memberID,$trainer){

        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->memberID = $memberID;
        $this->trainer = $trainer;

        $this->name = htmlentities($this->name);
        $this->lastName = htmlentities($this->lastName);
        $this->email = htmlentities($this->email);

        $insertMember = "INSERT INTO gym.member(name_member,lastName_member,email,memberID,trainer_id_trainer) VALUES (:name_member,:lastName_member,:email,:memberID,:trainer_id_trainer)";

        $createMember = parent::SetConnection()->prepare($insertMember);

        
       $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");

       if (empty($this->name) || !isset($this->name) || !ctype_upper($this->name[0])) {
               $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
       }elseif (empty($this->lastName) || !isset($this->lastName) || !ctype_upper($this->lastName[0])) {
               $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
       }elseif (empty($this->email) || !isset($this->email) || !filter_var($this->email,FILTER_VALIDATE_EMAIL)){
               $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
       }elseif(empty($this->memberID) || !isset($this->memberID) || $this->memberID <= 0) {
               $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
       }elseif($this->SelectXY($this->memberID)) {
               $message = $xmlFile->addChild("message","User with that MemberID already exist!");
       }elseif ($this->EmailExist($this->email)) {
                $message = $xmlFile->addChild("message","User with that Email already exist!");
       }else{

            $createMember->bindParam(":name_member",$this->name);
            $createMember->bindParam(":lastName_member",$this->lastName);
            $createMember->bindParam(":email",$this->email);
            $createMember->bindParam(":memberID",$this->memberID);
            $createMember->bindParam(":trainer_id_trainer",$this->trainer);

            $createMember->execute();

            $message = $xmlFile->addChild("message","You have been successfully add member.");

       }
       
       Header("Content-type:text/xml");
       echo $xmlFile->asXML();

    }

    function SelectXY()
    {
     
     $selectXY = "SELECT memberID FROM gym.member WHERE memberID = :memberID";

     $existUser = parent::SetConnection()->prepare($selectXY);

     $existUser->bindParam(":memberID",$this->memberID);

     $existUser->execute();
     
     if ($existUser->rowCount() == 1 ) {
          return true;
     }else{
          return false;
     }

    }

    public function EmailExist($email){

        $this->email = $email;

        $select = "SELECT email from gym.member where email = :email";

        $selectEmail = parent::SetConnection()->prepare($select);

        $selectEmail->bindParam(":email",$this->email);

        $selectEmail->execute();

        if($selectEmail->rowCount() == 1){
                return true;
        }else{
                return false;
        }

    }


    function Read(){

        $readQuery = "SELECT id,name_member,lastName_member,email,memberID,name_trainer,lastName_trainer
        from gym.member 
        join gym.trainer
        on id_trainer = trainer_id_trainer
        order by name_member asc";

        $read = parent::SetConnection()->prepare($readQuery);

        $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><members></members>");

        $read->execute();

        if ($read->rowCount() > 0) {
                
                while($red = $read->fetch(PDO::FETCH_ASSOC)){
                        $member = $xmlFile->addChild("member");
                        $member->addChild("id",$red["id"]);
                        $member->addChild("name_member",$red["name_member"]);
                        $member->addChild("lastName_member",$red["lastName_member"]);
                        $member->addChild("email",$red["email"]);
                        $member->addChild("memberID",$red["memberID"]);
                        $member->addChild("name_trainer",$red["name_trainer"]);
                        $member->addChild("lastName_trainer",$red["lastName_trainer"]);
                }
        }
 
       Header("Content-type:text/xml");
       echo $xmlFile->asXML();

    }
    
    public function Delete($id)
    {
        
        $this->id = $id;

        $delete = "DELETE FROM gym.member WHERE id = :id";

        $deleteMember = parent::SetConnection()->prepare($delete);

        $deleteMember->bindParam(":id",$this->id);

        $deleteMember->execute();
        
    }


    public function Update($id,$name,$lastName,$email,$trainer){

        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->trainer = $trainer;

        $update = "UPDATE gym.member 
        JOIN gym.trainer 
        ON id_trainer = trainer_id_trainer
        SET name_member = :name_member, lastName_member = :lastName_member,email = :email,trainer_id_trainer = :trainer_id_trainer
        WHERE id = :id";

        $updateMember = parent::SetConnection()->prepare($update);

        $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");
        
       if (empty($this->name) || !isset($this->name) || !ctype_upper($this->name[0])) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
        }elseif (empty($this->lastName) || !isset($this->lastName) || !ctype_upper($this->lastName[0])) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
        }elseif (empty($this->email) || !isset($this->email) || !filter_var($this->email,FILTER_VALIDATE_EMAIL)){
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
        }else{

                $updateMember->bindParam(":id",$this->id);
                $updateMember->bindParam(":name_member",$this->name);
                $updateMember->bindParam(":lastName_member",$this->lastName);
                $updateMember->bindParam(":email",$this->email);
                $updateMember->bindParam(":trainer_id_trainer",$this->trainer);

                $updateMember->execute();

                $message = $xmlFile->addChild("message","You have been successfully updated member.");

        }
        
        Header("Content-type:text/xml");
        echo $xmlFile->asXML();

    }

}


Class Trainer extends Database implements Read,Select{

        public $name_trainer;
        public $lastName_trainer;
        public $phone;
        public $id_trainer;

        function AddTrainer($name_trainer,$lastName_trainer,$trainerID,$phone){

                
          $this->name = htmlentities($this->name_trainer);
          $this->lastName = htmlentities($this->lastName_trainer);
          $this->phone = htmlentities($this->phone);

          $this->name_trainer = $name_trainer;
          $this->lastName_trainer = $lastName_trainer;
          $this->phone = $phone;
          $this->trainerID = $trainerID;

          $insertTrainer = "INSERT INTO gym.trainer(name_trainer,lastName_trainer,trainerID,phone) VALUES (:name_trainer,:lastName_trainer,:trainerID,:phone)";

          $addTrainer = parent::SetConnection()->prepare($insertTrainer);

          $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");

          if (empty($this->name_trainer) || !isset($this->name_trainer) || !ctype_upper($this->name_trainer[0])) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
          }elseif (empty($this->lastName_trainer) || !isset($this->lastName_trainer) || !ctype_upper($this->lastName_trainer[0])) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
          }elseif (empty($this->trainerID) || !isset($this->trainerID) || mb_strlen($this->trainerID) <= 2)  {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
          }elseif(empty($this->phone) || !isset($this->phone) || strlen($this->phone) <= 6 ){
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
          }else{
                
                $addTrainer->bindParam(":name_trainer",$this->name_trainer);
                $addTrainer->bindParam(":lastName_trainer",$this->lastName_trainer);
                $addTrainer->bindParam(":trainerID",$this->trainerID);
                $addTrainer->bindParam(":phone",$this->phone);

                $addTrainer->execute();

                $message = $xmlFile->addChild("message","You have been successfully add member.");

          }

          Header("Content-type:text/xml");
          echo $xmlFile->asXML();

        }
        
        public function Read(){

           $readTrainer = "SELECT id_trainer,name_trainer,lastName_trainer,trainerID,phone FROM gym.trainer ORDER BY lastName_trainer ASC";     

           $readTrainer = parent::SetConnection()->prepare($readTrainer);
           
           $readTrainer->execute();

           $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><trainers></trainers>");

           if ($readTrainer->rowCount() > 0) {
        
                while ($red = $readTrainer->fetch(PDO::FETCH_ASSOC)) {
                      $trainer = $xmlFile->addChild("trainer");
                      $trainer->addChild("id_trainer",$red["id_trainer"]);  
                      $trainer->addChild("name_trainer",$red["name_trainer"]);
                      $trainer->addChild("lastName_trainer",$red["lastName_trainer"]);   
                      $trainer->addChild("trainerID",$red["trainerID"]);   
                      $trainer->addChild("phone",$red["phone"]);      
                }

           }

           Header("Content-type:text/xml");
           echo $xmlFile->asXML();

        }

        public function SelectXY()
        {
        
           $selectTrainer = "SELECT id_trainer,lastName_trainer FROM gym.trainer ORDER BY lastName_trainer ASC";
           
           $select = parent::SetConnection()->prepare($selectTrainer);

           $select->execute();

           $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><trainers></trainers>");

           if ($select->rowCount() > 0) {
                
                while ($red = $select->fetch(PDO::FETCH_ASSOC)) {
                        $trainer = $xmlFile->addChild("trainer");  
                        $trainer->addChild("id_trainer",$red["id_trainer"]);
                        $trainer->addChild("lastName_trainer",$red["lastName_trainer"]);    
                  }

           }

           Header("Content-type:text/xml");
           echo $xmlFile->asXML();

        }

        public function Update($id_trainer,$name_trainer,$lastName_trainer,$phone){

          $this->id_trainer = $id_trainer;
          $this->name_trainer = $name_trainer;
          $this->lastName_trainer = $lastName_trainer;
          $this->phone = $phone;      

          $update = "UPDATE gym.trainer
          SET name_trainer = :name_trainer,lastName_trainer = :lastName_trainer,phone = :phone
          WHERE id_trainer = :id_trainer";

          $updateTrainer = parent::SetConnection()->prepare($update);

          $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");

          if (empty($this->name_trainer) || !isset($this->name_trainer) || !ctype_upper($this->name_trainer[0])) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
          }elseif (empty($this->lastName_trainer) || !isset($this->lastName_trainer) || !ctype_upper($this->lastName_trainer[0])) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
          }elseif(empty($this->phone) || !isset($this->phone) || strlen($this->phone) <= 10 ){
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
          }else{
                
                $updateTrainer->bindParam(":id_trainer",$this->id_trainer);
                $updateTrainer->bindParam(":name_trainer",$this->name_trainer);
                $updateTrainer->bindParam(":lastName_trainer",$this->lastName_trainer);
                $updateTrainer->bindParam(":phone",$this->phone);

                $updateTrainer->execute();

                $message = $xmlFile->addChild("message","You have been successfully updated trainer.");

          }

          Header("Content-type:text/xml");
          echo $xmlFile->asXML();

        }


        function Delete($id_trainer){

           $this->id_trainer = $id_trainer;

           $delete = "DELETE FROM gym.trainer WHERE id_trainer = :id_trainer";

           $deleteTrainer = parent::SetConnection()->prepare($delete);
           
           $deleteTrainer->bindParam(":id_trainer",$this->id_trainer);

           $deleteTrainer->execute();

        }

}

Class Payment extends Database implements Select,Read{

        public $payment_id;
        public $amount;
        public $date_payment;
        public $payment_type;
        public $member;

        public function SelectXY()
        {
         
          $selectMember = "SELECT id,name_member,lastName_member FROM gym.member ORDER BY lastName_member ASC";
          
          $select = parent::SetConnection()->prepare($selectMember);

          $select->execute();

          $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><members></members>");

          while($row = $select->fetch(PDO::FETCH_ASSOC)){
              $member = $xmlFile->addChild("member");
              $member->addChild("id",$row["id"]);  
              $member->addChild("name_member",$row["name_member"]);
              $member->addChild("lastName_member",$row["lastName_member"]);    
          }

          
          Header("Content-type:text/xml");
          echo $xmlFile->asXML();

        }

        public function AddPayment($amount,$date_payment,$payment_type,$member){
                
           $this->amount = $amount;
           $this->date_payment = $date_payment;
           $this->payment_type = $payment_type;
           $this->member = $member;
           
           $payment = "INSERT INTO gym.payment(amount,date,payment_type,member_id_member) VALUES (:amount,:date,:payment_type,:member_id_member)";

           $addPayment = parent::SetConnection()->prepare($payment);

           $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");

           if (!isset($this->amount) || empty($this->amount)) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
           }elseif (!isset($this->date_payment) || empty($this->date_payment)) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
           }elseif (!isset($this->payment_type) || empty($this->payment_type)) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
           }elseif (!isset($this->member) || empty($this->member)) {
                $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
           }else{

                $addPayment->bindParam(":amount",$this->amount);
                $addPayment->bindParam(":date",$this->date_payment);
                $addPayment->bindParam(":payment_type",$this->payment_type);
                $addPayment->bindParam(":member_id_member",$this->member);

                $addPayment->execute();

                $message = $xmlFile->addChild("message","You have been successfully add payment.");

           }

           
           Header("Content-type:text/xml");
           echo $xmlFile->asXML();

        }

        public function Read()
        {
           
           $readPayment = "SELECT id,name_member,lastName_member,email,date,amount,payment_type
           FROM gym.member
           JOIN gym.payment
           WHERE id = member_id_member
           ORDER BY lastName_member ASC";

           $read = parent::SetConnection()->prepare($readPayment);


           $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><members></members>");

           $read->execute();

                if ($read->rowCount() > 0) {
                
                        while($red = $read->fetch(PDO::FETCH_ASSOC)){
                                $member = $xmlFile->addChild("member");
                                $member->addChild("id",$red["id"]);
                                $member->addChild("name_member",$red["name_member"]);
                                $member->addChild("lastName_member",$red["lastName_member"]);
                                $member->addChild("email",$red["email"]);
                                $member->addChild("date",$red["date"]);
                                $member->addChild("amount",$red["amount"]);
                                $member->addChild("payment_type",$red["payment_type"]);
                        }
                }

                Header("Content-type:text/xml");
                echo $xmlFile->asXML();                     

        }

        public function Update($payment_id,$amount,$date_payment,$payment_type){

                $this->payment_id = $payment_id;
                $this->amount = $amount;
                $this->date_payment = $date_payment;
                $this->payment_type = $payment_type;

                $update = "UPDATE gym.payment
                join gym.member
                on id = member_id_member
                SET amount = :amount, date = :date, payment_type = :payment_type
                WHERE id = :id";

                $updatePayment = parent::SetConnection()->prepare($update);

                $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");

                if (!isset($this->amount) || empty($this->amount)) {
                        $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
                }elseif (!isset($this->date_payment) || empty($this->date_payment)) {
                        $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
                }elseif (!isset($this->payment_type) || empty($this->payment_type)) {
                        $message = $xmlFile->addChild("message","Something is wrong with your inputs.");
                }else{

                        $updatePayment->bindParam(":id",$this->payment_id);
                        $updatePayment->bindParam(":amount",$this->amount);
                        $updatePayment->bindParam(":date",$this->date_payment);
                        $updatePayment->bindParam(":payment_type",$this->payment_type);

                        $updatePayment->execute();

                        $message = $xmlFile->addChild("message","You have been successfully updated payment.");

           }

           
           Header("Content-type:text/xml");
           echo $xmlFile->asXML();


        }

}



?>