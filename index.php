<?php
header("Content-Type: application/json");
include_once 'db.php';
include_once 'tasks.php';

// Handle incoming requests
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

switch ($request_method) {
    case 'POST':
        if ($request_uri === '/tasks') {
            createTask();
        } elseif ($request_uri === '/tasks/suggest') {
            suggestTask();
        }
        break;
    case 'GET':
        if ($request_uri === '/tasks') {
            getTasks();
        } elseif (preg_match('/\/tasks\/(\d+)/', $request_uri, $matches)) {
            getTask($matches[1]);
        }
        break;
    case 'PUT':
        if (preg_match('/\/tasks\/(\d+)/', $request_uri, $matches)) {
            updateTask($matches[1]);
        }
        break;
    case 'DELETE':
        if (preg_match('/\/tasks\/(\d+)/', $request_uri, $matches)) {
            deleteTask($matches[1]);
        }
        break;
    default:
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}

// Include the task-related functions
function createTask() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    
    $title = $data['title'];
    $description = $data['description'];
    $due_date = $data['due_date'];
    $priority = $data['priority'];
    
    $sql = "INSERT INTO tasks (title, description, due_date, priority) VALUES ('$title', '$description', '$due_date', '$priority')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['id' => $conn->insert_id, 'message' => 'Task created']);
    } else {
        echo json_encode(['message' => 'Error creating task']);
    }
}

function getTasks() {
    global $conn;
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);
    
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    echo json_encode($tasks);
}

function getTask($id) {
    global $conn;
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['message' => 'Task not found']);
    }
}

function updateTask($id) {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    
    $title = $data['title'];
    $description = $data['description'];
    $due_date = $data['due_date'];
    
    $sql = "UPDATE tasks SET title='$title', description='$description', due_date='$due_date' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Task updated']);
    } else {
        echo json_encode(['message' => 'Error updating task']);
    }
}

function deleteTask($id) {
    global $conn;
    $sql = "DELETE FROM tasks WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Task deleted']);
    } else {
        echo json_encode(['message' => 'Error deleting task']);
    }
}

function suggestTask() {
    $suggestions = [
        'title' => 'Suggested Task Title',
        'description' => 'Suggested Task Description'
    ];
    echo json_encode($suggestions);
}
?>
