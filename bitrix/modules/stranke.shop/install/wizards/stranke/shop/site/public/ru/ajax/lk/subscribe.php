<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
  
class SubscribeManager
{
  private $mail;
  private $id;
  private $checked;
  private $arUser;
  private $contactID;
  private $db;
  private $user;
  
  function __construct($DB, $USER)
  {
    $this->db = $DB;
    $this->user = $USER;
    $this->arUser = $this->user->GetByID($this->user->GetID())->Fetch();
  
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['checked']))
    {
      if (check_email($this->arUser["EMAIL"], true))
      {
        $this->mail = $this->arUser["EMAIL"];
        $this->id = intval($_POST['id']);
        $this->checked = $_POST['checked'];
  
        $this->GetContactID();
      } else {
        $this->ErrStr("Error mail");
      }
    }
  }
  
  private function CreateContact(){
    $sqlCreate = 'INSERT INTO b_sender_contact SET CODE="'.$this->mail.'", DATE_INSERT=NOW(), DATE_UPDATE=NOW()';
    $this->db->Query($sqlCreate);
    $this->GetContactID();
  }
  
  private function GetContactID(){
    $sqlContact = 'SELECT C.ID FROM b_sender_contact C WHERE C.CODE = "'.$this->mail.'"';
    $contactID = $this->db->Query($sqlContact)->Fetch();
    
    if($contactID === false){
      $this->CreateContact();
    } else {
      $this->contactID = $contactID["ID"];
      $this->UpdateOrInsert();
    }
  }
  
  private function ErrStr($str){
    echo \Bitrix\Main\Web\Json::encode($str);
  }
  
  private function Insert(){
    $sql = 'INSERT INTO b_sender_mailing_subscription SET MAILING_ID='.$this->id.', CONTACT_ID='.$this->contactID.', DATE_INSERT=NOW()';
    $this->db->Query($sql);
  }
  
  private function Delete(){
    $sql='DELETE FROM b_sender_mailing_subscription WHERE CONTACT_ID='.$this->contactID.' AND MAILING_ID='.$this->id.' LIMIT 1';
    $this->db->Query($sql);
  }
  
  private function UpdateOrInsert()
  {
    $sql = 'SELECT *
      FROM b_sender_mailing_subscription S
      WHERE S.MAILING_ID = '.$this->id.' AND
      S.CONTACT_ID = '.$this->contactID;
    
    $result = $this->db->Query($sql)->Fetch();
  
    if($this->checked === 'true' && $result === false){

      $this->Insert();
      
    } elseif ($this->checked === 'false' && $result !== false) {
    
      $this->Delete();
      
    }
    
  }
}

global $DB;
global $USER;

$subscribeManager = new SubscribeManager($DB, $USER);

