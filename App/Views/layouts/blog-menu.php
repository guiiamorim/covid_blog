<style>
    #dropdown-btn::after {
        display: none;
    }
</style>

<div class="w-full h-24 shadow-md bg-white z-50 mx-auto relative flex items-center box-border
p-3">
    <a href="/">
        <h1 class="font-semibold text-2xl mr-24 inline-flex items-center">
            <img src="<?= PATH . '/public/img/profile/covid.svg' ?>"
                 class="w-12 h-12 mr-2">
            Covid News
        </h1>
    </a>
    
    <div class="w-full justify-end flex-grow items-end flex md:w-auto">
        <?php if ($Sessao::retornaLogin() != null): ?>
            <?php $usuario = $Sessao::retornaLogin() ?>
            <div class="dropdown cursor-pointer ml-auto">
                <div class="mr-3 inline-flex dropdown-toggle" id="dropdown-btn" data-toggle="dropdown">
                    <span class="text-lg mr-2 break-words hidden md:block">Olá, <?= $usuario->getNome() ?></span>
                    <img src="<?= PATH . '/public/img/profile/' . ($usuario->getFoto() ?? 'covid.svg') ?>"
                         class="rounded-circle w-8 h-8 shadow-outline">
                </div>
                <div class="dropdown-menu" aria-labelledby="dropdown-btn">
                    <a href="<?= PATH ?>/post/create" class="dropdown-item text-lg text-black">Criar post</a>
                    <a href="<?= PATH ?>/post/myPosts" class="dropdown-item text-lg text-black">Meus posts</a>
                    <a href="<?= PATH ?>/user/profile" class="dropdown-item text-lg text-black">Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a href="<?= PATH ?>/login/signOut" class="dropdown-item text-lg text-black">Sair</a>
                </div>
            </div>
        <?php else: ?>
            <a href="<?= PATH ?>/login" class="ml-auto text-lg md:mr-3 text-gray-800">LogIn</a>
        <?php endif; ?>
    </div>
</div>