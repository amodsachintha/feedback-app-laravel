@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row" align="center">
            <img src="{{asset('img/logo_text.png')}}" width="500">
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default" style="-webkit-filter: drop-shadow(1px 2px 2px rgba(227,72,0,0.2)); background-color: #fffffe">
                    <div class="panel-heading">
                        <h3 class="panel-title">ජාතික හැඳුනුම්පත් අංකය</h3>
                    </div>
                    <div class="panel-body">
                        <form action="/check/id" method="GET">
                            <div class="form-group">
                                <input type="text" class="form-control " name="nic" min="9" max="12" required>
                                <code>
                                    <small>**ජාතික හැඳුනුම්පත් අංකය මෙතන අැතුලත් කරන්න</small>
                                </code>
                            </div>

                            <div class="form-group" align="center">
                                <input type="submit" class="btn btn-success" value="Submit" style="width: 150px">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop