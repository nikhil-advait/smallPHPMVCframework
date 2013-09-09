<?php include APP_PATH . '/views/header.php';?>

<p>
  <b>Title:</b>
  <?php echo $post['title'] ?>
</p>

<p>
  <b>Content:</b>
  <?php echo $post['body'] ?>
</p>

<a href="<?php echo APP_DIR . '/' . Controller::$params['controller'] . '/' .  $post['id'] . '/edit'?>" >Edit</a>
<a href="<?php echo APP_DIR . '/' . Controller::$params['controller'] ?>" >Back</a>

<div id="trialDeleteAjax">Click for DELETE ajax</div>
<div id="goBack">Click for going back</div>


<?php include APP_PATH . '/views/footer.php';?>