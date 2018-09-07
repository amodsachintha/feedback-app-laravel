@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {{--NEW REGISTRATION--}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">නව ලියාපදිංචි වීම්</h3>
                    </div>
                    <div class="panel-body">
                        <form action="/add/customer" method="POST">
                            <div class="form-group">
                                <label for="nic">ජාතික හැඳුනුම්පත් අංකය</label>
                                <input type="text" class="form-control " name="nic_value" value="{{$nic}}" disabled>
                            </div>
                            <input type="hidden" name="nic" value="{{$nic}}">
                            <div class="form-group">
                                <label for="name">නම</label>
                                <input type="text" class="form-control " name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="mobile">දුරකථන අංකය</label>
                                <input type="text" class="form-control " name="mobile">
                            </div>
                            <div class="form-group">
                                <label for="address">ලිපිනය</label>
                                <input type="text" class="form-control " name="address" required>
                            </div>

                            {{--DATALIST OF SERVICES--}}
                            <div class="form-group">
                                <label for="service_id">සේවාව තෝරන්න</label>
                                @if(isset($services))
                                    <select id="service_id" name="service_id" class="form-control" required>
                                        @foreach($services as $service)
                                            <option value="{{$service->id}}">{{$service->service}}</option>
                                        @endforeach
                                    </select>
                                @endif
                                {{--<input type="text" class="form-control " name="service_id">--}}
                            </div>
                            <div class="form-group">
                                <label for="service_des">වෙනත් විස්තර</label>
                                <input type="text" class="form-control " name="service_des">
                            </div>


                            <div class="form-group" align="center">
                                <input type="submit" class="btn btn-success" value="Submit" style="width: 150px;">
                            </div>

                            {{csrf_field()}}

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

@stop