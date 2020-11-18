@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Cat User
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($catUser, ['route' => ['catUsers.update', $catUser->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('cat_users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection