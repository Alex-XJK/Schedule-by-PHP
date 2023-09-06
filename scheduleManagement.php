<?php
$trFun = $_POST["function"];
$location = "./temporarySchedule.json";

try {
    switch ($trFun) {
        case 'change':
            $trKey = $_POST["key"];
            echo "Operation command received: [add / change / override event] <br>";
            $trDay = number_format($_POST["date"], 0);
            $trTim = number_format($_POST["time"], 0);
            $trTyp = $_POST["type"] == null ? "free" : $_POST["type"];
            $trCod = $_POST["code"] == null ? "" : $_POST["code"];
            $trNam = $_POST["name"] == null ? "" : $_POST["name"];
            $trMsE = $_POST["msge"] == null ? "" : $_POST["msge"];
            $trMsC = $_POST["msgc"] == null ? "" : $_POST["msgc"];
            $result = change($trDay, $trTim, $trTyp, $trCod, $trNam, $trMsE, $trMsC);
            break;
        case 'setnotice':
            $trKey = $_POST["key"];
            $trNot = $_POST["notice"];
            echo "Operation command received: [set notice line] <br>";
            $result = notice($trNot);
            break;
        case 'clsnotice':
            $trKey = $_POST["key"];
            echo "Operation command received: [clear notice line] <br>";
            $result = notice(null);
            break;
        case 'clear':
            $trKey = $_POST["key"];
            echo "Operation command received: [clear all in temporary schedule] <br>";
            $result = clearAll();
            break;
        case 'roll':
            $trKey = $_POST["key"];
            echo "Operation command received: [rollback to last check point] <br>";
            $result = rollback();
            break;
        default:
            throw new Exception("Error Processing Request", 1);
            break;
    }
    echo "Operation finished with code: ".$result."<br>";
} catch (Exception $e) {
    echo $e->getMessage();
    exit(1);
}


function change($day, $time, $type, $code, $name, $enmsg, $chmsg) {
    // Load Existing Data
    global $location;
    $json_string = file_get_contents($location);
    $decode_string = json_decode($json_string, true);
    $wholeSchedule = $decode_string["schedule"];

    // Create New Event Object
    $newMsg = array();
    $newMsg["EN"] = $enmsg;
    $newMsg["CH"] = $chmsg;
    $newEvent = array();
    $newEvent["date"] = (int)$day;
    $newEvent["time"] = (int)$time;
    $newEvent["type"] = $type;
    $newEvent["code"] = $code;
    $newEvent["name"] = $name;
    $newEvent["message"] = $newMsg;

    // Write In New Data
    array_push($wholeSchedule, $newEvent);
    $decode_string["backup"] = $decode_string["schedule"];
    $decode_string["schedule"] = $wholeSchedule;
    $newData = json_encode($decode_string, JSON_PRETTY_PRINT);
    return file_put_contents($location, $newData);
}


function clearAll() {
    // Load Existing Data
    global $location;
    $json_string = file_get_contents($location);
    $decode_string = json_decode($json_string, true);

    // Backup
    $decode_string["backup"] = $decode_string["schedule"];
    $decode_string["schedule"] = array();

    // Write In New Data
    $newData = json_encode($decode_string, JSON_PRETTY_PRINT);
    return file_put_contents($location, $newData);
}


function rollback() {
    // Load Existing Data
    global $location;
    $json_string = file_get_contents($location);
    $decode_string = json_decode($json_string, true);

    // Replace
    $decode_string["schedule"] = $decode_string["backup"];

    // Write In New Data
    $newData = json_encode($decode_string, JSON_PRETTY_PRINT);
    return file_put_contents($location, $newData);
}


function notice($newNotice) {
    // Load Existing Data
    global $location;
    $json_string = file_get_contents($location);
    $decode_string = json_decode($json_string, true);

    // Update
    $decode_string["notice"] = $newNotice;

    // Write In New Data
    $newData = json_encode($decode_string, JSON_PRETTY_PRINT);
    return file_put_contents($location, $newData);
}
?>