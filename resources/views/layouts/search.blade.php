<div class="pull-right">
    <!-- search form -->
    <form action="{{$route}}" method="get" id="admin-search">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Procurar..." value="{{ request()->input('q') }}">
            @isset($fair_id)
                <input type="hidden" name="fair_id" value="{{$fair_id}}"/>
            @endisset
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> Procurar </button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
</div>
