@extends('layouts.app')

@section('content')
<header-component></header-component>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
               
                <tareas-component></tareas-component>
                    
            </div>

        </div>
    </div>
</div>
@endsection