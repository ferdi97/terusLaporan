<?php
require_once '../../includes/db_functions.php';
require_once '../../includes/header.php';

$technicians = getJSON('teknisi');
?>

<div class="container animated fadeIn">
    <div class="card">
        <div class="card-header">
            <h3>Technician List</h3>
            <div>
                <a href="form.php" class="btn btn-success">Add Technician</a>
                <button class="btn btn-primary pivot-btn" data-pivot-type="technician-by-sektor">Pivot by Sektor</button>
                <button class="btn btn-primary pivot-btn" data-pivot-type="technician-by-sto">Pivot by STO</button>
            </div>
        </div>
        
        <div class="card-body">
            <form class="filter-form mb-4">
                <div class="filter-controls">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" id="search" name="search" class="form-control" placeholder="Search by name or NIK">
                    </div>
                    <div class="form-group">
                        <label for="sektor">Sektor</label>
                        <select id="sektor" name="sektor" class="form-control">
                            <option value="">All Sektors</option>
                            <?php
                            $sektors = array_unique(array_column($technicians, 'SEKTOR'));
                            foreach ($sektors as $sektor) {
                                echo "<option value='$sektor'>$sektor</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sto">STO</label>
                        <select id="sto" name="sto" class="form-control">
                            <option value="">All STOs</option>
                            <?php
                            $stos = array_unique(array_column($technicians, 'STO'));
                            foreach ($stos as $sto) {
                                echo "<option value='$sto'>$sto</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="align-self: flex-end;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-secondary reset-filters">Reset</button>
                    </div>
                </div>
            </form>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Job Desk</th>
                            <th>Sektor</th>
                            <th>STO</th>
                            <th>Rayon</th>
                            <th>Datel</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($technicians as $tech) {
                            echo "<tr>
                                <td>{$tech['NIK']}</td>
                                <td><img src='{$tech['FOTO']}' alt='Photo' class='avatar' onerror=\"this.src='../../assets/images/default-avatar.png'\"></td>
                                <td>{$tech['NAMA']}</td>
                                <td>{$tech['JOBDESK']}</td>
                                <td>{$tech['SEKTOR']}</td>
                                <td>{$tech['STO']}</td>
                                <td>{$tech['RAYON']}</td>
                                <td>{$tech['DATEL']}</td>
                                <td>
                                    <a href='form.php?nik={$tech['NIK']}' class='btn btn-sm btn-primary'>Edit</a>
                                    <a href='process.php?action=delete&nik={$tech['NIK']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure?')\">Delete</a>
                                </td>
                            </tr>";
                        }
                        
                        if (empty($technicians)) {
                            echo "<tr><td colspan='9'>No technicians found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>