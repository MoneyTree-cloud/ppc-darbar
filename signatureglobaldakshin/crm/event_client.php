<?php include('php/check_login.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Event Leads</title>

    <?php include('resource.php'); ?>

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

            <?php include('php/admin_details.php'); ?>
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search" id="search_bar">
                    <label>
                        <input type="text" id="searchInput" placeholder="Search by Name, Ticket, Employee ID/Name...">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                    <img src="assets/imgs/admin/<?php echo $admin_profile; ?>" onclick="openPopup('<img src=\'assets/imgs/admin/<?php echo $admin_profile; ?>\' alt=\'Image\' /><p><?php echo $admin_name; ?></p>')">
                </div>
                <div class="popup-overlay" id="reusablePopup">
                    <div class="popup-content">
                        <button class="popup-close" onclick="closePopup()">&times;</button>
                        <div id="popup-body"></div>
                        <div id="popup-actions" class="popup-actions"></div>
                    </div>
                </div>
            </div>


            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Event Leads</h2>
                        <div style="display: flex;justify-content: center; align-items: center; flex-wrap: wrap; gap: 5px;">
                            <a href="feedback.php" class="btn">View Collected Data</a>
                        <div class="dropdown" style="position: relative; background: transparent; display: inline-block;">
                                <button class="btn" onclick="toggleDropdown()" style="border-radius: 5px;">
                                    Reports ▾
                                </button>
                                <div id="reportDropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 10; border-radius: 5px; min-width: 160px;">
                                    <a href="event_report.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">View Report</a>
                                </div>
                            </div>
                        <div class="dropdown" style="position: relative; display: inline-block;">
                            <button class="btn" onclick="toggleExportDropdown()">
                                Download Report ▾
                            </button>
                            <div id="exportDropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 10; border-radius: 5px; min-width: 120px;">
                                <a href="#" onclick="exportToPNG()">PNG</a>
                                <a href="#" onclick="exportToPDF()">PDF</a>
                                <a href="#" onclick="exportToExcel()">Excel</a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Ticket No.</th>
                                <th>Meeting Time</th>
                                <th>Invited By (Employ ID)</th>
                                <th>Submitted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="event_leads_data">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="notificationContainer"></div>

    <script>

        function toggleDropdown() {
                    const dropdown = document.getElementById('reportDropdown');
                    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
                }

                // Optional: Hide dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    const dropdown = document.getElementById('reportDropdown');
                    if (dropdown && !event.target.closest('.dropdown')) {
                        dropdown.style.display = 'none';
                    }
                });

        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById('searchInput');

            // Function to fetch and display data
            function fetchEventLeads(searchTerm = '') {
                // The fetch URL from your previous code was 'event/php/fetch_event_leads.php'.
                // Adjust this path if your file structure is different.
                let url = `event/php/fetch_event_leads.php`;
                if (searchTerm) {
                    url += `?search=${encodeURIComponent(searchTerm)}`;
                }

                fetch(url)
                    .then((res) => res.json())
                    .then((data) => {
                        const tbody = document.getElementById("event_leads_data");
                        tbody.innerHTML = ""; // Clear existing rows

                        if (!Array.isArray(data) || data.length === 0) {
                            tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;">No results found.</td></tr>`;
                            return;
                        }

                        data.forEach((row) => {
                            const tr = document.createElement("tr");

                            // Format the created_at date for better readability
                            const submittedDate = new Date(row.created_at);
                            const formattedDate = submittedDate.toLocaleString('en-IN', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            });

                            tr.innerHTML = `
                                <td style="text-align:center;">${row.sno}</td>
                                <td>${row.name}</td>
                                <td style="text-align:center;">${row.phone}</td>
                                <td style="text-align:center;">${row.ticket_id}</td>
                                <td style="text-align:center;">${row.timing}</td>
                                <td style="text-align:center;">${row.employ_id} (${row.invited_by})</td>
                                <td style="text-align:center;">${formattedDate}</td>
                                <td style="text-align:center;">
                                    <a class="btn" href="event/ticket.php?ticket_id=${encodeURIComponent(row.ticket_id)}" target="_blank" title="View Ticket">
                                        <ion-icon name="ticket-outline"></ion-icon>
                                    </a>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    })
                    .catch((err) => {
                        console.error('Fetch Error:', err);
                        document.getElementById("event_leads_data").innerHTML = `<tr><td colspan="8" style="text-align:center;">Error loading data.</td></tr>`;
                    });
            }

            // Initial data load
            fetchEventLeads();

            // Add event listener for the search input to filter results as the user types
            searchInput.addEventListener('input', function() {
                fetchEventLeads(this.value.trim());
            });

            // Auto-refresh every 30 seconds, but only if the user is not actively searching
            setInterval(() => {
                if (searchInput.value.trim() === '') {
                    fetchEventLeads();
                }
            }, 30000);
        });

        // --- Export Functions ---
        function toggleExportDropdown() {
            const dropdown = document.getElementById('exportDropdown');
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                const dropdown = document.getElementById('exportDropdown');
                if (dropdown) {
                    dropdown.style.display = 'none';
                }
            }
        });

        function exportToPNG() {
            toggleExportDropdown()
            html2canvas(document.querySelector('.details')).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Event-Leads-Report.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }

        // 🚀 MODIFIED: This function is completely rewritten using jsPDF AutoTable
        function exportToPDF() {
            toggleExportDropdown(); // Hide the dropdown menu

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const table = document.querySelector('table');

            // --- Get Header Data ---
            // We select all header cells (th), convert them to an array, and get their text content.
            // .slice(0, -1) is used to remove the last column ("Action") which we don't need in the PDF.
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText).slice(0, -1);
            
            // --- Get Body Data ---
            // We select all body rows (tr), and for each row, we select its cells (td).
            // We map over them to get the text content and again use .slice(0, -1) to skip the "Action" cell.
            const body = Array.from(table.querySelectorAll('tbody tr')).map(tr =>
                Array.from(tr.querySelectorAll('td')).map(td => td.innerText).slice(0, -1)
            );

            // Add a title to the PDF
            doc.text("Event Leads Report", 14, 15);

            // --- Generate the Table ---
            // This is the magic part. The autoTable function takes the headers and body data
            // and automatically creates a table, handling page breaks if the table is long.
            doc.autoTable({
                head: [headers],
                body: body,
                startY: 20, // Y position to start the table (below the title)
                theme: 'grid', // 'striped', 'grid', or 'plain'
                headStyles: { fillColor: [41, 128, 185] }, // Style the header
            });
            
            // --- Save the PDF ---
            doc.save('Event-Leads-Report.pdf');
        }

        function exportToExcel() {
            toggleExportDropdown()
            const table = document.querySelector('table');
            const html = table.outerHTML;
            const url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html);
            const link = document.createElement('a');
            link.download = 'Event-Leads-Report.xls';
            link.href = url;
            link.click();
        }
    </script>

    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>