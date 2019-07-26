<html>
        <head>
                <title> | Report</title>
                <link rel="shortcut icon" href="img/favicon.ico" />
                <link rel="stylesheet" href="css/bootstrap.css"/>
                <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css"/>
                <link rel="stylesheet" href="css/buttons.bootstrap4.min.css"/>
                <style>
                        #example_wrapper
                        {
                                margin:20px;
                        }
                        th, td
                        {
                                white-space: nowrap;
                        }
                </style>
        </head>
        <body>
<?php
$dbhost = 'x.x.x.x';
$dbname='awx';
$dbuser = 'awx';
$dbpass = 'awxpass';
$port = '5432';

$dbconn = pg_connect("host=$dbhost dbname=$dbname port=$port user=$dbuser password=$dbpass")
        or die('Could not connect: ' . pg_last_error());

#$query ='SELECT t1.name AS org,t2.name AS inv,t3.name AS host,t4.username AS username from main_organization t1 JOIN main_inventory t2 on t1.id = t2.organization_id JOIN main_host t3 on t2.id = t3.inventory_id JOIN auth_user t4 on t3.created_by_id = t4.id';
$query = "SELECT t1.name AS org,t2.name AS inv,t3.name AS host,t4.username AS username,t3.ansible_facts->>'ansible_os_family' AS family,t3.ansible_facts->>'ansible_kernel' AS kernel,t3.ansible_facts->>'ansible_distribution_release' AS release,t3.ansible_facts->>'ansible_distribution_version' AS version,t3.ansible_facts->>'ansible_processor_vcpus' as cpus,t3.ansible_facts->>'ansible_memtotal_mb' as ram,t3.ansible_facts->'facter_system_uptime'->>'days' AS days,t3.ansible_facts->'facter_system_uptime'->>'hours' AS hours,t3.ansible_facts->>'ansible_hostname' AS hostname,t3.ansible_facts->'ansible_mounts'->0->>'size_total' AS total,t3.ansible_facts->'ansible_mounts'->0->>'size_available' AS available from main_organization t1 JOIN main_inventory t2 on t1.id = t2.organization_id JOIN main_host t3 on t2.id = t3.inventory_id JOIN auth_user t4 on t3.created_by_id = t4.id";
    $result = pg_query($query) or die('Error message: ' . pg_last_error());
$i = 0;
?>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Organization</th>
                <th>Inventory</th>
                <th>IP Address</th>
                <th>Username</th>
                <th>OS Family</th>
                <th>Kernel</th>
                <th>Release</th>
                <th>Version</th>
                <th>CPUs</th>
                <th>RAM</th>
                <th>Uptime in Days</th>
                <th>Uptime in Hours</th>
                <th>Hostname</th>
                <th>Total Root Disk Space</th>
                <th>Available Root Disk Space</th>
            </tr>
        </thead>
        <tbody>
            <tr>
<?php
while ($row = pg_fetch_array($result)) {
?>
                <td><?php echo ++$i;?></td>
                <td><?php echo $row['org'];?></td>
                <td><?php echo $row['inv'];?></td>
                <td><?php echo $row['host'];?></td>
                <td><?php echo $row['username'];?></td>
                <td><?php echo $row['family'];?></td>
                <td><?php echo $row['kernel'];?></td>
                <td><?php echo $row['release'];?></td>
                <td><?php echo $row['version'];?></td>
                <td><?php echo $row['cpus'];?></td>
                <td><?php echo (round($row['ram'] / 1024)).'GB';?></td>
                <td><?php echo $row['days'];?></td>
                <td><?php echo $row['hours'];?></td>
                <td><?php echo $row['hostname'];?></td>
                <td><?php echo (ceil($row['total'] / 1073741824)).'GB';?></td>
                <td><?php echo (ceil($row['available'] / 1073741824)).'GB';?></td>
            </tr>
<?php
}
pg_free_result($result);
pg_close($dbconn);
?>
            <!--<tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
            </tr>-->
        </tbody>
        <tfoot>
            <tr>
                <th>S.No</th>
                <th>Organization</th>
                <th>Inventory</th>
                <th>IP Address</th>
                <th>Username</th>
                <th>OS Family</th>
                <th>Kernel</th>
                <th>Release</th>
                <th>Version</th>
                <th>CPUs</th>
                <th>RAM</th>
                <th>Uptime in Days</th>
                <th>Uptime in Hours</th>
                <th>Hostname</th>
                <th>Total Root Disk Space</th>
                <th>Available Root Disk Space</th>
            </tr>
        </tfoot>
    </table>
        <script src="js/jquery-3.3.1.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap4.min.js"></script>
        <script src="js/dataTables.buttons.min.js"></script>
        <script src="js/buttons.bootstrap4.min.js"></script>
        <script src="js/jszip.min.js"></script>
        <script src="js/pdfmake.min.js"></script>
        <script src="js/vfs_fonts.js"></script>
        <script src="js/buttons.html5.min.js"></script>
        <script src="js/buttons.print.min.js"></script>
        <script src="js/buttons.colVis.min.js"></script>
        <script>
        $(document).ready(function() {
                var table = $('#example').DataTable( {
                        "scrollX": true,
                        "autoWidth": false,
                        "lengthChange": true,
                        buttons: [ 'copy', 'excel', 'colvis' ]
                   } );

                table.buttons().container()
                .appendTo( '#example_wrapper .col-md-6:eq(0)' );
        } );
        </script>
        </body>

</html>
