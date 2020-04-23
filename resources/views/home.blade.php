@extends('layouts.app')


@section('content')
    <section class="content-header">
      <h1>
        Workspace
        <small>{{ $role }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
        <li>Workspace</li>
        <li class="active">{{ $role }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">List Whatsapp's User</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body table-responsive">
          <table id="phones-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Whatsapp</th>
                <th>Created</th>
                <th>Last Interaction</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Whatsapp</th>
                <th>Created</th>
                <th>Last Interaction</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>

    <section class="content">

      <!-- Default box -->
      <div class="box" id="box_list_response">
        <div class="box-header with-border">
          <h3 class="box-title">List Bot's Response</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body table-responsive">
          <table id="responses-table" class="table table-bordered table-striped">
          <thead>
              <tr>
                <th>No</th>
                <th>Code</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Code</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#ResponseModal">Add new Response</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

      <!-- Default box -->
      <div class="box" id="box_edit_response" style="display: none;">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Bot's Response</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-danger" id="btn_back_edit_response">
              <i class="fa fa-times"></i>Back</button>
          </div>
        </div>
        <div class="box-body">
          <form id="form_edit_response">
            @csrf
            <div class="form-group">
              <label>Code</label>
              <input readonly id="edit_code_response" type="text" class="form-control" name="code" placeholder="Code ..." maxlength="191" required>
            </div>
            <div class="form-group">
              <label>Question</label>
              <textarea id="edit_question_response" class="form-control form-success" rows="3" name="question" placeholder="Question ..." required></textarea>
            </div>
            <div class="form-group">
              <label>Answer</label>
              <textarea id="edit_answer_response" class="form-control" rows="3" name="answer" placeholder="Answer ..." required></textarea>
            </div>
            <input type="hidden" id="edit_id_response" class="" name="id" required >
            <input type="submit" class="btn btn-info" value="Update">
          </form>
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>

    
  <!-- Modal -->
  <div class="modal modal-success fade" id="ResponseModal" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form add new Response</h4>
        </div>
        <form id="form_add_response">
          <div class="modal-body">
              @csrf
              <div class="form-group">
                <label>Code</label>
                <input id="add_code_response" type="text" class="form-control" name="code" placeholder="Code ..." maxlength="191" required>
              </div>
              <div class="form-group">
                <label>Question</label>
                <textarea id="add_question_response" class="form-control form-success" rows="3" name="question" placeholder="Question ..." required></textarea>
              </div>
              <div class="form-group">
                <label>Answer</label>
                <textarea id="add_answer_response" class="form-control" rows="3" name="answer" placeholder="Answer ..." required></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-outline" value="Save">
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  @push('scripts')
    <script type="text/javascript">
        var pTable = $('#phones-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url("api/phone") }}'
                },
                columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'number', name: 'number'},
                {data: 'cCreateDate', name: 'created_at'},
                {data: 'cUpdateDate', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            });
        var rTable = $('#responses-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("api/response") }}'
            },
            columns: [
            {data: 'DT_RowIndex', name:'DT_RowIndex'},
            {data: 'code', name: 'code'},
            {data: 'question', name: 'question'},
            {data: 'answer', name: 'answer'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        });

        function deleteDataPhone(id){
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          if (confirm('Are you sure you want to delete this?')) {
              $.ajax({
                  url: '{{url("api/phone/delete")}}',
                  type: 'DELETE',
                  dataType: 'json',
                  data: {'id': id},
                  success: function(){
                    alert('success');
                    $('#phones-table').DataTable().draw(false);
                  },            
                  error: function(){
                    alert('failure');
                    $('#phones-table').DataTable().draw(false);
                  }
              });
          }
        }

        function deleteDataResponse(id){
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          if (confirm('Are you sure you want to delete this?')) {
              $.ajax({
                  url: '{{url("api/response/delete")}}',
                  type: 'DELETE',
                  dataType: 'json',
                  data: {'id': id},
                  success: function(){
                    alert('success');
                    $('#responses-table').DataTable().draw(false);
                  },            
                  error: function(){
                    alert('failure');
                    $('#responses-table').DataTable().draw(false);
                  }
              });
          }
        }

        function editDataResponse(id){
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
              url: '{{url("api/response")}}/'+id,
              type: 'GET',
              dataType: 'json',
              success: function(result){
                $('#box_list_response').hide();

                $('#box_edit_response').removeAttr("style").show();
                $('#edit_id_response').val(result[0].id);
                $('#edit_code_response').val(result[0].code);
                $('#edit_question_response').val(result[0].question);
                $('#edit_answer_response').val(result[0].answer);
              },            
              error: function(){
                alert('failure');
              }
          });
        }

        $("#btn_back_edit_response").click(function(){
          $('#box_list_response').show();
          $('#box_edit_response').hide();
        });

        $("#form_add_response").submit(function( event ) {
          event.preventDefault();
          const dataForm = $(this).serializeArray();
          
          $.getJSON('{{url("api/response/check-code")}}/'+dataForm[1].value)
            .done(function(response){
              var status = response.status;
              if (status) {
                $.ajax({
                  url: '{{url("api/response/post")}}',
                  type: 'POST',
                  dataType: 'json',
                  data: dataForm,
                  success: function(){
                    alert('success');
                    $('#responses-table').DataTable().draw(false);
                    $('#ResponseModal').modal('toggle');
                    $('#ResponseModal').on('hidden.bs.modal', function (e) {
                      $(this)
                        .find(".form-control")
                        .val('')
                        .end();
                    });
                  },            
                  error: function(){
                    alert('failure');
                    // $('#response-table').DataTable().draw(false);
                  }
                });
              } else {
                alert('"Code" has been used!'); 
              }
            }); 
        });

        $("#form_edit_response").submit(function( event ) {
          event.preventDefault();
          const dataForm = $(this).serializeArray();
          
          $.ajax({
            url: '{{url("api/response/update")}}',
            type: 'POST',
            dataType: 'json',
            data: dataForm,
            success: function(){
              alert('success');
              $('#box_edit_response').hide();
              $('#box_list_response').show();
              $('#responses-table').DataTable().draw(false);
            },            
            error: function(){
              alert('failure');
              // $('#response-table').DataTable().draw(false);
            }
          }); 
        });

    </script>
  @endpush
@endsection