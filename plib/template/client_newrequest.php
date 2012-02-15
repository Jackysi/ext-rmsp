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
            <li><a href="<?php echo $BASE_URL?>index.php?action=unresolved">Unresolved</a></li>
            <li><a href="<?php echo $BASE_URL?>index.php?action=resolved">Resolved</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

<div class="container">

<h1>Add new request</h1>
<br />
<form class="form-horisontal" method="POST" action="<?php echo $BASE_URL;?>/index.php?action=addrequest">
    <fieldset>
        <legend>Please fill desctiption of problem</legend>
        <textarea class="input-xlarge" rows="4" name="description"></textarea>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Submit</button>
            <button class="btn" type="reset">Cancel</button>
        </div>
    </fieldset>
</form> 
