<p>There are list of problems appear during using of hosting.</p>
<div class="action-box">
    <div class="objects-toolbar clearfix">
        <a class="s-btn sb-add-new" href="<?php echo $BASE_URL;?>index.php?action=newrequest"><span>Add new request</span></a>
        <a class="s-btn" href="<?php echo $BASE_URL?>index.php?action=unresolved"><span>Unresolved</span></a>
        <a class="s-btn" href="<?php echo $BASE_URL?>index.php?action=resolved"><span>Resolved</span></a>
        <a class="s-btn sb-logout" target="_top" href="/"><span>Back to Plesk Panel</span></a>
    </div>
</div>

<h1>My requests (<?php echo $activeMenu;?>)</h1>
<div class="list">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>State</th>
                <th>Description</th>
                <?php echo ($activeMenu == 'resolved') ? "<th>Actions</th>" : ''; ?>
            </tr>
        </thead>

        <tbody>
        <?php
            $active = "<span class='label label-warning'>Active</span>";
            $resolved = "<span class='label label-success'>Resolved</span>";
            foreach($requests as $request) {
                $state = ($request->state === '0') ? $active : $resolved;
                echo <<<HTML
<tr>
    <td>{$request->id}</td>
    <td>{$state}</td>
    <td>{$request->description}</td>
HTML;
                if ($activeMenu == 'resolved') {
                    echo <<<HTML
<td>
    <form method="POST" action="{$BASE_URL}index.php?action=reopen">
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
