@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="-webkit-filter: drop-shadow(1px 2px 2px #797979); background-color: #fffffe; text-align: center">
                    <div class="panel-heading">
                        පුද්ගලයාගේ විස්තර
                    </div>
                    <div class="panel-body">
                        @if(isset($customer))
                            <table class="table table-condensed" style="font-size: 15px; font-family: sans-serif">
                                <tbody>
                                <tr>
                                    <td>නම:</td>
                                    <td><strong>{{$customer->name}}</strong></td>
                                </tr>
                                <tr>
                                    <td>ජා.හැ.අං:</td>
                                    <td><strong>{{$customer->nic}}</strong></td>
                                </tr>
                                <tr>
                                    <td>දුරකථන අංකය:</td>
                                    <td><strong>{{$customer->mobile}}</strong></td>
                                </tr>
                                <tr>
                                    <td>ලිපිනය:</td>
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
        @if(isset($services))
            <div class="row" style="font-family: sans-serif; color: black">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table table-responsive table-condensed table-bordered img-rounded" style="-webkit-filter: drop-shadow(1px 2px 2px #b4b4b4); background-color: #fffffe; text-align: center">
                        <thead>
                        <tr>
                            <th style="text-align: center">#</th>
                            <th style="text-align: center">Service</th>
                            <th style="text-align: center">Visits</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            @if($service->n == 1)
                                <tr class="success">
                            @elseif($service->n == 2)
                                <tr class="warning">
                            @else
                                <tr class="danger">
                                    @endif
                                    <td>{{$loop->iteration}}</td>
                                    @if(!$service->resolved)
                                        <td><a href="/check/id?nic={{$customer->nic}}">{{$service->service}}</a></td>
                                    @else
                                        <td>{{$service->service}}</td>
                                    @endif
                                    <td>{{$service->n}}</td>
                                    <td>
                                        @if($service->resolved)
                                            <span class="label label-success">විසඳන ලදි</span>
                                        @else
                                            <span class="label label-danger">විසඳා නැත</span>
                                        @endif
                                    </td>
                                    <td>{{date('d M Y h:i A',strtotime($service->updated_at))}}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="row" style="margin-top: 20px">
            <div class="col-md-2 col-md-offset-5" align="center">
                @if(isset($_SERVER['HTTP_REFERER']))
                    <a href="{{$_SERVER['HTTP_REFERER']}}" class="btn btn-default">අාපසු</a>
                @endif
            </div>
        </div>
    </div>
@endsection