@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Cat Category
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($catCategory, ['route' => ['catCategories.update', $catCategory->id], 'method' => 'patch']) !!}

                        @include('cat_categories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection