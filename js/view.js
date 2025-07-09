// Get the secret code from the URL parameter
const urlParams = new URLSearchParams(window.location.search);
const secretCode = urlParams.get('code') || '';
const messageList = document.getElementById('messageList');

// Fetch messages from the server and display them
async function fetchMsgs() {
  const res = await fetch('fetch.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ code: secretCode }) // Send the secret code to fetch related messages
  });

  const msgs = await res.json();
  messageList.innerHTML = ''; // Clear any previous messages

  // If no messages found, show a message
  if (!msgs.length) {
    messageList.innerHTML = `<tr><td colspan="5" style="text-align:center;color:red;">No message found for this code.</td></tr>`;
    return;
  }

  // Loop through each message and create a table row
  msgs.forEach(msg => {
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td>${msg.content}</td>
      <td>${new Date(msg.created_at).toLocaleString()}</td>
      <td>
        <button class="download-btn" onclick="downloadText('${msg.content}', 'message.txt')" title="Download">
          <span class="material-icons">download</span>
        </button>
      </td>
      <td>
        <button class="delete-btn" onclick="deleteMsg(${msg.id})" title="Delete">
          <span class="material-icons">delete</span>
        </button>
      </td>
      <td>
        <button class="update-btn" onclick="updateMsg(${msg.id}, \`${msg.content}\`)" title="Update">
          <span class="material-icons">edit</span>
        </button>
      </td>
    `;

    messageList.appendChild(tr); // Add the row to the table body
  });
}

// Download message content as a .txt file
function downloadText(content, filename) {
  const blob = new Blob([content], { type: 'text/plain' });
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob); // Create temporary URL for the file
  a.download = filename;
  a.click(); // Trigger download
}

// Delete a specific message by ID
async function deleteMsg(id) {
  if (!confirm("Are you sure you want to delete this message?")) return;

  const res = await fetch('delete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id }) // Send the message ID
  });

  const result = await res.json();

  if (result.success) {
    alert("Message deleted");
    fetchMsgs(); // Reload message list
  } else {
    alert("Failed to delete message");
  }
}

// Update an existing message
function updateMsg(id, current) {
  const newMsg = prompt("Update your message:", current); // Prompt for new message content
  if (!newMsg || newMsg === current) return;

  fetch('update.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id, content: newMsg }) // Send updated content
  })
  .then(res => res.json())
  .then(result => {
    if (result.success) {
      alert("Message updated");
      fetchMsgs(); // Reload message list
    } else {
      alert("Update failed");
    }
  });
}

// Redirect the user back to dashboard
function goBack() {
  window.location.href = 'dashboard.php';
}

// Load messages initially when the page opens
fetchMsgs();
