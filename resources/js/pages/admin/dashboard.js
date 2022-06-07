import $ from "jquery";

const { Chart, registerables } = require("chart.js");
Chart.register(...registerables);

const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

const lmiJobsSolicitedChart = async () => {

    const ctx = document.getElementById("lmiJobSolicited").getContext("2d");
    const labels = months;

    const lmiData = await (async function(){
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
                url: `/admin/reports/lmi-data/${new Date().getFullYear()}`,
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
    })();

    console.log(lmiData)

    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Local',
                data: lmiData.jobsSolicitedLocal,
                backgroundColor: "rgb(56, 156, 71)",
                // borderColor
            },
            {
                label: 'Overseas',
                data: lmiData.jobsSolicitedOverseas,
                backgroundColor: "rgb(217, 59, 74)"
            },
            {
                label: 'Total',
                data: lmiData.jobsSolicitedTotal,
                backgroundColor: "rgb(207, 190, 37)"
            }
        ]
    };
    const config = {
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        },
    };

    const chart = new Chart(ctx, config);
}
lmiJobsSolicitedChart()

