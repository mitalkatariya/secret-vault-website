// Handle message form submission (lock a message with secret code)
document.getElementById('msgForm').onsubmit = async e => {
  e.preventDefault(); // Prevent page reload

  const fd = new FormData(e.target); // Get form data

  // Send POST request to create.php with message content and secret code
  const res = await fetch('create.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      code: fd.get('code'),
      content: fd.get('content')
    })
  });

  const result = await res.json();

  // Handle response
  if (result.status === 'ok') {
    alert('Message locked successfully!');
    e.target.reset(); // Clear form
  } else {
    alert('Error locking message: ' + (result.error || 'Unknown error'));
  }
};

// Unlock a message using secret code and redirect to view.html
function unlock() {
  const code = document.getElementById('unlockCode').value.trim(); // Get entered code
  if (!code) {
    alert("Please enter your secret code");
    return;
  }

  const encoded = encodeURIComponent(code); // Encode the code for URL safety
  window.location.href = `view.html?code=${encoded}`; // Redirect with code
}

// Delete a message by ID
async function deleteMessage(id) {
  const sure = confirm("Are you sure you want to delete this message?");
  if (!sure) return;

  const res = await fetch('delete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id }) // Send ID of message to delete
  });

  const result = await res.json();
  if (result.deleted) {
    alert("Message deleted successfully!");
    location.reload(); // Refresh the page to show updated list
  } else {
    alert("Delete failed: " + (result.reason || 'Unknown error'));
  }
}

// Update message content using secret code
async function updateMessage(code) {
  const newContent = prompt("Enter new message content:");
  if (!newContent) return;

  const res = await fetch('update.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ code, content: newContent }) // Send new content and code
  });

  const result = await res.json();
  if (result.status === 'success') {
    alert("Message updated successfully!");
    location.reload(); // Refresh the page
  } else {
    alert("Update failed: " + (result.message || 'Unknown error'));
  }
}

// Logout the user and redirect to logout.php
function logout() {
  alert("You have been logged out successfully.");
  window.location = 'logout.php';
}
