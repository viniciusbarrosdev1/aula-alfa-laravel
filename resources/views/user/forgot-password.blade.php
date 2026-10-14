@extends('layouts.default')
@section('title', 'Esqueci a senha')
@section('classe-body', 'login-page bg-body-secondary')
@section('content')
    <main class="login-box">
        <h1 class="login-logo">
            <b>Esqueci a senha</b>
        </h1>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Esqueceu sua senha? Informe seu e-mail para recuperá-la.</p>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                <form action="{{ route('password.send-code') }}" method="post">
                    @csrf
                    <label class="visually-hidden" for="email">Email</label>
                    <div class="input-group mb-3">
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email" />
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Enviar código</button>
                            </div>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-0">
                    <a href="{{ route('login') }}">Voltar ao login</a>
                </p>

            </div>
        </div>
    </main>
@endsection
