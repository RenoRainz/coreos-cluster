<h1>Customers</h1>
<?php
if( count( $customers ) > 0 )
{
  ?>
  <table class="table table-small table-bordered">
    <thead>
      <th>Name</th>
      <th>Email</th>
      <th>Email2</th>
    </thead>
    <?php
    foreach( $customers as $customer )
    {
      ?>
      <tr>
        <td><?= $customer->getFirstname() . " " . $customer->getLastname() ?></td>
        <td><?= $customer->getEmail() ?></td>
        <td><?= $customer->getEmail2() ?></td>
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
