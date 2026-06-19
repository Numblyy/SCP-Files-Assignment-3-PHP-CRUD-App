<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class="container">
      
      <?php include "connection_scp.php"; ?> 
      <!-- Nav menu based on the SCP model -->
      <div>
          <ul>
              <?php foreach($result as $link): ?>
              
                <li class="nav-item active">
                  <a href="index_scp.php?link=<?php echo $link['subject']; ?>"><?php echo $link['subject']; ?></a>
               </li>
              <?php endforeach; ?>
              
              
          </ul>
          <p class="nav-item active">
                  <a href="create_scp.php" class="btn btn-dark text-light">Create a new SCP Entry.</a>
            </p>
      </div>
      
    <h1>SCP CRUD Application</h1>
    
    <div>
        <?php 
        
            if(isset($_GET['link']))
            {
                $subject = $_GET['link'];
                
                // prepared statement to retrieve record based on get value
                $stmt = $connection->prepare("select * from scp where subject  = ?");
                
                $stmt->bind_param("s", $subject);
                
                if($stmt->execute())
                {
                    $record = $stmt->get_result();
                    $array = $record->fetch_assoc();
                    
                    // create update variable based on record id
                    $update = "update_scp.php?update=" . $array['id'];
                    
                    // delete variable based on record id
                    $delete = "index_scp.php?delete=" . $array['id'];
                    
                    
                    echo "
                    
                        <div class='p-3 border shadow rounded mb-2'>
                            <h3>{$array['subject']}</h3>
                            <h4>{$array['class']}</h4>
                            <p class='text-center'><img class='img-fluid' src='{$array['image']}' alt='{$array['model']}'></p>
                            <p>{$array['description']}</p>
                            <p>{$array['containment']}</p>
                        </div>
                        <p class='text-center'>
                            <a href='{$update}' class='btn btn-warning'>Update Record</a>
                            <a href='{$delete}' class='btn btn-danger'>Delete Record</a>
                        </p>
                    
                    ";
                }
                else
                {
                    echo "<p class='alert alert-danger'>No Entry found</p>";
                }
            }
            else
            {
                echo "
                
                <div class='p-3 border shadow rounded'>
                    <h2>Welcome to the SCP Subject Website</h2>
                    <p>Use the menu above to browse this site.</p>
                    
                </div>
    
                ";
            }
            
            // delete record
            if(isset($_GET['delete']))
            {
                $delID = $_GET['delete'];
                $delete = $connection->prepare("delete from scp where id=?");
                $delete->bind_param("i", $delID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-primary'>Record Deleted...</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Error: {$delete->error}</div>";
                }
            }
        
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>