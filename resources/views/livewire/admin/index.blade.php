<div class="p-4 space-y-4">
    <!-- Summary Section -->
    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Dashboard Summary</h2>
        <div class="flex justify-between mb-2">
            <div class="text-center">
                <h3 class="text-lg font-medium">Total Income</h3>
                <p class="text-xl font-bold text-green-600">{{ number_format($totalIncome, 2) }} Php</p>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium">Number of Users</h3>
                <p class="text-xl font-bold text-blue-600">{{ $numberOfUsers }}</p>

            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium">Assigned Orders</h3>
                <p class="text-xl font-bold text-orange-600">{{ $assignedOrders }}</p>
            </div>
        </div>
    </div>

   
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <canvas id="dailyChart" width="400" height="200"></canvas>
        <canvas id="weeklyChart" width="400" height="200"></canvas>
        <canvas id="monthlyChart" width="400" height="200"></canvas>
        <canvas id="yearlyChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctxDaily = document.getElementById('dailyChart').getContext('2d');
            new Chart(ctxDaily, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($dailySales)),
                    datasets: [{
                        label: 'Daily Income',
                        data: @json(array_values($dailySales)),
                        borderColor: 'rgba(255, 205, 86, 1)',
                        backgroundColor: 'rgba(255, 205, 86, 0.2)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `Income: ${tooltipItem.raw} Php`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Date',
                                color: '#666'
                            }
                        },
                        y: {
                            grid: {
                                borderColor: '#ddd',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return value + ' Php';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Amount (Php)',
                                color: '#666'
                            }
                        }
                    }
                }
            });

            var ctxWeekly = document.getElementById('weeklyChart').getContext('2d');
            new Chart(ctxWeekly, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($weeklySales)),
                    datasets: [{
                        label: 'Weekly Income',
                        data: @json(array_values($weeklySales)),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 1,
                        barThickness: 20
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `Income: ${tooltipItem.raw} Php`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Week',
                                color: '#666'
                            }
                        },
                        y: {
                            grid: {
                                borderColor: '#ddd',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return value + ' Php';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Amount (Php)',
                                color: '#666'
                            }
                        }
                    }
                }
            });

            var ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
            new Chart(ctxMonthly, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($monthlySales)),
                    datasets: [{
                        label: 'Monthly Income',
                        data: @json(array_values($monthlySales)),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        barThickness: 20
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `Income: ${tooltipItem.raw} Php`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Month',
                                color: '#666'
                            }
                        },
                        y: {
                            grid: {
                                borderColor: '#ddd',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return value + ' Php';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Amount (Php)',
                                color: '#666'
                            }
                        }
                    }
                }
            });

            var ctxYearly = document.getElementById('yearlyChart').getContext('2d');
            new Chart(ctxYearly, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($yearlySales)),
                    datasets: [{
                        label: 'Yearly Income',
                        data: @json(array_values($yearlySales)),
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderWidth: 1,
                        barThickness: 20
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `Income: ${tooltipItem.raw} Php`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Year',
                                color: '#666'
                            }
                        },
                        y: {
                            grid: {
                                borderColor: '#ddd',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return value + ' Php';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Amount (Php)',
                                color: '#666'
                            }
                        }
                    }
                }
            });
        });
    </script>
</div>
