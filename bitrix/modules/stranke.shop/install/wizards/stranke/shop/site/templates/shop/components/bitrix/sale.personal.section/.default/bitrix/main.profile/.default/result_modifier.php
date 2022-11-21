<?
  global $DB;
  
  /** begin get current user subscription email **/
  $subscr_EMAIL = strtolower(strlen($subscr_EMAIL) > 0? $subscr_EMAIL : $USER->GetParam("EMAIL"));
  /** end get current user subscription email **/
  
  if($subscr_EMAIL <> ""){
  
    /** begin get current user subscribed list **/
    $strSQL = 'SELECT *
      FROM b_sender_contact C
      LEFT JOIN b_sender_mailing_subscription S ON (C.ID = S.CONTACT_ID)
      WHERE
        CODE="'.$subscr_EMAIL.'"';
    
    $res = $DB->Query($strSQL);
    
    $arUserSubscribedList = array();
    
    while($row = $res->Fetch()){
      $arUserSubscribedList[$row["MAILING_ID"]] = $row;
    }
    /** end get current user subscribed list **/
    
    
  }
  
  
  /** begin get company subscription list **/
  $strSQLCompany = 'SELECT *
      FROM b_sender_mailing M
      WHERE
      M.IS_PUBLIC = "Y" AND
      M.ACTIVE = "Y" AND
      M.SITE_ID = "'.SITE_ID.'"
    ';
  
  $res = $DB->Query($strSQLCompany);
  
  $arCompanySubscriptionList = array();
  
  while($row = $res->Fetch()){
    $arCompanySubscriptionList[$row["ID"]] = $row;
  }
  /** end get company subscription list **/

  $arResult["RUBRICS"] = array();
  foreach($arCompanySubscriptionList as $key => $mailing)
  {
    $bChecked = array_key_exists($key, $arUserSubscribedList);
    

    $arResult["RUBRICS"][]=array(
      "ID"=>$mailing["ID"],
      "NAME"=>$mailing["NAME"],
      "DESCRIPTION"=>$mailing["DESCRIPTION"],
      "CHECKED"=>$bChecked,
    );
  }

?>