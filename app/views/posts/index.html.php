<?php include APP_PATH . '/views/header.php';?>

<!-- <h1>Listing posts</h1> -->
<h1>Listing <?php echo ucfirst(Controller::$params['controller']); ?></h1>
<table>
  <tr>
    <th>Title</th>
    <th>Body</th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  <?php foreach($posts as $post){ ?>
  <tr>
    <td><?php echo $post['title'] ?></td>
    <td><?php echo $post['body'] ?></td>
    <td><a href="<?php echo APP_DIR . '/' . Controller::$params['controller'] . '/' . $post['id']?>" >Show</a></td>
    <td><a href="<?php echo APP_DIR . '/' . Controller::$params['controller'] . '/' .  $post['id'] . '/edit'?>" >Edit</a></td>
    <td>
      <form class="delete_form" name="delete_form" method='post' action= "<?php echo APP_DIR . '/' . Controller::$params['controller'] . '/' .  $post['id'] ?>" >
        <input type="hidden" name="_method" value="delete" />
        <input type="submit" name="delete_form_submit" value="Delete"/>
      </form>
    </td> 
<!--     <td><a href="<?php echo APP_DIR . '/' . Controller::$params['controller'] . '/' .  $post['id'] ?>" >Delete</a></td> -->
  </tr>
  <?php } ?>
</table>

<br />

<a href="<?php echo APP_DIR . '/' . Controller::$params['controller'] . "/neo" ?>">New Post</a>

<?php include APP_PATH . '/views/footer.php';?>

 