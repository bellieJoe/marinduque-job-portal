const { Chart, registerables } = require("chart.js");
Chart.register(...registerables);


const UserDistChart = () => {
    const ctx = document.getElementById("userDistChart").getContext("2d");
    const myChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Employer", "Job Seeeker"],
            datasets: [
                {
                    data: [12, 19],
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(54, 162, 235)"
                    ],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: "Number of Users"
                },
                legend: {
                    position: 'bottom',
                  },
            }
        },
    });
}
UserDistChart();

const userTimelineChart = () => {
    const ctx = document.getElementById("userTimelineChart").getContext("2d");
    const DATA_COUNT = 7;
    const NUMBER_CFG = { count: DATA_COUNT, min: -100, max: 100 };

    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']
    const data = {
        labels: labels,
        datasets: [
            {
                label: "Employer",
                data: [100, 200, 300, 400, 450, 500, 600, 650, 680, 700, 600, 10000],
                borderColor: 'rgba(245, 40, 145, 1)',
                backgroundColor: 'rgba(245, 40, 145, 0.45)',
                pointStyle: 'circle',
                pointRadius: 5,
                pointHoverRadius: 10,
                // fill: true,
                tension: 0.4,
                borderWidth: 1
            },
            {
                label: "Job Seeker",
                data: [450, 450, 250, 450, 500, 600, 768, 800, 924, 800, 857, 870],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.45)',
                pointStyle: 'circle',
                pointRadius: 5,
                pointHoverRadius: 10,
                // fill: true,
                tension: 0.4,
                borderWidth: 1
            }
        ],
    };
    const config = {
        type: "line",
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Users Registered by 2022",
                },
            },
        },
    };
    const chart = new Chart(ctx, config);

};
userTimelineChart();
