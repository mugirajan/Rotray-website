<?php
include 'db.php';

function fetchRotariansList($club_value)
{
    $data = [];
    $where = "club_name = '".$club_value."'";
    $sql = "SELECT 
                member_id,
                full_name,
                phone_number 
            FROM rotary_members
            WHERE ".$where." ORDER BY full_name";
    message($sql);
    $result = $GLOBALS['conn']->query($sql);

    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        return [];
    }
}

function fetchRotaryClubList()
{
    $data = [];
    $sql = "SELECT DISTINCT club_name FROM rotary_members";
    $result = $GLOBALS['conn']->query($sql);

    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        echo "0 results";
    }
}

function fetchRotariansDetails($value)
{
    $data = [];
    $sql = "SELECT * FROM rotary_members WHERE member_id = {$value}";
    $result = $GLOBALS['conn']->query($sql);

    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data[0];
    } else {
        echo "0 results";
    }
}

function insertRotariansDetails($data)
{
    foreach ($data as $row) {
        if($row['rotarianSearch'] != "") {
            $food_preference = is_array($row['food_preference']) ? implode(',', $row['food_preference']) : $row['food_preference'];
            
            $sql = "INSERT INTO register_event (name, call_name, type, food_preference, mobile, fktransaction_id) VALUES ('".$row['rotarianSearch']."', '".$row['rotarian_call_name']."', 1, '".$food_preference."', '".$row['rotarian_mobile']."', ".$row['fktransaction_id'].")";
            
            if ($GLOBALS['conn']->query($sql) !== TRUE) {
                message("Error: " . $sql . "<br>" . $GLOBALS['conn']->error);
            }
        }
    }
}


function insertTransactionDetails($data)
{
    $conn = $GLOBALS['conn'];
    $sql = "INSERT INTO rotary_transactions (transaction_ref, receipt_path, transaction_date, total_amount, registerer_id, registerer_email, registerer_mobile) VALUES ('".$data['transactionRef']."', '".$data['transactionRecipt']."', '".$data['transactionDate']."', '".$data['totalAmount']."', '".$data['registerer_name']."', '".$data['registerer_email']."', '".$data['registerer_mobile']."')";
    
    if ($conn->query($sql) !== TRUE) {
        message("Error: " . $sql . "<br>" . $conn->error);
    } else {
        return array("id" => $conn->insert_id);
    }
}

function insertAnnDetails($data)
{
    $ff = "fileo.txt";
    file_put_contents($ff, print_r($data, true), FILE_APPEND | LOCK_EX);
    foreach ($data as $row) {
        if($row['ann_name'] != "") {
            $food_preference = is_array($row['ann_food_preference']) ? implode(',', $row['ann_food_preference']) : $row['ann_food_preference'];
            $sql = "INSERT INTO register_event (name, call_name, type, food_preference, mobile, fktransaction_id) VALUES ('".$row['ann_name']."', '".$row['ann_call_name']."', 2, '".$food_preference."', '".$row['ann_mobile']."', ".$row['fktransaction_id'].")";
            
            if ($GLOBALS['conn']->query($sql) !== TRUE) {
                message("Error: " . $sql . "<br>" . $GLOBALS['conn']->error);
            }
        }
    }
}

function insertAnnetteDetails($data)
{

    foreach ($data as $row) {
        if($row['annette_name'] != "") {
            $food_preference = is_array($row['annette_food_preference']) ? implode(',', $row['annette_food_preference']) : $row['annette_food_preference'];

            $sql = "INSERT INTO register_event (name, call_name, type, food_preference, mobile, fktransaction_id) VALUES ('".$row['annette_name']."', '".$row['annette_call_name']."', 3, '".$food_preference."', '".$row['annette_mobile']."', ".$row['fktransaction_id'].")";
            
            if ($GLOBALS['conn']->query($sql) !== TRUE) {
                message("Error: " . $sql . "<br>" . $GLOBALS['conn']->error);
            }
        }
    }
}

function insertGuestDetails($data)
{
    foreach ($data as $row) {
        if($row['guest_name'] != "") {
            $food_preference = is_array($row['guest_food_preference']) ? implode(',', $row['guest_food_preference']) : $row['guest_food_preference'];

            $sql = "INSERT INTO register_event (name, call_name, type, food_preference, mobile, fktransaction_id) VALUES ('".$row['guest_name']."', '".$row['guest_call_name']."', 4, '".$food_preference."', '".$row['guest_mobile']."', ".$row['fktransaction_id'].")";
            
            if ($GLOBALS['conn']->query($sql) !== TRUE) {
                message("Error: " . $sql . "<br>" . $GLOBALS['conn']->error);
            }
        }
    }
}

function getEventRegisterDetails()
{
    $data = [];
    $sql = "
            SELECT 
                re.register_event_id AS id,
                IF(type = 1, (SELECT full_name FROM rotary_members WHERE member_id = re.name), re.name) AS name,
                re.call_name AS callName,
                IF(re.type = 1, 'Rotarian', IF(re.type = 2, 'Ann', IF(re.type = 3, 'Annette', 'Guest'))) AS type,
                IF(re.food_preference = 1, 'Veg', 'Non-Veg') AS foodPrefrence,
                IF(type = 1, (SELECT phone_number FROM rotary_members WHERE member_id = re.name), re.mobile) AS mobile,
                rt.transaction_ref AS transaction_ref,
                rt.receipt_path AS receipt_path,
                (SELECT full_name FROM rotary_members WHERE member_id = rt.registerer_id) AS registrerName,
                (SELECT club_name FROM rotary_members WHERE member_id = rt.registerer_id) AS clubName,
                rt.registerer_gst AS gst
            FROM register_event re
            LEFT JOIN rotary_transactions rt ON re.fktransaction_id = rt.transaction_id
            ";
    $result = $GLOBALS['conn']->query($sql);

    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        echo "0 results";
    }
}

function getTransactionDetails()
{
    $data = [];
    $sql = "
            SELECT 
                rt.transaction_id AS id,
                rt.transaction_ref AS transactionRef,
                rt.total_amount AS amount,
                rt.transaction_date AS date,
                rt.receipt_path AS receipt_path,
                (SELECT full_name FROM rotary_members WHERE member_id = rt.registerer_id) AS registrerName,
                (SELECT club_name FROM rotary_members WHERE member_id = rt.registerer_id) AS clubName,
                rt.registerer_email AS email,
                rt.registerer_mobile AS mobile,
                rt.registerer_gst AS gst
            FROM rotary_transactions rt
            ";
    $result = $GLOBALS['conn']->query($sql);

    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        echo "0 results";
    }
}
?>
