<h1>Users</h1>
<?php
if( count( $users ) > 0 )
{
  ?>
  <table class="table table-small table-bordered">
    <thead>
      <th>Name</th>
      <th>Email</th>
    </thead>
    <?php
    foreach( $users as $user )
    {
      ?>
      <tr>
        <td><?= $user->getFirstName() . " " . $user->getLastName() ?></td>
        <td><?= $user->getEmail() ?></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <?php
}
else
{
  ?>
  <div class="alert alert-info">Database empty</div>
  <?php
}
?>
