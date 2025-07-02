
document.getElementById('msgForm').onsubmit = async e => {
  e.preventDefault();
  const fd = new FormData(e.target);

  const res = await fetch('create.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      code: fd.get('code'),
      content: fd.get('content')
    })
  });

  const result = await res.json();

  if (result.status === 'ok') {
    alert('✅ Message locked successfully!');
    e.target.reset();
  } else {
    alert('❌ Error locking message: ' + (result.error || 'Unknown error'));
  }
};

// 🔓 Unlock function using URL encoding
function unlock() {
  const code = document.getElementById('unlockCode').value.trim();
  if (!code) {
    alert("❌ Please enter your secret code");
    return;
  }
  const encoded = encodeURIComponent(code);
  window.location.href = `view.html?code=${encoded}`;
}

// 🗑️ Delete Message
async function deleteMessage(id) {
  const sure = confirm("❌ Are you sure you want to delete this message?");
  if (!sure) return;

  const res = await fetch('delete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  });

  const result = await res.json();
  if (result.deleted) {
    alert("✅ Message deleted successfully!");
    location.reload();
  } else {
    alert("❌ Delete failed: " + (result.reason || 'Unknown error'));
  }
}

// 📝 Update Message
async function updateMessage(code) {
  const newContent = prompt("✏️ Enter new message content:");
  if (!newContent) return;

  const res = await fetch('update.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ code, content: newContent })
  });

  const result = await res.json();
  if (result.status === 'success') {
    alert("✅ Message updated successfully!");
    location.reload();
  } else {
    alert("❌ Update failed: " + (result.message || 'Unknown error'));
  }
}

// 🔌 Logout
function logout() {
  alert("👋 You have been logged out successfully.");
  window.location = 'logout.php';
}
