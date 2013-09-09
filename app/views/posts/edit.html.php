<?php include APP_PATH . '/views/header.php';?>

<h1>Editing post</h1>
<form method="post" id="edit_post" class="edit_post" action="<?php echo APP_DIR . '/' . Controller::$params['controller'] . '/' . Controller::$params['id'] ?>" accept-charset="UTF-8">
  <input type="hidden" value="put" name="_method">

  <div class="field">
    <label for="post_title">Title</label><br>
    <input type="text" value="<?php echo $post['title']?>" size="30" name="post[title]" id="post_title">
  </div>
  <div class="field">
    <label for="post_content">Body</label><br>
    <textarea rows="20" name="post[body]" id="post_boody" cols="40"><?php echo $post['body']?></textarea>
  </div>

  <div class="actions">
    <input type="submit" value="Update Post" name="commit">
  </div>
</form>

<a href="<?php echo APP_DIR . '/' . Controller::$params['controller'] . '/' . $post['id']?>" >Show</a>
<a href="<?php echo APP_DIR . '/' . Controller::$params['controller'] ?>" >Back</a>

<!-- trialAjax -->
<div id="trialPutAjax">Click for putting ajax</div>

<?php include APP_PATH . '/views/footer.php';?>