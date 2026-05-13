<?php include('php/check_login.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Feedback Submissions</title>
    <?php include('resource.php') ?>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
</head>

<body>
    <div class="container">
        <?php include('components/navbar.php') ?>

        <div class="main">
             <?php include('components/topbar.php'); ?> 

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Collected Data</h2>
                        
                        <div class="dropdown" style="position: relative; display: inline-block;">
                            <button class="btn" onclick="toggleExportDropdown()">Download Report ▾</button>
                            <div id="exportDropdown" class="dropdown-content" style="display: none;">
                                <a href="#" onclick="exportToPNG()">PNG</a>
                                <a href="#" onclick="exportToPDF()">PDF</a>
                                <a href="#" onclick="exportToExcel()">Excel</a>
                            </div>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr align="left">
                                <th>S no.</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Feedback Message</th>
                                <th>Submitted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="feedbackTableBody">
                            <!-- Fetched rows will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="notificationContainer"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById('searchInput');

            function fetchFeedback(searchTerm = '') {
                const url = `php/fetch/fetch_feedback.php?search=${encodeURIComponent(searchTerm)}`;

                fetch(url)
                    .then((res) => res.json())
                    .then((data) => {
                        const tbody = document.getElementById("feedbackTableBody");
                        tbody.innerHTML = "";

                        if (!Array.isArray(data) || data.length === 0) {
                            tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;">No feedback found.</td></tr>`;
                            return;
                        }

                        data.forEach((row) => {
                            const tr = document.createElement("tr");
                            const submittedDate = new Date(row.submitted_at);
                            const formattedDate = submittedDate.toLocaleString('en-IN', {
                                day: '2-digit', month: 'short', year: 'numeric',
                                hour: '2-digit', minute: '2-digit', hour12: true
                            });

                            tr.innerHTML = `
                                <td style="text-align:center;">${row.sno}</td>
                                <td style="text-align:left;">${row.name}</td>
                                <td style="text-align:left;">${row.contact}</td>
                                <td style="text-align:left;">${row.email}</td>
                                <td style="text-align:left; max-width: 300px; white-space: pre-wrap; word-wrap: break-word;">${row.feedback_message}</td>
                                <td style="text-align:left;">${formattedDate}</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0);" onclick="confirmDelete(${row.id})" class="btn" title="Delete Feedback">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </a>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    })
                    .catch((err) => {
                        console.error('Fetch Error:', err);
                        document.getElementById("feedbackTableBody").innerHTML = `<tr><td colspan="7" style="text-align:center;">Error loading data.</td></tr>`;
                    });
            }

            // Initial data load
            fetchFeedback();

            // Add event listener for the search input
            searchInput.addEventListener('input', function() {
                fetchFeedback(this.value.trim());
            });

            // Auto-refresh every 30 seconds
            setInterval(() => {
                fetchFeedback(searchInput.value.trim());
            }, 30000);
        });

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this feedback? This action cannot be undone.')) {
                window.location.href = `php/delete/delete_feedback.php?id=${id}`;
            }
        }
    </script>

    <script>
        function toggleExportDropdown() {
            const dropdown = document.getElementById('exportDropdown');
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        }
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                const dropdown = document.getElementById('exportDropdown');
                if (dropdown) dropdown.style.display = 'none';
            }
        });

        function exportToPNG() {
            toggleExportDropdown();
            html2canvas(document.querySelector('.details')).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Feedback-Report.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }

        function exportToPDF() {
            toggleExportDropdown();
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.text("Feedback Submissions Report", 14, 15);
            doc.autoTable({
                html: 'table',
                startY: 20,
                theme: 'grid',
                headStyles: { fillColor: [41, 128, 185] },
                // Exclude the 'Action' column from the PDF
                columns: [0, 1, 2, 3, 4, 5]
            });
            doc.save('Feedback-Report.pdf');
        }

        function exportToExcel() {
            toggleExportDropdown();
            const table = document.querySelector('table').cloneNode(true);
            // Remove the 'Action' column for Excel export
            table.querySelectorAll('tr').forEach(tr => tr.deleteCell(-1)); 
            const html = table.outerHTML;
            const url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html);
            const link = document.createElement('a');
            link.download = 'Feedback-Report.xls';
            link.href = url;
            link.click();
        }
    </script>

    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
