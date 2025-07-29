
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("categoryChart").getContext("2d");
    const rawData = window.chartData || [];
    let currentView = "category";

    const backgroundColors = [
        "#36a2eb", "#ff6384", "#ffcd56", "#4bc0c0", "#9966ff", "#ff9f40", "#c9cbcf"
    ];

    let currentCategory = null;
    let myChart;

    function getCategoryData() {
        return {
            labels: rawData.map(d => d.category),
            datasets: [{
                data: rawData.map(d => d.total),
                backgroundColor: backgroundColors,
            }]
        };
    }

    function getSubcategoryData(categoryName) {
        const category = rawData.find(d => d.category === categoryName);
        const subcategories = category ? category.subcategories : {};

        return {
            labels: Object.keys(subcategories),
            datasets: [{
                data: Object.values(subcategories),
                backgroundColor: backgroundColors,
            }]
        };
    }

    function renderChart(data, title) {
        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: "doughnut",
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: title
                    },
                    legend: {
                        position: "bottom"
                    }
                },
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        if (currentView === "category") {
                            currentCategory = data.labels[index];
                            const subcatData = getSubcategoryData(currentCategory);
                            currentView = "subcategory";
                            renderChart(subcatData, "Répartition par sous-catégorie : " + currentCategory);
                        } else {
                            currentView = "category";
                            renderChart(getCategoryData(), "Répartition par catégorie");
                        }
                    }
                }
            }
        });
    }

    renderChart(getCategoryData(), "Répartition par catégorie");
});
