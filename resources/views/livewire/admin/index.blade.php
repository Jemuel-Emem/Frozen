<div class="p-4 space-y-4" x-data="dashboardCharts()" x-init="init()">
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

    <!-- Tabs -->
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <div class="flex justify-center mb-4 space-x-4">
            <button @click="tab = 'daily'" :class="tab === 'daily' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-700'" class="px-4 py-2 rounded">Daily</button>
            <button @click="tab = 'weekly'" :class="tab === 'weekly' ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'" class="px-4 py-2 rounded">Weekly</button>
            <button @click="tab = 'monthly'" :class="tab === 'monthly' ? 'bg-teal-500 text-white' : 'bg-white text-gray-700'" class="px-4 py-2 rounded">Monthly</button>
            <button @click="tab = 'yearly'" :class="tab === 'yearly' ? 'bg-orange-500 text-white' : 'bg-white text-gray-700'" class="px-4 py-2 rounded">Yearly</button>
        </div>

        <!-- Charts -->
        <div x-show="tab === 'daily'" class="w-full">
            <canvas id="dailyChart" height="200"></canvas>
        </div>
        <div x-show="tab === 'weekly'" class="w-full">
            <canvas id="weeklyChart" height="200"></canvas>
        </div>
        <div x-show="tab === 'monthly'" class="w-full">
            <canvas id="monthlyChart" height="200"></canvas>
        </div>
        <div x-show="tab === 'yearly'" class="w-full">
            <canvas id="yearlyChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Alpine Component -->
<script>
    function dashboardCharts() {
        return {
            tab: 'daily',
            chartRefs: {
                daily: null,
                weekly: null,
                monthly: null,
                yearly: null
            },
            init() {
                this.renderChart('daily'); // First chart visible
                this.$watch('tab', value => {
                    if (!this.chartRefs[value]) {
                        this.renderChart(value);
                    }
                });
            },
            renderChart(type) {
                const ctx = document.getElementById(`${type}Chart`).getContext('2d');
                let chartData = {};
                let label = '';
                let borderColor = '';
                let backgroundColor = '';

                switch(type) {
                    case 'daily':
                        chartData = {
                            labels: @json(array_keys($dailySales)),
                            data: @json(array_values($dailySales))
                        };
                        label = 'Daily Income';
                        borderColor = 'rgba(255, 205, 86, 1)';
                        backgroundColor = 'rgba(255, 205, 86, 0.2)';
                        break;
                    case 'weekly':
                        chartData = {
                            labels: @json(array_keys($weeklySales)),
                            data: @json(array_values($weeklySales))
                        };
                        label = 'Weekly Income';
                        borderColor = 'rgba(54, 162, 235, 1)';
                        backgroundColor = 'rgba(54, 162, 235, 0.2)';
                        break;
                    case 'monthly':
                        chartData = {
                            labels: @json(array_keys($monthlySales)),
                            data: @json(array_values($monthlySales))
                        };
                        label = 'Monthly Income';
                        borderColor = 'rgba(75, 192, 192, 1)';
                        backgroundColor = 'rgba(75, 192, 192, 0.2)';
                        break;
                    case 'yearly':
                        chartData = {
                            labels: @json(array_keys($yearlySales)),
                            data: @json(array_values($yearlySales))
                        };
                        label = 'Yearly Income';
                        borderColor = 'rgba(255, 159, 64, 1)';
                        backgroundColor = 'rgba(255, 159, 64, 0.2)';
                        break;
                }

                this.chartRefs[type] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: label,
                            data: chartData.data,
                            borderColor: borderColor,
                            backgroundColor: backgroundColor,
                            borderWidth: 2,
                            barThickness: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: true, position: 'top' },
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
                                grid: { display: false },
                                title: {
                                    display: true,
                                    text: type.charAt(0).toUpperCase() + type.slice(1),
                                    color: '#666'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' Php';
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Amount (Php)',
                                    color: '#666'
                                },
                                grid: {
                                    borderColor: '#ddd',
                                    borderDash: [5, 5]
                                }
                            }
                        }
                    }
                });
            }
        }
    }
</script>
