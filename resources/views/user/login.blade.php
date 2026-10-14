@extends('layouts.default')
@section('title', 'Entrar')
@section('classe-body', 'login-page bg-body-secondary')
@section('content')
    <main class="login-box">
        <h1 class="login-logo">
            <b>Entrar</b>
        </h1>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Faça login para iniciar sua sessão.</p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                <form action="{{ route('login.attempt') }}" method="post">
                    @csrf
                    <label class="visually-hidden" for="email">Email</label>
                    <div class="input-group mb-3">
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" />
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>
                    <label class="visually-hidden" for="password">Senha</label>
                    <div class="input-group mb-3">
                        <input id="password" name="password" type="password" class="form-control" placeholder="Senha" />
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </div>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('password.forgot') }}">Esqueci minha senha</a>
                </p>
                <p class="mb-0">
                    <a href="{{ url('register') }}">Cadastrar novo usuário</a>
                </p>
            </div>
        </div>
    </main>
@endsection
