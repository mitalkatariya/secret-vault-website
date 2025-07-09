<?php
// Start session and verify admin login
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
  
  <!-- Link to main stylesheet -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- Main Dashboard Container -->
  <div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Table: Registered Users -->
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

    <!-- Table: All Messages -->
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

    <!-- Table: Contact Messages -->
    <h3>Contact Messages</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody id="contact-table-body"></tbody>
    </table>
  </div>

  <!-- Admin Dashboard JavaScript -->
  <script>
    // Load all data when page finishes loading
    document.addEventListener('DOMContentLoaded', () => {
      fetchUsers();
      fetchMessages();
      fetchContacts();
    });

    // Fetch all registered users
    function fetchUsers() {
      fetch('admin_fetch_users.php')
        .then(res => res.json())
        .then(data => {
          const table = document.getElementById('user-table-body');
          table.innerHTML = '';
          data.forEach(user => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${user.id}</td>
              <td>${user.username}</td>
              <td>${user.email}</td>
              <td>${user.role}</td>
              <td><button onclick="deleteUser(${user.id})">Delete</button></td>
            `;
            table.appendChild(tr);
          });
        });
    }

    // Fetch all messages
    function fetchMessages() {
      fetch('admin_fetch_messages.php')
        .then(res => res.json())
        .then(data => {
          const table = document.getElementById('message-table-body');
          table.innerHTML = '';
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
            table.appendChild(tr);
          });
        });
    }

    // Fetch all contact messages
    function fetchContacts() {
      fetch('admin_fetch_contacts.php')
        .then(res => res.json())
        .then(data => {
          const table = document.getElementById('contact-table-body');
          table.innerHTML = '';
          data.forEach(contact => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${contact.id}</td>
              <td>${contact.name}</td>
              <td>${contact.email}</td>
              <td>${contact.message}</td>
              <td><button onclick="deleteContact(${contact.id})">Delete</button></td>
            `;
            table.appendChild(tr);
          });
        });
    }

    // Delete a user by ID
    function deleteUser(id) {
      if (confirm("Are you sure to delete this user?")) {
        fetch(`admin_delete_user.php?id=${id}`)
          .then(() => fetchUsers()); // Reload user table
      }
    }

    // Delete a message by ID
    function deleteMessage(id) {
      if (confirm("Are you sure to delete this message?")) {
        fetch(`admin_delete_message.php?id=${id}`)
          .then(() => fetchMessages()); // Reload message table
      }
    }

    // Delete a contact message by ID
    function deleteContact(id) {
      if (confirm("Are you sure to delete this contact message?")) {
        fetch(`admin_delete_contact.php?id=${id}`)
          .then(() => fetchContacts()); // Reload contact table
      }
    }
  </script>

</body>
</html>
