@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                    <thead>
                    <tr>
                        <th style="text-align: center">#</th>
                        <th style="text-align: center">NIC</th>
                        <th style="text-align: center">Name</th>
                        <th style="text-align: center">Telephone</th>
                        <th style="text-align: center">Address</th>
                        <th style="text-align: center">Unresolved issues</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($customers))
                        @foreach($customers as $customer)
                            @if($customer->count == 1)
                                <tr class="bg-success">
                            @elseif($customer->count < 3)
                                <tr class="bg-warning">
                            @else
                                <tr class="bg-danger">
                                    @endif
                                    <td style="text-align: center">{{$i++}}</td>
                                    <td style="text-align: center"><a href="/check/id?nic={{$customer->nic}}">{{$customer->nic}}</a></td>
                                    <td style="text-align: center">{{$customer->name}}</td>
                                    <td style="text-align: center">{{$customer->mobile}}</td>
                                    <td style="text-align: center">{{$customer->address}}</td>
                                    <td style="text-align: center"><kbd>{{$customer->count}}</kbd></td>
                                </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="6" align="center">{{$customers->links()}}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-md-2 col-md-offset-5" align="center">
                @if(isset($_SERVER['HTTP_REFERER']))
                    <a href="{{$_SERVER['HTTP_REFERER']}}" class="btn btn-default">Back</a>
                @endif
            </div>
        </div>
    </div>
@stop