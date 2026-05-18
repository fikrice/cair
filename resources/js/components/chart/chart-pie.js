export const initStockPieChart = () => {
    const chartElement = document.querySelector('#stockPieChart');

    if (chartElement) {
        const labels = JSON.parse(chartElement.getAttribute('data-labels') || '[]');
        const values = JSON.parse(chartElement.getAttribute('data-values') || '[]');

        const options = {
            series: values,
            chart: {
                fontFamily: "Outfit, sans-serif",
                type: 'donut',
                height: 300,
            },
            labels: labels,
            colors: ["#465FFF", "#9CB9FF", "#31C48D", "#F98080", "#FACA15", "#9061F9"],
            legend: {
                show: false,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '12px',
                                fontWeight: 900,
                                color: '#64748b',
                                offsetY: -10
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 900,
                                color: '#1e293b',
                                offsetY: 10,
                                formatter: function (val) {
                                    return parseInt(val).toLocaleString();
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total Stock',
                                fontSize: '10px',
                                fontWeight: 900,
                                color: '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString();
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false,
            },
            tooltip: {
                enabled: true,
                y: {
                    formatter: function (val) {
                        return val + " Units";
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                }
            }]
        };

        const chart = new ApexCharts(chartElement, options);
        chart.render();
        return chart;
    }
}

export default initStockPieChart;
