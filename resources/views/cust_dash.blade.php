@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Person Info
                    </div>
                    <div class="panel-body">
                        @if(isset($customer))
                            <table class="table table-hover" style="font-size: 15px">
                                <tbody>
                                <tr>
                                    <td>Name:</td>
                                    <td><strong>{{$customer->name}}</strong></td>
                                </tr>
                                <tr>
                                    <td>NIC:</td>
                                    <td><strong>{{$customer->nic}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Telephone:</td>
                                    <td><strong>{{$customer->mobile}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td><strong>{{$customer->address}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Record New Service
                    </div>
                    <div class="panel-body">
                        <input type="hidden" id="s_nic" name="s_nic" value="{{$customer->nic}}">

                        <div class="form-group">
                            <label for="service_id">Select Service</label>
                            @if(isset($services))
                                <select id="s_service_id" name="s_service_id" class="form-control" required>
                                    @foreach($services as $service)
                                        <option value="{{$service->id}}">{{$service->service}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="service_des">Description</label>
                            <input type="text" class="form-control " name="s_service_des" id="s_service_des">
                        </div>

                        <div class="form-group" align="center">
                            <button class="btn btn-success" onclick="if(confirm('Are you sure?')) addServiceRecord()" style="width: 150px;">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(isset($pending))
            @foreach($pending as $service)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        @if($service->n == 1)
                            <div class="panel panel-primary">
                                @elseif($service->n < 3)
                                    <div class="panel panel-warning">
                                        @elseif($service->n >= 3)
                                            <div class="panel panel-danger">
                                                @endif
                                                <div class="panel-heading">
                                                    {{$service->service}}
                                                </div>
                                                <div class="panel-body">
                                                    @if($service->description != "" || $service->description != null)
                                                        <p>Description: <strong>{{$service->description}}</strong></p>
                                                    @endif
                                                    <p>First Visit: <strong>{{date('d M Y h:i:s A',strtotime($service->date_time))}}</strong></p>
                                                    @if($service->n != 1)
                                                        <p>Last Visit: <strong>{{date('d M Y h:i:s A',strtotime($service->updated_at))}}</strong></p>
                                                    @endif
                                                    <p>Visits: <strong>{{$service->n}}</strong></p>
                                                    <p>
                                                        <button class="btn btn-primary" onclick="if(confirm('Are you sure?')) setResolved('{{$customer->nic}}','{{$service->service_id}}')"
                                                                style="margin-right: 30px">Set Resolved
                                                        </button>
                                                        <button class="btn btn-danger"
                                                                onclick="if(confirm('Are you sure?')) incrementVisit('{{$customer->nic}}','{{$service->service_id}}','{{$service->n}}')">Update Visit
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                            @endforeach
                        @endif
                    </div>


                </div>
    </div>
    <script type="text/javascript">
        function setResolved(nic, service_id) {
            var ajax = new XMLHttpRequest();
            var url = '/update/service/resolve?nic=' + nic + '&service_id=' + service_id;
            ajax.open('GET', url, true);
            ajax.onload = function (ev) {
                var res = JSON.parse(ajax.responseText);
                if (res['status'] === 'ok') {
                    alert('Service resolved successfully!');
                    window.location.reload();
                }
                else
                    alert('RESOLVE FAILED!');
            };
            ajax.send();
        }

        function incrementVisit(nic, service_id, n) {
            var ajax = new XMLHttpRequest();
            var url = '/update/service/visit?nic=' + nic + '&service_id=' + service_id + '&n=' + n;
            ajax.open('GET', url, true);
            ajax.onload = function (ev) {
                var res = JSON.parse(ajax.responseText);
                if (res['status'] === 'ok') {
                    alert('Visit incremented successfully!');
                    window.location.reload();
                }
                else
                    alert('INCREMENT FAILED!');
            };
            ajax.send();
        }

        function addServiceRecord() {
            var nic = document.getElementById('s_nic').value;
            var service_id = document.getElementById('s_service_id').value;
            var service_des = document.getElementById('s_service_des').value;
            console.log(nic + ' ' + service_id + ' ' + service_des);
            var url = '/add/servicerecord?nic=' + nic + '&service_id=' + service_id + '&service_des=' + service_des;

            var ajax = new XMLHttpRequest();
            ajax.open('GET', url, true);
            ajax.onload = function (ev) {
                var res = JSON.parse(ajax.responseText);
                if (res['status'] === 'ok') {
                    alert('Service Record added successfully!');
                    window.location.reload();
                }
                else
                    alert('ADD SERVICE RECORD FAILED!');
            };
            ajax.send();

        }
    </script>

@stop