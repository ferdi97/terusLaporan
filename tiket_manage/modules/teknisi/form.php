<?php
require_once '../../includes/db_functions.php';
require_once '../../includes/header.php';

$technician = [
    'NIK' => '',
    'NAMA' => '',
    'JOBDESK' => '',
    'SEKTOR' => '',
    'STO' => '',
    'RAYON' => '',
    'DATEL' => '',
    'FOTO' => ''
];

if (isset($_GET['nik'])) {
    $technicians = getJSON('teknisi');
    foreach ($technicians as $tech) {
        if ($tech['NIK'] == $_GET['nik']) {
            $technician = $tech;
            break;
        }
    }
}
?>

<div class="container animated fadeIn">
    <div class="card">
        <div class="card-header">
            <h3><?php echo isset($_GET['nik']) ? 'Edit Technician' : 'Add New Technician'; ?></h3>
            <a href="list.php" class="btn btn-secondary">Back to List</a>
        </div>
        
        <div class="card-body">
            <form action="process.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="<?php echo isset($_GET['nik']) ? 'update' : 'create'; ?>">
                <input type="hidden" name="old_nik" value="<?php echo $technician['NIK']; ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" id="nik" name="nik" class="form-control" value="<?php echo $technician['NIK']; ?>" required>
                            <div class="invalid-feedback">Please provide a NIK.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama">Name</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $technician['NAMA']; ?>" required>
                            <div class="invalid-feedback">Please provide a name.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="jobdesk">Job Desk</label>
                            <input type="text" id="jobdesk" name="jobdesk" class="form-control" value="<?php echo $technician['JOBDESK']; ?>" required>
                            <div class="invalid-feedback">Please provide a job desk.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="sektor">Sektor</label>
                            <input type="text" id="sektor" name="sektor" class="form-control" value="<?php echo $technician['SEKTOR']; ?>" required>
                            <div class="invalid-feedback">Please provide a sektor.</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sto">STO</label>
                            <input type="text" id="sto" name="sto" class="form-control" value="<?php echo $technician['STO']; ?>" required>
                            <div class="invalid-feedback">Please provide a STO.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="rayon">Rayon</label>
                            <input type="text" id="rayon" name="rayon" class="form-control" value="<?php echo $technician['RAYON']; ?>" required>
                            <div class="invalid-feedback">Please provide a rayon.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="datel">Datel</label>
                            <input type="text" id="datel" name="datel" class="form-control" value="<?php echo $technician['DATEL']; ?>" required>
                            <div class="invalid-feedback">Please provide a datel.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="foto">Photo</label>
                            <?php if (!empty($technician['FOTO'])): ?>
                                <div class="mb-2">
                                    <img src="<?php echo $technician['FOTO']; ?>" alt="Current Photo" class="avatar" onerror="this.src='../../assets/images/default-avatar.png'">
                                </div>
                            <?php endif; ?>
                            <input type="file" id="foto" name="foto" class="form-control-file">
                            <small class="form-text text-muted">Leave blank to keep current photo</small>
                        </div>
                    </div>
                </div>
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="list.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>