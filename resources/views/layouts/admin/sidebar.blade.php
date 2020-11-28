<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $user->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">HOME</li>
            <li><a href="{{ route('admin.dashboard') }}"> <i class="fa fa-home"></i> Home</a></li>
            <li class="header">Vendas</li>
            <li class="treeview @if(request()->segment(2) == 'products' || request()->segment(2) == 'attributes' || request()->segment(2) == 'brands') active @endif">
                <a href="#">
                    <i class="fa fa-gift"></i> <span>Produtos</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if($user->hasPermission('view-product'))<li><a href="{{ route('admin.products.index') }}"><i class="fa fa-circle-o"></i> Lista de Produtos</a></li>@endif
                        @if($user->hasRole('admin|superadmin'))<li><a href="{{ route('admin.product.list.all-products') }}"><i class="fa fa-list" aria-hidden="true"></i>Atualizar Todos os produtos</a></li>@endif
                        @if($user->hasRole('admin|superadmin'))<li><a href="{{ route('admin.product.list.pendency') }}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Pendências</a></li>@endif
                    @if($user->hasPermission('create-product'))<li><a href="{{ route('admin.products.create') }}"><i class="fa fa-plus"></i> Criar Produto</a></li>@endif
                    <li class="@if(request()->segment(2) == 'attributes') active @endif">
                    <a href="#">
                        <i class="fa fa-gear"></i> <span>Atributos</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.attributes.index') }}"><i class="fa fa-circle-o"></i> Lista de Atributos</a></li>
                        <li><a href="{{ route('admin.attributes.create') }}"><i class="fa fa-plus"></i> Criar Atributo</a></li>
                    </ul>
                    </li>
                    <li class="@if(request()->segment(2) == 'brands') active @endif">
                    <a href="#">
                        <i class="fa fa-tag"></i> <span>Marcas</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.brands.index') }}"><i class="fa fa-circle-o"></i> Lista de Marcas</a></li>
                        <li><a href="{{ route('admin.brands.create') }}"><i class="fa fa-plus"></i> Criar Marca</a></li>
                    </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview @if(request()->segment(2) == 'products' || request()->segment(2) == 'attributes' || request()->segment(2) == 'brands') active @endif">
                <a href="#">
                    <i class="fa fa-percent" aria-hidden="true"></i> <span>Percentuais</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.percentages.index') }}"><i class="fa fa-circle-o"></i> Lista de Percentuais</a></li>
                    <li><a href="{{ route('admin.percentages.create') }}"><i class="fa fa-plus"></i> Criar Percentual</a></li>
                </ul>
            </li>
            <li class="treeview @if(request()->segment(2) == 'categories') active @endif">
                <a href="#">
                    <i class="fa fa-circle" aria-hidden="true"></i> <span>Categorias</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.categories.index') }}"><i class="fa fa-circle-o"></i> Lista de Categorias</a></li>
                    <li><a href="{{ route('admin.categories.create') }}"><i class="fa fa-plus"></i> Cadastrar Categoria</a></li>
                </ul>
            </li>
            <li class="treeview @if(request()->segment(2) == 'categories') active @endif">
                <a href="#">
                    <i class="fa fa-users" aria-hidden="true"></i> <span>Produtores</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.producers.index') }}"><i class="fa fa-circle-o"></i> Lista de Produtores</a></li>
                    @if($user->hasPermission('view-product'))<li><a href="{{ route('admin.producer.list.products') }}">
                            <i class="fa fa-list" aria-hidden="true"></i>Atualizar em Lote</a></li>@endif
                    <li><a href="{{ route('admin.producers.create') }}"><i class="fa fa-plus"></i> Cadastrar Produtores</a></li>
                </ul>
            </li>
            <li class="treeview @if(request()->segment(2) == 'customers' || request()->segment(2) == 'addresses') active @endif">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Clientes</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.customers.index') }}"><i class="fa fa-circle-o"></i> Listas de Clientes</a></li>
                    <li><a href="{{ route('admin.customers.history') }}"><i class="fa fa-history" ></i> Histórico de Compras</a></li>
                    <li><a href="{{ route('admin.customers.create') }}"><i class="fa fa-plus"></i> Criar Cliente</a></li>
                    <li class="@if(request()->segment(2) == 'addresses') active @endif">
                        <a href="#"><i class="fa fa-map-marker"></i> Addresses
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.addresses.index') }}"><i class="fa fa-circle-o"></i> Lista de Endereços</a></li>
                            <li><a href="{{ route('admin.addresses.create') }}"><i class="fa fa-plus"></i> Criar Endereços</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="header">PEDIDOS</li>
            <li class="treeview @if(request()->segment(2) == 'countries' || request()->segment(2) == 'provinces') active @endif">
                <a href="#">
                    <i class="fa fa-pagelines"></i> <span>Feiras</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.fairs.index') }}"><i class="fa fa-circle-o"></i>Listar Feiras</a></li>
                    <li><a href="{{ route('admin.fairs.create') }}"><i class="fa fa-plus"></i> Criar</a>
                    </li>
                </ul>
            </li>
            {{--<li class="treeview @if(request()->segment(2) == 'orders') active @endif">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-money"></i> <span>Pedidos</span>--}}
                    {{--<span class="pull-right-container">--}}
                            {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="{{ route('admin.orders.index') }}"><i class="fa fa-circle-o"></i> Lista de Pedidos</a></li>--}}
                    {{--<li><a href="{{ route('admin.orders.labels') }}"><i class="fa fa-circle-o"></i> Pegar etiquetas</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <li class="treeview @if(request()->segment(2) == 'order-statuses') active @endif">
                <a href="#">
                    <i class="fa fa-anchor"></i> <span>Status do Pedido</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.order-statuses.index') }}"><i class="fa fa-circle-o"></i> Lista de Status do Pedido</a></li>
                    <li><a href="{{ route('admin.order-statuses.create') }}"><i class="fa fa-plus"></i> Criar Status do Pedido</a></li>
                </ul>
            </li>
            <li class="header">Entrega</li>
            <li class="treeview @if(request()->segment(2) == 'couriers') active @endif">
                <a href="#">
                    <i class="fa fa-truck"></i> <span>Entregadores</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.couriers.index') }}"><i class="fa fa-circle-o"></i> Lista de Entregadores</a></li>
                    <li><a href="{{ route('admin.couriers.create') }}"><i class="fa fa-plus"></i> Criar Entregador</a></li>
                </ul>
            </li>
            <li class="header">Configurações</li>
            @if($user->hasRole('admin|superadmin'))
                <li  class="treeview">
                    <a href="{{route('admin.config.show')}}">
                        <i class="fa fa-cog"></i> <span>Sistema</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                </li>
                <li class="treeview
                    @if(request()->segment(2) == 'employees' ||
                        request()->segment(2) == 'roles' ||
                        request()->segment(2) == 'permissions') active
                    @endif">
            <a href="#">
                <i class="fa fa-star"></i> <span>Produtores e Admin</span>
                <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('admin.employees.index') }}">
                        <i class="fa fa-circle-o"></i> Lista de Produtores e Admin</a>
                </li>
                <li><a href="{{ route('admin.employees.create') }}">
                        <i class="fa fa-plus"></i> Criar</a>
                </li>
                <li class="@if(request()->segment(2) == 'roles') active @endif">
                    <a href="#">
                        <i class="fa fa-star-o"></i> <span>Roles</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-circle-o"></i> Lista de roles</a></li>
                    </ul>
                </li>
                <li class="@if(request()->segment(2) == 'permissions') active @endif">
                    <a href="#">
                        <i class="fa fa-star-o"></i> <span>Permissões</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.permissions.index') }}"><i class="fa fa-circle-o"></i> Lista de Permissões</a></li>
                    </ul>
                </li>
            </ul>
        </li>
            @endif


            <li class="treeview @if(request()->segment(2) == 'countries' || request()->segment(2) == 'provinces') active @endif">
                <a href="#">
                    <i class="fa fa-flag"></i> <span>Países</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.countries.index') }}"><i class="fa fa-circle-o"></i> Lista</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->