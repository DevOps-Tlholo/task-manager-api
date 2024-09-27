# Smart Task Manager

## Overview
A simple task manager application with a RESTful API and a responsive user interface.

## Technologies Used
- PHP for the API
- MySQL for the database
- HTML, CSS, JavaScript for the UI

## Setup Instructions

### 1. Database Setup
1. Create a MySQL database named `task_manager`.
2. Create a table called `tasks` with the following structure:

```sql
CREATE TABLE tasks (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE NOT NULL,
    priority ENUM('low', 'medium', 'high') NOT NULL,
    completed BOOLEAN DEFAULT FALSE
);
