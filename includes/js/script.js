document.addEventListener("DOMContentLoaded", () => {
  let accounts = JSON.parse(localStorage.getItem("accounts")) || [];
  let transactions = JSON.parse(localStorage.getItem("transactions")) || [];

  const accountForm = document.getElementById("account-form");
  const transactionForm = document.getElementById("transaction-form");
  const transferForm = document.getElementById("transfer-form");
  const filterAccount = document.getElementById("filter-account");
  const filterType = document.getElementById("filter-type");
  const clearFiltersBtn = document.getElementById("clear-filters");

  function saveData() {
    localStorage.setItem("accounts", JSON.stringify(accounts));
    localStorage.setItem("transactions", JSON.stringify(transactions));
    renderAccounts();
    renderTransactions();
  }

  function renderAccounts() {
    const selects = [
      document.getElementById("transaction-account"),
      document.getElementById("transfer-from"),
      document.getElementById("transfer-to"),
      document.getElementById("filter-account")
    ].filter(Boolean);

    const list = document.getElementById("accounts-list");
    if (list) list.innerHTML = "";
    selects.forEach(sel => sel.innerHTML = sel.id === "filter-account" ? "<option value=''>Tous les comptes</option>" : "");

    accounts.forEach(account => {
      if (list) {
        const li = document.createElement("li");
        li.className = "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `
          <span><strong class="account-name" data-id="${account.id}">${account.name}</strong> - ${account.balance.toFixed(2)} €</span>
          <button class="btn btn-sm btn-outline-secondary btn-edit" data-id="${account.id}">Modifier</button>`;
        list.appendChild(li);
      }

      selects.forEach(sel => {
        const opt = document.createElement("option");
        opt.value = account.id;
        opt.textContent = account.name;
        sel.appendChild(opt);
      });
    });

    // Gestion du clic sur les boutons "Modifier"
    document.querySelectorAll(".btn-edit").forEach(button => {
      button.addEventListener("click", () => {
        const id = parseInt(button.dataset.id);
        const nameEl = document.querySelector(`.account-name[data-id="${id}"]`);
        const currentName = nameEl.textContent;
        const input = document.createElement("input");
        input.type = "text";
        input.value = currentName;
        input.className = "form-control form-control-sm d-inline w-auto";
        nameEl.replaceWith(input);
        button.textContent = "Valider";
        button.classList.remove("btn-outline-secondary");
        button.classList.add("btn-success");

        button.addEventListener("click", () => {
          const newName = input.value.trim();
          const account = accounts.find(a => a.id === id);
          if (account && newName) {
            account.name = newName;
            transactions.forEach(tx => {
              if (tx.accountId === id) tx.accountName = newName;
            });
            saveData();
          }
        }, { once: true });
      });
    });
  }

  function renderTransactions() {
    const tbody = document.getElementById("transactions-table");
    tbody.innerHTML = "";

    const selectedAccount = filterAccount?.value;
    const selectedType = filterType?.value;

    const filtered = transactions.filter(tx => {
      const accountMatch = !selectedAccount || tx.accountId == selectedAccount;
      const typeMatch = !selectedType || tx.type === selectedType;
      return accountMatch && typeMatch;
    });

    filtered.forEach(tx => {
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

  accountForm?.addEventListener("submit", e => {
    e.preventDefault();
    const name = document.getElementById("account-name").value;
    const balance = parseFloat(document.getElementById("account-balance").value.replace(",", "."));
    accounts.push({ id: Date.now(), name, balance });
    saveData();
    accountForm.reset();
  });

  transactionForm?.addEventListener("submit", e => {
    e.preventDefault();
    const type = document.getElementById("transaction-type").value;
    const amount = parseFloat(document.getElementById("transaction-amount").value.replace(",", "."));
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
      date: document.getElementById('transfer-date').value || new Date().toLocaleDateString()
    });

    saveData();
    transactionForm.reset();
  });

  transferForm?.addEventListener("submit", e => {
    e.preventDefault();
    const fromId = parseInt(document.getElementById("transfer-from").value);
    const toId = parseInt(document.getElementById("transfer-to").value);
    const amount = parseFloat(document.getElementById("transfer-amount").value.replace(",", "."));
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
      date: document.getElementById('transfer-date').value || new Date().toLocaleDateString()
    });

    saveData();
    transferForm.reset();
  });

  filterAccount?.addEventListener("change", renderTransactions);
  filterType?.addEventListener("change", renderTransactions);
  clearFiltersBtn?.addEventListener("click", () => {
    filterAccount.value = "";
    filterType.value = "";
    renderTransactions();
  });

  renderAccounts();
  renderTransactions();
});
