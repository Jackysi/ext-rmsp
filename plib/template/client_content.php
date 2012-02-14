<h1>My requests</h1>

<table class="table table-striped table-bordered">
<thead>
<tr>
    <th>State</th>
    <th>Description</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php
foreach($requests as $request) {
    echo <<<HTML
<tr>
    <td>{$request->state}</td>
    <td>{$request->description}</td>
    <td><a class='btn btn-danger' href="#">Delete</a></td>
</tr>
HTML;
}
?>
</tbody>
</table>
<a class="btn btn-success" href="#" >Add new request</a>
