document.addEventListener("DOMContentLoaded", () => {
  const accounts = JSON.parse(localStorage.getItem("accounts")) || [];
  const transactions = JSON.parse(localStorage.getItem("transactions")) || [];

  const accountForm = document.getElementById("account-form");
  const transactionForm = document.getElementById("transaction-form");
  const transferForm = document.getElementById("transfer-form");

  function saveData() {
    localStorage.setItem("accounts", JSON.stringify(accounts));
    localStorage.setItem("transactions", JSON.stringify(transactions));
    renderAccounts();
    renderTransactions();
  }

  function renderAccounts() {
    const accountSelects = [document.getElementById("transaction-account"), document.getElementById("transfer-from"), document.getElementById("transfer-to")];
    const list = document.getElementById("accounts-list");
    list.innerHTML = "";
    accountSelects.forEach(sel => sel.innerHTML = "");

    accounts.forEach(account => {
      const li = document.createElement("li");
      li.className = "list-group-item d-flex justify-content-between";
      li.innerHTML = `<strong>${account.name}</strong> <span>${account.balance.toFixed(2)} €</span>`;
      list.appendChild(li);

      accountSelects.forEach(sel => {
        const opt = document.createElement("option");
        opt.value = account.id;
        opt.textContent = account.name;
        sel.appendChild(opt);
      });
    });
  }

  function renderTransactions() {
    const tbody = document.getElementById("transactions-table");
    tbody.innerHTML = "";
    transactions.forEach(tx => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${tx.date}</td>
        <td>${tx.type}</td>
        <td>${tx.amount.toFixed(2)} €</td>
        <td>${tx.accountName}</td>
        <td>${tx.label}</td>`;
      tbody.appendChild(row);
    });
  }

  accountForm.addEventListener("submit", e => {
    e.preventDefault();
    const name = document.getElementById("account-name").value;
    const balance = parseFloat(document.getElementById("account-balance").value);
    accounts.push({ id: Date.now(), name, balance });
    saveData();
    accountForm.reset();
  });

  transactionForm.addEventListener("submit", e => {
    e.preventDefault();
    const type = document.getElementById("transaction-type").value;
    const amount = parseFloat(document.getElementById("transaction-amount").value);
    const accountId = parseInt(document.getElementById("transaction-account").value);
    const label = document.getElementById("transaction-label").value || "";
    const account = accounts.find(a => a.id === accountId);

    if (type === "revenu") account.balance += amount;
    else account.balance -= amount;

    transactions.push({
      id: Date.now(),
      type,
      amount,
      label,
      accountId,
      accountName: account.name,
      date: new Date().toLocaleDateString()
    });

    saveData();
    transactionForm.reset();
  });

  transferForm.addEventListener("submit", e => {
    e.preventDefault();
    const fromId = parseInt(document.getElementById("transfer-from").value);
    const toId = parseInt(document.getElementById("transfer-to").value);
    const amount = parseFloat(document.getElementById("transfer-amount").value);
    if (fromId === toId || isNaN(amount)) return;

    const fromAccount = accounts.find(a => a.id === fromId);
    const toAccount = accounts.find(a => a.id === toId);

    fromAccount.balance -= amount;
    toAccount.balance += amount;

    transactions.push({
      id: Date.now(),
      type: "virement",
      amount,
      label: `Virement de ${fromAccount.name} à ${toAccount.name}`,
      accountId: fromId,
      accountName: fromAccount.name,
      date: new Date().toLocaleDateString()
    });

    saveData();
    transferForm.reset();
  });

  renderAccounts();
  renderTransactions();
});
