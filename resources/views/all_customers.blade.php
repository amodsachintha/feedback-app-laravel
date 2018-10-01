@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-condensed" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                    <thead>
                    <tr>
                        <th style="text-align: center">#</th>
                        <th style="text-align: center">ජා.හැ.අං</th>
                        <th style="text-align: center">නම</th>
                        <th style="text-align: center">දුරකථන අංකය</th>
                        <th style="text-align: center">ලිපිනය</th>
                        <th style="text-align: center">දත්ත අැතුලත් කල දිනය</th>
                        <th style="text-align: center">services</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($customers))
                        @foreach($customers as $customer)
                            <tr>
                                <td style="text-align: center">{{ (($customers->currentPage() - 1 ) * $customers->perPage() ) + $loop->iteration }}</td>
                                <td style="text-align: center"><a href="/check/id?nic={{$customer->nic}}">{{$customer->nic}}</a></td>
                                <td style="text-align: center">{{$customer->name}}</td>
                                <td style="text-align: center">{{$customer->mobile}}</td>
                                <td style="text-align: center">{{$customer->address}}</td>
                                <td style="text-align: center">{{date('d M Y h:i:s A',strtotime($customer->created_at))}}</td>
                                <td style="text-align: center"><a href="/view/customer?nic={{$customer->nic}}" class="btn btn-sm btn-primary">View</a></td>
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
                    <a href="{{$_SERVER['HTTP_REFERER']}}" class="btn btn-default">අාපසු</a>
                @endif
            </div>
        </div>
    </div>
@stop