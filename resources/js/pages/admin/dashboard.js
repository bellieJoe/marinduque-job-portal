import $ from "jquery";
const { Chart, registerables } = require("chart.js");
Chart.register(...registerables);

const Utils = {
    months : ["January","February","March","April","May","June","July","August","September","October","November","December"]
}


const lmiCharts = async () => {

    document.getElementById("inputYear").value = new Date().getFullYear()

    async function getLMI(year){
        var sortedLMI = {
            jobsSolicitedTotal: [],
            jobsSolicitedLocal: [],
            jobsSolicitedOverseas: [],
            applicantsReferredTotal: [],
            applicantsReferredMale: [],
            applicantsReferredFemale: [],
            applicantsPlacedTotal: [],
            applicantsPlacedMale: [],
            applicantsPlacedFemale: []
        };

        try {
            const lmiData = await $.ajax({
                url: `/admin/reports/lmi-data/${year}`,
                method: 'GET'
            })

            lmiData.forEach(el => {
                if(el){
                    sortedLMI.jobsSolicitedTotal.push(el.jobs_solicited_total)
                    sortedLMI.jobsSolicitedLocal.push(el.jobs_solicited_local)
                    sortedLMI.jobsSolicitedOverseas.push(el.jobs_solicited_overseas)
                    sortedLMI.applicantsReferredTotal.push(el.applicants_referred_total)
                    sortedLMI.applicantsReferredMale.push(el.applicants_referred_male)
                    sortedLMI.applicantsReferredFemale.push(el.applicants_referred_female)
                    sortedLMI.applicantsPlacedTotal.push(el.applicants_placed_total)
                    sortedLMI.applicantsPlacedMale.push(el.applicants_placed_male)
                    sortedLMI.applicantsPlacedFemale.push(el.applicants_placed_female)
                }
                else{
                    sortedLMI.jobsSolicitedTotal.push(0)
                    sortedLMI.jobsSolicitedLocal.push(0)
                    sortedLMI.jobsSolicitedOverseas.push(0)
                    sortedLMI.applicantsReferredTotal.push(0)
                    sortedLMI.applicantsReferredMale.push(0)
                    sortedLMI.applicantsReferredFemale.push(0)
                    sortedLMI.applicantsPlacedTotal.push(0)
                    sortedLMI.applicantsPlacedMale.push(0)
                    sortedLMI.applicantsPlacedFemale.push(0)
                }
            })

        } catch (error) {
            console.log(error)
            alert(error)
            return [];
        }

        return sortedLMI;
    }

    let lmiData = await getLMI(new Date().getFullYear())

    const solicitedJobsData = {
        labels: Utils.months,
        datasets: [
            {
                label: 'Local',
                data: lmiData.jobsSolicitedLocal,
                backgroundColor: "rgb(56, 156, 71)",
            },
            {
                label: 'Overseas',
                data: lmiData.jobsSolicitedOverseas,
                backgroundColor: "rgb(217, 59, 74)"
            },
            {
                label: 'Total',
                data: lmiData.jobsSolicitedTotal,
                backgroundColor: "rgb(255, 216, 107)"
            }
        ]
    };
    const applicantsRefered = {
        labels: Utils.months,
        datasets: [
            {
                label: 'Female',
                data: lmiData.applicantsReferredFemale,
                backgroundColor: "rgb(255, 112, 253)",
            },
            {
                label: 'Male',
                data: lmiData.applicantsReferredMale,
                backgroundColor: "rgb(62, 68, 247)"
            },
            {
                label: 'Total',
                data: lmiData.applicantsReferredTotal,
                backgroundColor: "rgb(121, 32, 245)"
            }
        ]
    };
    const applicantsPlaced = {
        labels: Utils.months,
        datasets: [
            {
                label: 'Female',
                data: lmiData.applicantsPlacedFemale,
                backgroundColor: "rgb(255, 112, 253)",
            },
            {
                label: 'Male',
                data: lmiData.applicantsPlacedMale,
                backgroundColor: "rgb(62, 68, 247)"
            },
            {
                label: 'Total',
                data: lmiData.applicantsPlacedTotal,
                backgroundColor: "rgb(121, 32, 245)"
            }
        ]
    };

    let delayed;
    const solicitedChart = new Chart(
         document.getElementById("lmiJobSolicited").getContext("2d"), 
         {
            type: 'bar',
            data: solicitedJobsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    onComplete: () => {
                    delayed = true;
                    },
                    delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                    },
                },
                scales: {
                    y: {
                      beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                    position: 'top',
                    },
                    title: {
                    display: true,
                    text: 'Solicited Jobs'
                    }
                }
            },
        }
    );
    const referedChart = new Chart(
         document.getElementById("lmiApplicantRefered").getContext("2d"), 
         {
            type: 'bar',
            data: applicantsRefered,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    onComplete: () => {
                    delayed = true;
                    },
                    delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                    },
                },
                scales: {
                    y: {
                      beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                    position: 'top',
                    },
                    title: {
                    display: true,
                    text: 'Refered Applicants'
                    }
                }
            },
        }
    );
    const placedChart = new Chart(
         document.getElementById("lmiApplicantPlaced").getContext("2d"), 
         {
            type: 'bar',
            data: applicantsPlaced,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    onComplete: () => {
                    delayed = true;
                    },
                    delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                    },
                },
                scales: {
                    y: {
                      beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                    position: 'top',
                    },
                    title: {
                    display: true,
                    text: 'Placed Applicants'
                    }
                }
            },
        }
    );

    document.getElementById("btnYear").addEventListener('click', async(ev) => {
        const year = document.getElementById("inputYear").value
        lmiData = await getLMI(year)
        solicitedChart.data.datasets[0].data = lmiData.jobsSolicitedLocal
        solicitedChart.data.datasets[1].data = lmiData.jobsSolicitedOverseas
        solicitedChart.data.datasets[2].data = lmiData.jobsSolicitedTotal
        solicitedChart.update()

        placedChart.data.datasets[0].data = lmiData.applicantsPlacedFemale
        placedChart.data.datasets[1].data = lmiData.applicantsPlacedMale
        placedChart.data.datasets[2].data = lmiData.applicantsPlacedTotals
        placedChart.update()

        referedChart.data.datasets[0].data = lmiData.applicantsReferredFemale
        referedChart.data.datasets[1].data = lmiData.applicantsReferredMale
        referedChart.data.datasets[2].data = lmiData.applicantsReferredTotal
        referedChart.update()
        console.log(lmiData)
    })
}
lmiCharts()


