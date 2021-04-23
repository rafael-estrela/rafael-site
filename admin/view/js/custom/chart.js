// Area Chart Example
window.onload = function() {
    var ctx = document.getElementById("accessChart");

    $.ajax({
        type: 'GET',
        url: `/rafael-site/api/home/accessChart/`,
        processData: false,
        contentType: false,
        success: function(response) {
            let json = response.data

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: json.lastMonthsLabels,
                    datasets: [{
                        label: "Acessos",
                        lineTension: 0.3,
                        backgroundColor: "rgba(158,169,240, 0.05)",
                        borderColor: "rgba(158,169,240, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(158,169,240, 1)",
                        pointBorderColor: "rgba(158,169,240, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(158,169,240, 1)",
                        pointHoverBorderColor: "rgba(158,169,240, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: json.lastMonthsValues,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return number_format(value);
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                }
            })
        }, error: function(response) {
            let error = response.responseJSON.error

            displayErrorMessage(error)
        }
    })
}
