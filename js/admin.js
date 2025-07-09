// Load all users from the server and display them in the user table
async function loadUsers() {
  const res = await fetch('admin_fetch_users.php'); // Fetch user data from PHP
  const users = await res.json(); // Convert response to JSON
  const tbody = document.querySelector('#userTable tbody'); // Select tbody inside userTable
  tbody.innerHTML = ''; // Clear previous table content

  // Loop through all users and create table rows
  users.forEach(user => {
    tbody.innerHTML += `
      <tr>
        <td>${user.id}</td>
        <td>${user.username}</td>
        <td>${user.email}</td>
        <td>${user.role}</td>
        <td>
          <button onclick="deleteUser(${user.id})">Delete</button>
        </td>
      </tr>
    `;
  });
}

// Load all messages from the server and display them in the message table
async function loadMessages() {
  const res = await fetch('admin_fetch_messages.php'); // Fetch message data from PHP
  const messages = await res.json(); // Convert response to JSON
  const tbody = document.querySelector('#messageTable tbody'); // Select tbody inside messageTable
  tbody.innerHTML = ''; // Clear previous table content

  // Loop through all messages and create table rows
  messages.forEach(msg => {
    tbody.innerHTML += `
      <tr>
        <td>${msg.id}</td>
        <td>${msg.user_id}</td>
        <td>${msg.content}</td>
        <td>${msg.code}</td>
        <td>${msg.created_at}</td>
        <td>
          <button onclick="deleteMessage(${msg.id})">Delete</button>
        </td>
      </tr>
    `;
  });
}

// Delete a user by ID
async function deleteUser(id) {
  // Confirm before deleting
  if (confirm('Are you sure you want to delete this user?')) {
    await fetch('admin_fetch_users.php', {
      method: 'POST',
      body: JSON.stringify({ id }) // Send user ID to delete
    });
    loadUsers(); // Reload the user table after deletion
  }
}

// Delete a message by ID
async function deleteMessage(id) {
  // Confirm before deleting
  if (confirm('Are you sure you want to delete this message?')) {
    await fetch('admin_fetch_messages.php', {
      method: 'POST',
      body: JSON.stringify({ id }) // Send message ID to delete
    });
    loadMessages(); // Reload the message table after deletion
  }
}

// Run both load functions on initial page load
loadUsers();
loadMessages();
