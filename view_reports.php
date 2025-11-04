<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$daily_report = $conn->query("SELECT * FROM vw_daily_revenue_report");

$monthly_report = $conn->query("SELECT * FROM vw_monthly_revenue_report");

$room_type_report = $conn->query("SELECT * FROM vw_room_type_revenue_report");

$payment_method_report = $conn->query("SELECT * FROM vw_payment_method_report");

$daily_data = [];
if ($daily_report && $daily_report->num_rows > 0) {
    $daily_report->data_seek(0);
    while ($row = $daily_report->fetch_assoc()) {
        $daily_data[] = $row;
    }
}

$monthly_data = [];
if ($monthly_report && $monthly_report->num_rows > 0) {
    $monthly_report->data_seek(0);
    while ($row = $monthly_report->fetch_assoc()) {
        $monthly_data[] = $row;
    }
}

$room_type_data = [];
if ($room_type_report && $room_type_report->num_rows > 0) {
    $room_type_report->data_seek(0);
    while ($row = $room_type_report->fetch_assoc()) {
        $room_type_data[] = $row;
    }
}

$payment_method_data = [];
if ($payment_method_report && $payment_method_report->num_rows > 0) {
    $payment_method_report->data_seek(0);
    while ($row = $payment_method_report->fetch_assoc()) {
        $payment_method_data[] = $row;
    }
}

$daily_report->data_seek(0);
$monthly_report->data_seek(0);
$room_type_report->data_seek(0);
$payment_method_report->data_seek(0);

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports - Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/view_reports.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        .chart-container {
            width: 100%;
            max-width: 280px;
            height: 200px;
            margin: 15px auto;
            flex-shrink: 0;
        }
        .section-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }
        @media (min-width: 1200px) {
            .section-content {
                flex-direction: row;
                align-items: flex-start;
                justify-content: space-between;
            }
            .table-container {
                flex: 1;
                min-width: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-hotel"></i>
                <h2>LuxeStay</h2>
            </div>
            <div class="user-info">
                <h3><?php echo htmlspecialchars($_SESSION['full_name']); ?></h3>
                <p><i class="fas fa-user-tie"></i> Manager</p>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="manager_dashboard.php" class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="view_reports.php" class="menu-item active">
                <i class="fas fa-file-alt"></i>
                <span>View Reports</span>
            </a>
            <a href="view_reservations.php" class="menu-item">
                <i class="fas fa-calendar-check"></i>
                <span>View Reservations</span>
            </a>
            <a href="room_status.php" class="menu-item">
                <i class="fas fa-door-open"></i>
                <span>Room Status</span>
            </a>
            
            <div class="menu-divider"></div>
            
            <a href="index.php" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-left">
                <h1>View Reports</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Reports</span>
                </div>
            </div>
            <div class="top-bar-right">
                <div class="date-time">
                    <p><?php echo date('l'); ?></p>
                    <h4><?php echo date('F d, Y'); ?></h4>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="section">
                <h3><i class="fas fa-calendar-day"></i> Daily Revenue Report (Last 30 Days)</h3>
                <div class="section-content">
                    <div class="chart-container">
                        <canvas id="dailyChart"></canvas>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total Bookings</th>
                                    <th>Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($daily_report && $daily_report->num_rows > 0): ?>
                                    <?php while ($row = $daily_report->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('F d, Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row['bookings']; ?></td>
                                        <td><strong style="color: #2563eb;">₱<?php echo number_format($row['revenue'], 2); ?></strong></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 20px; color: #666;">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h3><i class="fas fa-chart-bar"></i> Monthly Revenue Report (Last 12 Months)</h3>
                <div class="section-content">
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Total Bookings</th>
                                    <th>Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($monthly_report && $monthly_report->num_rows > 0): ?>
                                    <?php while ($row = $monthly_report->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('F Y', strtotime($row['month'] . '-01')); ?></td>
                                        <td><?php echo $row['bookings']; ?></td>
                                        <td><strong style="color: #2563eb;">₱<?php echo number_format($row['revenue'], 2); ?></strong></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 20px; color: #666;">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h3><i class="fas fa-bed"></i> Revenue by Room Type</h3>
                <div class="section-content">
                    <div class="chart-container">
                        <canvas id="roomTypeChart"></canvas>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Total Bookings</th>
                                    <th>Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($room_type_report && $room_type_report->num_rows > 0): ?>
                                    <?php while ($row = $room_type_report->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                                        <td><?php echo $row['total_bookings']; ?></td>
                                        <td><strong style="color: #2563eb;">₱<?php echo number_format($row['total_revenue'], 2); ?></strong></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 20px; color: #666;">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h3><i class="fas fa-credit-card"></i> Payment Methods Report</h3>
                <div class="section-content">
                    <div class="chart-container">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Payment Method</th>
                                    <th>Transaction Count</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($payment_method_report && $payment_method_report->num_rows > 0): ?>
                                    <?php while ($row = $payment_method_report->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo ucfirst(str_replace('_', ' ', $row['payment_method'])); ?></td>
                                        <td><?php echo $row['count']; ?></td>
                                        <td><strong style="color: #2563eb;">₱<?php echo number_format($row['total'], 2); ?></strong></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 20px; color: #666;">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dailyData = <?php echo json_encode(array_reverse($daily_data)); ?>;
        const monthlyData = <?php echo json_encode(array_reverse($monthly_data)); ?>;
        const roomTypeData = <?php echo json_encode($room_type_data); ?>;
        const paymentMethodData = <?php echo json_encode($payment_method_data); ?>;

        Chart.defaults.color = '#374151';
        Chart.defaults.borderColor = '#e5e7eb';

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        };

        if (dailyData.length > 0) {
            new Chart(document.getElementById('dailyChart'), {
                type: 'line',
                data: {
                    labels: dailyData.map(d => new Date(d.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })),
                    datasets: [{
                        label: 'Revenue',
                        data: dailyData.map(d => parseFloat(d.revenue)),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 10
                                },
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            },
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 9
                                },
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 8
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        if (monthlyData.length > 0) {
            new Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: monthlyData.map(d => new Date(d.month + '-01').toLocaleDateString('en-US', { month: 'short', year: '2-digit' })),
                    datasets: [{
                        label: 'Revenue',
                        data: monthlyData.map(d => parseFloat(d.revenue)),
                        backgroundColor: '#8b5cf6',
                        borderRadius: 4
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 10
                                },
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            },
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 9
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        if (roomTypeData.length > 0) {
            new Chart(document.getElementById('roomTypeChart'), {
                type: 'doughnut',
                data: {
                    labels: roomTypeData.map(d => d.type_name),
                    datasets: [{
                        data: roomTypeData.map(d => parseFloat(d.total_revenue)),
                        backgroundColor: [
                            '#3b82f6',
                            '#8b5cf6',
                            '#ec4899',
                            '#f59e0b',
                            '#10b981',
                            '#06b6d4'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    ...chartOptions,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right',
                            labels: {
                                font: {
                                    size: 11
                                },
                                padding: 12,
                                boxWidth: 12,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        if (paymentMethodData.length > 0) {
            new Chart(document.getElementById('paymentMethodChart'), {
                type: 'pie',
                data: {
                    labels: paymentMethodData.map(d => d.payment_method.replace('_', ' ').toUpperCase()),
                    datasets: [{
                        data: paymentMethodData.map(d => parseFloat(d.total)),
                        backgroundColor: [
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#8b5cf6',
                            '#06b6d4',
                            '#ec4899'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right',
                            labels: {
                                font: {
                                    size: 11
                                },
                                padding: 12,
                                boxWidth: 12,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>