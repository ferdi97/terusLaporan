<?php
require_once 'includes/db_functions.php';
require_once 'includes/header.php';
?>

<div class="container animated fadeIn">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Technicians</h3>
                    <a href="modules/teknisi/list.php" class="btn btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <?php
                    $technicians = getJSON('teknisi');
                    $count = count($technicians);
                    echo "<h4>Total: $count</h4>";
                    if ($count > 0) {
                        echo "<p>Last added: " . end($technicians)['NAMA'] . "</p>";
                    }
                    ?>
                    <a href="modules/teknisi/form.php" class="btn btn-success">Add New</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>HD Staff</h3>
                    <a href="modules/hd/list.php" class="btn btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <?php
                    $hd = getJSON('hd');
                    $count = count($hd);
                    echo "<h4>Total: $count</h4>";
                    if ($count > 0) {
                        echo "<p>Last added: " . end($hd)['NAMA'] . "</p>";
                    }
                    ?>
                    <a href="modules/hd/form.php" class="btn btn-success">Add New</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Tickets</h3>
                    <a href="modules/tiket/list.php" class="btn btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <?php
                    $tickets = getJSON('tiket');
                    $count = count($tickets);
                    $open = array_filter($tickets, function($t) { return $t['status_tiket'] !== 'CLOSE'; });
                    $openCount = count($open);
                    echo "<h4>Total: $count (Open: $openCount)</h4>";
                    if ($count > 0) {
                        echo "<p>Last ticket: #" . end($tickets)['id_tiket'] . "</p>";
                    }
                    ?>
                    <a href="modules/tiket/form.php" class="btn btn-success">Add New</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Recent Activity</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Combine all data for activity log
                            $activities = [];
                            
                            foreach (getJSON('teknisi') as $tech) {
                                $activities[] = [
                                    'date' => $tech['created_at'] ?? date('Y-m-d H:i:s'),
                                    'type' => 'Technician',
                                    'desc' => $tech['NAMA'] . ' added',
                                    'user' => 'System'
                                ];
                            }
                            
                            foreach (getJSON('hd') as $hd) {
                                $activities[] = [
                                    'date' => $hd['created_at'] ?? date('Y-m-d H:i:s'),
                                    'type' => 'HD Staff',
                                    'desc' => $hd['NAMA'] . ' added',
                                    'user' => 'System'
                                ];
                            }
                            
                            foreach (getJSON('tiket') as $ticket) {
                                $activities[] = [
                                    'date' => $ticket['reportdate'],
                                    'type' => 'Ticket',
                                    'desc' => 'Ticket #' . $ticket['id_tiket'] . ' created',
                                    'user' => $ticket['nama_hd']
                                ];
                            }
                            
                            // Sort by date
                            usort($activities, function($a, $b) {
                                return strtotime($b['date']) - strtotime($a['date']);
                            });
                            
                            // Display last 5 activities
                            $recent = array_slice($activities, 0, 5);
                            foreach ($recent as $activity) {
                                echo "<tr>
                                    <td>" . date('d M Y H:i', strtotime($activity['date'])) . "</td>
                                    <td><span class='badge badge-primary'>{$activity['type']}</span></td>
                                    <td>{$activity['desc']}</td>
                                    <td>{$activity['user']}</td>
                                </tr>";
                            }
                            
                            if (empty($recent)) {
                                echo "<tr><td colspan='4'>No recent activity</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>