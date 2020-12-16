<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Crud operation using ajax(Real Programmer)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
    
<div class="container">
    <h1>Laravel 8 Crud with Ajax</h1>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Author</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="bookForm">
        <div class="form-group">
          <label for="">Name</label>
          <input type="text"
            class="form-control" name="" id="name" aria-describedby="helpId" placeholder="">
        </div> 
        <div class="form-group">
          <label for="">Email</label>
          <input type="text"
            class="form-control" name="" id="email" aria-describedby="helpId" placeholder="">
        </div> 
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

//edit modal

<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="bookForm_edit">
        <div class="form-group">
        <input hidden id="id">
          <label for="">Name</label>
          <input type="text"
            class="form-control" name="" id="name_edit" aria-describedby="helpId" placeholder="">
        </div> 
        <div class="form-group">
          <label for="">Email</label>
          <input type="text"
            class="form-control" name="" id="email_edit" aria-describedby="helpId" placeholder="">
        </div> 
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
<script>
  $(document).ready(function () {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          }
    });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('index.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('#bookForm').submit(function(e){
        e.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
         $.ajax({
         url:"{{route('add.data')}}",
         type:"POST",
         data:{
             name:name,
             email:email,
         },
         success:function(add_data){
             table.draw();           
         }
     })    
    });
    $('body').on('click', '#edit', function () {
        var id = $(this).data('id');// lay id tu trang khac khong cung trong 1 trang
        $.get('/edit/'+id,function(edit_data_form){
            $('#id').val(edit_data_form.id);
            $('#name_edit').val(edit_data_form.name);
            $('#email_edit').val(edit_data_form.email);
            $('#exampleModal_edit').modal('show');
    });
    });
    $('#bookForm_edit').submit(function(e){
        e.preventDefault();
        var id = $('#id').val();
        var name = $('#name_edit').val();
        var email = $('#email_edit').val();
        $.ajax({
            url:"{{route('edit_data')}}",
            type:"PUT",
            data:{
                id:id,
                name:name,
                email:email,
            },
            success:function(suc){
                alert('eidt thanh cong');
            }
        })
    });
    $('body').on('click','#remove',function(){
        var id = $(this).data('id');// lay id tu trang khac khong cung trong 1 trang
        $.ajax({
            url:"/delete/"+id,
            type:"DELETE",
            success:function(rem){
                table.draw();
            }
        })
    })

  });
</script>
</body>
</html>