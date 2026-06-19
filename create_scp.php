<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add a new record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class="container">
      
      <?php include "connection_scp.php"; 
      
        if(isset($_POST['submit']))
        {
            // code a prepared statement to insert form contents to database
            $insert = $connection->prepare(
                "insert into scp(subject, class, description, containment, image) values(?, ?, ?, ?, ?)"
                );
            $insert->bind_param("sssss", $_POST['subject'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image']);
            
            if($insert->execute())
            {
                echo "
                <div class='alert alert-success'>Entry Added Successfully</div>
                ";
            }
            else
            {
                echo "
                <div class='alert alert-danger'>Error: {$insert->error}</div>
                ";
            }
        }
      
      
      ?>
      
   
   
      <button class="btn btn-dark"><a href="index_scp.php">Back to index page</a></button>
    <h1>add a new Entry.</h1>
    
    <div>
        <form method="post" action="create_scp.php" class="form-group">
            <label>Enter SCP Subject:</label>
            <br>
            <input type="text" name="subject" placeholder="SCP Subject..." required class="form-control">
            <br>
            <label>Enter SCP Class:</label>
            <br>
            <input type="text" name="class" placeholder="Class..." required class="form-control">
            <br>
            <label>Enter SCP Description: </label>
            <textarea name="description" class="form-control">Description Here...</textarea>
            <br>
            <label>Enter SCP Containment Procedure: </label>
            <textarea name="containment" class="form-control">Containment Here...</textarea> 
            <br>
            <Label>Enter SCP Image:</Label>
            <br>
            <input type="text" name="image" placeholder="image URL or Path e.g images/name-of-image.png" required class="form-control">
            <br>
            <br>
            <input type="submit" name="submit" class="btn btn-primary">
        </form>
    </div>
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>