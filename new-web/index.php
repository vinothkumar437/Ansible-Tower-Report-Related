<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 4 Responsive Datatables Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="css/responsive.bootstrap4.min.css">
</head>
<body>

<div class="jumbotron text-center">
  <h1>My First Bootstrap Page</h1>
  <p>Resize this responsive page to see the effect!</p>
</div>
<?php
$dbhost = '192.168.1.106';
$dbname='awx';
$dbuser = 'awx';
$dbpass = 'awxpass';
$port = '5432';
$dbconn = pg_connect("host=$dbhost dbname=$dbname port=$port user=$dbuser password=$dbpass")
        or die('Could not connect: ' . pg_last_error());

if($dbconn)
{
 echo 'connected';
}
else
{
 echo 'not connected';
}

$query = "select t1.name as organization,t2.name as inventory,t3.name as hostname,
          t4.username as username,t3.ansible_facts->>'ansible_kernel' AS kernel,
          t3.ansible_facts->>'ansible_os_family' AS family,
          t3.ansible_facts->>'ansible_distribution_release' AS release,
          t3.ansible_facts->>'ansible_distribution_version' AS version,
          t3.ansible_facts->>'ansible_processor_vcpus' as cpus,
          t3.ansible_facts->'ansible_local'->'cpu'->>'Cpu_Usage' AS cpu_usage,
          t3.ansible_facts->'ansible_local'->'process'->>'process_count' AS process_count,
          t3.ansible_facts->>'ansible_memtotal_mb' as memory,
          t3.ansible_facts->'ansible_local'->'memory_in_use'->>'memory_in_use' AS memory_in_use,
          t3.ansible_facts->'ansible_local'->'free_memory'->>'free_memory' AS free_memory,
          t3.ansible_facts->'ansible_local'->'memory_in_buffer'->>'memory_in_buffer' AS memory_in_buffer,
          t3.ansible_facts->'facter_system_uptime'->>'days' AS days,
          t3.ansible_facts->'ansible_mounts'->1->>'size_total' AS total,
          t3.ansible_facts->'ansible_mounts'->1->>'size_available' AS available,
          t3.ansible_facts->'ansible_local'->'last'->>'last_login' AS last_login,
          t3.ansible_facts->'ansible_local'->'last1'->>'last_login1' AS last_login1,
          t3.ansible_facts->'ansible_local'->'last2'->>'last_login2' AS last_login2,
          t3.ansible_facts->'ansible_local'->'last3'->>'last_login3' AS last_login3,
          t3.ansible_facts->'ansible_local'->'last4'->>'last_login4' AS last_login4,
          t3.ansible_facts->'ansible_local'->'last5'->>'last_login5' AS last_login5,
          t3.ansible_facts->'ansible_all_ipv4_addresses'->>0 AS ipaddress from main_organization t1
          JOIN main_inventory t2 on t1.id = t2.organization_id
          JOIN main_host t3 on t2.id = t3.inventory_id
          JOIN auth_user t4 on t3.created_by_id = t4.id";


#echo $query;

$result = pg_query($query) or die('Error message: ' . pg_last_error());

$i = 0;

?>
<div class="container-fluid">
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Organization</th>
                <th>Inventory</th>
                <th>Username</th>
                <th>Hostname Added in Tower</th>
                <th>Kernel</th>
                <th>OS Family</th>
                <th>Release</th>
                <th>Version</th>
                <th>CPU</th>
                <th>CPU Usage</th>
                <th>Process Count</th>
                <th>Memory(RAM)</th>
                <th>Memory in Use</th>
                <th>Free Memory</th>
                <th>Memory in Buffer</th>
                <th>Uptime in days</th>
                <th>Root Disk Total Size</th>
                <th>Root Disk Available</th>
                <th>Last Login User One</th>
                <th>Last Login User Two</th>
                <th>Last Login User Three</th>
                <th>Last Login User Four</th>
                <th>Last Login User Fifth</th>
                <th>Last Login User Sixth</th>
                <th>IP Address</th>
            </tr>
        </thead>
        <tbody>
            <tr>
<?php
while ($row = pg_fetch_array($result)) {
?>
                <td><?php echo ++$i;?></td>
                <td><?php echo $row['organization'];?></td>
                <td><?php echo $row['inventory'];?></td>
                <td><?php echo $row['username'];?></td>
                <td><?php echo $row['hostname'];?></td>
                <td><?php echo $row['kernel'];?></td>
                <td><?php echo $row['family'];?></td>
                <td><?php echo $row['release'];?></td>
                <td><?php echo $row['version'];?></td>
                <td><?php echo $row['cpus'];?></td>
                <td><?php echo (round($row['cpu_usage']))."%";?></td>
                <td><?php echo $row['process_count'];?></td>
                <td><?php echo (round($row['memory'] / 1024)).'GB';;?></td>
                <td><?php echo $row['memory_in_use']."%";?></td>
                <td><?php echo $row['free_memory']."%";?></td>
                <td><?php echo $row['memory_in_buffer']."%";?></td>
                <td><?php echo $row['days'];?></td>
                <td><?php echo (ceil($row['total'] / 1073741824)).'GB';?></td>
                <td><?php echo (ceil($row['available'] / 1073741824)).'GB';?></td>
                <td><?php echo $row['last_login'];?></td>
                <td><?php echo $row['last_login1'];?></td>
                <td><?php echo $row['last_login2'];?></td>
                <td><?php echo $row['last_login3'];?></td>
                <td><?php echo $row['last_login4'];?></td>
                <td><?php echo $row['last_login5'];?></td>
                <td><?php echo $row['ipaddress'];?></td>
            </tr>
<?php
}
pg_free_result($result);
pg_close($dbconn);
?>
          <!--  <tr>
                <td>Garrett</td>
                <td>Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
                <td>8422</td>
                <td>g.winters@datatables.net</td>
            </tr>
            <tr>
                <td>Ashton</td>
                <td>Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
                <td>1562</td>
                <td>a.cox@datatables.net</td>
            </tr>
            <tr>
                <td>Cedric</td>
                <td>Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012/03/29</td>
                <td>$433,060</td>
                <td>6224</td>
                <td>c.kelly@datatables.net</td>
            </tr>
            <tr>
                <td>Airi</td>
                <td>Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>2008/11/28</td>
                <td>$162,700</td>
                <td>5407</td>
                <td>a.satou@datatables.net</td>
            </tr>-->
        </tbody>
    </table>

</div>

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
        <!--<script src="js/responsive.bootstrap4.min.js"></script>
        <script src="js/dataTables.responsive.min.js"></script>-->
         <script>
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                    "scrollX": true,
                        "autoWidth": false,
                "lengthChange": true,
                buttons: [ 'copy', 'excel', 'csv', 'colvis' ]
            } );

            table.buttons().container()
                .appendTo( '#example_wrapper .col-md-6:eq(0)' );
        } );
     </script>

</head>

</body>
</html>
