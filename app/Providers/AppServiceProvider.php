<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Pessoa;
use App\Models\Atendimento;
use App\Models\Comentario;
use App\Models\Curtida;
use App\Policies\PessoaPolicy;
use App\Policies\AtendimentoPolicy;
use App\Policies\ComentarioPolicy;
use App\Policies\CurtidaPolicy;
use App\Observers\AtendimentoObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Pessoa::class, PessoaPolicy::class);
        Gate::policy(Atendimento::class, AtendimentoPolicy::class);
        Gate::policy(Comentario::class, ComentarioPolicy::class);
        Gate::policy(Curtida::class, CurtidaPolicy::class);
        
         Atendimento::observe(AtendimentoObserver::class);
    }
}
