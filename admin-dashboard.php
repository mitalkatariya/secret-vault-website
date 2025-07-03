<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Table for Registered Users -->
    <h3>Registered Users</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody id="user-table-body"></tbody>
    </table>

    <!-- Table for All Messages -->
    <h3>All Messages</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>User ID</th>
          <th>Content</th>
          <th>Code</th>
          <th>Created At</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody id="message-table-body"></tbody>
    </table>
  </div>

  <script>
    // On page load, fetch users and messages
    document.addEventListener('DOMContentLoaded', () => {
      fetchUsers();
      fetchMessages();
    });

    // Fetch all users and display in the table
    function fetchUsers() {
      fetch('admin_fetch_users.php')
        .then(res => res.json())
        .then(data => {
          const userTable = document.getElementById('user-table-body');
          userTable.innerHTML = '';

          data.forEach(user => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${user.id}</td>
              <td>${user.username}</td>
              <td>${user.email}</td>
              <td>${user.role}</td>
              <td><button onclick="deleteUser(${user.id})">Delete</button></td>
            `;
            userTable.appendChild(tr);
          });
        });
    }

    // Fetch all messages and display in the table
    function fetchMessages() {
      fetch('admin_fetch_messages.php')
        .then(res => res.json())
        .then(data => {
          const msgTable = document.getElementById('message-table-body');
          msgTable.innerHTML = '';

          data.forEach(msg => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${msg.id}</td>
              <td>${msg.user_id}</td>
              <td>${msg.content}</td>
              <td>${msg.code}</td>
              <td>${msg.created_at}</td>
              <td><button onclick="deleteMessage(${msg.id})">Delete</button></td>
            `;
            msgTable.appendChild(tr);
          });
        });
    }

    // Delete a user by ID
    function deleteUser(id) {
      if (confirm("Are you sure to delete this user?")) {
        fetch(`admin_delete_user.php?id=${id}`)
          .then(res => res.text())
          .then(() => fetchUsers());
      }
    }

    // Delete a message by ID
    function deleteMessage(id) {
      if (confirm("Are you sure to delete this message?")) {
        fetch(`admin_delete_message.php?id=${id}`)
          .then(res => res.text())
          .then(() => fetchMessages());
      }
    }
  </script>
</body>
</html>
