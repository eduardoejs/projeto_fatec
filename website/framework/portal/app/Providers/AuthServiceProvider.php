<?php

namespace App\Providers;

use App\Models\Acl\Permissao;
use App\Policies\AvisoPolicy;
use App\Policies\NoticiaPolicy;
use Illuminate\Support\Facades\App;
use App\Models\Sistema\Avisos\Aviso;
use Illuminate\Support\Facades\Gate;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Noticia::class => NoticiaPolicy::class,
        Aviso::class => AvisoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Se usuario for ADMINISTRADOR é liberado antes 
        Gate::before(function($user){
            if($user->isAdmin())
                return true;
        });

        if(!App::runningInConsole())
        {
            foreach($this->getPermissoes() as $permissao) {
                Gate::define($permissao->nome, function($user) use($permissao){
                    return $user->temUmPerfilDestes($permissao->perfis) /*|| $user->isAdmin()*/;
                });
            }
        }
    }

    private function getPermissoes()
    {
        return Permissao::with('perfis')->get();
    }
}
