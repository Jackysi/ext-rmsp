<div class="action-box">
    <div class="objects-toolbar clearfix">
        <a class="s-btn sb-add-new" href="<?php echo $BASE_URL;?>index.php?action=newrequest"><span>Add new request</span></a>
        <a class="s-btn" href="<?php echo $BASE_URL?>index.php?action=unresolved"><span>Unresolved</span></a>
        <a class="s-btn" href="<?php echo $BASE_URL?>index.php?action=resolved"><span>Resolved</span></a>
        <a class="s-btn sb-logout" href="/"><span>Back to Plesk Panel</span></a>
    </div>
</div>

<h1>Add new request</h1>

<?php echo $form; ?>

