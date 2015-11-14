<br/><br/>

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ session('error') }}
    </div>
@endif

@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ session('warning') }}
    </div>
@endif

@if (session()->has('status'))
    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ session('status') }}
    </div>
@endif

@if (session()->has('info'))
    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ session('info') }}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Veuillez résoudre les problèmes suivants pour pouvoir poursuivre :
        <ul>
            @foreach ($errors->all() as $error)
                <p class="m-l-md"><i class="fa fa-caret-right"></i> {{ $error }}</p>
            @endforeach
        </ul>
    </div>
@endif