document.getElementById('task-form').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent form submission

    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const due_date = document.getElementById('due_date').value;
    const priority = document.getElementById('priority').value;

    // Create a new task object
    const task = {
        title: title,
        description: description,
        due_date: due_date,
        priority: priority
    };

    // POST the task to the API
    fetch('http://localhost/task_manager_api/index.php/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(task)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Task created:', data);
        loadTasks(); // Reload tasks after adding a new one
        // Clear the form fields
        document.getElementById('task-form').reset();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});

// Function to load and display tasks
function loadTasks() {
    fetch('http://localhost/task_manager_api/index.php/tasks')
        .then(response => response.json())
        .then(tasks => {
            const taskList = document.getElementById('task-list');
            taskList.innerHTML = ''; // Clear existing tasks
            tasks.forEach(task => {
                const taskDiv = document.createElement('div');
                taskDiv.className = 'task';
                taskDiv.innerHTML = `
                    <h3>${task.title} (Priority: ${task.priority})</h3>
                    <p>${task.description}</p>
                    <p>Due: ${task.due_date}</p>
                    <button onclick="deleteTask(${task.id})">Delete</button>
                `;
                taskList.appendChild(taskDiv);
            });
        })
        .catch((error) => {
            console.error('Error loading tasks:', error);
        });
}


// Function to delete a task
function deleteTask(id) {
    fetch(`http://localhost/task_manager_api/index.php/tasks/${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        console.log('Task deleted:', data);
        loadTasks(); // Reload tasks after deletion
    })
    .catch((error) => {
        console.error('Error deleting task:', error);
    });
}

// Load tasks on initial page load
loadTasks();

// Suggest tasks when the button is clicked
document.getElementById('suggest-task').addEventListener('click', function () {
    fetch('http://localhost/task_manager_api/index.php/tasks/suggest', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(suggestions => {
        const suggestionsDiv = document.getElementById('suggestions');
        suggestionsDiv.innerHTML = `<strong>Title:</strong> ${suggestions.title} <br> <strong>Description:</strong> ${suggestions.description}`;
    })
    .catch((error) => {
        console.error('Error fetching suggestions:', error);
    });
});

