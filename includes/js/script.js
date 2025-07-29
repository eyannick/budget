document.addEventListener("DOMContentLoaded", function () {
  const categorySelect = document.getElementById("category_id");
  const subcategorySelect = document.getElementById("subcategory_id");

  if (categorySelect && subcategorySelect && window.allSubcategories) {
    categorySelect.addEventListener("change", function () {
      const selectedCatId = categorySelect.value;
      subcategorySelect.innerHTML = '<option value="">-- Sélectionner une sous-catégorie --</option>';

      window.allSubcategories.forEach(function (sub) {
        if (sub.category_id === selectedCatId) {
          const option = document.createElement("option");
          option.value = sub.id;
          option.textContent = sub.name;
          subcategorySelect.appendChild(option);
        }
      });
    });
  }

  const transactionTypeSelect = document.getElementById("transaction_type");
  const targetAccountGroup = document.getElementById("target_account_group");

  if (transactionTypeSelect && targetAccountGroup) {
    transactionTypeSelect.addEventListener("change", function () {
      targetAccountGroup.style.display = (this.value === "virement") ? "block" : "none";
    });
  }
});
