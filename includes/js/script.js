document.addEventListener("DOMContentLoaded", function () {
  const categorySelect = document.getElementById("category_id");
  const subcategorySelect = document.getElementById("subcategory_id");
  const transactionType = document.getElementById("transaction_type");
  const targetGroup = document.getElementById("target_account_group");

  // Gérer affichage du champ compte cible (virement)
  if (transactionType && targetGroup) {
    transactionType.addEventListener("change", () => {
      targetGroup.style.display = transactionType.value === "virement" ? "block" : "none";
    });
  }

  // Gérer affichage des sous-catégories selon la catégorie
  if (categorySelect && subcategorySelect && window.allSubcategories) {
    categorySelect.addEventListener("change", () => {
      const selectedCategoryId = categorySelect.value;
      subcategorySelect.innerHTML = '<option value="">-- Sélectionner une sous-catégorie --</option>';

      window.allSubcategories.forEach(subcat => {
        if (subcat.category_id == selectedCategoryId) {
          const opt = document.createElement("option");
          opt.value = subcat.id;
          opt.textContent = subcat.name;
          subcategorySelect.appendChild(opt);
        }
      });
    });
  }
});
