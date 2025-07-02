<?php
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
    <h1>👨‍💼 Admin Dashboard</h1>

    <!-- Registered Users -->
    <h3>📋 Registered Users</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>🗑 Delete</th>
        </tr>
      </thead>
      <tbody id="user-table-body"></tbody>
    </table>

    <!-- All Messages -->
    <h3>✉ All Messages</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>User ID</th>
          <th>Content</th>
          <th>Code</th>
          <th>Created At</th>
          <th>🗑 Delete</th>
        </tr>
      </thead>
      <tbody id="message-table-body"></tbody>
    </table>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      fetchUsers();
      fetchMessages();
    });

    // ✅ Fetch Users
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
              <td><button onclick="deleteUser(${user.id})">🗑️</button></td>
            `;
            userTable.appendChild(tr);
          });
        });
    }

    // ✅ Fetch Messages
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
              <td><button onclick="deleteMessage(${msg.id})">🗑️</button></td>
            `;
            msgTable.appendChild(tr);
          });
        });
    }

    // ✅ Delete User
    function deleteUser(id) {
      if (confirm("Are you sure to delete this user?")) {
        fetch(`admin_delete_user.php?id=${id}`)
          .then(res => res.text())
          .then(() => fetchUsers());
      }
    }

    // ✅ Delete Message
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
