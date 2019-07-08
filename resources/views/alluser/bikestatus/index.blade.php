@extends('layouts.app')
@section('title','Welcome Homepage')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br><br>
            @if(count($errors) > 0)
            <div class="alert alert-danger"id="centerframemodal">
                <ul>@foreach($errors->all() as $error)                         
                     
                         <?php $geterror = "ข้อมูล status มีอยู่แล้ว";
                         if($error ==  $geterror)
                         echo "<h3><li>ข้อมูล \"สถานะ\" มีอยู่แล้ว!</li></h3><br>";
                         ?>         
                    @endforeach
                </ul>
            </div>
            @endif

            @if(\Session::has('success'))
            <div class="alert alert-success" id="centerframemodal">
                <p><h3>{{ \Session::get('success') }}</h3></p>
            </div>
            @endif
            <form action="{{url('admin/dashboard/bikestatus/search')}}" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Search">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search" ></i>
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </form>

            @if(isset($details))
            <div align="right">@include('alluser/bikestatus/create')</div>
            <table class="table table-bordered table-striped">
                <tr> 
                    <th>รหัสสถานะ</th>
                    <th>สถานะ</th>
                    <th>ลบ</th>
                </tr>

                @foreach($details as $row)
                <tr>
                    <td>{{$row['status_id']}}</td>
                    <td>{{$row['status']}}</td>   
                    @if($row['status_id'] == 0 || $row['status_id'] == 1 || $row['status_id'] == 2)               
                    <td>
                        <a href="javascript:;" data-toggle="modal"  data-target="#Modalnotdelete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                    @else
                    <td>
                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$row->status_id}})" data-target="#DeleteModal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </table>
            {!! $details->render() !!}
            @else
            <h1 id="centerframe"> {{ $message }} </h1>
            @endif
        </div>
    </div>
</div>

<div id="Modalnotdelete" class="modal fade " role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <form action="" id="deleteForm" method="post">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" color:#ffffff></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <h3>
                        <p class="text-center">ข้อมูลนี้ <b style="color:red;">"ไม่สามารถลบ"</b> <br>ได้เนื่องจากส่งผลเสียต่อระบบ</p>
                    </h3>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-success" data-dismiss="modal">ยกเลิก</button>
                    </center>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="DeleteModal" class="modal fade " role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <form action="" id="deleteForm" method="post">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" color:#ffffff>ยืนยันการลบข้อมูล</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <h3>
                        <p class="text-center">คุณแน่ใจหรือว่าต้องการลบ <br> ข้อมูลสถานะนี้?</p>
                    </h3>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-success" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">ใช่, ลบ</button>
                    </center>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function deleteData(id) {
        var id = id;
        var url = '{{ action("BikestatusController@destroy", ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm").attr('action', url);
    }

    function formSubmit() {
        $("#deleteForm").submit();
    }
</script>
@stop