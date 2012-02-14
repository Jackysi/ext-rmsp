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
foreach($requests as $request) {
    echo <<<HTML
<tr>
    <td>{$request->id}</td>
    <td>{$request->state}</td>
    <td>{$request->customer_id}</td>
    <td>{$request->description}</td>
    <td><a class='btn btn-success' href="#">Resolved</a> | <a class='btn btn-danger' href="#">Delete</a></td>
</tr>
HTML;
}
?>
</tbody>
</table>
