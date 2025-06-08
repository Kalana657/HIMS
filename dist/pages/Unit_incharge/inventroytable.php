<?php
session_start();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMS - Unit Incharge Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <link href="style.css" rel="stylesheet">
   
</head>
<body>
    <!-- Sidebar -->
   <?php include('slide_bar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
           <?php include('header.php') ?>

        <!-- Dashboard Content -->
        <div class="container-fluid dashboard-content">
            <div class="row">
                <!-- Left Column -->
              
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const medCtx = document.getElementById('medicationChart').getContext('2d');
            const medChart = new Chart(medCtx, {
                type: 'bar',
                data: {
                    labels: ['6 AM', '9 AM', '12 PM', '3 PM', '6 PM', '9 PM'],
                    datasets: [{
                        label: 'Scheduled Medications',
                        data: [12, 18, 8, 14, 10, 6],
                        backgroundColor: 'rgba(25, 118, 210, 0.7)',
                        borderColor: 'rgba(25, 118, 210, 1)',
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            title: {
                                display: true,
                                text: 'Number of Medications'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>