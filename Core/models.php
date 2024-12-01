<?php  

function insertSurgeon($pdo, $Surgeon_name, $experience_level, $Specialization, $user) {
    $sql = "INSERT INTO Surgeon (Surgeon_name, experience_level, Specialization) VALUES(?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$Surgeon_name, $experience_level, $Specialization]);

    if ($executeQuery) {
        logActivity($pdo, $user, 'INSERTION', "Inserted Surgeon: $Surgeon_name");
        return true;
    } else {
        return false;
    }
}

function deleteSurgeon($pdo, $Surgeon_id, $user) {
    try {
        $sql = "DELETE FROM Surgeon WHERE Surgeon_id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$Surgeon_id]);
        
        if ($result) {
            logActivity($pdo, $user, 'DELETION', "Deleted Surgeon ID: $Surgeon_id");
            return true;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function updateSurgeon($pdo, $Surgeon_name, $experience_level, $Specialization, $Surgeon_id, $user) {
    $sql = "UPDATE Surgeon SET Surgeon_name = ?, experience_level = ?, Specialization = ? WHERE Surgeon_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$Surgeon_name, $experience_level, $Specialization, $Surgeon_id]);

    if ($executeQuery) {
        logActivity($pdo, $user, 'UPDATING', "Updated Surgeon ID: $Surgeon_id");
        return true;
    }
}

function getAllSurgeon($pdo) {
    $sql = "SELECT * FROM Surgeon";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getSurgeonByID($pdo, $Surgeon_id) {
    $sql = "SELECT * FROM Surgeon WHERE Surgeon_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$Surgeon_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function searchSurgeon($pdo, $searchTerm, $user) {
    $sql = "SELECT * FROM Surgeon WHERE Surgeon_name LIKE :search OR Specialization LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':search' => "%$searchTerm%"]);

    logActivity($pdo, $user, 'SEARCH', "Searched for: $searchTerm");

    return $stmt->fetchAll();
}


function registerUser($pdo, $username, $password) {

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
if ($stmt->rowCount() > 0) {
    return false;
}

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
return $stmt->execute([$username, $password]);
}


function loginUser($pdo, $username, $password) {
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);

$user = $stmt->fetch();

if ($user) {
    return $user;
}

return false;
}


function getAllUsers($pdo) {
$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
return $stmt->fetchAll();
}

function logActivity($pdo, $user, $action_type, $action_details) {
    $sql = "INSERT INTO ActivityLogs (user, action_type, action_details) VALUES(?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user, $action_type, $action_details]);
}

function getActivityLogs($pdo) {
    $sql = "SELECT * FROM activitylogs ORDER BY date_added DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function logoutUser() {
session_start();
session_unset();
session_destroy();
}
?>
