<div class="w-full h-screen md:flex">
    <div class="md:w-1/2 md:block hidden h-screen bg-blue-100 bg-cover bg-center" style="background-image: url('<?=
    PATH
    ?>/public/img/bg.jpg')
            "></div>
    <div class="md:w-1/2 w-full object-center h-screen md:bg-gray-100">
        <?php if (!empty($Sessao::retornaErro())): ?>
            <div class="w-2/3 mx-auto mt-6 mb-n5 p-6 rounded-md bg-red-400 text-white"><?= $Sessao::retornaErro()
                ?></div>
        <?php $Sessao::limpaErro() ?>
        <?php endif; ?>
        <div class="w-2/3 mx-auto mt-40 p-6 md:shadow-md md:bg-white">
            <h1 class="text-5xl text-center mb-6">Login</h1>
            <form action="<?= PATH ?>/login/signIn" method="post">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="rounded-md border
                     w-11/12 h-10 p-6" placeholder="joao@provedor.com" required value="<?=
                    $Sessao::retornaFormulario('LoginController', 'index')['email'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="rounded-md border
                     w-11/12 h-10 p-6" required>
                </div>
                <button type="submit" class="w-11/12 h-12 my-6 rounded-md bg-green-500 text-white text-xl block
">Entrar</button>
                <a href="<?= PATH ?>/login/cadastro" class="text-green-400 mx-auto block hover:text-green-400">Não possui uma
                    conta?
                    cadastre-se.</a>
            </form>
        </div>
    </div>
</div>