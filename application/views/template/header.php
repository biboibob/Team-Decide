

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/Header.css"/>

    <!-- font -->
    <link href="https://fonts.googleapis.com/css?family=Anton|Fredoka+One&display=swap" rel="stylesheet">

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/decoupled-document/ckeditor.js"></script>

    <!-- Modal Bootstrap -->
   
    
   
   

  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
    <a class="navbar-brand" href="<?php echo base_url()?>Header_C/backToProject" style="margin-left: 50%;">
      <img class="logoBack"  src="<?php echo base_url()?>assets/image/TDW.png" style="width: 100px;">
    </a>
      
      <ul class="navbar-nav ml-auto">
        
          <?php foreach($data_user as $data) { ?>
            <a class="navbar-brand" style="color: white;margin-top:2px; ">Halo, <?php echo $data['username'] ?></a>
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($data['Image']); ?>" style="width: 35px;height: 35px;margin-right: 10px;border-radius: 50%;" />

     <div class="dropdown">
        <?php if($NotifCount > 0) { ?>
          <i style="position: absolute;color: white;transform: rotateY(0deg) rotate(45deg);font-size: 16px;margin-left:-5px;margin-top:20px;" class="fas fa-bell"></i>
        <?php } ?>
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" >
          Option<i class="fas fa-cog" style="margin-left: 10px;"></i> 
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="font-size: 14px;height: 120px;width: 200px;margin-right: -50px;">
          <a class="dropdown-item" href="<?php echo base_url('Profile_C/Home_Profile'); ?>">Profile</a>
          <a class="dropdown-item BtnNotification"  data-toggle="modal" data-target="#NotificationModal" data-user="<?php echo $data['id_user'] ?>" style="cursor: pointer;">Notification 
            <?php if($NotifCount > 0) { ?>
              <span class="badge badge-primary"><?php echo $NotifCount?></span>
            <?php } ?></a>
          <a class="dropdown-item" href="<?php echo base_url('PilihProject_C/PilihProject'); ?>"  style="color:#0079BF;font-weight: 600;">Projects</a>
          <a class="dropdown-item" href="<?php echo base_url('PilihProject_C/logout'); ?>" style="color: red;font-weight: 600;">Logout</a>
        </div>
      </div>

      <?php } ?>
          
      </ul>
  </nav>

  <!-- Modal Notification -->

  <div class="modal fade" id="NotificationModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header" style="padding-left: 40%;">
          <h2 class="modal-title" ><strong>Notification</strong></h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body NotifModal" style="max-height: 250px;white-space: nowrap;position: relative;overflow-x: hidden;overflow-y: scroll;-webkit-overflow-scrolling: touch;">

        </div>

      </div>
    </div>
  </div>
  </div>

  
  
  </body>
  </html>

  <script type="text/javascript">


    $(".BtnNotification").click(function () {

        var id = $(this).data("user");
        console.log(id);
        $.ajax({
            url: "<?php echo base_url()?>Header_C/Notification",
            method: "POST",
            data: {id:id},

            success:function(data) {

              $.ajax ({
                  url: "<?php echo base_url()?>Header_C/NotificationReadChange",
                  method: "POST",
                  data: {id:id},
              });

              $(".NotifModal").html(data);
          } 
        });

     });

    $(".logoBack").click(function() {
       $.ajax({
            url: "<?php echo base_url()?>Header_C/backToProject",
            method: "GET"
      });
    });

  /*  $(".chooseProject").click(function() {
        $.ajax({
            url: "<?php echo base_url()?>Header_C/unsetProject",
            method: "GET"
        });
    });*/

  </script>
