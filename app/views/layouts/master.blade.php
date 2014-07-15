<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab|Roboto' rel='stylesheet' type='text/css'>
    {{ HTML::style('/assets/css/global.css') }}

</head>
    <body>
    <header class="site-header">
        <div class="container">
            <h1 class="site-logo">Books</h1>
            <ul class="site-nav">
                <li><a href="/income" class="{{ Request::is( 'income') ? 'active' : '' }}">Income</a></li>
                <li><a href="/expenses" class="{{ Request::is( 'expenses') ? 'active' : '' }}">Expenses</a></li>
                <li><a href="/transactions" class="{{ Request::is( 'transactions') ? 'active' : '' }}">Transactions</a></li>
                <li class="last">
                    <a href="/settings" class="dropdown-toggle  {{ Request::is( 'settings') ? 'active' : '' }}" data-toggle="dropdown"><i class="glyphicon-cog"></i> Settings</a>
                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                        <li><a href="/settings/categories/" class="">Categories</a></li>
                        <li><a href="/settings/streams/" class="">Streams</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>

    @yield('content')

    {{ HTML::script('/assets/js/global.js') }}
    </body>
</html>