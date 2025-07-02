// Users Load
async function loadUsers() {
  const res = await fetch('admin_fetch_users.php');
  const users = await res.json();
  const tbody = document.querySelector('#userTable tbody');
  tbody.innerHTML = '';
  users.forEach(user => {
    tbody.innerHTML += `
      <tr>
        <td>${user.id}</td>
        <td>${user.username}</td>
        <td>${user.email}</td>
        <td>${user.role}</td>
        <td><button onclick="deleteUser(${user.id})">Delete</button></td>
      </tr>
    `;
  });
}

// Messages Load
async function loadMessages() {
  const res = await fetch('admin_fetch_messages.php');
  const messages = await res.json();
  const tbody = document.querySelector('#messageTable tbody');
  tbody.innerHTML = '';
  messages.forEach(msg => {
    tbody.innerHTML += `
      <tr>
        <td>${msg.id}</td>
        <td>${msg.user_id}</td>
        <td>${msg.content}</td>
        <td>${msg.code}</td>
        <td>${msg.created_at}</td>
        <td><button onclick="deleteMessage(${msg.id})">Delete</button></td>
      </tr>
    `;
  });
}

async function deleteUser(id) {
  if (confirm('Are you sure you want to delete this user?')) {
    await fetch('admin_fetch_users.php', {
      method: 'POST',
      body: JSON.stringify({ id })
    });
    loadUsers();
  }
}

async function deleteMessage(id) {
  if (confirm('Are you sure you want to delete this message?')) {
    await fetch('admin_fetch_messages.php', {
      method: 'POST',
      body: JSON.stringify({ id })
    });
    loadMessages();
  }
}

loadUsers();
loadMessages();


