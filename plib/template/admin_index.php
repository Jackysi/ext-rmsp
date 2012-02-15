    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">

            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Request Management System for Plesk</a>
          <div class="nav-collapse">
            <ul class="nav">
                <li <?php echo ($activeMenu == 'unresolved') ? "class='active'" : ''; ?>><a href="<?php echo $BASE_URL?>index.php?action=unresolved">Unresolved</a></li>
                <li <?php echo ($activeMenu == 'resolved') ? "class='active'" : ''; ?>><a href="<?php echo $BASE_URL?>index.php?action=resolved">Resolved</a></li>
                <li><a href="/">Back to Plesk Panel</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
        <h1>Customers requests</h1>

        <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>State</th>
            <th>Customer_id</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
<?php
$active = "<span class='label label-warning'>Active</span>";
$resolved = "<span class='label label-success'>Resolved</span>";
foreach($requests as $request) {
$state = $request->state === '0' ? $active : $resolved;
echo <<<HTML
<tr>
<td>{$request->id}</td>
<td>{$state}</td>
<td><a href="/admin/customer/overview/id/{$request->customer_id}">{$request->client_name}</a></td>
<td>{$request->description}</td>
<td>
<form method="POST" action="{$BASE_URL}index.php?action=resolve">
<input type='hidden' name='request_id' value='{$request->id}'/>
<input type='submit' class='btn btn-success' value='Resolve'/></form>
</td>
</tr>
HTML;
}
?>
        </tbody>
        </table>

