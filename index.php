<?php
  $insert=false;
  $update=false;
  $delete=false;
  // connect To The DataBase  
  $servername="localhost";
  $username="root";
  $password="";
  $database="notes";

  $conn=mysqli_connect($servername,$username,$password,$database);

  if(!$conn){
    echo "Sorry Failed To Connect".mysqli_connect_error();
  }


  if(isset($_GET['delete'])){
    $sno=$_GET['delete'];
    $delete=true;
    $sql="DELETE FROM `notes` WHERE `notes`.`sno` =$sno";
    $result=mysqli_query($conn,$sql);
  }

  if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['snoEdit'])){
      //Update The Record
        $sno=$_POST['snoEdit'];
        $title=$_POST['titleEdit'];
        $description=$_POST['descriptionEdit'];
    
        $sql="UPDATE `notes` SET `title` = '$title' , `description`='$description' WHERE `notes`.`sno` = $sno";
        $result=mysqli_query($conn,$sql);
        if($result){
          $update=true;
        }
    }
    else{
          $title=$_POST['title'];
          $description=$_POST['description'];

          if(empty($title)||empty($description)){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Failure!</strong> The Notes Has Not  Been inserted Successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
          }
          else if((!empty($title)||!empty($description))){
            $sql="INSERT INTO `notes` ( `title`, `description`) VALUES ('$title', '$description')";
            $result=mysqli_query($conn,$sql);

            if($result){
              // echo "The Record Has Been inserted Successfully!<br>";
              $insert=true;
            }
            else{
              echo "The Record Was Not inserted Successfully because Of This Error".mysqli_error($conn);
            }
          }
      }
    }
    
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">

    <!-- jquery Table  -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    

    <!-- title  -->
    <title>iNotes</title>

   
  </head>
  <body>
    <!--Edit Modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->

<!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit This Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="/iNotes/index.php" method="post">
          <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              </div>
  
              <div class="mb-3">
                  <label for="desc" class="form-label">Note Description</label>
                  <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>
              <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><b>iNotes</b></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

      <?php
        if($insert){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Success!</strong> The Notes Has Been inserted Successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }            
        
      ?>
      <?php 
        if($update){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Success!</strong> The Notes Has Been Updated Successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
      ?>
      <?php 
        if($delete){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Success!</strong> The Notes Has Been Deleted Successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
      ?>

      <!-- <div class="container my-5">
          <h2>Add A Note</h2>
        <form action="/iNotes/index.php?" method="post">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
      </div> -->

      <div class="container my-5">
          <button  type="button" id="Add" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNote">Add A Note</button>
          <div class="modal fade" id="addNote" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Add A Note</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="container">
                  <form action="/iNotes/index.php?" method="post">
                    <div class="mb-3">
                      <label for="title" class="form-label">Note Title</label>
                      <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    </div>
        
                    <div class="mb-3">
                        <label for="desc" class="form-label">Note Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Add Note</button>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
      </div>

      <div class="container my-4">
          <table class="table" id="myTable">
            <thead>
              <tr>
                <th scope="col">S.No</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql="SELECT * FROM `notes`";
                $result=mysqli_query($conn,$sql);
                $sno=0;
                while($row=mysqli_fetch_assoc($result)){
                  $sno=$sno+1;
                  echo "<tr>
                          <th scope='row'>". $sno ."</th>
                          <td>".$row['title'] ."</td>
                          <td>".$row['description'] ."</td>
                          <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>   <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button> </td>
                        </tr>";
                }                
              ?>
            </tbody>
          </table>
      </div>
      <hr>
  </body>
  <!-- bootstrap script  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js"  crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>    
    <script>
        $(document).ready( function () {
        $('#myTable').DataTable();
      });
    </script>

<script>
  edits=document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener("click",(e)=>{
      console.log("edit",);
      tr=e.target.parentNode.parentNode;
      title=tr.getElementsByTagName("td")[0].innerText;
      description=tr.getElementsByTagName("td")[1].innerText;
      console.log(title,description);
      titleEdit.value=title;
      descriptionEdit.value=description;
      snoEdit.value=e.target.id;
      console.log(e.target.id)
      $('#editModal').modal('toggle');
    })
  })

  deletes=document.getElementsByClassName('delete');
  Array.from(deletes).forEach((element)=>{
    element.addEventListener("click",(e)=>{
      console.log("edit",);
      sno=e.target.id.substr(1,)
      if(confirm("Are You Sure Want To Delete!")){
        console.log("yes");
        window.location=`/iNotes/index.php?delete=${sno}`;
      }
      else{
        console.log("no");
      }
    })
  })
</script>

</html>