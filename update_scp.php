<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update / Edit Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class="container"> 
      
      <?php include "connection_scp.php"; 
      
        // enable error reporting, remove these when application is finished
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        // setup empty array called $row
        $row = [];
            
            // redirected from index page with update get value
            if(isset($_GET['update']))
            {
                $id = $_GET['update'];
                // based on the above, retrieve appropriate record from the table
                $recordID = $connection->prepare("select * from scp where id = ?");
                
                if(!$recordID)
                {
                    echo "<div class='alert alert-danger'>Error retrieving record for editing</div>";
                    exit;
                }
                
                $recordID->bind_param("i", $id);
                
                if($recordID->execute())
                {
                    echo "<div class='alert alert-success'>Record ready for updating</div>";
                    $temp = $recordID->get_result();
                    $row = $temp->fetch_assoc();
                    
                }
            }
        
        if(isset($_POST['update']))
            {
                // write a prepared statement to save edits/update from form submission
                $update = $connection->prepare("update scp set subject=?, class=?, description=?, containment=?, image=? where id=?");
                $update->bind_param("sssssi", $_POST['subject'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image'], $_POST['id']);
                
                if($update->execute())
                {
                    echo "<div class='alert alert-success'>Recorded updated successfully</div>";
                    
                }
                else
                {
                   echo "<div class='alert alert-danger'>Error: {$update->error}</div>"; 
                }
            }
      
                ?>
        <ul>
        <?php foreach($result as $link): ?>
        
        
        <li>
        <a href="index_scp.php?link=<?php echo $link['subject']; ?>"><?php echo $link['subject']; ?></a>
        </li>
        
        
        <?php endforeach; ?>
        </ul>
      
   
   
      <button class="btn btn-dark"><a href="index_scp.php">Back to index page</a></button>
    <h1>Update / Edit Entry.</h1>
    
    <div>
        <form method="post" action="update_scp.php" class="form-group">
            <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : '' ?>"> 
            <label>Enter SCP Subject:</label>
            <br>
            <input type="text" name="subject"  class="form-control" value="<?php echo isset($row['subject']) ? $row['subject'] : '' ?>">
            <br>
            <label>Enter SCP Class:</label>
            <br>
            <input type="text" name="class" class="form-control" value="<?php echo isset($row['class']) ? $row['class'] : '' ?>">
            <br>
            <label>Enter SCP Description:</label>
            <textarea name="description" class="form-control" ><?php echo isset($row['description']) ? $row['description'] : '' ?></textarea>
            <br>
            <label>Enter SCP Containment Procedure</label>
            <textarea name="containment" class="form-control" ><?php echo isset
                ($row['containtment']) ? $row['containment']: '' ?></textarea>
            <br>
            <label>Enter SCP Image:</label>
            <br>
            <input type="text" name="image"   class="form-control" value="<?php echo isset($row['image']) ? $row['image'] : '' ?>">
            <br>
            <br>
            <input type="submit" name="update" class="btn btn-primary">
        </form>    
    
    </div>
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>