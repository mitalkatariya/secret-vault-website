let msgs = [];

async function fetchExpired() {
  let res = await fetch('fetch_expired.php');
  msgs = await res.json();
  render();
}

function render() {
  const tbody = document.querySelector('#msgs tbody');
  const search = document.getElementById('searchBox').value.toLowerCase();
  tbody.innerHTML = '';

  msgs.forEach(m => {
    if (!m.content.toLowerCase().includes(search)) return;

    const expDate = new Date(m.expiry).toLocaleString();
    const viewedText = m.viewed ? 'Viewed' : 'Not Viewed';

    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${m.content}</td>
      <td>${expDate}</td>
      <td>${viewedText}</td>
    `;
    tbody.appendChild(tr);
  });
}

document.getElementById('searchBox').addEventListener('input', render);
fetchExpired();
