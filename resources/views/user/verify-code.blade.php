@extends('layouts.default')
@section('title', 'Verificar código')
@section('classe-body', 'login-page bg-body-secondary')
@section('content')
    <main class="login-box">
        <h1 class="login-logo">
            <b>Verificar código</b>
        </h1>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Digite o código de verificação enviado para o seu e-mail.</p>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                <form action="{{ route('password.verify-code') }}" method="post">
                    @csrf
                    <label class="visually-hidden" for="code">Código</label>
                    <div class="input-group mb-3">
                        <input id="code" name="code" type="text" class="form-control" placeholder="Código" />
                        <div class="input-group-text">
                            <span class="bi bi-key"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Verificar código</button>
                            </div>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-0 text-muted small">
                    <strong>Obs.:</strong> apenas para teste, qualquer caractere digitado passa na verificação.
                </p>
            </div>
        </div>
    </main>
@endsection
