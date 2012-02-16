<p>There are list of customers problem you can investigate and resolve.</p>
<div class="action-box">
    <div class="objects-toolbar clearfix">
        <a class="s-btn" href="<?php echo $BASE_URL?>index.php?action=unresolved"><span>Unresolved</span></a>
        <a class="s-btn" href="<?php echo $BASE_URL?>index.php?action=resolved"><span>Resolved</span></a>
    </div>
</div>

<h1>Customers requests (<?php echo $activeMenu;?>)</h1>
<div class="list">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>State</th>
                <th>Customer</th>
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
HTML;
                if ($activeMenu == 'unresolved') {
                    echo <<<HTML
<td>
    <form method="POST" action="{$BASE_URL}index.php?action=resolve" style="margin:0">
        <input type='hidden' name='request_id' value='{$request->id}'/>
        <input type='submit' class='btn btn-success' value='Resolve'/>
    </form>
</td>
HTML;
                } else {
                    echo <<<HTML
<td>
    <form method="POST" action="{$BASE_URL}index.php?action=reopen" style="margin:0">
        <input type='hidden' name='request_id' value='{$request->id}'/>
        <input type='submit' class='btn' value='Reopen'/>
    </form>
</td>
HTML;
                }
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</div>
